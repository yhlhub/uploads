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
class index_controller extends job_controller{
	function comsearch(){
		if($_GET[job]){
			$job=explode("_",$_GET[job]);
			$_GET['job1']=$job[0];
			$_GET['job1_son']=$job[1];
			$_GET['job_post']=$job[2];
		}
		if($_GET[city]){
			$city=explode("_",$_GET[city]);
			$_GET['provinceid']=$city[0];
			$_GET['cityid']=$city[1];
			$_GET['three_cityid']=$city[2];
		}
		if($_GET[job1son]){
	       
	        $_GET['job1_son']=$_GET[job1son];
	    }
		if($_GET[jobpost]){
	       
	        $_GET['job_post']=$_GET[jobpost];
	    }
		if($_GET[tp]==1){
			$_GET['urgent']=1;
		}
		if($_GET[tp]==2){
			$_GET['rec']=1;
		}
	if($_GET[all]){//�ϲ�����ƥ��
	        $allurl=explode("_",$_GET[all]);
	        $_GET['hy']=$allurl[0];
	        $_GET['edu']=$allurl[1];
	        $_GET['exp']=$allurl[2];
	        $_GET['sex']=$allurl[3];
	        $_GET['report']=$allurl[4];
	        $_GET['uptime']=$allurl[5];
	    }
	    if ($_GET['salary']){
	        $salary=explode('_', $_GET['salary']);
	        $_GET['minsalary']=$salary[0];
	        $_GET['maxsalary']=$salary[1];
	    }
        include(CONFIG_PATH."db.data.php");		
		$this->yunset("arr_data",$arr_data);
		$arr_data1=$arr_data['sex'][$_GET['sex']];
		$this->yunset("arr_data1",$arr_data1);
		
		if($this->config['province']){
			$_GET['provinceid'] = $this->config['province'];
		}
		if($this->config['cityid']){
			$_GET['cityid'] = $this->config['cityid'];
		}
		if($this->config['three_cityid']){
			$_GET['three_cityid'] = $this->config['three_cityid'];
		}
        $uptime=array('1'=>'����','3'=>'���3��','7'=>'���7��','30'=>'���һ����','90'=>'���������');
        $this->yunset("uptime",$uptime);
		$sdate=array('1'=>'һ����',"3"=>'������','7'=>'������',"15"=>'ʮ������','30'=>'һ������',"60"=>'��������');
		$this->yunset("sdate",$sdate);
        $CacheM=$this->MODEL('cache');
        $CacheList=$CacheM->GetCache(array('job','city','com','hy'));
	    $this->yunset($CacheList);
		$FinderParams=array('hy','job','city','job1','job1_son','job_post','provinceid','cityid','three_cityid','minsalary','maxsalary','edu','exp','sex','type','report','sdate','uptime');
		foreach($_GET as $k=>$v){
			if(in_array($k,$FinderParams)&&$v!=""&&$v!="0"){ 
				$finder[$k]=$v; 
			}
		}
		unset($finder['city']);unset($finder['job']);unset($finder['all']);unset($finder['tp']);unset($finder['minsalary']);unset($finder['maxsalary']);
		$this->yunset('finder',$finder);
		if($this->config['cityid']){
			unset($finder['cityid']);
		}

		if($finder&&is_array($finder)){
			foreach($finder as $key=>$val){
				$para[]=$key."=".$val;
			}
			$paras=@implode('##',$para);
			$this->yunset("paras",$paras);
		}

		if($_COOKIE['lookjob'] || $_COOKIE['favjob'] || $_COOKIE['useridjob']){
			$this->yunset(array('lookjob'=>@explode(',',$_COOKIE['lookjob']),'favjob'=>@explode(',',$_COOKIE['favjob']),'useridjob'=>@explode(',',$_COOKIE['useridjob'])));
		}else{
			$historyM = $this->MODEL('history');
			$lookjob = $historyM->lookJobHistory($this->uid);
			$favjob  = $historyM->favjobHistory($this->uid);
			$useridjob  = $historyM->useridjobHistory($this->uid);
			if($this->config['sy_web_site']=="1"){
				if($this->config['sy_onedomain']!=""){
					$weburl=get_domain($this->config['sy_onedomain']);
				}elseif($this->config['sy_indexdomain']!=""){
					$weburl=get_domain($this->config['sy_indexdomain']);
				}else{
					$weburl=get_domain($this->config['sy_weburl']);
				}
				
				SetCookie("lookjob",$lookjob,time() + 86400,"/",$weburl);
				SetCookie("favjob",$favjob,time() + 86400,"/",$weburl);
				SetCookie("useridjob",$useridjob,time() + 86400,"/",$weburl);

			}else{
				SetCookie("lookjob",$lookjob,time() + 86400,"/");
				SetCookie("favjob",$favjob,time() + 86400,"/");
				SetCookie("useridjob",$useridjob,time() + 86400,"/");			
			}
			
			$this->yunset(array('lookjob'=>@explode(',',$lookjob),'favjob'=>@explode(',',$favjob),'useridjob'=>@explode(',',$useridjob)));
		}
		
		
		$this->seo("com_search");
		$this->yun_tpl(array('search'));
	}
	function search_action(){
		$this->comsearch();
	}
	function index_action(){
		if($this->config['sy_default_comclass']=='1'){
			$CacheM=$this->MODEL('cache');
            $CacheList=$CacheM->GetCache(array('job','city','hy'));
            $this->yunset($CacheList);
			$this->seo("com");
			$this->yun_tpl(array('index'));
		}else{
			$this->comsearch();
		}
	}
	function addfinder_action(){
		if($this->usertype==$_POST['usertype']&&$this->uid){
			$M=$this->MODEL('job');
			if($_COOKIE['usertype']=='1'){
				$finder =  $this->config['user_finder'];
			}elseif($_COOKIE['usertype']=='2'){
				$finder =  $this->config['com_finder'];
			}

			if($finder){
				$num=$M->GetFinderNum(array('uid'=>$this->uid));
				if($num>=$finder){
					$this->layer_msg("�������Ѵ����������",8,0);
				}
			}
			$res=$this->insertfinder(trim($_POST['para']));
			$res?$this->layer_msg("����ɹ���",9,0):$this->layer_msg("����ʧ�ܣ�",8,0);
		}else{
			if($_POST['usertype']=="1"){
				$msg="ֻ�и����û��������ְλ������";
			}elseif($_POST['usertype']=="2"){
                $msg="ֻ����ҵ�û���������˲���������";
			}else{
                $msg="��ǰ��Ա���Ͳ����������������";
            }
			$this->layer_msg($msg,8,0);
		}
	}
	function report_action(){
        session_start();
		$M=$this->MODEL('job');
        $AskM=$this->MODEL('ask');
		if($this->config['user_report']!='1'){echo 5;die;}
		if(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode']  || empty($_SESSION['authcode'])){unset($_SESSION['authcode']);echo 1;die;}
		$row=$AskM->GetReportOne(array('p_uid'=>$this->uid,'eid'=>(int)$_POST['id'],'c_uid'=>(int)$_POST['r_uid'],'usertype'=>$this->usertype));
		if(is_array($row)){echo 2;die;}
        $data=array('c_uid'=>(int)$_POST['r_uid'],'inputtime'=>mktime(),'p_uid'=>$this->uid,'usertype'=>(int)$this->usertype,'eid'=>(int)$_POST['id'],'r_name'=>$this->stringfilter($_POST['r_name']),'username'=>$this->username,'r_reason'=>$this->stringfilter($_POST['r_reason']),'did'=>$this->userdid);
		$nid=$AskM->AddReport($data);
		if($nid){
			echo 3;die;
		}else{
			echo 4;die;
		}
	}
	function recommend_action(){
		if($_POST){
			if($_POST['femail']=="" || $_POST['myemail']=="" || $_POST['authcode']==""){
				echo "��������д��Ϣ��";die;
			}
			session_start();
			if(md5(strtolower($_POST['authcode']))!=$_SESSION[authcode]){
				echo "��֤�벻��ȷ��";die;
			}
			unset($_SESSION[authcode]);
			if($_COOKIE["sendjob"]==$_POST['id']){
				echo "�벻ҪƵ�������ʼ���ͬһְλ���ͼ��Ϊ�����ӣ�";die;
			}
			if($this->config['sy_email_set']!="1"){
				echo "��վ�ʼ�������������";die;
			}
			$filename = TPL_PATH.$this->config['style']."/".$this->m."/sendjob.htm";

		    $handle = fopen($filename, "r");
		    $contents = fread($handle, filesize ($filename));
		    fclose($handle);
		    $contents = $this->assignhtm($contents,(int)$_POST['id']);
			$myemail = $this->stringfilter(trim($_POST['myemail']));
			$title="���ĺ���".$myemail."�����Ƽ���ְλ��";


			$emailData['to'] = $_POST['femail'];
			$emailData['subject'] = $title;
			$emailData['content'] = $contents;
			$sendid = $this->sendemail($emailData);	

			if($sendid){
				echo 1;
			}else{
				echo "�ʼ����ʹ��� ԭ��1���䲻���� 2��վ�ر��ʼ�����";die;
			}
			SetCookie("sendjob",$_POST['id'],time() + 120, "/");
			die;
		}
		$JobM=$this->MODEL('job');
		$Member=$this->MODEL('userinfo');
		$Info=$JobM->GetComjobOne(array("state"=>"1","id"=>(int)$_GET['id'],"`r_status`<>'2'"));
		$com=$Member->GetUserinfoOne(array("uid"=>$Info['uid']),array("usertype"=>"2","field"=>"hy,sdate,address,zip,linkman,website,content"));
		$Info['hy']=$com['hy'];
		$Info['sdate']=$com['sdate'];
		$Info['address']=$com['address'];
		$Info['zip']=$com['zip'];
		$Info['linkman']=$com['linkman'];
		$Info['content']=$com['content'];
		$Info['website']=$com['website'];
		if(is_array($Info)){

			$cache_array = $this->db->cacheget();
			$Job = $this->db->array_action($Info,$cache_array);
		}

		if($this->uid&&$this->usertype&&$this->usertype!=1){
			$typename=array('2'=>'��ҵ�˻�');
			$this->yunset("usertypemsg",'����ǰ�ʺ���Ϊ��<span class="job_user_name_s">'.$this->username.'</span>������'.$typename[$this->usertype].'��');
		}
		$data['job_name']=$Job['name'];
		$data['industry_class']=$Job['job_hy'];
		$data['job_class']=$Job['job_class_one'].",".$Job['job_class_two'].",".$Job['job_class_three'];
		$data['job_desc']=$this->GET_content_desc($Job['description']);
		$this->data=$data;
		$this->yunset("Info",$Job);
		$this->seo("recommend");
		$this->yun_tpl(array('recommend'));
	}
	function send_email_job_action(){
		$this->yun_tpl(array('send_email_job'));
	}

	function question_action(){
		$this->yun_tpl(array('question'));
	}


}
?>