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
class rating_model extends model{
	function rating_info($id='',$uid=''){
		if(!$id){
			$id =$this->config['com_rating'];
		}
		if(!$uid){
			$uid = $this->uid;
		}
		$row = $this->DB_select_once("company_rating","`id`='".$id."'");
		$value="`rating`='$id',";
		$value.="`rating_name`='".$row['name']."',";
		$value.="`job_num`='".$row['job_num']."',";
		$value.="`down_resume`='".$row['resume']."',";
		$value.="`invite_resume`='".$row['interview']."',";
		$value.="`editjob_num`='".$row['editjob_num']."',";
		$value.="`breakjob_num`='".$row['breakjob_num']."',";
		$value.="`part_num`='".$row['part_num']."',";
		$value.="`editpart_num`='".$row['editpart_num']."',";
		$value.="`breakpart_num`='".$row['breakpart_num']."',";
		$value.="`rating_type`='".$row['type']."',";
		$value.="`integral`=`integral`+'".$row['integral_buy']."',";
		if($row['service_time']>0){
			$time=time()+86400*$row['service_time'];
		}else{
			$time=0;
		}
		$value.="`vip_etime`='".$time."',";
		$value.="`vip_stime`='".time()."'";
		if($row['integral_buy']>0){
			$dingdan=time().rand(10000,99999);
			$data['order_id']=$dingdan;
			$data['com_id']=$uid;
			$data['pay_remark']='������ҵ�ײͣ�'.$row['name'].'������'.$row['integral_buy'];
			$data['pay_state']='2';
			$data['pay_time']=time();
			$data['order_price']=$row['integral_buy'];
			$data['pay_type']=27;
			$data['type']=1;
			
			$this->insert_into("company_pay",$data);
		}
		return $value;
	}
}
?>