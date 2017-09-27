<?php
/*
 * $Author ��PHPYUN�����Ŷ�
 *
 * ����: http://www.phpyun.com
 *
 * ��Ȩ���� 2009-2017 ��Ǩ�γ���Ϣ�������޹�˾������������Ȩ����
 *
 * ���������δ����Ȩǰ���£�����������ҵ��Ӫ�����ο����Լ��κ���ʽ���ٴη�����
 */

class ApiPay extends common{ 
	function payAll($dingdan,$total_fee,$paytype=''){ 

		if(!preg_match('/^[0-9]+$/', $dingdan)){

			die;
		} 
		
		$order=$this->obj->DB_select_once("company_order","`order_id`='$dingdan'");
		
		if($order['order_state']!='2' && $order['id']){

			$member=$this->obj->DB_select_once("member","`uid`='".$order['uid']."'","`usertype`,`username`,`wxid`");

			if($member['usertype']=='1'){
				$table='member_statis';
				$marr=$this->obj->DB_select_once("resume","`uid`='".$order['uid']."'","`name`,`email`,`telphone`as `moblie`");
			}else if($member['usertype']=='2'){
				$table='company_statis';
				$tvalue=",`all_pay`=`all_pay`+'".$order["order_price"]."'";
				$marr=$this->obj->DB_select_once("company","`uid`='".$order['uid']."'","`name`,`linkmail` as `email`,`linktel` as `moblie`");
			}
	
			$emaildata['type']="recharge";
			$emaildata['username']=$member['username'];
			$emaildata['name']=$marr['name'];
			$emaildata['price']=$order['order_price'];
			$emaildata['time']=date("Y-m-d H:i:s");
			$emaildata['email']=$marr['email'];
			$emaildata['moblie']=$marr['moblie'];
			
			$sendInfo['wxid'] = $member['wxid'];
			$sendInfo['first'] = '����һ�ʶ���֧���ɹ���';
			$sendInfo['username'] = $member['username'];
			$sendInfo['order'] = $order['order_id'];
			$sendInfo['price'] = $order['order_price'];
			$sendInfo['time'] = date('Y-m-d H:i:s');
			switch($paytype){
			
				case 'alipay':$sendInfo['paytype']='֧����'; 
				break;
				case 'wxpay':$sendInfo['paytype']='΢��֧��'; 
				break;
				case 'wapalipay':$sendInfo['paytype']='֧�����ֻ�֧��'; 
				break;
				case 'tenpay':$sendInfo['paytype']='�Ƹ�ͨ'; 
				break;
				default :$sendInfo['paytype']='����֧����ʽ';
				
				break; 

			}

			if($order['type']=='1' && $order['rating'] && $member['usertype']!='1'){
				
				
				

				$row=$this->obj->DB_select_once("company_rating","`id`='".$order['rating']."'");
				$sendInfo['info'] = '����'.$row['name'];

				$ratingM = $this->MODEL('rating');
				$value=$ratingM->rating_info($order['rating'],$order['uid']);
				$nid=$this->obj->DB_update_all($table,$value,"`uid`='".$order['uid']."'");
				
				$sendMail = 1;
			}else if($order['type']=='2' && $order['integral']){ 
				$nid=$this->obj->DB_update_all($table,"`integral`=`integral`+'".$order['integral']."'".$tvalue,"`uid`='".$order['uid']."'");
				if($nid){ 
					$this->obj->DB_insert_once("company_pay","`order_id`='".$order['order_id']."',`order_price`='".$order['integral']."',`pay_time`='".time()."',`pay_state`='2',`com_id`='".$order["uid"]."',`pay_remark`='"."����".$this->config['integral_pricename']."',`type`='1',`pay_type`='2',`did`='".$this->config['did']."'");
					$sendMail = 1;
				}
				$sendInfo['info'] = '��ֵ'.$this->config['integral_pricename'].'��'.$order['integral'];

			}else if($order['type']=='5'){
				$value='';
				$row=$this->obj->DB_select_once("company_service_detail","`id`='".$order['rating']."'");
				if($member['usertype']=='2'){
					
					$value.="`job_num`=`job_num`+'".$row['job_num']."',";
					$value.="`down_resume`=`down_resume`+'".$row['resume']."',";
					$value.="`invite_resume`=`invite_resume`+'".$row['interview']."',";
					$value.="`breakjob_num`=`breakjob_num`+'".$row['breakjob_num']."',";
					$value.="`part_num`=`part_num`+'".$row['part_num']."',";
					$value.="`breakpart_num`=`breakpart_num`+'".$row['breakpart_num']."',";
					$value.="`all_pay`=`all_pay`+'".$order["order_price"]."'";
				}
				$nid=$this->obj->DB_update_all($table,$value,"`uid`='".$order['uid']."'");
				$sendMail = 1;
				$sendInfo['info'] = '������ֵ����'.$row['name'];
			}else if($order['type']=='6'){

				$value='';
				
				$sendMail = 1;
				$sendInfo['info'] = '������ѵ�γ̣�';
				$nid = 1;
			}
			
			if($nid){
				$this->obj->DB_update_all("company_order","`order_state`='2',`order_type`='".$paytype."'","`id`='".$order['id']."'"); 

				$Weixin=$this->MODEL('weixin');
				$Weixin->sendWxPay($sendInfo);
				
				
				if($sendMail==1){ 
					$this->send_msg_email($emaildata);
				}
			}
		} 
	} 
}

?>