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
class topbid_controller extends company
{
	function index_action(){
		$this->public_action();
		$this->industry_cache();
 		$where="`xsdate`>'".time()."'";
		if($_GET['hy']){
			$where.=" and `hy`='".(int)$_GET['hy']."'";
		}
		$jingjia=$this->obj->DB_select_all("company_job",$where." order by `xuanshang` desc limit 10","xuanshang");
		$num=count($jingjia);
		if(is_array($jingjia)){
			foreach($jingjia as $v){
				$list[]=$v['xuanshang'];
			}
			for($i = $num; $i <10; $i++){
				$list[]=0;
			}
		}
		$Field = "SUM(case when 1=1 then 1 else 0 end) as job,SUM(case when state='0' then 1 else 0 end) as status0,SUM(case when state='1' then 1 else 0 end) as status1,SUM(case when state='2' then 1 else 0 end) as status2,SUM(case when state='3' then 1 else 0 end) as status3";
		$status=$this->obj->DB_select_all("company_job","`uid`='".$this->uid."'",$Field);
		$this->yunset("status",$status[0]);
		$this->company_satic();
		$this->yunset("hy",$_GET['hy']);
		$this->yunset("list",$list);
		$this->yunset("js_def",3);
		$this->com_tpl('topbid');
	}
}
?>