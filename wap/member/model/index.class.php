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
class index_controller extends wap_controller{
	function waptpl($tpname){
		$this->yuntpl(array('wap/member/user/'.$tpname));
	}
	function get_user(){
		$statis=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'");
		if(!$statis['name'] || !$statis['edu']){			
			 $data['msg']='�������Ƹ������ϣ�';
		     $data['url']='index.php?c=info';
			 $this->yunset("layer",$data);	
		}
	}
	function index_action(){
		$this->rightinfo();
		$looknum=$this->obj->DB_select_num("look_resume","`uid`='".$this->uid."' and `status`='0'");
		$look_jobnum=$this->obj->DB_select_num("look_job","`uid`='".$this->uid."' and `status`='0'");
		$this->yunset("looknum",$looknum);
		$this->yunset("look_jobnum",$look_jobnum);
		$yqnum=$this->obj->DB_select_num("userid_msg","`uid`='".$this->uid."'");
		$this->yunset("yqnum",$yqnum);
		$wkyqnum=$this->obj->DB_select_num("userid_msg","`uid`='".$this->uid."' and `is_browse`=1");
		$this->yunset("wkyqnum",$wkyqnum);
		$statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'");
		$resume_num=$this->obj->DB_select_num("resume_expect","`uid`='".$this->uid."'");
		$this->yunset("resume_num",$resume_num);
		$sq_nums=$this->obj->DB_select_num("userid_job","`uid`='".$this->uid."' ");
		$statis['sq_jobnum']=$sq_nums;
		$expect=$this->obj->DB_select_once("resume_expect","`uid`='".$this->uid."' and `defaults`='1'","integrity,id");
		$fav_jobnum=$this->obj->DB_select_num("fav_job","`uid`='".$this->uid."'");
		$statis['fav_jobnum']=$fav_jobnum;
		$this->yunset("expect",$expect);
		
		$user=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'");
		$this->yunset("user",$user);
		
		
		$this->yunset("statis",$statis);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->waptpl('index');
	}
	function photo_action(){
		if($_POST['submit']){
			preg_match('/^(data:\s*image\/(\w+);base64,)/', $_POST['uimage'], $result);
			$uimage=str_replace($result[1], '', str_replace('#','+',$_POST['uimage']));
			if(in_array(strtolower($result[2]),array('jpg','png','gif','jpeg'))){
				$new_file = time().rand(1000,9999).".".$result[2];
			}else{
				$new_file = time().rand(1000,9999).".jpg";
			}
			$im = imagecreatefromstring(base64_decode($uimage));
			if ($im === false) {
				echo 2;die;
			}
			if (!file_exists(DATA_PATH."upload/user/".date('Ymd')."/")){
				mkdir(DATA_PATH."upload/user/".date('Ymd')."/");
				chmod(DATA_PATH."upload/user/".date('Ymd')."/",0777);

			}
			$re=file_put_contents(DATA_PATH."upload/user/".date('Ymd')."/".$new_file, base64_decode($uimage));
			chmod(DATA_PATH."upload/user/".date('Ymd')."/".$new_file,0777);
			if($re){
				$user=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","`photo`,`resume_photo`");
				if($user['photo']||$user['resume_photo']){
					unlink_pic(APP_PATH.$user['photo']);
					unlink_pic(APP_PATH.$user['resume_photo']);
				}
				$photo="./data/upload/user/".date('Ymd')."/".$new_file;
				$this->obj->DB_update_all("resume","`resume_photo`='".$photo."',`photo`='".$photo."'","`uid`='".$this->uid."'");
				$this->obj->DB_update_all("resume_expect","`photo`='".$photo."'","`uid`='".$this->uid."'");
				echo 1;die;
			}else{
				unlink_pic("../data/upload/user/".date('Ymd')."/".$new_file);
				echo 2;die;
			}
		} else{
			$user=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","sex,`resume_photo`,`phototype`");
		    if(!$user['resume_photo'] || !file_exists(str_replace('./',APP_PATH,$user['resume_photo']))){
			    if ($user['sex']==1){
			        $user['resume_photo']=$this->config['sy_weburl']."/".$this->config['sy_member_icon'];
			    }else{
			        $user['resume_photo']=$this->config['sy_weburl']."/".$this->config['sy_member_iconv'];
			    }
			}else{
			    $user['resume_photo']=str_replace("./",$this->config['sy_weburl']."/",$user['resume_photo']);
			}
			$this->yunset("user",$user);
			$backurl=Url('wap',array(),'member');
		    $this->yunset('backurl',$backurl);
			$this->get_user();
			$this->waptpl('photo');
		}
	}
	function phototype_action(){
	    $this->obj->DB_update_all("resume","`phototype`='".intval($_POST['phototype'])."'","uid='".$this->uid."'");
	    echo $_POST['phototype'];die();
	}
	function sq_action(){
		$this->rightinfo();
		$urlarr=array("c"=>"sq","page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$rows=$this->get_page("userid_job","`uid`='".$this->uid."' order by id desc",$pageurl,"10");
		if(is_array($rows)){
			foreach($rows as $v){
				$com_id[]=$v['com_id'];
			}
			$company=$this->obj->DB_select_all("company","`uid` in (".pylode(",",$com_id).")","cityid,uid,name");
			include PLUS_PATH."/city.cache.php";
			foreach($rows as $k=>$v){
				foreach($company as $val){
					if($v['com_id']==$val['uid']){
						$rows[$k]['city']=$city_name[$val['cityid']];
                        $rows[$k]['com_name']=$val['name'];
					}
				}
			}
		}
		$this->yunset("rows",$rows);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('sq');
	}
	function partcollect_action(){
		$this->rightinfo();
		if($_GET['del']){
			$id=$this->obj->DB_delete_all("part_collect","`id`='".(int)$_GET['del']."' and `uid`='".$this->uid."'");
			if($id){
				$data['msg']="ɾ���ɹ�!";
				$this->member_log("ɾ���ղصļ�ְ");
			}else{
				$data['msg']="ɾ��ʧ�ܣ�";
			}
			$data['url']='index.php?c=partcollect';
			$this->yunset("layer",$data);
		}
		$urlarr=array("c"=>"partcollect","page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$rows=$this->get_page("part_collect","`uid`='".$this->uid."' order by id desc",$pageurl,"10");
		if($rows&&is_array($rows)){
			foreach($rows as $val){
				$jobids[]=$val['jobid'];
			}
			$joblist=$this->obj->DB_select_all("partjob","`id` in(".pylode(',',$jobids).")","`id`,`name`,`com_name`");
			foreach($rows as $key=>$val){
				foreach($joblist as $v){
					if($val['jobid']==$v['id']){
						$rows[$key]['job_name']=$v['name'];
						$rows[$key]['com_name']=$v['com_name'];

					}
				}
			}
		}
		$this->yunset("rows",$rows);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('partcollect');
	}
	
	function partapply_action(){
		$this->rightinfo();
		if($_GET['del']){
			$nid=$this->obj->DB_delete_all("part_apply","`id`='".(int)$_GET['del']."' and `uid`='".$this->uid."'");
			if($nid){
				$data['msg']="ɾ���ɹ�!";
				$this->member_log("ɾ�������ļ�ְ");
			}else{
				$data['msg']="ɾ��ʧ�ܣ�";
			}
			$data['url']='index.php?c=partapply';
			$this->yunset("layer",$data);
		}
		$urlarr=array("c"=>"partapply","page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$rows=$this->get_page("part_apply","`uid`='".$this->uid."' order by id desc",$pageurl,"10");
		if($rows&&is_array($rows)){
			include PLUS_PATH."/city.cache.php";
			foreach($rows as $val){
				$jobids[]=$val['jobid'];
			}
			$joblist=$this->obj->DB_select_all("partjob","`id` in(".pylode(',',$jobids).")","`id`,`name`,`cityid`,`com_name`,`linktel`");
			foreach($rows as $key=>$val){
				foreach($joblist as $v){
					if($val['jobid']==$v['id']){
						$rows[$key]['job_name']=$v['name'];
						$rows[$key]['city']=$city_name[$v['cityid']];
						$rows[$key]['com_name']=$v['com_name'];
						$rows[$key]['linktel']=$v['linktel'];
					}
				}
			}
		}

		$this->yunset("rows",$rows);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('partapply');
	}
	function delsq_action(){
		if($_GET['id']){
			$userid_job=$this->obj->DB_select_once("userid_job","`id`='".(int)$_GET['id']."' and `uid`='".$this->uid."'");
			$id=$this->obj->DB_delete_all("userid_job","`id`='".(int)$_GET['id']."' and `uid`='".$this->uid."'");
			if($id){
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
				$this->obj->DB_update_all('company_statis',"`sq_job`=`sq_job`-1","`uid`='".$userid_job['com_id']."'");
				$this->obj->DB_update_all('member_statis',"`sq_jobnum`=`sq_jobnum`-1","`uid`='".$userid_job['uid']."'");
				$this->member_log("ɾ�������ְλ");
				$this->waplayer_msg('ɾ���ɹ���');
			}else{
				$this->waplayer_msg('ɾ��ʧ�ܣ�');
			}
		}
	}

	function collect_action(){
		$this->rightinfo();
		if($_GET['del']){
			$id=$this->obj->DB_delete_all("fav_job","`id`='".$_GET['del']."' and `uid`='".$this->uid."'");
			if($id){
				$historyM = $this->MODEL('history');
				$favjob  = $historyM->favjobHistory($this->uid);
				if($this->config['sy_web_site']=="1"){
					if($this->config['sy_onedomain']!=""){
						$weburl=get_domain($this->config['sy_onedomain']);
					}elseif($this->config['sy_indexdomain']!=""){
						$weburl=get_domain($this->config['sy_indexdomain']);
					}else{
						$weburl=get_domain($this->config['sy_weburl']);
					}
					SetCookie("favjob",$favjob,time() + 86400,"/",$weburl);
				
				}else{
					SetCookie("favjob",$favjob,time() + 86400,"/");
				}
				$data['msg']="ɾ���ɹ�!";
				$this->obj->DB_update_all("member_statis","`fav_jobnum`=`fav_jobnum`-1","uid='".$this->uid."'");
				$this->member_log("ɾ���ղص�ְλ");
			}else{
				$data['msg']="ɾ��ʧ�ܣ�";
			}
			$data['url']='index.php?c=collect';
			$this->yunset("layer",$data);
		}
		$urlarr=array("c"=>"collect","page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$this->get_page("fav_job","`uid`='".$this->uid."' order by id desc",$pageurl,"10");
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('collect');
	}

	function password_action(){
		if($_POST['submit']){
			$member=$this->obj->DB_select_once("member","`uid`='".$this->uid."'");
			$pw=md5(md5($_POST['oldpassword']).$member['salt']);
			if($pw!=$member['password']){
				$data['msg']="�����벻��ȷ�����������룡";
			}else if(strlen($_POST['password1'])<6 || strlen($_POST['password1'])>20){
				$data['msg']="���볤��Ӧ��6-20λ��";
			}else if($_POST['password1']!=$_POST['password2']){
				$data['msg']="�������ȷ�����벻һ�£�";
			}else if($this->config['sy_uc_type']=="uc_center" && $member['name_repeat']!="1"){
				$this->uc_open();
				$ucresult= uc_user_edit($member['username'], $_POST['oldpassword'], $_POST['password1'], "","1");
				if($ucresult == -1){
					$data['msg']="�����벻��ȷ�����������룡";
				}
			}else{
				$salt = substr(uniqid(rand()), -6);
				$pass2 = md5(md5($_POST['password1']).$salt);
				$this->obj->DB_update_all("member","`password`='".$pass2."',`salt`='".$salt."'","`uid`='".$this->uid."'");
				SetCookie("uid","",time() -286400, "/");
				SetCookie("username","",time() - 86400, "/");
				SetCookie("salt","",time() -86400, "/");
				SetCookie("shell","",time() -86400, "/");
				$this->member_log("�޸�����");
				$data['msg']="�޸ĳɹ��������µ�¼��";
				$data['url']=$this->config['sy_weburl'].'/wap/index.php?m=login';
			}
            $this->waplayer_msg($data['msg'],$data['url']);
			
		}
		$this->rightinfo();
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('password');
	}
	function invitecont_action(){
		$this->rightinfo();
		$id=(int)$_GET['id'];
		$info=$this->obj->DB_select_once("userid_msg","`id`='".$id."' and `uid`='".$this->uid."'");
		if($info['is_browse']==1){
			$this->obj->update_once("userid_msg",array('is_browse'=>2),array("id"=>$info['id']));
		}
		$this->yunset("info",$info);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('invitecont');
	}
	function inviteset_action(){
		$id=(int)$_GET['id'];
		$browse=(int)$_GET['browse'];
		if($id){
			$nid=$this->obj->update_once("userid_msg",array('is_browse'=>$browse),array("id"=>$id,"uid"=>$this->uid));
			$comuid=$this->obj->DB_select_once("userid_msg","`id`='".$id."'",'fid,jobid');
			$comarr=$this->obj->DB_select_once("company_job","`id`='".$comuid['jobid']."' and `r_status`<>'2' and `status`<>'1'");
			$uid=$this->obj->DB_select_once("company","`uid`='".$comuid['fid']."'","linkmail,linktel,name");
			$name=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","name");
			$data['uid']=$comuid['fid'];
			$data['cname']=$this->username;
			$data['name']=$uid['name'];
			$data['type']="yqmshf";
			$data['cuid']=$this->uid;
			$data['cusername']=$name['name'];
			if($browse==3){
				$data['typemsg']='ͬ��';
			}elseif($browse==4){
				$data['typemsg']='�ܾ�';
			}
			if($this->config['sy_msg_yqmshf']=='1'&&$uid["linktel"]&&$this->config["sy_msguser"]&&$this->config["sy_msgpw"]&&$this->config["sy_msgkey"]&&$this->config['sy_msg_isopen']=='1'){$data["moblie"]=$uid["linktel"]; }

			if($this->config['sy_email_yqmshf']=='1'&&$uid["linkmail"]&&$this->config['sy_email_set']=="1"){$data["email"]=$uid["linkmail"]; }
			if($data["email"]||$data['moblie']){
				$this->send_msg_email($data);
			}
			$nid?$this->waplayer_msg("�����ɹ���"):$this->waplayer_msg("����ʧ�ܣ�");
		}
	}
	function invite_action(){
		$this->rightinfo();
		if($_GET['id']){
			$id=$this->obj->DB_delete_all("userid_msg","`id`='".(int)$_GET['id']."' and `uid`='".$this->uid."'");
			if($id){
				$this->member_log("ɾ��������Ϣ");
				$this->layer_msg('�����ɹ���',9,0,"index.php?c=invite");
			}else{
				$this->layer_msg('����ʧ�ܣ�',8,0,"index.php?c=invite");
			}
			$data['url']='index.php?c=invite';
			$this->yunset("layer",$data);
		}
		$urlarr=array("c"=>"invite","page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$this->get_page("userid_msg","`uid`='".$this->uid."' order by id desc",$pageurl,"10");
		$this->yunset("backurl","index.php");
		$this->get_user();
		$this->waptpl('invite');
	}
	function look_action(){
		$this->rightinfo();
		if($_GET['del']){
			$id=$this->obj->DB_delete_all("look_resume","`id`='".(int)$_GET['del']."' and `uid`='".$this->uid."'");
			if($id){
				$data['msg']="ɾ���ɹ�!";
				$this->member_log("ɾ�����������¼");
			}else{
				$data['msg']="ɾ��ʧ��!";
			}
			$data['url']='index.php?c=look';
			$this->yunset("layer",$data);
		}
		$urlarr=array("c"=>"look","page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$rows=$this->get_page("look_resume","`uid`='".$this->uid."' order by id desc",$pageurl,"10");
		if(is_array($rows)){
			foreach($rows as $v){
				$uid[]=$v['com_id'];
				$eid[]=$v['resume_id'];
			}
			$type=$this->obj->DB_select_all("member","`uid`IN  (".pylode(",",$uid).")","uid,usertype");
			foreach($type as  $v){
				if($v['usertype']==2){
					$com_uid[]=$v['uid'];
				}
			}
			$company=$this->obj->DB_select_all("company","`uid` IN (".pylode(",",$com_uid).")","uid,name");
			$resume=$this->obj->DB_select_all("resume_expect","`id` in (".pylode(",",$eid).")","`id`,`name`");
			foreach($rows as $k=>$v){
				foreach($company as $val){
					if($v['com_id']==$val['uid']){
						$rows[$k]['com_name']=$val['name'];
						$rows[$k]['type']=2;
					}
				}
				
				foreach($resume as $val){
					if($v['resume_id']==$val['id']){
						$rows[$k]['resume_name']=$val['name'];
					}
				}
			}
		}
		$this->yunset("rows",$rows);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('look');
	}

	function addresume_action(){
		include(CONFIG_PATH."db.data.php");
		unset($arr_data['sex'][3]);
		$this->yunset("arr_data",$arr_data);
		$this->rightinfo();				
		$resume=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'");
		$arr_data1=$arr_data['sex'][$resume['sex']];		
		$this->yunset("arr_data1",$arr_data1);
		$this->yunset("resume",$resume);
		$this->yunset($this->MODEL('cache')->GetCache(array('city','user','hy','job')));
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->waptpl('addresume');
	}
	function kresume_action(){		
		$row=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'");
		if(!$_POST['name']||!$_POST['hy']||!$_POST['job_classid']||!$_POST['minsalary']||!$_POST['cityid']||!$_POST['type']||!$_POST['report']||!$_POST['jobstatus']||!$_POST['uname']||!$_POST['sex']||!$_POST['birthday']||!$_POST['edu']||!$_POST['exp']||!$_POST['telphone']||!$_POST['living']){
			echo 6;die;	
		}
		$min = (int)$_POST['minsalary'];$max= (int)$_POST['maxsalary'];
		if($min>$max && $max>0){
			echo 7;die;
		}
		if($this->config['user_enforce_identitycert']=="1"){
			if($row['idcard_status']!="1"){
				echo 5;die;				
			}
		}
		$num=$this->obj->DB_select_num("resume_expect","`uid`='".$this->uid."'");
		if($num>=$this->config['user_number']){
			echo 4;die;		  
		}
		if($_POST['email']!=""){
			$email=$this->obj->DB_select_num("member","`uid`<>'".$this->uid."' and `email`='".$_POST['email']."'","`uid`");
			if($email){
				echo 3;die;
			  
			}
		}
		
		$mobile=$this->obj->DB_select_once("member","`uid`<>'".$this->uid."' and `moblie`='".$_POST['telphone']."'","`uid`");
		if($mobile){
			echo 2;die;
		  
		}		       
		delfiledir("../data/upload/tel/".$this->uid);
		$where['uid']=$this->uid;		       
		$data['edu']=$_POST['edu'];
		$data['exp']=$_POST['exp'];
		$data['name']=iconv("utf-8", "gbk", $_POST['uname']);
		$data['sex']=$_POST['sex'];
		$data['birthday']=$_POST['birthday'];
		$data['living']=iconv("utf-8", "gbk", $_POST['living']);
		if($row['moblie_status']==0){
			$data['telphone']=$_POST['telphone'];
			$mvalue['moblie']=$_POST['telphone'];
		}
		if($row['email_status']==0){
			$data['email']=$_POST['email'];
			$mvalue['email']=$_POST['email'];
		}
		$data['lastupdate']=time();
		$nid=$this->obj->update_once("resume",$data,$where);
		if($nid){
			if(!empty($mvalue)){
				$this->obj->update_once('member',$mvalue,$where);
			}
			if($row['name']==""||$row['living']==""){
				$this->MODEL('userinfo')->company_invtal($this->uid,$this->config['integral_userinfo'],true,"�״���д��������",true,2,'integral',25);
			}
			$edata=array();
			$edata['idcard_status']=$row['idcard_status'];
			$edata['status']=$row['status'];
			$edata['r_status']=$row['r_status'];
			$edata['photo']=$row['photo'];
			$edata['edu']=$data['edu'];
			$edata['exp']=$data['exp'];
			$edata['uname']=$data['name'];
			$edata['sex']=$data['sex'];
			$edata['birthday']=trim($data['birthday']);
			$edata['name']=trim(iconv("utf-8", "gbk", $_POST['name']));
			$edata['jobstatus']=(int)$_POST['jobstatus'];
			$edata['report']=(int)$_POST['report'];
			$edata['hy']=(int)$_POST['hy'];
			$edata['type']=(int)$_POST['type'];
			$edata['job_classid']=$_POST['job_classid'];
			$edata['minsalary']=(int)$_POST['minsalary'];
			$edata['maxsalary']=(int)$_POST['maxsalary'];
			$edata['provinceid']=(int)$_POST['provinceid'];
			$edata['cityid']=(int)$_POST['cityid'];
			$edata['three_cityid']=(int)$_POST['three_cityid'];
			$edata['uid']=$this->uid;
			$edata['did']=$this->userdid;
			$edata['integrity']=55;
			$edata['lastupdate']=time();
			$edata['ctime']=time();
			$edata['source']=2;
			$edata['defaults']=$num<=0?1:0;
			$eid=$this->obj->insert_into("resume_expect",$edata);
			if($eid){
				if($num==0){
					$this->obj->update_once('resume',array('def_job'=>$eid,'resumetime'=>time()),array('uid'=>$this->uid));
					
				}else{
					$this->obj->update_once('resume',array('resumetime'=>time()),array('uid'=>$this->uid));
				}
				$this->obj->insert_into("user_resume",array("eid"=>$eid,"uid"=>$this->uid,"expect"=>1));
				$resume_num=$num+1;
				$this->obj->DB_update_all('member_statis',"`resume_num`='".$resume_num."'","`uid`='".$this->uid."'");
				$resume_url=Url("resume",array("c"=>"show","id"=>$eid));
				$state_content = "������ <a href=\"".$resume_url."\" target=\"_blank\">�¼���</a>��";
				$fdata['uid']	  = $this->uid;
				$fdata['content'] = $state_content;
				$fdata['ctime']   = time();
				$fdata['type']   = 2;
				$this->obj->insert_into("friend_state",$fdata);
				$this->obj->member_log("����һ�ݼ���",2,1);
				$num=$this->obj->DB_select_num("company_pay","`com_id`='".$this->uid."' AND `pay_remark`='��������'");
				if($num<1){
					$this->get_integral_action($this->uid,"integral_add_resume","��������");
				}
				$this->warning("3");
			   echo 1;die;
			}else{
			   echo 0;die;
			}		      
		}		   				
	}
	function addresumeson_action(){
		$this->rightinfo();
		if(!in_array($_GET['type'],array('expect','desc','cert','doc','edu','other','project','show','skill','tiny','training','work'))){
			unset($_GET['type']);
		}
		if($_GET['type']=="desc"){
			$desc=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","`description`,`tag`");
			if($desc['tag']){
				$tag = @explode(',',$desc['tag']);
			}
			
			$this->yunset("arrayTag",$tag);
			$this->yunset("description",$desc['description']);
		}
		if($_GET['id'] && $_GET['type']){

			$row=$this->obj->DB_select_once("resume_".$_GET['type'],"`id`='".(int)$_GET['id']."' and `uid`='".$this->uid."'"); 
			$this->yunset("row",$row);
		}
		$this->user_cache(); 
		if($_POST['submit']){
		   $_POST=$this->post_trim($_POST);
		   if($_POST['eid']>0){
		       if($_POST['table']=='skill'){
		           $id=(int)$_POST['id'];
		           $url=$_POST['table'];
		           if(is_uploaded_file($_FILES['file']['tmp_name'])){
		               $resume=$this->obj->DB_select_once("resume_skill","`id`='".$id."',","pic");
		               $upload=$this->upload_pic(APP_PATH."data/upload/user/",false);
		               $pictures=$upload->picture($_FILES['file']);
		               $this->picmsg($pictures,$_SERVER['HTTP_REFERER'],'wap');
		               $pictures = str_replace(APP_PATH."data/upload/user","./data/upload/user",$pictures);
		           }
		           if(strlen($pictures)!=1){ 
		               if($id){
		                   if($pictures==''){
		                       $nid=$this->obj->DB_update_all("resume_skill", "`uid`='".$this->uid."',`eid`='".$_POST['eid']."',`name`='".$_POST['name']."',`longtime`='".$_POST['longtime']."'","`id`='".$id."'");
		                   }else{
		                       $nid=$this->obj->DB_update_all("resume_skill", "`uid`='".$this->uid."',`eid`='".$_POST['eid']."',`name`='".$_POST['name']."',`longtime`='".$_POST['longtime']."',`pic`='".$pictures."'","`id`='".$id."'");
		                   }
		               }else{
		                   $nid=$this->obj->DB_insert_once("resume_skill", "`uid`='".$this->uid."',`eid`='".$_POST['eid']."',`name`='".$_POST['name']."',`longtime`='".$_POST['longtime']."',`pic`='".$pictures."'");
		                   $this->obj->DB_update_all("user_resume","`$url`=`$url`+1","`eid`='".(int)$_POST['eid']."' and `uid`='".$this->uid."'");
		                   $resume_row=$this->obj->DB_select_once("user_resume","`eid`='".(int)$_POST['eid']."'");
		                   $this->complete($resume_row);
		               }
		               $nid?$data['msg']='����ɹ���':$data['msg']='����ʧ�ܣ�';
		               $data['url']="index.php?c=rinfo&eid=".$_POST['eid']."&type=".$url;
		               $this->yunset("layer",$data);
		           }
		       }
		   }
		}
		if($_GET['type']=='desc'){
			$backurl=Url('wap',array('c'=>'modify','eid'=>$_GET['eid']),'member');
		}else{
			$backurl=Url('wap',array('c'=>'rinfo','eid'=>$_GET['eid'],'type'=>$_GET['type']),'member');
		}
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('addresumeson');
	}
	function saveresumeson_action(){
		if($_POST['submit']){
		    $_POST=$this->post_trim_iconv($_POST);
			if($_POST['table']=="resume"){
				if($_POST['tag']){
						$tag = array_unique(@explode(',',$_POST['tag']));
						foreach($tag as $value){
							$tagLen = mb_strlen($value);
							if($tagLen>=2 && $tagLen<=8){
								$tagList[] = $value;
							}
							if(count($tagList)>=5){
								break;
							}
						}
						$tagStr = implode(',',$tagList);
				}
				$this->obj->DB_update_all("resume","`tag`='".$tagStr."',`description`='".$_POST['description']."' , `lastupdate`='".time()."'","`uid`='".$this->uid."'");
				$data['url']="index.php?c=modify&eid=".$_POST['eid'];
				$data['msg']=iconv('gbk','utf-8',"����ɹ���");
				echo json_encode($data);die;
			}
			if($_POST['eid']>0){
				$table="resume_".$_POST['table'];
				$id=(int)$_POST['id'];
				$url=$_POST['table'];
				unset($_POST['submit']);
				unset($_POST['table']);
				unset($_POST['id']);
				$_POST['sdate']=strtotime($_POST['sdate']);
				if(intval($_POST['today'])=='1'){
					unset($_POST['today']);
					$_POST['edate']='';
				}else{
					$_POST['edate']=strtotime($_POST['edate']);
				}
				
				if($id){
			        $where['id']=$id;
				    $where['uid']=$this->uid;
				    $nid=$this->obj->update_once($table,$_POST,$where);
				}else{
			        $_POST['uid']=$this->uid;
				    $nid=$this->obj->insert_into($table,$_POST);
					$this->obj->DB_update_all("user_resume","`$url`=`$url`+1","`eid`='".(int)$_POST['eid']."' and `uid`='".$this->uid."'");
					$resume_row=$this->obj->DB_select_once("user_resume","`eid`='".(int)$_POST['eid']."'");
					$this->complete($resume_row);
				}
				if($table=='resume_work'){
					
					$workList = $this->obj->DB_select_all("resume_work","`eid`='".(int)$_POST['eid']."' AND `uid`='".$this->uid."'","`sdate`,`edate`");
					$whour = 0;$hour=array();
					foreach($workList as $value){
						
						if ($value['edate']){
							$workTime = ceil(($value['edate']-$value['sdate'])/(30*86400));
						}else{
							$workTime = ceil((time()-$value['sdate'])/(30*86400));
						}
						$hour[] = $workTime;
						$whour += $workTime;
					}
					
					$avghour = ceil($whour/count($hour));
					
					$this->obj->DB_update_all("resume_expect","`whour`='".$whour."',`avghour`='".$avghour."'","`id`='".(int)$_POST['eid']."' AND `uid`='".$this->uid."'");
	             }
				$nid?$data['msg']='����ɹ���':$data['msg']='����ʧ�ܣ�';
				$data['url']="index.php?c=rinfo&eid=".$_POST['eid']."&type=".$url;
			    $data['msg']=iconv('gbk','utf-8',$data['msg']);
			    echo json_encode($data);die;
			}
		}
	}
	function post_trim_iconv($data){
		foreach($data as $d_k=>$d_v){
			if(is_array($d_v)){
				$data[$d_k]=$this->post_trim_iconv($d_v);
			}else{
				$data[$d_k]=iconv("UTF-8","GBK",trim($data[$d_k]));
			}
		}
		return $data;
	}
	function get_email_moblie_action(){
		$row=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","`email_status`,`moblie_status`");
		$mail=$_POST['email'];	 
		$data=array('msg'=>1);
		if($row['email_status']!=1&&!empty($mail)){
			$email=$this->obj->DB_select_num("member","`uid`<>'".$this->uid."' and `email`='".$_POST['email']."'","`uid`");
			if($email){
				$data['msg']='�����Ѵ��ڣ�';
			}
		}
		if($row['moblie_status']!=1){
			$mobile=$this->obj->DB_select_once("member","`uid`<>'".$this->uid."' and `moblie`='".$_POST['moblie']."'","`uid`");
			if($mobile){
				$data['msg']='�ֻ��Ѵ��ڣ�';
			}
		} 
		$data['msg']=iconv('gbk','utf-8',$data['msg']);
		echo json_encode($data);die;
	}
	function info_action(){
		$this->rightinfo();
		include(CONFIG_PATH."db.data.php");
		unset($arr_data['sex'][3]);
		$this->yunset("arr_data",$arr_data);
		$nametype=array('1'=>'��ȫ����','2'=>'��ʾ���','3'=>'��������');
		$this->yunset("nametype",$nametype);
		if($_POST['submit']){
			$row=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","`email_status`,`moblie_status`,`name`,`living`,`wxewm`"); 
			if($row['email_status']!='1'&&!empty($_POST['email'])){
				$email=$this->obj->DB_select_num("member","`uid`<>'".$this->uid."' and `email`='".$_POST['email']."'");
				if($email>0){
					$data['msg']='�����Ѵ��ڣ�';
				}else{
					$mvalue['email']=$_POST['email'];
				}
			}else{
				$mvalue['email']=$_POST['email'];
			}
			if($row['moblie_status']!='1'){
				 $mobile=$this->obj->DB_select_num("member","`uid`<>'".$this->uid."' and `moblie`='".$_POST['telphone']."'");
				if($mobile>0 && $data['msg']==""){
					$data['msg']='�ֻ��Ѵ��ڣ�';
				}else{
					$mvalue['moblie']=$_POST['telphone'];
				}
			}

			if($_POST['name']=="" && $data['msg']==""){
				$data['msg']='��������Ϊ�գ�';
			}
			if(($_POST['birthday']=="") && $data['msg']==""){
				$data['msg']='�������²���Ϊ�գ�';
			}
			if($_POST['living']=="" && $data['msg']==""){
				$data['msg']='�־�ס�ز���Ϊ�գ�';
			}
			if($data['msg']==""){
				unset($_POST['submit']);
				delfiledir("../data/upload/tel/".$this->uid);
				if($_FILES['wxewm']['tmp_name']){
					$upload=$this->upload_pic("../../data/upload/user/",false);
					$wxewm=$upload->picture($_FILES['wxewm']);
					$this->picmsg($wxewm,$_SERVER['HTTP_REFERER']);
					$_POST['wxewm'] = str_replace("../../data/","./data/",$wxewm);
					if($row['wxewm']){
						unlink_pic("../.".$row['wxewm']);
					}
				}
				$_POST['lastupdate']=time();
				$where['uid']=$this->uid;  
				$nid=$this->obj->update_once("resume",$_POST,$where);
				if($nid){
					if(!empty($mvalue)){
						$this->obj->update_once('member',$mvalue,$where);
					}
					$this->member_log("���������Ϣ");
					
					if($row['name']==""||$row['living']=="")
					{
						$this->MODEL('userinfo')->company_invtal($this->uid,$this->config['integral_userinfo'],true,"�״���д��������",true,2,'integral',25);
					}else{
						$this->obj->update_once("resume_expect",array("edu"=>$_POST['edu'],"exp"=>$_POST['exp'],"uname"=>$_POST['name'],"sex"=>$_POST['sex'],"birthday"=>$_POST['birthday']),$where);
					}
					$data['msg']='����ɹ���';
				}else{
					$data['msg']='����ʧ�ܣ�';
				}
				if($_POST['eid']){
					$data['url']="index.php?c=modify&eid=".$_POST['eid'];
				}else{
					$data['url']="index.php";
				}
			}

			$this->yunset("layer",$data);
		}
		$year=date('Y',time());
		for($i=$year-70;$i<=$year;$i++){
			$years[]=$i;
		}
		$this->yunset("years",$years);
		$resume=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'"); 
		$arr_data1=$arr_data['sex'][$resume['sex']];		
		$this->yunset("arr_data1",$arr_data1);
		$this->yunset("resume",$resume);
        $this->yunset($this->MODEL('cache')->GetCache(array('user')));
		if($_GET['eid']){
        	$backurl=Url('wap',array('c'=>'modify','eid'=>$_GET['eid']),'member');
        }else{
        	$backurl=Url('wap',array(),'member');
        }
		$this->yunset('backurl',$backurl);
		$this->waptpl('info');
	}
    function addexpect_action(){
    	$CacheArr=$this->MODEL('cache')->GetCache(array('city','user','hy','job'));
        $this->yunset($CacheArr);
		if($_GET['eid']){
			$row=$this->obj->DB_select_once("resume_expect","`id`='".(int)$_GET['eid']."' and `uid`='".$this->uid."'");
			if($row['job_classid']){
				$job_classid=@explode(',',$row['job_classid']);
				$jobname=array();
				foreach($job_classid as $val){
					$jobname[]=$CacheArr['job_name'][$val];
				}
			} 
			$this->yunset("jobname",@implode('+',$jobname));
			$this->yunset("row",$row);
		}
    	if($_GET['eid']){
			$backurl=Url('wap',array('c'=>'modify','eid'=>$_GET['eid']),'member');
		}else{
			$backurl=Url('wap',array(),'member');
		}
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('addexpect');
	}
	function expect_action(){
		$eid=(int)$_POST['eid'];
		unset($_POST['submit']);
		unset($_POST['eid']);
		$where['id']=$eid;
		$where['uid']=$this->uid;
		$_POST['lastupdate']=time();
		$_POST['height_status']="0";
		if($eid==""){
            $num=$this->obj->DB_select_num("resume_expect","`uid`='".$this->uid."'");
			$_POST['uid']=$this->uid;
			$_POST['did']=$this->userdid;
			$_POST['source']=2;
            $_POST['defaults']=$num<=0?1:0;
			$nid=$this->obj->insert_into("resume_expect",$_POST);
			if ($nid){
				$num=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'");
				if($num['resume_num']==0){
					$this->obj->update_once('resume',array('def_job'=>$nid,'resumetime'=>time(),'lastupdate'=>time()),array('uid'=>$this->uid));
				}
				$data['uid'] = $this->uid;
				$data['eid'] = $nid;
				$this->obj->insert_into("user_resume",$data);
				$resume_num=$num+1;
				$this->obj->DB_update_all('member_statis',"`resume_num`='".$resume_num."'","`uid`='".$this->uid."'");
				$state_content = "������ <a href=\"".$this->config['sy_weburl']."/index.php?m=resume&id=$nid\" target=\"_blank\">�¼���</a>��";
				$fdata['uid']	  = $this->uid;
				$fdata['content'] = $state_content;
				$fdata['ctime']   = time();
				$this->obj->insert_into("friend_state",$fdata);
				$this->member_log("�������¼���");
			}
			$eid=$nid;
		}else{
			$nid=$this->obj->update_once("resume_expect",$_POST,$where);
			$this->member_log("�����˼���");
		}
		echo $nid;die;
	}
	function resume_action(){
		$this->rightinfo();
		$statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'","`integral`");
		$num=$this->obj->DB_select_num("resume_expect","`uid`='".$this->uid."'");
		$maxnum=$this->config['user_number']-$num;
		if($maxnum<0){$maxnum='0';}
		$this->yunset("maxnum",$maxnum);
		$rows=$this->obj->DB_select_all("resume_expect","`uid`='".$this->uid."' order by defaults desc","id,name,lastupdate,height_status,open,hits,defaults,statusbody,integrity,hits,statusbody,`topdate`,`is_entrust`,`top`");
		if($rows&&is_array($rows)){
			foreach($rows as $k=>$v){
				$eid[]=$v['id'];
			}
			$user_resume=$this->obj->DB_select_all("user_resume","`eid` in (".@implode(",",$eid).")");
			foreach($rows as $key=>$val){
				foreach($user_resume as $v){
					if($val['id']==$v['eid']){
						$rows[$key]['skill']=$v['skill'];
						$rows[$key]['work']=$v['work'];
						$rows[$key]['project']=$v['project'];
						$rows[$key]['edu']=$v['edu'];
						$rows[$key]['training']=$v['training'];
						$rows[$key]['cert']=$v['cert'];
						$rows[$key]['other']=$v['other'];						
					}
				}
				if($val['topdate']>1){
					$rows[$key]['topdate']=date("Y-m-d",$val['topdate']);
					$rows[$key]['topdatetime']=$val['topdate']-time();
				}else{
					$rows[$key]['topdate']='δ����';
				}
			}
		}
		$this->yunset("rows",$rows);
		$defjob=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","def_job,status,description");
		$this->yunset("defjob",$defjob);
		$this->yunset("statis",$statis);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('resume');
	}
	function modify_action(){
		if($_POST['submit']){
			if(trim($_POST['name'])==""){
				$data['msg']='�������Ʋ���Ϊ�գ�';
				$data['url']='index.php?c=modify&eid='.(int)$_POST['eid'];
				$this->yunset("layer",$data);
			}else{
				$this->obj->DB_update_all("resume_expect","`name`='".trim($_POST['name'])."'","`uid`='".$this->uid."' and `id`='".(int)$_POST['eid']."'");
				$data['msg']='���������޸ĳɹ���';
				$data['url']='index.php?c=modify&eid='.$_POST['eid'];
				$this->member_log("�޸ļ�������");
			}
			$this->yunset("layer",$data);
		}else{
			$expect=$this->obj->DB_select_once("resume_expect","`uid`='".$this->uid."' and `id`='".(int)$_GET['eid']."'");
			if($expect['id']){
				$this->yunset("expect",$expect);
				$resume=$this->obj->DB_select_once("user_resume","`eid`='".$_GET['eid']."'");
				$this->yunset("resume",$resume);
				$user=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","sex,photo,`description`");
				$this->yunset("user",$user);
			}else{
				$data['msg']="�Ƿ�������";
				$data['url']="index.php?c=resume";
			}
		}
		$this->yunset("layer",$data);
		$this->rightinfo();
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('modify');
	}
    function rinfo_action(){
		$_GET['id']=intval($_GET['id']);
		if(!in_array($_GET['type'],array('expect','cert','doc','edu','other','project','show','skill','tiny','training','work'))){
			unset($_GET['type']);
		}

		if($_GET['type']&&intval($_GET['id'])){
			$nid=$this->obj->DB_delete_all("resume_".$_GET['type'],"`eid`='".(int)$_GET['eid']."' and `id`='".(int)$_GET['id']."' and `uid`='".$this->uid."'");
			if($nid){
				$url=$_GET['type'];
				$this->obj->DB_update_all("user_resume","`$url`=`$url`-1","`eid`='".(int)$_GET['eid']."' and `uid`='".$this->uid."'");
				$resume_row=$this->obj->DB_select_once("user_resume","`eid`='".(int)$_GET['eid']."'");
				$this->complete($resume_row);
				if($_GET['type']=='work'){
					
					$workList = $this->obj->DB_select_all("resume_work","`eid`='".(int)$_GET['eid']."' AND `uid`='".$this->uid."'","`sdate`,`edate`");
					$whour = 0;$hour=array();
					foreach($workList as $value){
						
						if ($value['edate']){
							$workTime = ceil(($value['edate']-$value['sdate'])/(30*86400));
						}else{
							$workTime = ceil((time()-$value['sdate'])/(30*86400));
						}
						$hour[] = $workTime;
						$whour += $workTime;
					}
					
					$avghour = ceil($whour/count($hour));
					
					$this->obj->DB_update_all("resume_expect","`whour`='".$whour."',`avghour`='".$avghour."'","`id`='".(int)$_GET['eid']."' AND `uid`='".$this->uid."'");
	             }
				$data['msg']='ɾ���ɹ���';
			}else{
				$data['msg']='ɾ��ʧ�ܣ�';
			}
            $data['url']="index.php?c=rinfo&eid=".(int)$_GET['eid']."&type=".$_GET['type'];
			$this->yunset("layer",$data);
		}
		$this->rightinfo();
		$this->yunset($this->MODEL('cache')->GetCache(array('city','user','hy','job')));
		$rows=$this->obj->DB_select_all("resume_".$_GET['type'],"`eid`='".(int)$_GET['eid']."' and `uid`='".$this->uid."'");
		$this->yunset("backurl","index.php?c=modify&eid=".intval($_GET['eid']));
		$this->yunset("rows",$rows);
		$this->yunset("type",$_GET['type']);
		$this->yunset("eid",$_GET['eid']);
		$backurl=Url('wap',array('c'=>'modify','eid'=>$_GET['eid']),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('rinfo');
	}
	function resumeset_action(){
		if($_GET['del']){
			$del=(int)$_GET['del'];
			$del_array=array("resume_cert","resume_edu","resume_other","resume_project","resume_skill","resume_training","resume_work","resume_doc","user_resume","down_resume","user_trust","user_trust_record");
			if($this->obj->DB_delete_all("resume_expect","`id`='".$del."' and `uid`='".$this->uid."'")){
				foreach($del_array as $v){
					$this->obj->DB_delete_all($v,"`eid`='".$del."'' and `uid`='".$this->uid."'","");
				}
				$this->obj->DB_delete_all("look_resume","`resume_id`='".$del."'","");
				$defid=$this->obj->DB_select_once("resume","`uid`='".$this->uid."' and `def_job`='".$del."'");
			    if(is_array($defid)){
					$row=$this->obj->DB_select_once("resume_expect","`uid`='".$this->uid."'","`id`");
					if($row['id']!=''){
					    $this->obj->update_once('resume_expect',array('defaults'=>1),array('id'=>$row['id']));
					    $this->obj->update_once('resume',array('def_job'=>$row['id']),array('uid'=>$this->uid));
					}
			    } 
				$num=$this->obj->DB_select_num("resume_expect","`uid`='".$this->uid."'");
				$num=$num+1;
				$this->obj->DB_update_all('member_statis',"`resume_num`='".$num."'","`uid`='".$this->uid."'"); 
				$this->member_log("ɾ������");
				$this->waplayer_msg("ɾ���ɹ���");
			}else{
				$this->waplayer_msg("ɾ��ʧ�ܣ�");
			}
		}else if($_GET['update']){
			$id=(int)$_GET['update'];
			$nid=$this->obj->update_once('resume_expect',array('lastupdate'=>time()),array('id'=>$id,'uid'=>$this->uid));
			$nid?$this->waplayer_msg("ˢ�³ɹ���"):$this->waplayer_msg("ˢ��ʧ�ܣ�");
		}else if($_GET['def']){
			$nid=$this->obj->DB_update_all("resume","`def_job`='".(int)$_GET['def']."'","`uid`='".$this->uid."'");
            $nid=$this->obj->DB_update_all("resume_expect","`defaults`=''","`uid`='".$this->uid."'");
            $nid=$this->obj->DB_update_all("resume_expect","`defaults`='1'","`uid`='".$this->uid."' and `id`='".$_GET['def']."'");
			$nid?$this->waplayer_msg("���óɹ���"):$this->waplayer_msg("����ʧ�ܣ�");
		}else if($_GET['open']){
			if(!in_array($_GET['type'],array('expect','cert','doc','edu','other','project','show','skill','tiny','training','work'))){
				unset($_GET['type']);
			}
			$_GET['type']?$type='1':$type='0';
			$nid=$this->obj->DB_update_all("resume_expect","`open`='".$type."'","`uid`='".$this->uid."' and `id`='".(int)$_GET['open']."'");
            $nid=$this->obj->DB_update_all("resume_expect","`defaults`=''","`uid`='".$this->uid."'");
			$nid?$this->waplayer_msg("���óɹ���"):$this->waplayer_msg("����ʧ�ܣ�");
		}
	}
	function loginout_action(){
		SetCookie("uid","",time() -86400, "/");
		SetCookie("username","",time() - 86400, "/");
		SetCookie("usertype","",time() -86400, "/");
		SetCookie("salt","",time() -86400, "/");
		SetCookie("shell","",time() -86400, "/");
		$this->wapheader('index.php');
	}
	function lookjobdel_action(){
		$this->rightinfo();
		if($_GET['id']){
			$nid=$this->obj->DB_update_all("look_job","`status`='1'","`id`='".$_GET['id']."' and `uid`='".$this->uid."'");
			if($nid){
				$this->member_log("ɾ��ְλ�����¼��ID:".$_GET['id']."��");
				$this->waplayer_msg('ɾ���ɹ���');
			}else{
				$this->waplayer_msg('ɾ��ʧ�ܣ�');
			}
		}
	}
	function look_job_action(){
		$this->rightinfo();
		$urlarr=array("c"=>$_GET['c'],"page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$look=$this->get_page("look_job","`uid`='".$this->uid."' and `status`='0' order by `datetime` desc",$pageurl,"10");
		if(is_array($look)){
			include PLUS_PATH."/city.cache.php";
			include PLUS_PATH."/com.cache.php";
			foreach($look as $v){
				$jobid[]=$v['jobid'];
			}
			$job=$this->obj->DB_select_all("company_job","`id` in (".pylode(",",$jobid).")","`id`,`name`,`com_name`,`minsalary`,`maxsalary`,`provinceid`,`cityid`,`uid`,`edate`,`status`,`state`");

			foreach($look as $k=>$v){
				foreach($job as $val){
					if($v['jobid']==$val['id']){
						if($val['edate']<time()){
							$look[$k]['jobstate']=2;
						}else if($val['status']=='1'||$val['state']!='1'){
							$look[$k]['jobstate']=3;
						}else{
							$look[$k]['jobstate']=1;
						}
						$look[$k]['jobname']=$val['name'];
						$look[$k]['com_id']=$val['uid'];
						$look[$k]['job_id']=$val['id'];
						$look[$k]['comname']=$val['com_name'];
						$look[$k]['minsalary']=$val['minsalary'];
						$look[$k]['maxsalary']=$val['maxsalary'];
						$look[$k]['provinceid']=$city_name[$val['provinceid']];
						$look[$k]['cityid']=$city_name[$val['cityid']];
					}
				}
			}
		}
		$this->yunset("js_def",2);
		$this->yunset("look",$look);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('look_job');
	}
	function getYears($startYear=0,$endYear=0){
		$list=array();
		$month_list=array();
		if($endYear>0){
			if($startYear<=0){
				$startYear=	$endYear-150;
			}
			for($i=$endYear;$i>=$startYear;$i--){
				$list[]=$i;
			}
		}
		for($i=12;$i>=1;$i--){
			$month_list[]=$i;
		}
		$this->yunset("year_list",$list);
		$this->yunset("month_list",$month_list);
		return $list;
	}
	function binding_action(){
		if($_POST['moblie']){
			$row=$this->obj->DB_select_once("company_cert","`uid`='".$this->uid."' and `check`='".$_POST['moblie']."'");
			if(!empty($row)){
				session_start();
				if($row['check2']!=$_POST['code']){
					echo 3;die;
				}else if(!$_POST['authcode']){
					echo 4;die;
				}elseif(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
					echo 5;die;
				}else{
					$this->obj->DB_update_all("resume","`moblie_status`='0',`lastupdate`='".time()."'","`telphone`='".$row['check']."'");
					$this->obj->DB_update_all("company","`moblie_status`='0'","`linktel`='".$row['check']."'");
					$this->obj->DB_update_all("member","`moblie`='".$row['check']."'","`uid`='".$this->uid."'");
					$this->obj->DB_update_all("resume","`telphone`='".$row['check']."',`moblie_status`='1'","`uid`='".$this->uid."'");
					$this->obj->DB_update_all("company_cert","`status`='1'","`uid`='".$this->uid."' and `check2`='".$_POST['code']."'");
					$this->obj->member_log("�ֻ���");
					$pay=$this->obj->DB_select_once("company_pay","`pay_remark`='�ֻ���' and `com_id`='".$this->uid."'");
					if(empty($pay)){
						$this->get_integral_action($this->uid,"integral_mobliecert","�ֻ���");
					}
					echo 1;die;
				}
			}else{
				echo 2;die;
			}
		}
		if($_GET['type']){
			if($_GET['type']=="moblie"){
				$this->obj->DB_update_all("resume","`moblie_status`='0'","`uid`='".$this->uid."'");
			}
			if($_GET['type']=="email"){
				$this->obj->DB_update_all("resume","`email_status`='0'","`uid`='".$this->uid."'");
			}
			if($_GET['type']=="qqid"){
				$this->obj->DB_update_all("member","`qqid`=''","`uid`='".$this->uid."'");
			}
			if($_GET['type']=="sinaid"){
				$this->obj->DB_update_all("member","`sinaid`=''","`uid`='".$this->uid."'");
			}
			$this->waplayer_msg('����󶨳ɹ���');
		}
		$member=$this->obj->DB_select_once("member","`uid`='".$this->uid."'");
		$this->yunset("member",$member);
		$resume=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'");
		$this->yunset("resume",$resume);
		if(($member['qqid']!=""||$member['wxid']!=""||$member['unionid']!=""||$member['sinaid']!="") && $member['restname']=="0"){
			$this->yunset("setname",1);
		}
		$this->rightinfo();
		$this->get_user();
		$this->yunset("backurl","index.php");
		$this->waptpl('binding');
	}
	function idcard_action(){
		if($_POST['submit']){
			$row=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'");  
			if($_POST['idcard']==''){
				$data['msg']='���������֤��';   
			}else if(is_uploaded_file($_FILES['pic']['tmp_name'])==false&&!$row['idcard_pic']){
				$data['msg']='���ϴ�֤���գ�';
			}else{
				if(is_uploaded_file($_FILES['pic']['tmp_name'])){
				    $upload=$this->upload_pic(APP_PATH."/data/upload/user/",false);
				    $pic=$upload->picture($_FILES['pic']);
				    $this->picmsg($pictures,$_SERVER['HTTP_REFERER']);
				    $photo = str_replace(APP_PATH."/data/upload/user","/data/upload/user",$pic);
					if($row['idcard_pic']){
						unlink_pic("APP_PATH".$row['idcard_pic']);
					}
				}else{
					$photo=$row['idcard_pic'];
				}
			}
				if(strlen($pictures)!=1){ 
				    if($this->config['user_idcard_status']=="1"){
				        $status='0';
				    }else{
				        $status='1';
				    }
				    $dataarr=array(
				        'idcard'=>$_POST['idcard'],
				        'idcard_pic'=>$photo,
				        'idcard_status'=>$status,
				        'cert_time'=>time()
				    );
				    $nid=$this->obj->update_once('resume',$dataarr,array('uid'=>$this->uid));
				    if($nid){
				        unlink_pic($row['idcard_pic']);
				        $data['msg']='�ϴ��ɹ���';
				        $data['url']="index.php?c=binding";
				    }else{
				        $data['msg']='�ϴ�ʧ�ܣ�';
				    }
				    
			}
			if($data){
			    $this->yunset("layer",$data);
			}
		}
		$this->rightinfo();
		$this->get_user();
		$resume=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'",'idcard,idcard_pic');
		$this->yunset("resume",$resume);
		$backurl=Url('wap',array('c'=>'binding'),'member');
		$this->yunset('backurl',$backurl);
		$this->waptpl('idcard');
	}
	function bindingbox_action(){
		$member=$this->obj->DB_select_once("member","`uid`='".$this->uid."'");
		$this->yunset("member",$member);
		$this->rightinfo();
		$backurl=Url('wap',array('c'=>'binding'),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('bindingbox');
	}
	function setname_action(){
		if($_POST['username']){
			$user=$this->obj->DB_select_once("member","`uid`='".$this->uid."'");
			if(($user['qqid']==""&&$user['wxid']==""&&$user['unionid']==""&&$user['sinaid']=="") || $user['restname']=="1"){
				echo "����Ȩ�޸��˻���";die;
			}
			$username=yun_iconv("utf-8","gbk",$_POST['username']);
			$num = $this->obj->DB_select_num("member","`username`='".$username."'");
			if($num>0){
				echo "�û����Ѵ��ڣ�";die;
			}
			if($this->config['sy_regname']!=""){
				$regname=@explode(",",$this->config['sy_regname']);
				if(in_array($username,$regname)){
					echo "���û�����ֹʹ�ã�";die;
				}
			}
			$salt = substr(uniqid(rand()), -6);
		    $password = md5(md5($_POST['password']).$salt);
		    $data['password']=$password;
		    $data['salt']=$salt;
		    $data['username']=$username;
		    $data['restname']=1;
			$this->obj->update_once('member',$data,array('uid'=>$this->uid));
			$this->unset_cookie();
			$this->obj->member_log("�޸��˻�",8);
			echo 1;die;
		}
		$user=$this->obj->DB_select_once("member","`uid`='".$this->uid."'");
		if(($user['qqid']==""&&$user['wxid']==""&&$user['unionid']==""&&$user['sinaid']=="") || $user['restname']=="1"){
			$data['msg']="����Ȩ�޸��˻���";
			$data['url']='index.php?c=binding';
			$this->yunset("layer",$data);
		}
		$this->rightinfo();
		$backurl=Url('wap',array('c'=>'binding'),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('setname');
	}
	
	function reward_list_action(){
		$urlarr['c']='reward_list';
		$urlarr["page"]="{{page}}";
		$pageurl=Url('wap',$urlarr,'member');
		$rows=$this->get_page("change","`uid`='".$this->uid."' order by id desc",$pageurl,"10");
		if(is_array($rows)){
			foreach($rows as $key=>$val){
				$gid[]=$val['gid'];
			}
			$M=$this->MODEL('redeem');
			$gift=$M->GetReward(array('`id` in('.pylode(',', $gid).')'),array('field'=>'id,pic'));
			foreach($rows as $k=>$val){
				foreach ($gift as $v){
					if($val['gid']==$v['id']){
						$rows[$k]['pic']=$v['pic'];
					}
				}
			}
		}
		$statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'","integral");
		$statis[integral]=number_format($statis[integral]);
		$this->yunset("statis",$statis);
		$this->yunset('rows',$rows);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('reward_list');
	}
	
	function privacy_action(){
		$urlarr=array("c"=>$_GET['c'],"page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$this->get_page("blacklist","`c_uid`='".$this->uid."' and `usertype`='1' order by `id` desc",$pageurl,"10");
		$resume = $this->obj->DB_select_once("resume","`uid`='".$this->uid."'","`status`,`info_status`");
        $this->yunset("resume",$resume);
        $this->yunset("backurl","index.php?c=resume");
		$this->get_user();
		$this->waptpl('privacy');
	}
	
	function up_action(){
		if(intval($_GET['status'])){ 
			$this->obj->DB_update_all("resume","`status`='".intval($_GET['status'])."'","`uid`='".$this->uid."'"); 
			$this->obj->DB_update_all("resume_expect","`status`='".intval($_GET['status'])."'","`uid`='".$this->uid."'"); 			
			$this->waplayer_msg('�����ɹ���');
		}
	}
	function del_action(){
		if($_GET['id']){
			$del=(int)$_GET['id'];
			$nid=$this->obj->DB_delete_all("blacklist","`id`='".$del."' and `c_uid`='".$this->uid."'");
			if($nid){				
				$this->waplayer_msg('ɾ���ɹ���');
			}else{
				$this->waplayer_msg('ɾ��ʧ�ܣ�');
			}
 		}
	}
	function delall_action(){
		$this->obj->DB_delete_all("blacklist","`c_uid`='".$this->uid."'","");
		$this->obj->member_log("��չ�˾��������Ϣ");
		$this->waplayer_msg('ɾ���ɹ���');
	}	
	function searchcom_action(){
		$blacklist=$this->obj->DB_select_all("blacklist","`c_uid`='".$this->uid."'","`p_uid`");
		if($blacklist&&is_array($blacklist)){
			$uids=array();
			foreach($blacklist as $val){
				$uids[]=$val['p_uid'];
			}
			$where=" and `uid` not in(".pylode(',',$uids).")";
		}
		$company=$this->obj->DB_select_all("company","`name` like '%".$this->stringfilter(trim($_POST['name']))."%' ".$where,"`uid`,`name`");
		$html="";
		if($company&&is_array($company)){
			foreach($company as $val){
				$html.="<li class=\"cur\"><input class=\"re-company\" type=\"checkbox\" value=\"".$val['uid']."\" name=\"buid[]\"><a href=\"".Url('wap',array('c'=>'company','a'=>'show',"id"=>$val['uid']))."\">".$val['name']."</a></li>";
			} 
		}else{
			$html="<li class=\"cur\">���޷���������ҵ</li>";
		}
		echo $html;die;
		
	}
	function save_action(){
		if(is_array($_POST['buid'])&&$_POST['buid']){
			$company=$this->obj->DB_select_all("company","`uid` in(".pylode(',',$_POST['buid']).")","`uid`,`name`");
			foreach($company as $val){
				$this->obj->insert_into("blacklist",array('p_uid'=>$val['uid'],'c_uid'=>$this->uid,"inputtime"=>time(),'usertype'=>'1','com_name'=>$val['name']));
			}
			$this->waplayer_msg('�����ɹ���');
		}else{
			$this->waplayer_msg('��ѡ�����εĹ�˾��');
		}
	}
	function rtop_action(){
		$id=$_POST['id'];
		$days=intval($id);
		if($days<1){echo 1;die;}
		if(intval($_POST['eid'])<1){echo 2;die;}
		$statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'","`integral`");
		$num=$days*$this->config['integral_resume_top'];
		if($num>$statis['integral']){
			echo 3;die;
			
		}else{
			
			$result=$this->company_invtal($this->uid,$num,false,'�����ö�');
			if($result){
				$time=86400*$days;
				$topdate=$this->obj->DB_select_once("resume_expect","`id`='".intval($_POST['eid'])."' and `uid`='".$this->uid."'","topdate");
				if($topdate['topdate']>=time()){$time=$topdate['topdate']+$time;}else{$time=time()+$time;}
				$this->obj->DB_update_all("resume_expect","`top`='1',`topdate`='".$time."'","`id`='".intval($_POST['eid'])."' and `uid`='".$this->uid."'");
				
				echo 4;die;
				
			}else{
				echo 5;die;
				
			}
		}
	}
	
	function com_res_action(){
		$telphone=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","`telphone`");
		$resume_expect=$this->obj->DB_select_all("resume_expect","`uid`='".$this->uid."' and `open`='1'","`name`,`doc`,`lastupdate`,`defaults`,`id`,`is_entrust`");
		if(is_array($resume_expect)&& !empty($resume_expect)){
			$html="";
			foreach($resume_expect as $key=>$val){
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
				$html.="<tr class=\"result_class\"><td>".mb_substr($val['name'],0,8,"GBK")."</td><td>".$telphone['telphone']."</td><td>".$entrust."</td></tr>";
			}
			echo $html;die;
		}else{
			echo 1;die;
		}
		
		
		
		
	}
	
	
	
	function canceltrust_action(){ 
		$resume_expect=$this->obj->DB_select_once("resume_expect","`uid`='".$this->uid."' and `id`='".(int)$_POST['id']."'","`is_entrust`,`id`");
		if((int)$this->config['user_trust_number']<1&&$resume_expect['is_entrust']=='0'){
			$this->waplayer_msg('��վ�ѹرմ˷���');			
		}else if($resume_expect['id']){
			if($resume_expect['is_entrust']=='0'){
				$entrust_num=$this->obj->DB_select_num("resume_expect","`uid`='".$this->uid."' and `is_entrust`>'0'","`id`");
				if($entrust_num<(int)$this->config['user_trust_number']){
					$member_statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'","`integral`");
					if($member_statis['integral']<$this->config['pay_trust_resume']&&$this->config['pay_trust_resume']){
						$this->waplayer_msg($this->config['integral_pricename'].'���㣬�޷�ί��');
					}else{						
						$res=$this->company_invtal($this->uid,$this->config['pay_trust_resume'],false,"ί�м���",true,2,'integral'); 						
						if($res){
							$idata['uid']      = $this->uid;
							$idata['did']      = $this->userdid;
							$idata['username'] = $this->username;
							$idata['eid']      = $resume_expect['id'];
							$idata['status']   =$this->config['user_trust_status'];
							$idata['price']    = $this->config['pay_trust_resume'];
							$idata['add_time'] = time();
							$nid=$this->obj->insert_into("user_entrust",$idata);
							if($nid){
								if($this->config['pay_trust_resume']=='1'){
									$this->obj->update_once("resume_expect",array('is_entrust'=>2),array('uid'=>$this->uid,'id'=>$resume_expect['id']));
								}else{
									$this->obj->update_once("resume_expect",array('is_entrust'=>1),array('uid'=>$this->uid,'id'=>$resume_expect['id']));
								}
								$this->waplayer_msg('����ί�гɹ���');
							}else{
								$this->waplayer_msg('����ί��ʧ�ܣ�');
							}
						}else{
							$this->waplayer_msg($this->config['integral_pricename'].'�۳�ʧ�ܣ����Ժ����ԡ�');
						}
					}
				}else{
					$this->waplayer_msg('����ί��'.$entrust_num.'�ݼ������޷��ٴβ�����');
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
						$this->waplayer_msg('�����ɹ���');
					}else{
						$this->waplayer_msg('ȡ��ʧ�ܣ����Ժ����ԣ�');
					}
				}else{
					$this->waplayer_msg('�Ƿ�������');
				}
			}
		}else{
			$this->waplayer_msg('�Ƿ�������');
		}
		
	}
	
	
	
	
	function delreward_action(){
		if($this->usertype!='1' || $this->uid==''){
			$this->waplayer_msg('��¼��ʱ��');
		}else{
			$rows=$this->obj->DB_select_once("change","`uid`='".$this->uid."' and `id`='".(int)$_GET['id']."' ");
			if($rows['id']){
				$this->obj->DB_update_all("reward","`num`=`num`-".$rows['num'].",`stock`=`stock`+".$rows['num']."","`id`='".$rows['gid']."'");
				$this->company_invtal($this->uid,$rows['integral'],true,"ȡ���һ�",true,2,'integral',24);
				$this->obj->DB_delete_all("change","`uid`='".$this->uid."' and `id`='".(int)$_GET['id']."' ");
			}
			$this->obj->member_log("ȡ���һ�");
			$this->waplayer_msg('ȡ���ɹ���');
		}
	}
	
	function pay_action(){
		if($this->config['wxpay']=='1'){		
			$paytype['wxpay']='1';
		}
		if($this->config['alipay']=='1' &&  $this->config['alipaytype']=='1'){
			$paytype['alipay']='1';
		}
		if($paytype){
			if($_GET['id']){
				$order=$this->obj->DB_select_once("company_order","`uid`='".$this->uid."' and `id`='".(int)$_GET['id']."'");
				if(empty($order)){ 
					$this->ACT_msg($_SERVER['HTTP_REFERER'],"���������ڣ�"); 
				}elseif($order['order_state']!='1'){ 
					header("Location:index.php?c=paylog"); 
				}else{
					$this->yunset("order",$order);
				}
			}
			$this->yunset("statis",$statis);
			$remark="������\n��ϵ�绰��\n���ԣ�";
			$this->yunset("paytype",$paytype);
			$this->yunset("remark",$remark);
		}else{		
			$data['msg']="��δ��ͨ�ֻ�֧�������Ʋ������Զ˳�ֵ��";
			$data['url']=$_SERVER['HTTP_REFERER'];
			$this->yunset("layer",$data);
			
		}
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('pay');
	}
	function dingdan_action(){
		if($_POST['price']){
			if($_POST['price_int']){
				if($this->config['integral_min_recharge'] && $_POST['price_int']<$this->config['integral_min_recharge']){
					$data['msg']="��ֵ���õ���".$this->config['integral_min_recharge'];
					$data['url']=$_SERVER['HTTP_REFERER'];
					$this->yunset("layer",$data);
					$this->waptpl('pay');exit;
				}
				$price = $_POST['price_int']/$this->config['integral_proportion'];
				$data['type']='2';
			}
			$dingdan=mktime().rand(10000,99999);
			$data['order_id']=$dingdan;
			$data['order_price']=$price;
			$data['order_time']=mktime();
			$data['order_state']="1";
			$data['order_remark']=trim($_POST['remark']);
			$data['uid']=$this->uid;
			$data['integral']=$_POST['price_int'];
			$data['did']=$this->userdid;
			$id=$this->obj->insert_into("company_order",$data);
			if($id){
				$this->member_log("�µ��ɹ�,����ID".$dingdan);
				$_POST['dingdan']=$dingdan;
				$_POST['dingdanname']=$dingdan;
				$_POST['alimoney']=$price;
				$data['msg']="�µ��ɹ����븶�";
				
				if($_POST['paytype']=='alipay'){
					$url=$this->config['sy_weburl'].'/api/wapalipay/alipayto.php?dingdan='.$dingdan.'&dingdanname='.$dingdanname.'&alimoney='.$price;
					header('Location: '.$url);exit();
				}elseif($_POST['paytype']=='wxpay'){
					$url='index.php?c=wxpay&id='.$id;
					header('Location: '.$url);exit();
				}
			}else{
				$data['msg']="�ύʧ�ܣ��������ύ������";
				$data['url']=$_SERVER['HTTP_REFERER'];
			}
		}else{
			$data['msg']="��������ȷ������ȷ��д��";
			$data['url']=$_SERVER['HTTP_REFERER'];
		}
		$this->yunset("layer",$data);
		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('pay');
	}
	function wxpay_action(){
		if($_GET['id']){
			$id = (int)$_GET['id'];
			$order = $this->obj->DB_select_once("company_order","`uid`='".$this->uid."' AND `id`='".$id."'");
			if(!empty($order)){
				require_once(LIB_PATH.'wxOrder.function.php');
				$jsApiParameters = wxWapOrder(array('body'=>iconv("gbk","utf-8",'��ֵ'),'id'=>$order['order_id'],'url'=>$this->config['sy_weburl'],'total_fee'=>$order['order_price']));
				if($jsApiParameters){
					$this->yunset('jsApiParameters',$jsApiParameters);
				}else{
						
					$data['msg']="��������ȷ��������֧����";
					$data['url']='index.php?c=paylog';
					$this->yunset("layer",$data);
				}
	
			}else{
				$data['msg']="��������ȷ������ȷ��д��";
				$data['url']=$_SERVER['HTTP_REFERER'];
				$this->yunset("layer",$data);
			}
	
			$this->yunset('id',(int)$_GET['id']);
			$this->waptpl('wxpay');
		}else{
			$data['msg']="��������ȷ������ȷ��д��";
			$data['url']=$_SERVER['HTTP_REFERER'];
			$this->yunset("layer",$data);
			$backurl=Url('wap',array(),'member');
		    $this->yunset('backurl',$backurl);
			$this->get_user();
			$this->waptpl('pay');
		}
	}
	function paylog_action(){
		include(CONFIG_PATH."db.data.php");
		$this->yunset("arr_data",$arr_data);
		$urlarr=array("c"=>"paylog","page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$where="`uid`='".$this->uid."' order by order_time desc";
		$rows=$this->get_page("company_order",$where,$pageurl,"10");
		$this->yunset("rows",$rows);
		$statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'","integral");
		$allprice=$this->obj->DB_select_once("company_pay","`com_id`='".$this->uid."' and `type`='1' and `order_price`<0","sum(order_price) as allprice");
		if($allprice['allprice']<0){
			$statis['allprice']=number_format(str_replace("-","", $allprice['allprice']));
		}else{
			$statis['allprice']='0';
		}
		$this->yunset("statis",$statis);
		$this->yunset('backurl','index.php');
		$this->get_user();
		$this->waptpl('paylog');
	}
	function delpaylog_action(){
		if($this->usertype!='1' || $this->uid==''){
			$this->waplayer_msg('��¼��ʱ��');
		}else{
			$oid=$this->obj->DB_select_once("company_order","`uid`='".$this->uid."' and `id`='".(int)$_GET['id']."' and `order_state`='1'");
			if(empty($oid)){
				$this->waplayer_msg('���������ڣ�');
			}else{
				$this->obj->DB_delete_all("company_order","`id`='".$oid['id']."' and `uid`='".$this->uid."'");
				$this->waplayer_msg('ȡ���ɹ���');
			}
		}
	}
	
	function consume_action(){
		include(CONFIG_PATH."db.data.php");
		$this->yunset("arr_data",$arr_data);
		$urlarr=array("c"=>"consume","page"=>"{{page}}");
		$pageurl=Url('wap',$urlarr,'member');
		$where="`com_id`='".$this->uid."'";
		$where.="  order by pay_time desc";
		$rows = $this->get_page("company_pay",$where,$pageurl,"10");
		if(is_array($rows)){
			foreach($rows as $k=>$v){
				$rows[$k]['pay_time']=date("Y-m-d H:i:s",$v['pay_time']);
				$rows[$k]['order_price']=str_replace(".00","",$rows[$k]['order_price']);
			}
		}
		$statis=$this->obj->DB_select_once("member_statis","`uid`='".$this->uid."'","integral");
		$allprice=$this->obj->DB_select_once("company_pay","`com_id`='".$this->uid."' and `type`='1' and `order_price`<0","sum(order_price) as allprice");
		if($allprice['allprice']<0){
			$statis['allprice']=number_format(str_replace("-","", $allprice['allprice']));
		}else{
			$statis['allprice']='0';
		}
		$this->yunset("statis",$statis);
		if ($_GET['type']==1){
			$this->yunset('backurl',Url('wap',array('c'=>'user'),'member'));
		}else{
			$this->yunset('backurl','index.php');
		}
		$this->yunset("rows",$rows);
		$this->get_user();
		$this->waptpl('consume');
	}
	

	
	function likejob_action(){
		$this->rightinfo();
		if($_GET['id']){
			$id=(int)$_GET['id'];
			$resumeexp=$this->obj->DB_select_once("resume_expect","`id`='".$id."'","uid,job_classid,cityid,three_cityid,exp,edu,report");
			$resume=$this->obj->DB_select_once("resume","`uid`='".$resumeexp['uid']."'","marriage");
			if($resumeexp['job_classid']!=""){
				$jobclass=@explode(",",$resumeexp['job_classid']);
				foreach($jobclass as $v){
					$where[]=$v;
				}
				$where=" and (`job_post` in (".@implode(" , ",$where).") or `job1_son` in (".@implode(" , ",$where)."))and `cityid`='".$resumeexp['cityid']."' order by id desc limit 16 ";
			}
			$time = time();
			$select="id,name,com_name,three_cityid,edu,sex,marriage,report,exp,minsalary,maxsalary,uid";
			$job=$this->obj->DB_select_all("company_job","`sdate`<'".$time."'and `r_status`<>2 and `status`<>1  and `edate`>'".$time."' and `state`='1' ".$where,$select);  
			if(is_array($resumeexp)){
				include PLUS_PATH."/user.cache.php";
				include PLUS_PATH."/com.cache.php";
				include(CONFIG_PATH."db.data.php");
				$this->yunset("arr_data",$arr_data);
				$this->yunset("comclass_name",$comclass_name);
				foreach($job as $k=>$v){
					$job[$k]['sex']=$arr_data['sex'][$v['sex']];
					$pre=60;
					if($v['three_cityid']==$resumeexp['three_cityid']){
						$pre=$pre+10;
					}
					if($userclass_name[$resumeexp['edu']]==$comclass_name[$v['edu']] || $comclass_name[$v['edu']]=="����"){
						$pre=$pre+5;
					}
					if($userclass_name[$resume['marriage']]==$comclass_name[$v['marriage']] || $comclass_name[$v['sex']]=="����"){
						$pre=$pre+5;
					}
					if($job['sex']==$v['sex']){
						$pre=$pre+5;
					}
					if($userclass_name[$resumeexp['report']]==$comclass_name[$v['report']] || $comclass_name[$v['report']]=="����"){
						$pre=$pre+5;
					}
					if($userclass_name[$resumeexp['exp']]==$comclass_name[$v['exp']] || $comclass_name[$v['exp']]=="����"){
						$pre=$pre+5;
					}
					$job[$k]['pre']=$pre;
				}
				$sort = array(
						'direction' => 'SORT_DESC',
						'field'     => 'pre',     
				);
				$arrSort = array();
				foreach($job AS $uniqid => $row){
					foreach($row AS $key=>$value){
						$arrSort[$key][$uniqid] = $value;
					}
				}
				if($sort['direction']){
					array_multisort($arrSort[$sort['field']], constant($sort['direction']), $job);
				}
				$this->yunset("job",$job);
			}
		}
		$this->yunset("js_def",2);
		$backurl=Url('wap',array('c'=>'resume'),'member');
		$this->yunset('backurl',$backurl);
		$this->get_user();
		$this->waptpl('likejob');
	}
}
?>