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
class show_controller extends zph_controller{ 
	function index_action(){   
		$this->Zphpublic_action();
		$id=(int)$_GET['id'];
		$M=$this->MODEL('zph');
		$row=$M->GetZphOnce(array("id"=>$id)); 
		if($row['id']==''){
			$this->ACT_msg(url("zph"),"û���ҵ�����Ƹ�ᣡ");
		}
		$row["stime"]=strtotime($row['starttime'])-mktime();
		$row["etime"]=strtotime($row['endtime'])-mktime();
		if(!$row['is_themb'] || (!file_exists(str_replace($this->config['sy_weburl'],APP_PATH,'.'.$row['is_themb'])) && !file_exists(str_replace($this->config['sy_weburl'],APP_PATH,$row['is_themb'])))){
		    $row['is_themb']=$this->config['sy_weburl']."/".$this->config['sy_logo'];
		}else{
		    $row['is_themb']=str_replace("./",$this->config['sy_weburl']."/",$row['is_themb']);
		}
		$rows=$M->GetZphPic(array("zid"=>$id));
		if($this->uid&&$this->usertype=='2'){
			$isyd=$M->GetZphComNum(array("zid"=>$id,"uid"=>$this->uid));
			$this->yunset("Info",$row);			
		} 
		$data['zph_title']=$row['title'];
		$data['zph_desc']=$this->GET_content_desc($row['body']);
		$this->data=$data;
		$this->yunset("Info",$row);
		$this->yunset("Image_info",$rows);
		$this->seo("zph_show");
		$this->zph_tpl('zphshow'); 
	} 
}
?>