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
class ad_order_controller extends company{
	function index_action(){
		$this->public_action();
		$urlarr=array("c"=>"ad_order","page"=>"{{page}}");
		$pageurl=Url('member',$urlarr);
		$where="`comid`='".$this->uid."'";
		$this->get_page("ad_order",$where,$pageurl,"10");
		$this->yunset("js_def",4);
		$this->com_tpl('ad_order');
	}
	function del_action(){
		if($_GET['id']){
			$pic_url=$this->obj->DB_select_once("ad_order","`id`='".(int)$_GET['id']."' and `comid`='".$this->uid."' and `status`<>'1'","`pic_url`");
 			if($pic_url['pic_url']){
				unlink_pic($pic_url['pic_url']);
			}
			$this->obj->DB_delete_all("ad_order","`id`='".(int)$_GET['id']."' and `comid`='".$this->uid."'");
			$this->obj->member_log("ɾ����涩��");
 			$this->layer_msg('ɾ���ɹ���',9,0,$_SERVER['HTTP_REFERER']);
		}
	}
	function look_action(){
		$this->public_action();
		$info=$this->obj->DB_select_once("ad_order","`id`='".(int)$_GET['id']."' and `comid`='".$this->uid."'");
		if($info['status']==1){
			$ad=$this->obj->DB_select_once("ad","`id`='".$info['ad_id']."'");
			$start = @strtotime($ad['time_start']);
			$end = @strtotime($ad['time_end']." 23:59:59");
			$time = time();
			if($ad['time_start']!="" && $start!="" &&($ad['time_end']==""||$end!="")){
				if($ad['time_end']=="" || $end>$time){
					if($ad['is_open']=='1'&&$start<$time){
						$ad['type']="<font color='green'>ʹ����..</font>";
					}else if($start<$time&&$ad['is_open']=='0'){
						$ad['type']="<font color='red'>��ͣ��</font>";
					}elseif($start>$time && ($end>$time || $ad['time']=="")){
						$ad['type']="<font color='#ff6600'>�����δ��ʼ</font>";
					}
				}else{
					$ad['type']="<font color='red'>���ڹ��</font>";
				}
			}else{
				$ad['type']="<font color='red'>��Ч���</font>";
			}
		}elseif($info['status']==2){
			$ad['type']="<font color='red'>���˻�</font>";
		}else{
			$ad['type']="<font color='red'>δ���</font>";
		}
		$this->yunset("info",$info);
		$this->yunset("ad",$ad);
		$this->yunset("js_def",4);
		$this->com_tpl('ad_detail');
	}
}
?>