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

error_reporting(0);

include(dirname(dirname(__FILE__))."/data/plus/config.php");

include(dirname(dirname(__FILE__))."/app/include/verify.class.php");

$capth = new verify($config['code_width'],$config['code_height'],$config['code_strlength'],$config['code_filetype'],$config['code_type']);

$capth->entry(); 

?>