<?php
/*
 * $Author ��PHPYUN�����Ŷ�
 *
 * ����: http://www.phpyun.com
 *
 * ��Ȩ���� 2009-2016 ��Ǩ�γ���Ϣ�������޹�˾������������Ȩ����
 *
 * ���������δ����Ȩǰ���£�����������ҵ��Ӫ�����ο����Լ��κ���ʽ���ٴη�����
 */
header("Content-Type: text/html; charset=gb2312");
ob_start();
error_reporting(0);
$i_model = 1;
define('APP_PATH',dirname(dirname(__FILE__)).'/');  
define('S_ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('VERSION', '4.3 beta');
define('YEAR', '2017');
if (substr(PHP_VERSION, 0, 1) == '7') {
	$installDir = 'php7';
}else{
	$installDir = 'php5';
}
define('INS_DIR',$installDir.'/'); 
require_once 'install_lang.php';
require_once $installDir.'/install_function.php';
require_once $installDir.'/install_mysql.php';
require_once $installDir.'/install_var.php';
include $installDir.'/install.php';

?>