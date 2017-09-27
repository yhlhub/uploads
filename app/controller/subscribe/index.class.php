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
class index_controller extends common{
	function index_action(){
		if($this->uid&&$this->usertype=='1'){ 
			$email=$this->MODEL("resume")->SelectResume(array("uid"=>$this->uid),"name,email,email_status");  
		}else if($this->uid&&$this->usertype=='2'){
			$email=$this->MODEL("company")->GetCompanyInfo(array("uid"=>$this->uid),array("field"=>"name,`linkmail` as `email`,email_status")); 
		}  
		if($_POST['submit']){
			if($this->usertype&&$this->usertype!=1&&$this->usertype!=2){
				$this->ACT_layer_msg("ֻ�и��˺���ҵ�û��ſɶ��ģ�",8);
			}
			unset($_POST['submit']);
			$sid=(int)$_POST['sid'];
			if(!$this->CheckRegEmail($_POST['email'])){
				$this->ACT_layer_msg("���������ʽ����ȷ��",8,$_SERVER['HTTP_REFERER']);
			}
			$Subscribe=$this->MODEL("subscribe");
			$info=$Subscribe->GetSubscribeOnce(array("email"=>$_POST['email'],"type"=>(int)$_POST['type']));
			if($info['status']=='1'){
				$email['email_status']=1;
				$email['email']=$info['email'];
			}
			if($info['status']=="1"&&$info['uid']!=$this->uid){
				$this->ACT_layer_msg("�����������ö��ģ��벻Ҫ�ظ����ã�",8,$_SERVER['HTTP_REFERER']);
			}else{
				$code = substr(uniqid(rand()), -6);
				$_POST['code']=$code;
				$_POST['ctime']=time(); 
				if($sid){
					if($info['email']!=$_POST['email']){
						$_POST['status']=$info['status']=0;
					}else {
						$_POST['status']=$info['status'];
					}
					if($email['email_status']=='1'&&$_POST['email']==$email['email']){
						$_POST['email']=$email['email'];
						$_POST['status']=1;
					}

					unset($_POST['sid']);
					$where['id']=$sid;
					$where['uid']=$this->uid;
					$Subscribe->UpdateSubscribe($_POST,$where);
				}else{
					if($email['email_status']=='1'){
						$_POST['email']=$email['email'];
						$_POST['status']=$info['status']=1;
					}
					$_POST['uid']=$this->uid;
					$sid=$Subscribe->AddSubscribe($_POST);
				}
				
				if($info['status']!="1"){
					$data=array();
					$data['cname']=$email['name'];
					$data['type']="cert";
					$data['code']=$code;
					$data['email']=$_POST['email'];
					$data['date']=date("Y-m-d");
					$base=base64_encode($_POST['email']."|".$code);
					if($this->uid){
					    $data['url']="<a href='".$this->config['sy_weburl']."/index.php?m=subscribe&c=cert&coid=".$base."&id=".$sid."'>�����֤</a>";
					}else{
					    $data['url']="<a href='".$this->config['sy_weburl']."/index.php?m=subscribe&c=cert&coid=".$base."&id=".$sid."&type=6'>�����֤</a>";
					}
					$this->send_msg_email($data);
					$this->ACT_layer_msg("�������óɹ�������֤���䣡",9,"index.php?m=subscribe&c=cert&id=".$sid);
				}else{
					$this->ACT_layer_msg("�������óɹ���",9,"member/index.php?c=subscribe");
				}
			}
		}
        $this->yunset($this->MODEL('cache')->GetCache(array('com','job','user','city'))); 
        
		$sid=(int)$_GET['id'];
		if($sid){
			$Subscribe=$this->MODEL("subscribe");
			$info=$Subscribe->GetSubscribeOnce(array("uid"=>$this->uid,"id"=>$sid));
			$this->yunset("info",$info);
		} 
		$this->yunset("email",$email); 
		$cycle_time=array('3'=>'3������','7'=>'1������','14'=>'2������','21'=>'3������','30'=>'1������','90'=>'3������');
		$this->yunset("cycle_time",$cycle_time);
		$this->seo("subscribe");
		$this->yun_tpl(array('index'));
	}
	function cert_action(){
		$Subscribe=$this->MODEL("subscribe");
		if($_GET['coid']){
			$arr=@explode("|",base64_decode($_GET['coid']));
			$email = $arr[0];
			$code = $arr[1];
			if(!$this->CheckRegEmail($email) || !ctype_alnum($code)){
				exit();
			}else{ 
				$nid=$Subscribe->UpdateSubscribe(array("status"=>"1"),array("email"=>$email,"code"=>$code));
				if($nid&&$this->uid){
					$UserinfoM=$this->MODEL("userinfo");
					$id=(int)$_GET['id'];
					$row=$Subscribe->GetSubscribeOnce(array('id'=>$id,"code"=>$code));
					$info=$UserinfoM->GetMemberOne(array("uid"=>$row['uid']),array("field"=>"usertype,uid"));
					$UserinfoM->UpdateUserinfo(array("usertype"=>$info['usertype'],"values"=>array("email_dy"=>1)),array("uid"=>$info['uid']));
				}
				if ($_GET['type']){
				    header("location:".$this->config['sy_weburl']."/index.php?m=register&c=ok&type=6");
				}else {
				    header("location:".$this->config['sy_weburl']."/index.php?m=register&c=ok&type=4");
				}
			}
		}
		$row=$Subscribe->GetSubscribeOnce(array('id'=>intval($_GET['id']),"uid"=>$this->uid));
		if($row['id']==''){
			$this->ACT_msg($this->config['sy_weburl'],"δ�ҵ��ü�¼��");
		}
		$this->yunset("row",$row);
		$this->seo("subscribe");
		$this->yun_tpl(array('cert'));
	}
	function send_email_action(){
		if($_POST['email']){
			$data['type']="cert";
			$code = substr(uniqid(rand()), -6);
			$data['code']=$code;
			$data['date']=date("Y-m-d");
			$data['email']=$_POST['email'];
			$base=base64_encode($_POST['email']."|".$code);
			$url=Url("subscribe",array("c"=>"cert","coid"=>$base));
			$data['url']="<a href='".$url."'>�����֤</a> �����������������ֱ�Ӵ򿪣��븴�Ƹ����ӵ��������ַ����ֱ�Ӵ򿪣�".$url;
			$status=$this->send_msg_email($data);
			$Subscribe=$this->MODEL("subscribe");
			$Subscribe->UpdateSubscribe(array("code"=>$code),array("email"=>$_POST['email']));
			echo 1;die;
		}
	}
}
