<?php
/* *
* $Author ��PHPYUN�����Ŷ�
*
* ����: http://www.phpyun.com
*
* ��Ȩ���� 2009-2017 ��Ǩ�γ���Ϣ�������޹�˾������������Ȩ����
*
* ���������δ����Ȩǰ���£�����������ҵ��Ӫ�����ο����Լ��κ���ʽ���ٴη�����
*/
class com_res_controller extends user{
 	function index_action(){
		$telphone=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","`telphone`");
		$resume_expect=$this->obj->DB_select_all("resume_expect","`uid`='".$this->uid."' and `open`='1'","`name`,`doc`,`lastupdate`,`defaults`,`id`,`is_entrust`");
		if(is_array($resume_expect)&& !empty($resume_expect)){
			$html="";
			foreach($resume_expect as $key=>$val){
				if($val['doc']){
					$doc_type='���ټ���';
				}else{
					$doc_type='��׼����';
				}
				if($val['is_entrust']=='1'){
					$entrust="<a href='javascript:void(0)' onclick=\"entrust('ȷ��ȡ����','".$val['id']."')\">ȡ��ί��</a>";
					$status="������";
				}else if($val['is_entrust']=='2'){
					$entrust="<a href='javascript:void(0)' onclick=\"layer_del('ί����ͨ����ˣ�ȡ�������˻���ȷ��ȡ����','".$val['id']."')\">ȡ��ί��</a>";
					$status="��ͨ��";
				}else if($val['is_entrust']=='3'){
					$entrust="<a href='javascript:void(0)' onclick=\"entr_resume('".$val['id']."')\">ί��</a>";
					$status="δͨ��";
				}else{
					$entrust="<a href='javascript:void(0)' onclick=\"entr_resume('".$val['id']."')\">ί��</a>";
					$status="δ����";
				}
				$html.="<tr class=\"result_class\"><td>".mb_substr($val['name'],0,8,"GBK")."</td><td>".$telphone['telphone']."</td><td><span>".$doc_type."</span></td><td>".date('Y-m-d',$val['lastupdate'])."</td><td>".$status."</td><td>".$entrust."</td></tr>";
			}
			echo $html;die;
		}else{
			echo 1;die;
		}
	}
	function canceltrust_action(){ 
		$resume_expect=$this->obj->DB_select_once("resume_expect","`uid`='".$this->uid."' and `id`='".(int)$_POST['id']."'","`is_entrust`,`id`");
		if((int)$this->config['user_trust_number']<1&&$resume_expect['is_entrust']=='0'){
			$data['type']='8';
			$data['msg']='��վ�ѹرմ˷���';
		}else if($resume_expect['id']){
			if($resume_expect['is_entrust']=='0'){
				$entrust_num=$this->obj->DB_select_num("resume_expect","`uid`='".$this->uid."' and `is_entrust`>'0'","`id`");
				if($entrust_num<(int)$this->config['user_trust_number']){
					$member_statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'","`integral`");
					if($member_statis['integral']<$this->config['pay_trust_resume']&&$this->config['pay_trust_resume']){
						$data['type']='8';
						$data['msg']=$this->config['integral_pricename'].'���㣬�޷�ί�С�';
						$data['url']='index.php?c=pay';
					}else{						
						$res=$this->company_invtal($this->uid,$this->config['pay_trust_resume'],false,"ί�м���",true,2,'integral'); 						
						if($res){
							$idata['uid']      = $this->uid;
							$idata['did']      = $this->userdid;
							$idata['username'] = $this->username;
							$idata['eid']      = $resume_expect['id'];
							$idata['status']   = $this->config['user_trust_status'];
							$idata['price']    = $this->config['pay_trust_resume'];
							$idata['add_time'] = time();
							$nid=$this->obj->insert_into("user_entrust",$idata);
							if($nid){
								if($this->config['pay_trust_resume']=='1'){
									$this->obj->update_once("resume_expect",array('is_entrust'=>2),array('uid'=>$this->uid,'id'=>$resume_expect['id']));
								}else{
									$this->obj->update_once("resume_expect",array('is_entrust'=>1),array('uid'=>$this->uid,'id'=>$resume_expect['id']));
								}
								$data['type']='9';
								$data['msg']='����ί�гɹ���';
							}else{
								$data['type']='8';
								$data['msg']='����ί��ʧ�ܡ�';
							}
						}else{
							$data['type']='8';
							$data['msg']=$this->config['integral_pricename'].'�۳�ʧ�ܣ����Ժ����ԡ�';
						}
					}
				}else{
					$data['type']='8';
					$data['msg']='����ί��'.$entrust_num.'�ݼ������޷��ٴβ�����';
				}
			}else if($resume_expect['is_entrust']=='1'){
				$user_entrust=$this->obj->DB_select_once("user_entrust","`uid`='".$this->uid."' and `eid`='".$resume_expect['id']."'");
				if($user_entrust['id']){
					$res=$this->obj->update_once("resume_expect",array('is_entrust'=>0),array('uid'=>$this->uid,'id'=>$resume_expect['id']));
					if($res){
						if($user_entrust['status']=='0'){
							$this->company_invtal($this->uid,$user_entrust['price'],true,"�˻�ί�м���".$this->config['integral_pricename'],true,2,'integral');   
						}
						$this->obj->DB_delete_all("user_entrust","`uid`='".$this->uid."' and `eid`='".$resume_expect['id']."'");
						$data['type']='9';
						$data['msg']='�����ɹ���';
					}else{
						$data['type']='8';
						$data['msg']='ȡ��ʧ�ܣ����Ժ����ԡ�';
					}
				}else{$data['type']='3';$data['msg']='�Ƿ�������';}
			}
		}else{$data['type']='3';$data['msg']='�Ƿ�������';} 
		$data['msg']=iconv("gbk","utf-8",$data['msg']);
		echo json_encode($data);die;
	}
}
?>