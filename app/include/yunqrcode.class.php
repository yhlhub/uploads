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
class YunQrcode {

	static function generatePng2($inputContent,$size){
		require_once LIB_PATH."phpqrcode.php";
		return QRcode::png($inputContent, false, QR_ECLEVEL_L, $size);
	}
}


?>