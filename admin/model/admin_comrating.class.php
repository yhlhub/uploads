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
class admin_comrating_controller extends common{	 
	function index_action(){
		$where="`category`='1'";
		if($_GET['rating']){
			$where.=" and `id`='".$_GET['rating']."'";
			$urlarr['rating']=$_GET['rating'];
		}
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
		$list=$this->get_page("company_rating",$where,$pageurl,$this->config['sy_listnum']);
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/admin_company_rating'));
	}
	function rating_action(){
		if($_GET['id']){
			$row=$this->obj->DB_select_once("company_rating","`id`='".$_GET['id']."'"); 
			$this->yunset("row",$row);
		}    
		$this->yuntpl(array('admin/admin_comclass_add'));
	}
	function saveclass_action(){
		if($_POST['useradd']){
			$id=$_POST['id'];
			unset($_POST['useradd']);
			unset($_POST['id']);
			if(is_uploaded_file($_FILES['com_pic']['tmp_name'])){
				$upload=$this->upload_pic("../data/upload/compic/");
				$pictures=$upload->picture($_FILES['com_pic']);
				$pic = str_replace("../data/upload","/data/upload",$pictures);
			} 
			if($_POST['youhui']){
				if($_POST['time_start']==''||$_POST['time_end']==''){
					$this->ACT_layer_msg("��ѡ���Żݿ�ʼ����������",8,$_SERVER['HTTP_REFERER']);
				}
				if($_POST['yh_price']==''||$_POST['yh_price']>$_POST['service_price']){
					$this->ACT_layer_msg("�Żݼ۸񲻵ô��ڳ�ʼ�ۼ�",8,$_SERVER['HTTP_REFERER']);
				}

				$_POST['time_start']=strtotime($_POST['time_start']." 00:00:00");
				$_POST['time_end']=strtotime($_POST['time_end']." 23:59:59");
			}else{
				$_POST['yh_price'] = 0;
				$_POST['time_start'] = 0;
				$_POST['time_end']=0;
			}
			foreach($_POST as $key=>$value){
				if($value==''){
					$_POST[$key] = 0;
				}
			}
			if(!$id){
				$_POST['com_pic']=$pic;
				$nid=$this->obj->insert_into("company_rating",$_POST);
				$name="��ҵ��Ա�ȼ���ID��".$nid."�����";
			}else{
				if($pic!=""){$_POST['com_pic']=$pic;};
				$where['id']=$id;
				$nid=$this->obj->update_once("company_rating",$_POST,$where);
				$name="��ҵ��Ա�ȼ���ID��".$id."������";
			}
		}
		$this->cache_rating();
		$nid?$this->ACT_layer_msg($name."�ɹ���",9,"index.php?m=admin_comrating",2,1):$this->ACT_layer_msg($name."ʧ�ܣ�",8,"index.php?m=admin_comrating");
	}
	function delrating_action(){
		if($_POST['del']){
			$layer_type='1';
			$id=pylode(',',$_POST['del']);
		}else if($_GET['id']){
			$this->check_token();
			$id=$_GET['id'];
			$layer_type='0';
		}
		$nid=$this->obj->DB_delete_all("company_rating","`id` in(".$id.")","");
		$this->cache_rating();
		$nid?$this->layer_msg('ɾ����ҵ��Ա�ȼ���ID��(ID:'.$id.')�ɹ���',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('ɾ��ʧ�ܣ�',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}
	function delpic_action(){
		if($_GET['id']){
			$this->check_token();
			$row=$this->obj->DB_select_once("company_rating","`id`='".$_GET['id']."'","`com_pic`");
			@unlink("..".$row['com_pic']);
			$this->obj->DB_update_all("company_rating","`com_pic`=''","`id`='".$_GET['id']."'");
			$this->cache_rating();
			$this->layer_msg('��ҵ��Ա�ȼ���ID��(ID:'.$_GET['id'].')ͼ��ɾ���ɹ���',9,0,$_SERVER['HTTP_REFERER']);
		}
	}
	function cache_rating(){
		include(LIB_PATH."cache.class.php");
		$cacheclass= new cache(PLUS_PATH,$this->obj);
		$makecache=$cacheclass->comrating_cache("comrating.cache.php");
	}

	function server_action(){
		$list=$this->obj->DB_select_all("company_service");
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/admin_com_rating'));
	}

	function srating_action(){
		$this->yuntpl(array('admin/admin_comrating_add'));
	}
	function save_action(){
		if($_POST['useradd']){
			unset($_POST['useradd']);
			$name=$_POST['name'];
			$row=$this->obj->DB_select_all("company_service","`name`='".$name."'");
			if (!empty($row)){
				$this->ACT_layer_msg("��ֵ�������Ѵ��ڣ�",8);
			}else{
				$nid=$this->obj->insert_into("company_service",$_POST);
				$name="��ҵ��ֵ����ID��".$nid."�����";
			}
		}
		$nid?$this->ACT_layer_msg($name."�ɹ���������ֵ��������ײͣ�",9,"index.php?m=admin_comrating&c=edit&id=".$nid,2,1):$this->ACT_layer_msg($name."ʧ�ܣ�",8);
	}

	function edit_action(){
		if($_GET['id']){
			$row=$this->obj->DB_select_once("company_service","`id`='".$_GET['id']."'");
			$this->yunset("row",$row);
			$list=$this->obj->DB_select_all("company_service_detail","`type`='".$_GET['id']."' order by `id` asc");
			$this->yunset("list",$list);
		}
		$this->yuntpl(array('admin/admin_comservice_add'));
	}

	function opera_action(){
		if ($_POST['display'] && $_POST['id']){
			$nid=$this->obj->update_once("company_service",array("display"=>$_POST['display']),array("id"=>$_POST['id']));
			if ($nid){
				echo 1;die;
			}else{
				echo 2;die;
			}
		}
	}

	function delserver_action(){
		if($_POST['del']){
			$layer_type='1';
			$id=pylode(',',$_POST['del']);
		}else if($_GET['id']){
			$this->check_token();
			$id=$_GET['id'];
			$layer_type='0';
		}
		$nid=$this->obj->DB_delete_all("company_service","`id` in(".$id.")","");
		$nid?$this->layer_msg('��ֵ�����ɾ��(ID:'.$id.')�ɹ���',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('ɾ��ʧ�ܣ�',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}

	function saves_action(){
		if($_POST['useradd']){
			$id=$_POST['id'];
			$_POST['type']=$id;
			unset($_POST['useradd']);
			unset($_POST['id']);
			$nid=$this->obj->insert_into("company_service_detail",$_POST);
			$name="�ײͣ�ID��".$id."�����";
		}
		$nid?$this->ACT_layer_msg($name."�ɹ���",9,"index.php?m=admin_comrating&c=edit&id=".$id,2,1):$this->ACT_layer_msg($name."ʧ�ܣ�",8,$_SERVER['HTTP_REFERER']);
	}

	function del_action(){
		if($_GET['id']){
			$this->check_token();
			$id=$_GET['id'];
			$layer_type='0';
		}
		$nid=$this->obj->DB_delete_all("company_service_detail","`id` in(".$id.")","");
		$nid?$this->layer_msg('�ײ�ɾ��(ID:'.$id.')�ɹ���',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('ɾ��ʧ�ܣ�',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}
	function ajax_action(){
	    if($_POST['name']){
	        $_POST['name']=iconv("UTF-8","gbk",$_POST['name']);
	        $name=$this->obj->DB_select_num('company_service',"`name`='".$_POST['name']."' and  `id` <>'".$_POST['id']."'");
	        if($name){
	        	echo 2;die;
	        }
	        $this->obj->DB_update_all("company_service","`name`='".$_POST['name']."'","`id`='".$_POST['id']."'");
	        $this->admin_log("��ҵ��ֵ��(ID:".$_POST['id'].")�����޸ĳɹ�");
	    }
	    echo '1';die;
	}
}
?>