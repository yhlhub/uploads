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
class site_model extends model{
	
	function GetSiteDomian($keyword,$id='1'){
       $Site = $this->DB_select_all("domain","`title` LIKE '%".iconv("utf-8","gbk",$_POST['keyword'])."%'");
		if(is_array($Site) && !empty($Site)){
			if($id=='2'){
				$didtype = 'domain';
			}else{
				$didtype = 'did';
			}
			foreach($Site as $value){
				
				$siteHtml .='<div class="yun_admin_select_box_list"> <a href="javascript:;" onClick="select_new(\''.$didtype.'\',\''.$value['id'].'\',\''.$value['title'].'\')">'.$value['title'].'</a> </div>';
			}
			echo $siteHtml;
		}else{
			return 1;
		}
    }
	
    function UpDid($Table=array(),$Did,$Where){		
		foreach($Table as $value){		
			$this->DB_update_all($value,"`did`='".$Did."'",$Where);
		}        
    }	
}
?>