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
class admin_comset_controller extends common{	 
	function index_action(){
		$this->yuntpl(array('admin/admin_integral_com'));
	}
	function save_action(){
 		if($_POST["config"]){
			unset($_POST["config"]);
		   foreach($_POST as $key=>$v){
		    	$config=$this->obj->DB_select_num("admin_config","`name`='$key'");
			   if($config==false){
				$this->obj->DB_insert_once("admin_config","`name`='$key',`config`='".iconv("utf-8", "gbk", $v)."'");
			   }else{
					$this->obj->DB_update_all("admin_config","`config`='".iconv("utf-8", "gbk", $v)."'","`name`='$key'");

				   }
			 }
		 $this->web_config();
		 $this->ACT_layer_msg("�����޸ĳɹ���",9,1,2,1);
		}
	}
	function logo_action(){
		if($_POST['submit']){
			$upload=$this->upload_pic("../data/logo/");
			if (is_uploaded_file($_FILES['sy_unit_icon']['tmp_name'])) {
				$mlogo_path = $this->logo_upload($_FILES['sy_unit_icon'],$upload);
				$this->logo_reset("sy_unit_icon",$mlogo_path);
			}
			if (is_uploaded_file($_FILES['sy_banner']['tmp_name'])) {
				$flogo_path = $this->logo_upload($_FILES['sy_banner'],$upload);
				$this->logo_reset("sy_banner",$flogo_path);
			}
			if (is_uploaded_file($_FILES['sy_guwen']['tmp_name'])) {
			    $flogo_path = $this->logo_upload($_FILES['sy_guwen'],$upload);
			    $this->logo_reset("sy_guwen",$flogo_path);
			}
			$this->web_config();
			$this->ACT_layer_msg("��Աͷ���������óɹ���",9,$_SERVER['HTTP_REFERER'],2,1);
		}
		$this->yuntpl(array('admin/admin_comlogo'));
	}
	function set_action(){
		$qy_rows=$this->obj->DB_select_all("company_rating","`category`=1 order by sort desc");
		$this->yunset("qy_rows",$qy_rows);
		$this->yuntpl(array('admin/admin_com_config'));
	}
	function rating_action(){
		$qy_rows=$this->obj->DB_select_all("company_rating","`category`=1 order by sort desc");
		$this->yunset("qy_rows",$qy_rows);
		$this->yuntpl(array('admin/admin_rating_config'));
	}
	function logo_upload($picurl,$upload){
		$pictures=$upload->picture($picurl);
		$pic = str_replace("../data/logo","data/logo",$pictures);
		return $pic;
	}
	function logo_reset($name,$value){
		$logo = $this->obj->DB_select_once("admin_config","`name`='$name'");
		if(is_array($logo)){
			unlink_pic("../".$logo['config']);
			$this->obj->DB_update_all("admin_config","`config`='$value'","`name`='$name'");
		}else{
			$this->obj->DB_insert_once("admin_config","`config`='$value',`name`='$name'");
		}
	}
}
?>