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
class admin_message_controller extends common{

	function set_search(){
		$search_list[]=array("param"=>"infotype","name"=>'�������',"value"=>array("1"=>"����","2"=>"���","3"=>"����","4"=>"Ͷ��"));
		$ad_time=array('1'=>'����','3'=>'�������','7'=>'�������','15'=>'�������','30'=>'���һ����');
		$search_list[]=array("param"=>"end","name"=>'���ʱ��',"value"=>$ad_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
		$where =1;
		if(trim($_GET['keyword'])){
			if($_GET["type"]==1){
				$where.=" and `username` like '%".trim($_GET['keyword'])."%'";
			}else{
				$where.=" and `content` like '%".trim($_GET['keyword'])."%'";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['end']){
			if($_GET['end']=='1'){
				$where.=" and `ctime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `ctime` >= '".strtotime('-'.$_GET['end'].'day')."'";
			}
			$urlarr['end']=$_GET['end'];
		}
		if($_GET['infotype']){
			$where.=" and `infotype` = '".$_GET['infotype']."'";
			$urlarr['infotype']=$_GET['infotype'];
		}
		if($_GET['order']){
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by ctime desc";
		}
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
        $M=$this->MODEL();
		$PageInfo=$M->get_page("advice_question",$where,$pageurl,$this->config['sy_listnum']);
        $this->yunset($PageInfo);
		$this->yunset("get_type", $_GET);
		$this->yuntpl(array('admin/admin_message'));
	}
   function show_action(){
		if($_POST['submit']){
			if($_POST['content']==""){
				$this->ACT_layer_msg("����д���ݣ�",2,"index.php?m=admin_message");
			}
			$value="`reply`='".$_POST['content']."',`reply_time`='".time()."',`status`='1'";
			$nid=$this->obj->DB_update_all("message",$value,"`id`='".$_POST['id']."'");
 		    $nid?$this->ACT_layer_msg("��������ظ�(ID:$nid)�ɹ���",9,"index.php?m=admin_message",2,1):$this->ACT_layer_msg("�ظ�(ID:$nid)ʧ�ܣ�",8,$_SERVER['HTTP_REFERER']);
		}
		$this->yuntpl(array('admin/admin_message_show'));
	}
	function del_action(){
	    if($_GET['del']){
			$this->check_token();
	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($del)){
	    			$del=@implode(',',$del);
					$layer_msg=1;
		    	}else{
					$layer_msg=0;
		    	}
		    	$this->obj->DB_delete_all("advice_question","`id` in (".$del.")","");
				$this->layer_msg("�������(ID:".$del.")ɾ���ɹ���",9,$layer_msg,$_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg('�Ƿ�������',8);
			}
	    }
	}
	function content_action(){
		$con=$this->obj->DB_select_once('advice_question','`id`=\''.intval($_GET['id']).'\'');
		
		if($con['infotype']==1){
			$con['type']='����';
		}elseif($con['infotype']==2){
			$con['type']='���';
		}elseif($con['infotype']==3){
			$con['type']='����';
		}elseif($con['infotype']==4){
			$con['type']='Ͷ��';
		}
		$con['name']=yun_iconv("gbk","utf-8",$con['username']);
		$con['type']=yun_iconv("gbk","utf-8",$con['type']);
		$con['ctime']=date('Y-m-d H:s:m',$con['ctime']);
		$con['content']=yun_iconv("gbk","utf-8",$con['content']);
		echo json_encode($con);die;
	}
}