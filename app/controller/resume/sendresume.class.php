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
class sendresume_controller extends resume_controller{
	function index_action(){
		if((int)$_GET['id']){
			include(CONFIG_PATH."db.data.php");
			unset($arr_data['sex'][3]);
			$this->yunset("arr_data",$arr_data);
			$M=$this->MODEL('resume');
			$id=(int)$_GET['id'];
			$user=$M->resume_select($id);
			$user['sex']=$arr_data['sex'][$user['sex']];
			$JobM=$this->MODEL('job');
			$time=strtotime("-14 day");
			$allnum=$JobM->GetUserJobNum(array("uid"=>$user['uid'],"eid"=>$user['id'],"`datetime`>'".$time."'"));
			$replynum=$JobM->GetUserJobNum(array("uid"=>$user['uid'],"eid"=>$user['id'],"`datetime`>'".$time."' and `is_browse`>'1'"));

			$pre=round(($replynum/$allnum)*100);
			$this->yunset("pre",$pre);
			$this->yunset("Info",$user);
		}

		$this->yuntpl(array('resume/sendresume'));
    }
}
?>