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
class resumeshare_controller extends resume_controller{
	function index_action(){
		if($_POST){
			if($_POST['femail']=="" || $_POST['myemail']=="" || $_POST['authcode']==""){
				echo "��������д��Ϣ��";die;
			}
			session_start();
			if(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
				echo "��֤�벻��ȷ��";die;
			}
			unset($_SESSION['authcode']);
			if($_COOKIE["sendresume"]==$_POST['id']){
				echo "�벻ҪƵ�������ʼ���ͬһ�������ͼ��Ϊ�����ӣ�";die;
			}
			if($this->config['sy_email_set']!="1"){
				echo "��վ�ʼ�������������!";die;
			}
			if($this->CheckRegEmail(trim($_POST['femail']))==false){echo "�����ʽ����";die;}
			$contents=file_get_contents($this->config[sy_weburl]."/resume/index.php?c=sendresume&id=".$_POST['id']);
			$myemail = $this->stringfilter($_POST['myemail']);

			
			$emailData['to'] = $_POST['femail'];
			$emailData['subject'] = "���ĺ���".$myemail."�����Ƽ��˼�����";
			$emailData['content'] = $contents;
			
			$emailData['uid'] = '';
			$emailData['name'] = $_POST['femail'];
			$emailData['cuid'] = $this->uid;
			$emailData['cname'] = $myemail;

			$sendid = $this->sendemail($emailData);	

			if($sendid){
				echo 1;
			}else{
				echo "�ʼ����ʹ��� ԭ��1���䲻���� 2��վ�ر��ʼ�����";die;
			}
			SetCookie("sendresume",$_POST['id'],time() + 120, "/");
			die;
		}
		if((int)$_GET['id']){
			$M=$this->MODEL('resume');
			$id=(int)$_GET['id'];
			$user=$M->resume_select($id);
			include(CONFIG_PATH."db.data.php");
		    unset($arr_data['sex'][3]);
		    $this->yunset("arr_data",$arr_data);
			$user['sex']=$arr_data['sex'][$user['sex']];
			$JobM=$this->MODEL('job');
			$time=strtotime("-14 day");
			$allnum=$JobM->GetUserJobNum(array("uid"=>$user['uid'],"eid"=>$user['id'],"`datetime`>'".$time."'"));
			$replynum=$JobM->GetUserJobNum(array("uid"=>$user['uid'],"eid"=>$user['id'],"`datetime`>'".$time."' and `is_browse`>'1'"));
			$pre=round(($replynum/$allnum)*100);
			$this->yunset("pre",$pre);
			$this->yunset('Info',$user);
			$data['resume_username']=$user['username_n'];
			$data['resume_city']=$user['city_one'].",".$user['city_two'];
			$data['resume_job']=$user['hy'];
			$this->data=$data;
		}
		$this->seo("resume_share");
		$this->yuntpl(array('resume/resume_share'));
    }
}
?>