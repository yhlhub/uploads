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
class resumetpl_controller extends user{
   function index_action() { 
		$rows=$this->obj->DB_select_all("resumetpl","`status`='1' order by `id` asc");
		$statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'",'`tpl`,`paytpls`');
		if($statis['paytpls']){
			$paytpls=@explode(',',$statis['paytpls']);
			$this->yunset("paytpls",$paytpls);
		}  
		$this->yunset("statis",$statis);
		$this->yunset("rows",$rows);
		$this->public_action();
		$this->user_tpl('resumetpl'); 
	}
	function pay_action(){
		$id=intval($_GET['id']);
		$statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'",'`tpl`,`paytpls`,`integral`');
		$info=$this->obj->DB_select_once("resumetpl","`id`='".$id."'");
		$paytpls=array();
		if($statis['paytpls']){
			$paytpls=@explode(',',$statis['paytpls']); 
			if(in_array($id,$paytpls)){
				$this->layer_msg('�����ظ�����',8,0,"index.php?c=resumetpl");
			}
		}
		if($info['price']>$statis['integral']){
			$this->layer_msg($this->config['integral_pricename'].'���㣬���ȳ�ֵ����',8,0,"index.php?c=resumetpl");
		}else{ 
			$nid=$this->company_invtal($this->uid,$info['price'],false,"�������ģ��",true,2,'integral',15);
			if($nid){
				$paytpls[]=$id;
				$this->obj->DB_update_all("member_statis","`paytpls`='".@implode(',',$paytpls)."'","`uid`='".$this->uid."'");
				$this->layer_msg('����ɹ���',9,0,"index.php?c=resumetpl");
			}else{
				$this->layer_msg('����ʧ�ܣ�',8,0,"index.php?c=resumetpl");
			}
		} 
	}
	function settpl_action(){
		$id=intval($_GET['id']);
		$statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'",'`tpl`,`paytpls`,`integral`');
		$paytpls=array();
		if($statis['paytpls']){
			$paytpls=@explode(',',$statis['paytpls']);  
		}
		if(in_array($id,$paytpls)==false&&$id>0){
			$this->layer_msg('���ȹ���',8,0,"index.php?c=resumetpl");
		}
		$this->obj->DB_update_all("member_statis","`tpl`='".$id."'","`uid`='".$this->uid."'");
		$this->layer_msg('�����ɹ���',9,0,"index.php?c=resumetpl");
	}
}
?>