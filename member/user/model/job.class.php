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
class job_controller extends user{
	function index_action(){
        $this->yunset($this->MODEL('cache')->GetCache(array('city','com')));
		$this->public_action();
		$this->member_satic();
		if($_GET['browse']){
			$where.="is_browse='".$_GET['browse']."' and ";
			$urlarr['browse']=$_GET['browse'];
		}
		if($_GET['datetime']){
			if($_GET['datetime']=='1'){
				$where.="`datetime`>'".strtotime(date("Y-m-d 00:00:00"))."' and ";
			}else{
				$where.="`datetime`>'".strtotime('-'.intval($_GET['datetime']).' day')."' and ";
			}
			$urlarr['datetime']=$_GET['datetime'];
		}
		$urlarr=array("c"=>"job","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$rows=$this->get_page("userid_job",$where."`uid`='".$this->uid."' order by id desc",$pageurl,"10");
		$rList=$this->obj->DB_select_all("resume_expect","`uid`=".$this->uid."","`id`");
		if($rows&&is_array($rows)){
			foreach($rows as $val){
				$jobids[]=$val['job_id'];
				$comids[]=$val['com_id'];
				$uid[]=$val['uid'];
				foreach ($rList as $v){
				    if($v['id']==$val['eid']){
				        $EidList[]=$val['eid'];
				    }
				}
			}
			$company_job=$this->obj->DB_select_all("company_job","`id` in(".pylode(',',$jobids).")","`id`,`salary`,`provinceid`,`cityid`");
            $ResumeList=$this->obj->DB_select_all("resume_expect","`id` in(".pylode(',',$EidList).")","`id`,`name`");
			$userid_msg=$this->obj->DB_select_all("userid_msg","`fid` in(".pylode(',',$comids).") and `uid` in (".pylode(",",$uid).")","uid,jobid");
			foreach($rows as $key=>$val){
				foreach($company_job as $v){
					if($val['job_id']==$v['id']){
						$rows[$key]['salary']=$v['salary'];
						$rows[$key]['provinceid']=$v['provinceid'];
						$rows[$key]['cityid']=$v['cityid'];
					}
				}
                foreach($ResumeList as $v){
					if($val['eid']==$v['id']){
						$rows[$key]['resume_name']=$v['name'];
						
					}
				}
				foreach($userid_msg as $v){
					if($v['uid']==$val['uid'] && $v['jobid']==$val['job_id']){
						$rows[$key]['userid_msg']=1;
					}
				}
			}
		}
        $StateList=array('1'=>'δ�鿴','2'=>'�Ѳ鿴','3'=>'�ȴ�֪ͨ','4'=>'��������','5'=>'�޷���ϵ');
		$this->yunset("StateList",$StateList);
		$search_list=array('1'=>'����','3'=>'�������','7'=>'�������','15'=>'�������','30'=>'���һ����');
		$this->yunset("search_list",$search_list);
		$num=$this->obj->DB_select_num("userid_job","`uid`='".$this->uid."'");
		$this->obj->DB_update_all("member_statis","sq_jobnum='".$num."'","`uid`='".$this->uid."'");
		$this->yunset("rows",$rows);
		$this->yunset("js_def",3);
		$this->user_tpl('job');
	}
	function del_action(){		
		if($_GET['del']||$_GET['id']){
			if(is_array($_GET['del'])){				
				$del=pylode(",",$_GET['del']);
				$layer_type=1;
			}else{
				$del=(int)$_GET['id'];
				$layer_type=0;
			}
			$userid=$this->obj->DB_select_once("userid_job","`id`='".$del."' and `uid`='".$this->uid."'","com_id,job_id");
			$nid=$this->obj->DB_delete_all("userid_job","`id` in (".$del.") and `uid`='".$this->uid."'","");
			if($nid){
				$historyM = $this->MODEL('history');
				$useridjob  = $historyM->useridjobHistory($this->uid);
				if($this->config['sy_web_site']=="1"){
					if($this->config['sy_onedomain']!=""){
						$weburl=get_domain($this->config['sy_onedomain']);
					}elseif($this->config['sy_indexdomain']!=""){
						$weburl=get_domain($this->config['sy_indexdomain']);
					}else{
						$weburl=get_domain($this->config['sy_weburl']);
					}
					SetCookie("useridjob",$useridjob,time() + 86400,"/",$weburl);
				
				}else{
					SetCookie("useridjob",$useridjob,time() + 86400,"/");
				}
				$fnum=$this->obj->DB_select_num("userid_job","`uid`='".$this->uid."'");
				$cnum=$this->obj->DB_select_num("userid_job","`com_id`='".$userid['com_id']."'");
				$this->obj->DB_update_all("member_statis","sq_jobnum='".$fnum."'","`uid`='".$this->uid."'");
				$this->obj->DB_update_all("company_statis","`sq_job`='".$cnum."'","`uid`='".$userid['com_id']."'");
				$this->obj->member_log("ɾ�������ְλ��Ϣ",6,3);
				$this->layer_msg('ɾ���ɹ���',9,$layer_type,"index.php?c=job");
			}			
		}
		
		
	}
	function is_browse_action(){		
		if($_POST['ajax']==1 && $_POST['ids']){			
			$this->obj->DB_update_all("userid_job","`quxiao`='1'","`id` in (".pylode(",",$_POST['ids']).")");
			$this->layer_msg('����ȡ���ɹ���',9,0,"index.php?c=job");
		}
	}
	function qs_action(){
		if($_POST['id']){
			$del=(int)$_POST['id'];
			$nid=$this->obj->DB_update_all("userid_job","`body`='".$_POST['body']."'","`id`='".$del."'");
			if($nid){
				$this->obj->member_log("ȡ�������ְλ��Ϣ",6,3);
				$this->ACT_layer_msg('ȡ���ɹ���',9,$_SERVER['HTTP_REFERER']);
			}else{
				$this->ACT_layer_msg('ȡ��ʧ�ܣ�',8,$_SERVER['HTTP_REFERER']);
			}
		}
	}
}
?>