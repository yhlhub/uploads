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
		if($this->uid==""){
			$this->ACT_msg($this->config['sy_weburl'], "����û�е�¼�����ȵ�¼��");
		}
		if($_POST['submit']){
			$authcode=md5(strtolower($_POST['authcode']));
			unset($_POST['authcode']);
			$_POST['email']=trim($_POST['email']);
			if($this->config['sy_email_set']!="1"){
				$this->ACT_layer_msg("��վ�ʼ��������ݲ����ã�",8,$_SERVER['HTTP_REFERER']);
			}
			if($_POST['email']==""){
				$this->ACT_layer_msg("�ʼ�����Ϊ�գ�",8,$_SERVER['HTTP_REFERER']);
			} 
			if(!$this->CheckRegEmail($_POST['email'])){
				$this->ACT_layer_msg("�ʼ���ʽ����ȷ��",8,$_SERVER['HTTP_REFERER']);
			}
			if($_POST['content']==""){
				$this->ACT_layer_msg("���ݲ���Ϊ�գ�",8,$_SERVER['HTTP_REFERER']);
			}
		
			if($authcode!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
					unset($_SESSION['authcode']);
					$this->ACT_layer_msg($_POST['authcode']."��֤�����".$_SESSION['authcode'],8);
			} 

			$emailData['to'] = $_POST['email'];
			$emailData['subject'] = "����ע��-".$this->config['sy_webname'];
			$emailData['content'] = $_POST['content'];
			$sendid = $this->sendemail($emailData);	

			if($sendid){
				$this->ACT_layer_msg("����ע���ʼ��ѷ��ͣ�",9,$_SERVER['HTTP_REFERER']);
			}else{
				$this->ACT_layer_msg("����ע���ʼ�����ʧ�ܣ�",8,$_SERVER['HTTP_REFERER']);
			}
		}
		$this->seo("invitereg");
		$this->yun_tpl(array('index'));
	}
}
?>