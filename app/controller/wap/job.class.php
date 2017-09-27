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
class job_controller extends common{
	function index_action(){
		$CacheM=$this->MODEL('cache');
		$CacheArr=$CacheM->GetCache(array('job','city','hy','com'));
		if($_GET['jobin']){
			$job_classid=@explode(',',$_GET['jobin']);
			$jobname=$CacheArr['job_name'][$job_classid[0]];
			$this->yunset("jobname",mb_substr($jobname,0,6,'gbk'));
		}
		$uptime=array(1=>'����',3=>'���3��',7=>'���7��',30=>'���һ����',90=>'���������');
		$this->yunset("uptime",$uptime);
		$this->yunset($CacheArr);
		$this->yunset("headertitle","ְλ����");
		foreach($_GET as $k=>$v){
			if($k!=""){
				$searchurl[]=$k."=".$v;
			}
		}
		$this->seo("com_search");
		$searchurl=@implode("&",$searchurl);
		$this->yunset('backurl',Url('wap'));
		$this->yunset("topplaceholder","������ְλ�ؼ���,�磺���...");
		$this->yunset("searchurl",$searchurl);
		$this->yuntpl(array('wap/job'));
	}
	function search_action(){
		$this->index_action();
	}
	function view_action(){
		$JobM=$this->MODEL('job');
		$CacheM=$this->MODEL('cache');
		$ResumeM=$this->MODEL('resume');
		$UserinfoM=$this->MODEL('userinfo');
		$CacheArr=$CacheM->GetCache(array('job','city','hy','com'));
		$job=$JobM->GetComjobOne(array("id"=>(int)$_GET['id']));
		include(CONFIG_PATH."db.data.php");		
		$this->yunset("arr_data",$arr_data);
		$welfare = @explode(",",$job['welfare']);
		  foreach($welfare as $k=>$v){
			if(!$v){
			  unset($welfare[$k]);
			}
		  }
		$job['welfare']=$welfare;
		if($job['lang']){
			$lang = @explode(",",$job['lang']);
			$job['lang']=$lang; 
		}
		$userid_job=$this->obj->DB_select_num("userid_job","`job_id`='".(int)$_GET['id']."'and `uid`='".$this->uid."'");
		$invite_job=$this->obj->DB_select_num("userid_msg","`jobid`='".(int)$_GET['id']."'and `uid`='".$this->uid."'");
		$fav_job=$this->obj->DB_select_num("fav_job","`job_id`='".(int)$_GET['id']."'and `uid`='".$this->uid."'");
		$report_job=$this->obj->DB_select_num("report","`eid`='".(int)$_GET['id']."'and `p_uid`='".$this->uid."' and `c_uid`='".$job['uid']."'");
		$job['userid_job']=$userid_job;
		$job['invite_job']=$invite_job;
		$job['fav_job']=$fav_job;
		$job['report_job']=$report_job;
		$company=$UserinfoM->GetUserinfoOne(array("uid"=>$job['uid']),array("usertype"=>'2'));
		$Info=array_merge_recursive($job,$company); 
		if($Info['linkman']){
			$operatime=time()-$Info['operatime'];
			if($Info['operatime']==''){
				$Info['operatime']='0';
			}else if($operatime<3600){
				$Info['operatime']='һСʱ����';
			}else if($operatime>=3600&&$operatime<86400){
				$Info['operatime']=floor($operatime/3600).'Сʱ';
			}else if($operatime>=86400){
				$Info['operatime']=floor($operatime/86400).'��';
			}  
			$allnum=$JobM->GetUserJobNum(array("com_id"=>$Info['uid'],"job_id"=>$Info['id']));
			$replynum=$JobM->GetUserJobNum(array("com_id"=>$Info['uid'],"job_id"=>$Info['id'],"`is_browse`>'1'")); 
			$pre=round(($replynum/$allnum)*100); 
			$this->yunset("pre",$pre);
		}
		$comrat=$UserinfoM->GetRatinginfoOne(array("id"=>$job['rating']));
		if($this->usertype=="1"&&$this->uid){
			$ResumeM=$this->MODEL('resume');
			$resume=$ResumeM->GetResumeExpectNum(array('uid'=>$this->uid,"`r_status`<>'2' and `job_classid`<>''","open"=>'1'));
			if($resume){
				
				$look_job=$JobM->GetLookJobOne(array("uid"=>$this->uid,"jobid"=>(int)$_GET['id']));
				if(!empty($look_job)){
					$JobM->UpdateLookJob(array("datetime"=>time()),array("uid"=>$this->uid,"jobid"=>(int)$_GET['id']));
				}else{
					
					$value['uid']=$this->uid;
					$value['did']=$this->userdid;
					$value['jobid']=(int)$_GET['id'];
					$value['com_id']=$job['uid'];
					$value['datetime']=time();
					$JobM->AddLookJob($value);
				}
			}
		}
		if($_GET['type']){
			if(!$this->uid || !$this->username ){
				$data['msg']='���ȵ�¼��';
				$data['url']='index.php?c=login';
				$data['msg']=iconv("GBK","UTF-8",$data['msg']);
				echo json_encode($data);die;
			}elseif($this->usertype!=1){
				$data['msg']='�����Ǹ����û���';
				$data['url']=$_SERVER['HTTP_REFERER'];
				$data['msg']=iconv("GBK","UTF-8",$data['msg']);
				echo json_encode($data);die;
			}else {
				if($_GET['type']=='sq'){
					$row=$JobM->GetUserJobNum(array("uid"=>$this->uid,"job_id"=>(int)$_GET['id']));
					$resume=$ResumeM->SelectExpectOne(array("uid"=>$this->uid,"defaults"=>1),"id");
					if(!$resume['id']){
						$data['msg']='����û�м�����������Ӽ�����';
						$data['url']='member/index.php?c=resume';
						$data['msg']=iconv("GBK","UTF-8",$data['msg']);
						echo json_encode($data);die;
					}else if(intval($row)>0){
						$data['msg']='���Ѿ�Ͷ�ݹ��ü������벻Ҫ�ظ�Ͷ�ݣ�';
						$data['url']=$_SERVER['HTTP_REFERER'];
						$data['msg']=iconv("GBK","UTF-8",$data['msg']);
						echo json_encode($data);die;
					}else{
						$info=$JobM->GetComjobOne(array("id"=>(int)$_GET['id']));
						$value['job_id']=$_GET['id'];
						$value['com_name']=$info['com_name'];
						$value['job_name']=$info['name'];
						$value['com_id']=$info['uid'];
						$value['uid']=$this->uid;
						$value['eid']=$resume['id'];
						$value['datetime']=mktime();
						$nid=$JobM->AddUseridJob($value);
						if($nid){
							$UserinfoM->UpdateUserStatis("`sq_job`=`sq_job`+1",array("uid"=>$value['com_id']),array('usertype'=>'2'));
							$UserinfoM->UpdateUserStatis("`sq_jobnum`=`sq_jobnum`+1",array("uid"=>$value['uid']),array('usertype'=>'1'));
							if($info['link_type']=='1'){
								$ComM=$this->MODEL("company");
								$job_link=$ComM->GetCompanyInfo(array("uid"=>$info['uid']),array("field"=>"`linkmail`,`linktel`"));
								$info['email']=$job_link['linkmail'];
								$info['mobile']=$job_link['linktel'];
							}else{
								$job_link=$JobM->GetComjoblinkOne(array("jobid"=>(int)$_GET['id'],"is_email"=>"1"),array("field"=>"`email`,`link_moblie`"));
								$info['email']=$job_link['email'];
								$info['mobile']=$job_link['link_moblie'];
							}
							if($this->config['sy_email_set']=="1"){
								if($info['email']){
									$contents=@file_get_contents(Url("resume",array("c"=>"sendresume","job_link"=>'1',"id"=>$resume['id'])));
									
									$emailData['to'] = $info['email'];
									$emailData['subject'] = "���յ�һ���µ���ְ����������".$this->config['sy_webname'];
									$emailData['content'] = $contents;
									$sendid = $this->sendemail($emailData);
								}
							}
							if($this->config['sy_msg_isopen']=='1'){
								if($info['mobile']){
									$data=array('uid'=>$info['uid'],'name'=>$info['com_name'],'cuid'=>'','cname'=>'','type'=>'sqzw','jobname'=>$info['name'],'date'=>date("Y-m-d"),'moblie'=>$info['mobile']);
									$this->send_msg_email($data);
								}
							}
							$JobM->UpdateComjob(array("`snum`=`snum`+1"),array("id"=>(int)$_GET['id']));
							$this->obj->member_log("��������ְλ��".$info['name'],6);
							$data['msg']='Ͷ�ݳɹ���';
							$data['url']=$_SERVER['HTTP_REFERER'];
							$data['msg']=iconv("GBK","UTF-8",$data['msg']);
							echo json_encode($data);die;
						}else{
							$data['msg']='Ͷ��ʧ�ܣ�';
							$data['url']=$_SERVER['HTTP_REFERER'];
							$data['msg']=iconv("GBK","UTF-8",$data['msg']);
							echo json_encode($data);die;
						}
					}
				}else if($_GET['type']=='fav'){
					$rows=$ResumeM->GetFavjobOne(array("uid"=>$this->uid,'job_id'=>(int)$_GET['id']));
					if($rows['id']){
						$data['msg']='���Ѿ��ղع���ְλ���벻Ҫ�ظ��ղأ�';
						$data['url']=$_SERVER['HTTP_REFERER'];
						$data['msg']=iconv("GBK","UTF-8",$data['msg']);
						echo json_encode($data);die;
					}
					$job=$JobM->GetComjobOne(array("id"=>(int)$_GET['id']));
					$value['job_id'] = $job['id'];
					$value['com_name'] = $job['com_name'];
					$value['job_name'] = $job['name'];
					$value['com_id'] = $job['uid'];
					$value['uid'] = $this->uid;
					$value['datetime'] = time();
					$nid=$JobM->AddFavJob($value);
					if($nid){
						$UserinfoM->UpdateUserStatis("`fav_jobnum`=`fav_jobnum`+1",array("uid"=>$this->uid),array('usertype'=>'1'));
						$data['msg']='�ղسɹ���';
						$data['url']=$_SERVER['HTTP_REFERER'];
						$data['msg']=iconv("GBK","UTF-8",$data['msg']);
						echo json_encode($data);die;
					}else{
						$data['msg']='�ղ�ʧ�ܣ�';
						$data['url']=$_SERVER['HTTP_REFERER'];
						$data['msg']=iconv("GBK","UTF-8",$data['msg']);
						echo json_encode($data);die;
					}
				}
			}
		}

		if($this->uid!=$job['uid']){
			if($this->config['com_login_link']=="2"){
				$look_msg=4;
			}elseif($this->config['com_login_link']=="3"){
				if($this->uid=="" && $this->username==""){
					$look_msg=1;
				}else{
					if($this->usertype!="1"){
						$look_msg=2;
					}
				}
			}
			if($this->config['com_resume_link']=="1"&&$this->usertype=='1'){
				$row=$ResumeM->GetResumeExpectNum(array("uid"=>$this->uid));
				if($row<1){
					$look_msg=3;
				}
			}
		}

		$data['job_name']=$job['name'];
		$data['company_name']=$job['com_name'];
		$data['industry_class']=$CacheArr['industry_name'][$job['hy']];
		$data['job_class']=$CacheArr['job_name'][$job['job1']].",".$CacheArr['job_name'][$job['job1_son']].",".$CacheArr['job_name'][$job['job_post']];
		$data['job_desc']=$this->GET_content_desc($job['description']);
		$this->data=$data;
		 
		if($job['is_link']=="1"){
		    if($job['link_type']==2){
		       $link=$JobM->GetComjoblinkOne(array('jobid'=>$job['id']),array('field'=>'`link_man`,`link_moblie`'));
		        $job['linkman']=$link['link_man'];
		        if($link['link_moblie']){
		        	if($look_msg==1){
		        		$job['linktel']= substr_replace($link['link_moblie'],'****',4,4);
		        	}else{
		        		$job['linktel']=$link['link_moblie'];
		        	}
		        }
		    }else{ 
				$job['linkman']=$company['linkman'];
				if($company['linktel']){
					if($look_msg==1){
						$job['linktel']= substr_replace($company['linktel'],'****',4,4);
					}else{
						$job['linktel']=$company['linktel'];
					}
				}
			}
		}else{
		    $look_msg=4;
		}
		if($company['linkphone']){$company['phone']=str_replace('-','',$company['linkphone']);}
		if($this->uid&&$this->usertype&&$this->usertype!=1){
			 
			$typename=array('2'=>'��ҵ�˻�');
			$this->yunset("usertypemsg","����ǰ�ʺ���Ϊ��<span class='job_user_name_s'>".$this->username.'</span>������'.$typename[$this->usertype].'��');
		}
		
		$job['sex'] =$arr_data['sex'][$job['sex']];
		$this->seo("comapply");
		$this->yunset("look_msg",$look_msg);
		$this->yunset("job",$job);
		$this->yunset("Info",$Info);
		$this->yunset("comrat",$comrat);
		$this->yunset($CacheArr);
		$this->yunset("company",$company);
		$this->yunset("headertitle","ְλ����");
		$this->yunset("shareurl",Url('wap',array('c'=>'job','a'=>'share','id'=>$job['id'])));
		$this->yuntpl(array('wap/job_show'));
	}
	function jobout_action(){
		$jobid=intval($_POST['jobid']);
		$this->unset_cookie();
		$url=Url('wap',array('c'=>'login','job'=>$jobid));
		echo $url;die;
	}
	function report_action(){ 
		if($this->usertype!='1'){
			$data['url']=$_SERVER['HTTP_REFERER'];
			$data['msg']=iconv("GBK","UTF-8",'ֻ�и��˻�Ա�ſɾٱ���');
			echo json_encode($data);die;
		}
		$M=$this->MODEL('job');
        $AskM=$this->MODEL('ask');
		$jobid=intval($_POST['id']);
        session_start();
		
		$job=$M->GetComjobOne(array("id"=>$jobid),array('field'=>'`uid`,`com_name`'));
		if($job['uid']==''){
			$data['url']=$_SERVER['HTTP_REFERER'];
			$data['msg']=iconv("GBK","UTF-8",'�Ƿ�������');
			echo json_encode($data);die;
		}
		if($this->config['user_report']!='1'){
			$data['url']=$_SERVER['HTTP_REFERER'];
			$data['msg']=iconv("GBK","UTF-8",'����Աδ�����ٱ����ܣ�');
			echo json_encode($data);die; 
		}
		if(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
			unset($_SESSION['authcode']);
			$data['url']=$_SERVER['HTTP_REFERER'];
			$data['msg']=iconv("GBK","UTF-8",'��֤�����');
			echo json_encode($data);die;  
		}
		$row=$AskM->GetReportOne(array('p_uid'=>$this->uid,'eid'=>(int)$_POST['id'],'c_uid'=>$job['uid'],'usertype'=>$this->usertype));
		if(is_array($row)){
			$data['url']=$_SERVER['HTTP_REFERER'];
			$data['msg']=iconv("GBK","UTF-8",'���Ѿٱ������û���');
			echo json_encode($data);die;  
		}
        $data=array('c_uid'=>$job['uid'],'inputtime'=>time(),'p_uid'=>$this->uid,'usertype'=>(int)$this->usertype,'eid'=>$jobid,'r_name'=>$job['com_name'],'username'=>$this->username,'r_reason'=>iconv("UTF-8","GBK",trim($_POST['reason'])),'did'=>$this->userdid);
		$nid=$AskM->AddReport($data);
		if($nid){
			$data['url']=$_SERVER['HTTP_REFERER'];
			$data['msg']=iconv("GBK","UTF-8",'�ٱ��ɹ���');
			echo json_encode($data);die;  
		}else{
			$data['url']=$_SERVER['HTTP_REFERER'];
			$data['msg']=iconv("GBK","UTF-8",'�ٱ�ʧ�ܣ�');
			echo json_encode($data);die;  
		}
	}
	function applyjobuid_action(){
		$CacheM=$this->MODEL('cache');
		$CacheList=$CacheM->GetCache(array('job','city','com','user','hy'));
		$JobM=$this->MODEL('job');
		if(intval($_GET['jobid'])&&intval($_GET['id'])){
			$Resume=$this->MODEL("resume");
			$row=$Resume->SelectTemporaryResume(array("id"=>intval($_GET['id'])));
			$jobids=@explode(',',$row['job_classid']);
			$jobname=array();
			foreach($jobids as $v){
				$jobname[]=$CacheList['job_name'][$v];
			}
			$row['jobname']=@implode('��',$jobname);
			$this->yunset('row',$row);
		}
		$job=$JobM->GetComjobOne(array("id"=>(int)$_GET['jobid']));
		$data['job_name']=$job['name'];
		$data['company_name']=$job['com_name'];
		$data['job_desc']=$this->GET_content_desc($job['description']);
		$this->data=$data;
		$this->seo("comapply"); 
        $this->yunset('job',$job);
        $this->yunset($CacheList);
		$this->yunset("headertitle","��������");
		$this->yuntpl(array('wap/applyjobuid'));
	}
	function applylogin_action(){
		$CacheM=$this->MODEL('cache');
		$CacheList=$CacheM->GetCache(array('job','city','com','user','hy'));
		$JobM=$this->MODEL('job');
		$job=$JobM->GetComjobOne(array("id"=>(int)$_GET['jobid']));
		$data['job_name']=$job['name'];
		$data['company_name']=$job['com_name'];
		$data['job_desc']=$this->GET_content_desc($job['description']);
		$this->data=$data;
		$this->seo("comapply");
		$this->yunset('job',$job);
		$this->yunset($CacheList);
		$url=Url('wap',array("c"=>"job","a"=>"applyjobuid",'jobid'=>intval($_GET['jobid']),"id"=>intval($_GET['id'])));
		$this->yunset('backurl',$url);
		$this->yunset("headertitle","��������");
		$this->yuntpl(array('wap/applylogin'));
	}
	function share_action(){
		$this->get_moblie();
		include(CONFIG_PATH."db.data.php");		
		$this->yunset("arr_data",$arr_data);
		$JobM=$this->MODEL('job');
		$CacheM=$this->MODEL('cache');
		$UserinfoM=$this->MODEL('userinfo');
		$CacheArr=$CacheM->GetCache(array('job','city','hy','com'));
		$job=$JobM->GetComjobOne(array("id"=>(int)$_GET['id']));
		$welfare = @explode(",",$job['welfare']);
		  foreach($welfare as $k=>$v){
			if(!$v){
			  unset($welfare[$k]);
			}
		  }
		$job['welfare']=$welfare;
		$lang = @explode(",",$job['lang']);
		$job['lang']=$lang;
		$job['sex']=$arr_data['sex'][$job['sex']];
		$company=$UserinfoM->GetUserinfoOne(array("uid"=>$job['uid']),array("usertype"=>'2'));
		if($company['linkphone']){$company['phone']=str_replace('-','',$company['linkphone']);}
		$company['content']=strip_tags($company['content']);
		$job['description']=strip_tags($job['description'],"<br>");
		if($this->uid!=$job['uid']){
			if($this->config['com_login_link']=="2"){
				$look_msg=4;
			}elseif($this->config['com_login_link']=="3"){
				if($this->uid=="" && $this->username==""){
					$look_msg=1;
				}else{
					if($this->usertype!="1"){
						$look_msg=2;
					}
				}
				if($this->config['com_resume_link']=="1"&&$this->usertype=='1'){
					$ResumeM=$this->MODEL('resume');
					$row=$ResumeM->GetResumeExpectNum(array("uid"=>$this->uid));
					if($row<1){
						$look_msg=3;
					}
				}
			}
			
		}
		$this->yunset("look_msg",$look_msg);
		$this->yunset("job",$job);
		$this->yunset($CacheArr);
		$this->yunset("company",$company);
		$this->yunset("headertitle",$job['name'].'-'.$job['com_name'].'-'.$this->config['sy_webname']);
		$this->yunset("job_style",$this->config['sy_weburl']."/app/template/wap/job");
		$this->yuntpl(array('wap/job/index'));
	}
	function ajax_url_action(){
		if($_POST){
			if($_POST['url']!=""){
				$urls=@explode("&",$_POST['url']);
				foreach($urls as $v){
					if($_POST['type']=="provinceid"||$_POST['type']=="cityid"||$_POST['type']=="three_cityid"){
						if(strpos($v,"provinceid")===false && strpos($v,"cityid")===false&& strpos($v,"three_cityid")===false){
							$gourl[]=yun_iconv('utf-8','gbk',$v);
						}
					}else{
						if(strpos($v,$_POST['type'])===false){
							$gourl[]=yun_iconv('utf-8','gbk',$v);
						}
					}
				}
				if($_POST['id']>0){
					$gourl=@implode("&",$gourl)."&".$_POST['type']."=".$_POST['id'];
				}else{
					$gourl=@implode("&",$gourl);
				}
			}else{
				$gourl=$_POST['type']."=".$_POST['id'];
			}
			echo "?".$gourl;die;
		}
	}
	function GetHits_action() {
	    if(intval($_GET['id'])){
	        $JobM=$this->MODEL('job');
	        $JobM->UpdateComjob(array("`jobhits`=`jobhits`+1"),array("id"=>(int)$_GET['id']));
	        $hits=$JobM->GetComjobOne(array('id'=>intval($_GET['id'])),array('field'=>'jobhits'));
	        echo 'document.write('.$hits['jobhits'].')';
	    }
	}
	function msg_action(){
		
			if($this->uid==''||$this->username==''){
				$data['url']=$_SERVER['HTTP_REFERER'];
			    $data['msg']=iconv("GBK","UTF-8",'���ȵ�¼��');
			    echo json_encode($data);die;				
			}
			if($this->usertype!="1"){
				$data['url']=$_SERVER['HTTP_REFERER'];
			    $data['msg']=iconv("GBK","UTF-8",'ֻ�и����û��ſ������ԣ�');
			    echo json_encode($data);die;				
			}
			$M=$this->MODEL("job");
			$black=$M->GetBlackOne(array('p_uid'=>$this->uid,'c_uid'=>(int)$_POST['job_uid']));
			if(!empty($black)){
				$data['url']=$_SERVER['HTTP_REFERER'];
			    $data['msg']=iconv("GBK","UTF-8",'����ҵ�ݲ����������ѯ��');
			    echo json_encode($data);die;				
			}
			if(trim($_POST['reason'])==""){
				$data['url']=$_SERVER['HTTP_REFERER'];
			    $data['msg']=iconv("GBK","UTF-8",'�������ݲ���Ϊ�գ�');
			    echo json_encode($data);die;
			}
			if(trim($_POST['authcode'])==""){
				$data['url']=$_SERVER['HTTP_REFERER'];
			    $data['msg']=iconv("GBK","UTF-8",'��֤�벻��Ϊ�գ�');
			    echo json_encode($data);die;
			}
			session_start();
			if(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
				$data['url']=$_SERVER['HTTP_REFERER'];
			    $data['msg']=iconv("GBK","UTF-8",'��֤�����');
			    echo json_encode($data);die;
			}
			$id=$M->AddMsg(array('uid'=>$this->uid,'username'=>$this->username,'jobid'=>trim($_POST['jobid']),'job_uid'=>trim($_POST['job_uid']),'content'=>iconv("UTF-8","GBK",trim($_POST['reason'])),'com_name'=>iconv("UTF-8","GBK",trim($_POST['com_name'])),'job_name'=>iconv("UTF-8","GBK",trim($_POST['job_name'])),'type'=>'1','datetime'=>time()));
			if($id){
			$data['url']=$_SERVER['HTTP_REFERER'];
			$data['msg']=iconv("GBK","UTF-8",'���Գɹ�����ȴ��ظ���');
			echo json_encode($data);die;  
		}else{
			$data['url']=$_SERVER['HTTP_REFERER'];
			$data['msg']=iconv("GBK","UTF-8",'����ʧ�ܣ�');
			echo json_encode($data);die;  
		}
		}
}
?>