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
class info_controller extends company{
	function index_action(){
		 
		$row=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
		if ($row['comqcode']){
		    $row['comqcode']=str_replace('./', $this->config['sy_weburl'].'/', $row['comqcode']);
		}
		$save=$this->obj->DB_select_once("lssave","`uid`='".$this->uid."'and `savetype`='3'");
		$save=unserialize($save['save']);
		if($save['lastupdate']){
			$save['time']=date('H:i',ceil(($save['lastupdate'])));
		} 
		if($row['linkphone']){
			$linkphone=@explode('-',$row['linkphone']);
			$row['phoneone']=$linkphone[0];
			$row['phonetwo']=$linkphone[1];
			$row['phonethree']=$linkphone[2]; 
		}
		if (($row['x']==''||$row['y']=='')&&$row['address']!=''){
		    $row['setmap']=1;
		}elseif ($row['x']!=''&&$row['y']!=''){
		    $row['setmap']=2;
		}else{
		    $row['setmap']=3;
		}
		$tel=$this->obj->DB_select_once("company_cert","`uid`='".$this->uid."' and `type`='2'");
		$this->yunset("save",$save);
		$this->yunset("tel",$tel);
		$this->yunset("row",$row);
		$this->public_action();
		$this->city_cache();
		$this->job_cache();
		$this->com_cache();
		$this->industry_cache();
		$cert=$this->obj->DB_select_once("company_cert","`uid`='".$this->uid."' and type='3'");
		$this->yunset("cert",$cert);
		$this->yunset("js_def",2);
		$this->com_tpl('info');
	}
	function save_action(){
		if($_POST['submitbtn']){
			$_POST=$this->post_trim($_POST);
		    if(trim($_POST['linktel'])){
				$t_exist=$this->obj->DB_select_once("member","`uid`<>'".$this->uid."' and `moblie`='".$_POST['linktel']."'","`uid`");
			}else if($_POST['linkmail']){
				$e_exist=$this->obj->DB_select_once("member","`uid`<>'".$this->uid."' and `email`='".$_POST['linkmail']."'","`uid`"); 
			}
			if($t_exist['uid']){
				$this->ACT_layer_msg("�ֻ��Ѵ��ڣ�",8);
			}elseif ($e_exist['uid']){
			    $this->ACT_layer_msg("�����Ѵ��ڣ�",8);
			}
			$company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'");
			$comname=$this->obj->DB_select_all('company',"`uid`<>'".$this->uid."' and `name`='".$_POST['name']."'","`uid`");
			if($_POST['name']==""){
				$this->ACT_layer_msg("��ҵȫ�Ʋ���Ϊ�գ�",8);
			}
			if($comname){
				$this->ACT_layer_msg("��ҵȫ���Ѵ��ڣ�",8);
			}
			if($_POST['hy']==""){
				$this->ACT_layer_msg("������ҵ����Ϊ�գ�",8);
			}
			if($_POST['pr']==""){
				$this->ACT_layer_msg("��ҵ���ʲ���Ϊ�գ�",8);
			}
			if($_POST['provinceid']==""){
				$this->ACT_layer_msg("���ڵز���Ϊ�գ�",8);
			}
			if($_POST['mun']==""){
				$this->ACT_layer_msg("��ҵ��ģ����Ϊ�գ�",8);
			}
			if($_POST['address']==""){
				$this->ACT_layer_msg("��˾��ַ����Ϊ�գ�",8);
			}
			$linkphone=array();
			if($_POST['phonetwo']&&$_POST['phonetwo']!='������'){
				if($_POST['phoneone']==''||$_POST['phoneone']=='����'){
					$this->ACT_layer_msg("����д���ţ�",8);
				}else{
					$linkphone[]=$_POST['phoneone'];
				}
				if($_POST['phonetwo']&&$_POST['phonetwo']!='������'){
					$linkphone[]=$_POST['phonetwo'];
				} 
				if($_POST['phonethree']&&$_POST['phonetwo']!='�ֻ���'){
					$linkphone[]=$_POST['phonethree'];
				} 
			}
			$_POST['linkphone']=@implode('-',$linkphone);
			if($_POST['linktel']==""){
				if($_POST['linkphone']==""){
					$this->ACT_layer_msg("��ϵ�ֻ��͹̶��绰����һ�",8);
				}else if($_POST['phoneone']==""){
					$this->ACT_layer_msg("����д���ţ�",8);
				} 
			}
			if($_POST['content']==""){
				$this->ACT_layer_msg("��ҵ��鲻��Ϊ�գ�",8);
			}
			
			delfiledir("../data/upload/tel/".$this->uid);
			unset($_POST['submitbtn']);
			if($_FILES['uplocadpic']['tmp_name']){
				$upload=$this->upload_pic("../data/upload/company/",false,$this->config['com_pickb']);
				$pictures=$upload->picture($_FILES['uplocadpic']);
				$this->picmsg($pictures,$_SERVER['HTTP_REFERER']);
				$s_thumb=$upload->makeThumb($pictures,185,75,'_S_');
				$_POST['logo']=str_replace("../data/upload/company","./data/upload/company",$s_thumb);
				if($company['logo']){
					unlink_pic(".".$company['logo']);
				}
			}
			if($_FILES['firmpic']['tmp_name']){
				$upload=$this->upload_pic("../data/upload/company/",false,$this->config['com_uppic']);
				$firmpic=$upload->picture($_FILES['firmpic']);
				$this->picmsg($firmpic,$_SERVER['HTTP_REFERER']);
				$_POST['firmpic'] = str_replace("../data/upload/company","./data/upload/company",$firmpic);
				if($company['firmpic']){
					unlink_pic(".".$company['firmpic']);
				}
			}
			$Member=$this->MODEL("userinfo");
			if($_POST['linktel']!=""){
			if($company['moblie_status']==1){
				unset($_POST['linktel']);
			}else{
				$moblieNum = $Member->GetMemberNum(array("moblie"=>$_POST['linktel'],"`uid`<>'".$this->uid."'"));
				if($_POST['linktel']==''){
					$this->ACT_layer_msg("�ֻ����벻��Ϊ�գ�",8);
				}elseif($this->CheckMoblie($_POST['linktel'])==false){
					$this->ACT_layer_msg("�ֻ������ʽ����",8);
				}elseif($moblieNum>0){
					$this->ACT_layer_msg("�ֻ������Ѵ��ڣ�",8);
				}else{
					$mvalue['moblie']=$_POST['linktel'];
				}
			}
			}
			if($company['email_status']==1){
				unset($_POST['linkmail']);
			}else{
				$emailNum = $Member->GetMemberNum(array("email"=>$_POST['linkmail'],"`uid`<>'".$this->uid."'"));
				if($_POST['linkmail']&&$this->CheckRegEmail($_POST['linkmail'])==false){
					$this->ACT_layer_msg("��ϵ�����ʽ����",8);
				}elseif($_POST['linkmail']&&$emailNum>0){
					$this->ACT_layer_msg("��ϵ�����Ѵ��ڣ�",8);
				}else{
					$mvalue['email']=$_POST['linkmail'];
				}
			} 
			$where['uid']=$this->uid;
			$_POST['content']=str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'background-color:','background-color:','white-space:'),html_entity_decode($_POST['content'],ENT_QUOTES,"GB2312"));
			$_POST['lastupdate']=mktime();
			if($company['yyzz_status']=='1'){
				unset($_POST['name']);
			}else{
				$data['com_name']=$_POST['name'];
			} 
			$nid=$this->obj->update_once("company",$_POST,$where);
			if($nid){	
				$this->obj->DB_delete_all("lssave","`uid`='".$this->uid."'and `savetype`='3'");
				$this->obj->member_log("�޸���ҵ��Ϣ",7);

				if($company['lastupdate']==""){
					if($this->config['integral_userinfo_type']=="1"){
						$auto=true;
					}else{
						$auto=false;
					}

					$this->company_invtal($this->uid,$this->config['integral_userinfo'],$auto,"�״���д��������",true,2,'integral',25);
				}
				$data['pr']=$_POST['pr'];
				$data['mun']=$_POST['mun'];
				$data['com_provinceid']=$_POST['provinceid'];
				$this->obj->update_once("company_job",$data,array("uid"=>$this->uid));
				if(!empty($mvalue)){
					$this->obj->update_once('member',$mvalue,array("uid"=>$this->uid));
				}
				if($_POST['name']!=$company['name']&&$_POST['name']){
					$this->obj->update_once("hotjob",array("username"=>$_POST['name']),array("uid"=>$this->uid));
					$this->obj->update_once("partjob",array("com_name"=>$_POST['name']),array("uid"=>$this->uid));
					$this->obj->update_once("userid_job",array("com_name"=>$_POST['name']),array("com_id"=>$this->uid));
					$this->obj->update_once("fav_job",array("com_name"=>$_POST['name']),array("com_id"=>$this->uid));
					$this->obj->update_once("report",array("r_name"=>$_POST['name']),array("c_uid"=>$this->uid));
					$this->obj->update_once("blacklist",array("com_name"=>$_POST['name']),array("c_uid"=>$this->uid));
					$this->obj->update_once("msg",array("com_name"=>$_POST['name']),array("job_uid"=>$this->uid));
				}

				$this->ACT_layer_msg("���³ɹ���",9,"index.php?c=info");
			}else{
				$this->ACT_layer_msg("����ʧ�ܣ�",8,"index.php?c=info");
			}
		}
	}
	function upewm_action(){
	    if ($_POST['uppic']){
	        $company=$this->obj->DB_select_once("company","`uid`='".$this->uid."'","comqcode");
	        if(is_uploaded_file($_FILES['comqcode']['tmp_name'])){
	            $upload=$this->upload_pic("../data/upload/company/",false);
	            $pictures=$upload->picture($_FILES['comqcode']);
	            $this->picmsg($pictures,$_SERVER['HTTP_REFERER']);
	            $comqcode = str_replace("../data","./data",$pictures);
	            if($company['comqcode']){
	                unlink_pic(".".$company['comqcode']);
	            }
	            $id=$this->obj->DB_update_all('company',"`comqcode`='".$comqcode."'","`uid`='".$this->uid."'");
	             
	            if($id){
	                unlink_pic(".".$company['comqcode']);
	                $data['url']=$pictures;
	            }else{
	                $data['msg']=iconv('gbk','utf-8','�ϴ�ʧ��');
	            }
	        }else{
	            $data['msg']=iconv('gbk','utf-8','���ϴ���ά��');
	        }
	        echo json_encode($data);
	    }
	}
}
?>