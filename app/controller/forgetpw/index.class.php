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
class index_controller extends common{
	function index_action(){
		$this->seo("forgetpw");
		$this->yun_tpl(array('index'));
	}
	function half_replace($str,$encoding='utf-8'){
        if(strtolower($encoding)=='gbk'){
            $length=mb_strlen($str,'utf-8');
            $len = ceil(mb_strlen($str,'utf-8')/4);
            $start=mb_substr($str,0,$len,'utf-8');
            if($len<$length-$len){
                $end=mb_substr($str,$length-$len,$len,'utf-8');
            }

            $str=$start.'***'.$end;
		    return $str;
        }else{
		    $len = strlen($str)/2;
		    return substr_replace($str,str_repeat('*',$len),ceil(($len)/2),$len);
        }
	}
	function checkuser_action(){
		$username=yun_iconv("utf-8","gbk",$_POST['username']);
		if(!$this->CheckRegUser($username)&&!$this->CheckRegEmail($username)){
			$res['msg']=iconv("gbk","utf-8","�û������������ַ���");
			$res['type']='8';
			echo json_encode($res);die;
		}
		$M=$this->MODEL("userinfo");
		$where=array("`username`='".$username."' or `email`='".$username."' or `moblie`='".$username."'");
		$info=$M->GetMemberOne($where,array("field"=>"`uid`,`username`,`email`,`moblie`"));
 		if(is_array($info)){
 			if($info['email']=="" && $info['moblie']==""){
				$res['msg']=iconv("gbk","utf-8","�����˺�û��������ֻ�������ϵ����Ա��");
				$res['type']='8';
				echo json_encode($res);die;
 			}else{
				$res['msg']='';
				$res['type']='1';
				$res['uid']=$info['uid'];
				$res['username']=$this->half_replace(yun_iconv("gbk","utf-8",$info['username']),'GBK');
				$res['email']=$this->half_replace($info['email']);
				$res['moblie']=$this->half_replace($info['moblie']);
				echo json_encode($res);die;
 			}
		}else{
			$res['type']='2';
			echo json_encode($res);die;
		}
	}
function send_action(){
		$username=yun_iconv("utf-8","gbk",$_POST['username']);
		if(!$this->CheckRegUser($username)&&!$this->CheckRegEmail($username)){
			$res['msg']=yun_iconv("gbk","utf-8","�û��������Ϲ淶��");
			$res['type']='8';
			echo json_encode($res);die;
		}
		if(strpos($this->config['code_web'],'ǰ̨��¼')!==false){
		    session_start();
		    if($this->config['code_kind']==3){
		        if(!gtauthcode($this->config,'mobile')){
		            $res['msg']=yun_iconv("gbk","utf-8",'������ť������֤��');
		            $res['type']='8';
		            echo json_encode($res);die;
		        }
		    }else{
		        if(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
		            unset($_SESSION['authcode']);
		            $res['msg']=yun_iconv("gbk","utf-8",'��֤�����');
		            $res['type']='3';
		            echo json_encode($res);die;
		        }
		    }
		}
		$M=$this->MODEL("userinfo");
		$where=array("`username`='".$username."' or `email`='".$username."' or `moblie`='".$username."'");
		$info=$M->GetMemberOne($where,array("field"=>"`uid`,`username`,`email`,`moblie`,`did`"));
        if($info['uid']){
            if ($_POST['sendtype']=='shensu'){
                $res['type']='1';
            }else{
                $sendcode = rand(100000,999999);
                if($_POST['sendtype']=='email'){
                    if($this->config['sy_email_set']!="1"){
                        $res['msg']=yun_iconv("gbk","utf-8","��վ�ʼ��������ݲ����ã�");
                        $res['type']='8';
                        echo json_encode($res);die;
                    }elseif($this->config['sy_email_getpass']=="2"){
                        $res['msg']=yun_iconv("gbk","utf-8","��վδ�����ʼ��һ����룡");
                        $res['type']='8';
                        echo json_encode($res);die;
                    }
                }elseif ($_POST['sendtype']=='moblie'){
                    if(!$this->config["sy_msguser"] || !$this->config["sy_msgpw"] || !$this->config["sy_msgkey"]||$this->config['sy_msg_isopen']!='1'){
                        $res['msg']=yun_iconv("gbk","utf-8","��û�����ö��ţ�����ϵ����Ա��");
                        $res['type']='8';
                        echo json_encode($res);die;
                    }elseif($this->config['sy_msg_getpass']=="2"){
                        $res['msg']=yun_iconv("gbk","utf-8","��վδ���������һ����룡");
                        $res['type']='8';
                        echo json_encode($res);die;
                    }
                }
				//�жϷ�������
				if($_POST['sendtype']=='email'){
				   
					$num=$this->obj->DB_select_num("company_cert","`uid`='".$info['uid']."' and `check`='".$info['email']."' AND `ctime`>='".strtotime(date('Y-m-d'))."'");
					if($num>=5){

						$res['msg']=iconv("gbk","utf-8",'�벻ҪƵ�������ʼ���');
						$res['type']='8';
						echo json_encode($res);die;
					}

				}elseif ($_POST['sendtype']=='moblie'){

					$num=$this->obj->DB_select_num("moblie_msg","`moblie`='".$info['moblie']."' and `ctime`>='".strtotime(date("Y-m-d"))."'");
					if($num>=$this->config['moblie_msgnum']){

						$res['msg']=iconv("gbk","utf-8",'�벻ҪƵ�����ͣ�');
						$res['type']='8';
						echo json_encode($res);die;
					}
					
					$ip=fun_ip_get();
					$ipnum=$this->obj->DB_select_num("moblie_msg","`ip`='".$ip."' and `ctime`>'".strtotime(date("Y-m-d"))."'");
					if($ipnum>=$this->config['ip_msgnum']){
						$res['msg']=iconv("gbk","utf-8",'��ǰIP���ŷ������ޣ�');
						echo json_encode($res);die;
					} 
				}
                $fdata=$this->forsend(array('uid'=>$info['uid'],'usertype'=>$info['usertype']));
                $data['uid']=$info['uid'];
                $data['username']=$info['username'];
                $data['name']=$fdata['name'];
                $data['type']="getpass";
                if($_POST['sendtype']=='email'){
                    $data['email']=$info['email'];
                }elseif ($_POST['sendtype']=='moblie'){
                    $data['moblie']=$info['moblie'];
                }
                $data['sendcode']=$sendcode;
                $data['date']=date("Y-m-d");
                $status=$this->send_msg_email($data);
                if($_POST['sendtype']=='email'){
                    $check=$info['email'];
                }else{
                    $check=$info['moblie'];
                }
                $cert=$M->GetCompanyCert(array("uid"=>$info['uid'],"type"=>"7","check"=>$check),array("field"=>"`uid`,`check2`,`ctime`,`id`"));
                if($cert){
                    $M->UpdateCompanyCert(array("check2"=>$sendcode,"ctime"=>time()),array("id"=>$cert['id']));
                }else{
                    $M->AddCompanyCert(array('type'=>'7','status'=>0,'uid'=>$info['uid'],'check2'=>$sendcode,'check'=>$check,'ctime'=>time(),'did'=>$info['did']));
                }
                if($_POST['sendtype']=='email'){
                    $res['msg']=iconv("gbk","utf-8",'��֤���ʼ����ͳɹ���');
                }elseif($_POST['sendtype']=='moblie'){
                    $res['msg']=iconv("gbk","utf-8",'��֤�����'.$status);
                    if($status!="���ͳɹ�!"){
                        $res['type']='8';
                        echo json_encode($res);die;
                    }
                }
                $res['type']='1';
                $res['uid']=$info['uid'];
                $res['username']=$this->half_replace(yun_iconv("gbk","utf-8",$info['username']),'GBK');
                $res['email']=$this->half_replace($info['email']);
                $res['moblie']=$this->half_replace($info['moblie']);
            }
			echo json_encode($res);die;
        }else{
            $res['type']='2';
			echo json_encode($res);die;
        }
	}
	function checksendcode_action(){
		$username=yun_iconv("utf-8","gbk",$_POST['username']);
		if(!$this->CheckRegUser($username)&&!$this->CheckRegEmail($username)){
            $res['msg']=yun_iconv("gbk","utf-8","�û������������ַ���");
            $res['type']='8';
            echo json_encode($res);die;
		}
		$M=$this->MODEL("userinfo");
		$where=array("`username`='".$username."' or `email`='".$username."' or `moblie`='".$username."'");
		$info = $M->GetMemberOne($where,array("field"=>"`uid`,`username`,`email`,`moblie`"));
		if($_POST['sendtype']=='email'){
			$check=$info['email'];
		}else{
			$check=$info['moblie'];
		}
		$cert = $M->GetCompanyCert(array("uid"=>$info['uid'],"type"=>"7","check"=>$check),array("field"=>"`uid`,`check2`,`ctime`,`id`"));
        if(($_POST['code']!=$cert['check2'])||(!$cert)){
			$res['msg']=iconv("gbk","utf-8","��֤�����");
			$res['type']='8';
			echo json_encode($res);die;
		}
		if(is_array($info)){
			$res['msg']=yun_iconv("gbk","utf-8","��֤����ȷ��");
			$res['type']='1';
			$res['uid']=$info['uid'];
			$res['username']=$this->half_replace(yun_iconv("gbk","utf-8",$info['username']),'GBK');
			$res['email']=$this->half_replace($info['email']);
			$res['moblie']=$this->half_replace($info['moblie']);
			echo json_encode($res);die;
		}else{
			$res['type']='2';
			echo json_encode($res);die;
		}
	}
	function checklink_action(){
	    $_POST=$this->post_trim($_POST);
	    $username=yun_iconv("utf-8","gbk",$_POST['username']);
	    if(!$this->CheckRegUser($username)&&!$this->CheckRegEmail($username)){
	        $res['msg']=yun_iconv("gbk","utf-8","�û������������ַ���");
	        $res['type']='8';
	        echo json_encode($res);die;
	    }
	    $_POST['linkman']=yun_iconv("utf-8","gbk",$_POST['linkman']);
	    $shensu=$_POST['linkman'].'-'.$_POST['linkphone'].'-'.$_POST['linkemail'];
	    $M=$this->MODEL("userinfo");
	    $where=array("`username`='".$username."'");
	    $nid = $M->UpdateMember(array('appeal'=>$shensu,'appealtime'=>time(),'appealstate'=>'1'),$where);
	    if ($nid){
	        $res['type']='1';
	        echo json_encode($res);die;
	    }
	}
	function editpw_action(){
        $username=yun_iconv("utf-8","gbk",$_POST['username']);
		if(!$this->CheckRegUser($username)&&!$this->CheckRegEmail($username)){
            $res['msg']=yun_iconv("gbk","utf-8","�û������������ַ���");
            $res['type']='8';
            echo json_encode($res);die;
		}
		$M=$this->MODEL("userinfo");
		$where=array("`username`='".$username."' or `email`='".$username."' or `moblie`='".$username."'");
		$info = $M->GetMemberOne($where,array("field"=>"`uid`,`username`,`email`,`moblie`"));
		if($_POST['sendtype']=='email'){
			$check=$info['email'];
		}else{
			$check=$info['moblie'];
		}
		$cert = $M->GetCompanyCert(array("uid"=>$info['uid'],"type"=>"7","check"=>$check),array("field"=>"`uid`,`check2`,`ctime`,`id`"));
        if($_POST['code']!=$cert['check2']){
			$res['msg']=yun_iconv("gbk","utf-8","��֤�����");
			$res['type']='8';
			echo json_encode($res);die;
		}
        if(!$_POST['password']){
			$res['msg']=yun_iconv("gbk","utf-8","��������д��Ϣ��");
			$res['type']='8';
			echo json_encode($res);die;
		}
        $password = $_POST['password'];
        if(is_array($info))
        {
            if($this->config[sy_uc_type]=="uc_center" && $info['name_repeat']!="1")
            {
                $this->uc_open();
                uc_user_edit($info[username], "", $password, $info['email'],"0");
            }

            $salt = substr(uniqid(rand()), -6);
            $pass2 = md5(md5($password).$salt);
            $M->UpdateMember(array("password"=>$pass2,"salt"=>$salt),array("uid"=>$cert['uid']));
            
            $res['msg']=yun_iconv("gbk","utf-8",'�����޸ĳɹ���');
            $res['type']='1';
            $res['uid']=$info['uid'];
            $res['username']=$this->half_replace(yun_iconv("gbk","utf-8",$info['username']),'GBK');
            $res['email']=$this->half_replace($info['email']);
            $res['moblie']=$this->half_replace($info['moblie']);
            echo json_encode($res);die;
        }else{
            $res['msg']=yun_iconv("gbk","utf-8","�Բ���û�и��û���");
            $res['type']='8';
            echo json_encode($res);die;
        }
    }
}