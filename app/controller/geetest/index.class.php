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

		session_start();

		require_once LIB_PATH . '/class.geetestlib.php';
		
		$GtSdk = new GeetestLib($this->config['sy_geetestid'], $this->config['sy_geetestkey']);
		
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
		$str ="";  
		for ( $i = 0; $i < 4; $i++ )  {  
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);   
		}
		$user_id = $str;

		$data = array(
				"user_id" => $user_id, 
				"client_type" => "web", 
				"ip_address" => "127.0.0.1" 
		);

		$status = $GtSdk->pre_process($data, 1);

		$_SESSION['gtserver'] = $status;
		$_SESSION['user_id'] = $str;
		echo $GtSdk->get_response_str();
	}
	
}
?>