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
class ad_controller extends company
{
	function index_action()
	{
		$this->public_action();
		$this->company_satic();
		$this->yunset("js_def",4);
		$rows=$this->obj->DB_select_all("ad_class","`type`='1'");
		$this->yunset("rows",$rows);
		$this->com_tpl('ad');
	}
	function adinfo_action()
	{
		if($_GET['id'])
		{
			$row=$this->obj->DB_select_once("ad_class","`id`='".(int)$_GET['id']."' and `type`='1'");
			if($row['id'])
			{
				$this->public_action();
				$this->company_satic();
				$this->yunset("js_def",4);
				$this->yunset("row",$row);
				$this->com_tpl('buyad');
			}else{
				$this->ACT_msg("index.php?c=ad","�Ƿ�������");
			}
		}
	}
}
?>