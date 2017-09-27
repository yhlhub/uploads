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
class uppic_controller extends company{
	function index_action(){
		$this->public_action();
		$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'","`logo`");
		if($company['logo']){
			$company['logo']=$this->config['sy_weburl'].str_replace("./","/",$company['logo']);
		}else{
			$company['logo']=$this->config['sy_weburl']."/".$this->config['sy_unit_icon'];
		} 
		$this->yunset("company",$company);
		$this->yunset("js_def",2);
		$this->com_tpl('uppic');
	}
	function uppath(){
		$upload_path = "../data/upload/company/";
		return $upload_path;
	}


	function ajaxfileupload_action(){
		if($_FILES['image']['tmp_name']){
			$upload=$this->upload_pic("../data/upload/company",false,$this->config['com_pickb']);
			$pictures=$upload->picture($_FILES['image']);
			$picMsg = $this->picmsg($pictures,$_SERVER['HTTP_REFERER'],"ajax");			
			if($picMsg){
				$imginfo=$this->getInfo($pictures);
				if($_POST['type']=='info'){
					$s_thumb=$upload->makeThumb($pictures,185,75,'_S_');
					$this->uplogo(array('1'=>$s_thumb));
					unlink_pic($pictures);
					$res["url"] = $s_thumb;
				}elseif($imginfo['width']<185 || $imginfo['height']<75){
					unlink_pic($pictures);
					$res['s_thumb'] = iconv('gbk','utf-8','LOGO�ߴ����̫С����С�ߴ磺��185/��75');
				}elseif($imginfo['width']>370 || $imginfo['height']>150){
					$s_thumb=$upload->makeThumb($pictures,370,150,'_S_');
					unlink_pic($pictures);
					$res["url"] = $s_thumb;
				}else{
					$res["url"] = $pictures;
				}	
				echo json_encode($res);
			}
		}else{
			$res["s_thumb"] = iconv('gbk','utf-8','��ѡ���ϴ�ͼƬ');
			echo json_encode($res);
		}die;
	}

	function getInfo($file){
		$data=getimagesize($file);
		$imageInfo["width"]	= $data[0];
		$imageInfo["height"]= $data[1];
		$imageInfo["type"]	= $data[2];
		$imageInfo["name"]	= basename($file);
		$imageInfo["size"]  = filesize($file);
		return $imageInfo;
	}

	function savethumb_action(){

		$upload_path = $this->uppath();
		$upload_path=ltrim($upload_path,'.');
		if(stripos(trim($_POST['img1']),$upload_path)===false){
			$this->ACT_layer_msg("�Ƿ�������",8,$_SERVER['HTTP_REFERER']);
		}
		include(LIB_PATH."sizer.class.php");
		$sizer=new Sizer("../data/upload/company/".date('Ymd').'/');
		$t_name = $sizer->sizeIt();
		$ref = $this->uplogo($t_name);
		if($ref){echo $ref;}else{echo 2;}
	}

	function uplogo($t_name){
		if(!empty($t_name)){
			$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'","`logo`");
			if($company['logo'] ){
				if($company['logo'] != './'.$this->config['sy_unit_icon']){
					unlink_pic('.'.$company['logo']);
				}
			}else{
				$this->get_integral_action($this->uid,"integral_avatar","�ϴ�LOGO");
			}
			$logo=str_replace("../data/upload/company/","./data/upload/company/",$t_name[1]);
			$ref=$this->obj->update_once("company",array('logo'=>$logo),array('uid'=>$this->uid));
		}
		
		return $ref;
	
	}
}
?>