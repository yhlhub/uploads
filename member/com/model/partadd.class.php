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
class partadd_controller extends company{
	function index_action(){
		include(CONFIG_PATH."db.data.php");		
		$this->yunset("arr_data",$arr_data);
		if($_GET['id']){
			$row=$this->obj->DB_select_once("partjob","`uid`='".$this->uid."' and `id`='".(int)$_GET['id']."'");
			$row['worktime']=explode(',', $row['worktime']);
			$this->yunset("row",$row);
		}else{
			$statics = $this->company_satic();
			if( $statics['addpartjobnum'] == 2){
				if(intval($statics['integral']) < intval($this->config['integral_partjob'])){
					$this->ACT_msg($_SERVER['HTTP_REFERER'],"���".$this->config['integral_pricename']."����������ְ��",8);
				}
			}
		
		}
		$save=$this->obj->DB_select_once("lssave","`uid`='".$this->uid."'and `savetype`='5'");
		$save=unserialize($save['save']);
		if($save['lastupdate']){
			$save['time']=date('H:i',ceil(($save['lastupdate'])));
		}
		$this->public_action();
		$this->yunset("save",$save);
		$this->yunset($this->MODEL('cache')->GetCache(array('city','part')));
		$this->company_satic();
		$morning=array('0101','0201','0301','0401','0501','0601','0701');
		$noon=array('0102','0202','0302','0402','0502','0602','0702');
		$afternoon=array('0103','0203','0303','0403','0503','0603','0703');
		$this->yunset(array('morning'=>$morning,'noon'=>$noon,'afternoon'=>$afternoon));
		$this->yunset("today",date("Y-m-d"));
		$this->yunset("js_def",3);
		$this->com_tpl('partadd');
	}
	function save_action(){
		if($_POST['submit']){
			if($_POST['worktime']){
				$_POST['worktime']=@implode(",",$_POST['worktime']);
			}
			$_POST['content']=str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'background-color:','background-color:','white-space:'),html_entity_decode($_POST['content'],ENT_QUOTES,"GB2312"));
			$_POST['sdate']=strtotime($_POST['sdate']);
			if($_POST['timetype']){
				$_POST['edate']="";
				$_POST['deadline']="";
			}else{
				$_POST['deadline']=strtotime($_POST['deadline']);
				$_POST['edate']=strtotime($_POST['edate']);
				if($_POST['deadline']>$_POST['edate']){
					$this->ACT_layer_msg("�������ڲ��ܴ��ڽ������ڣ�",8);
				}
			}
			
			$_POST['addtime'] = time();
			$_POST['lastupdate'] = time();
			$_POST['state'] = $this->config['com_partjob_status'];
			$_POST['uid'] = $this->uid;
			$id=(int)$_POST['id'];
			unset($_POST['submit']);
			unset($_POST['id']);
			$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'","`name`,`did`");
			$_POST['com_name']=$company['name'];
			$_POST['did']=$company['did'];
			if(!$id){
				$this->get_com(7);
				$nid=$this->obj->insert_into("partjob",$_POST);
				$name="��Ӽ�ְְλ";
				$type='1';
				if($nid){
					$this->obj->DB_delete_all("lssave","`uid`='".$this->uid."'and `savetype`='5'");
					$state_content = "�·����˼�ְְλ <a href=\"".url("part",array("c"=>"show","id"=>$nid))."\" target=\"_blank\">".$_POST['name']."</a>��";
					$this->addstate($state_content,2);
				}
			}else{
				$job=$this->obj->DB_select_once("partjob","`id`='".$id."'","state");
				if($job['state']=="1" || $job['state']=="2"){
					$this->get_com(8);
				}
				$where['id']=$id;
				$where['uid']=$this->uid;
				$nid=$this->obj->update_once("partjob",$_POST,$where);
				$name="���¼�ְְλ";
				$type='2';
			}
			if($nid){
				$this->obj->member_log($name."��".$_POST['name']."��",1,$type);
				$this->ACT_layer_msg($name."�ɹ���",9,"index.php?c=part");
			}else{
				$this->ACT_layer_msg($name."ʧ�ܣ�",8,$_SERVER['HTTP_REFERER']);
			}
		}
	}
}
?>