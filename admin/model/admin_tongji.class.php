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
class admin_tongji_controller extends common
{	

	function index_action(){
		
		$this->yuntpl(array('admin/admin_tongji'));
	}
	
	function reg_action(){
		
		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('member',$_GET,'reg_date');
		$List['all']['name'] = '���л�Ա';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		
		$comStats = $TongJi->getTj('member',$_GET,'reg_date',"`usertype`='2'");
		$List['com']['name'] = '��ҵ��Ա';
		$List['com']['list'] = $comStats['list'];
		$AllNum['com'] = $comStats['allnum'];
		
		$userStats = $TongJi->getTj('member',$_GET,'reg_date',"`usertype`='1'");
		$List['user']['name'] = '���˻�Ա';
		$List['user']['list'] = $userStats['list'];


		$CountTj = $TongJi->DataTj('reg',$Stats['timedate']['DateWhere'],'member','uid');
		
		$this->yunset('counttj',$CountTj);
		$AllNum['user'] = $userStats['allnum'];
		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','��Աע��ͳ��');

		$this->yuntpl(array('admin/admin_tongji_reg'));
	}
	function lookjob_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('look_job',$_GET,'datetime');
		
		$List['all']['name'] = 'ְλ���';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		$TopList['job'] = $TongJi->TopTen("look_job",$Stats['timedate']['DateWhere'],"jobid","job");

		$TopList['company'] = $TongJi->TopTen("look_job",$Stats['timedate']['DateWhere'],"com_id","company");
		
		
		$this->yunset('toplist',$TopList);
		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','ְλ���ͳ��');

		$this->yuntpl(array('admin/admin_tongji_lookjob'));
	
	}

	function lookresume_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('look_resume',$_GET,'datetime');
		$List['all']['name'] = '�������';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		$TopList['expect'] = $TongJi->TopTen("look_resume",$Stats['timedate']['DateWhere'],"resume_id","expect");

		$TopList['company'] = $TongJi->TopTen("look_resume",$Stats['timedate']['DateWhere'],"com_id","company");
		
		$this->yunset('toplist',$TopList);
		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','�������ͳ��');

		$this->yuntpl(array('admin/admin_tongji_lookresume'));
	
	}

	function useridmsg_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('userid_msg',$_GET,'datetime');
		$List['all']['name'] = '��������';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		$TopList['company'] = $TongJi->TopTen("userid_msg",$Stats['timedate']['DateWhere'],"fid","company");
		
		$TopList['resume'] = $TongJi->TopTen("userid_msg",$Stats['timedate']['DateWhere'],"uid","resume");

		$CountTj = $TongJi->DataTj('job',$Stats['timedate']['DateWhere'],'userid_msg','jobid');
		
		$this->yunset('counttj',$CountTj);
		$this->yunset('toplist',$TopList);
		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','��������ͳ��');

		$this->yuntpl(array('admin/admin_tongji_useridmsg'));
	
	}

	function downresume_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('down_resume',$_GET,'downtime');
		$List['all']['name'] = '��������';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		
		$TopList['company'] = $TongJi->TopTen("down_resume",$Stats['timedate']['DateWhere'],"comid","company");
		
		$TopList['resume'] = $TongJi->TopTen("down_resume",$Stats['timedate']['DateWhere'],"uid","resume");

		$CountTj = $TongJi->DataTj('resume_expect',$Stats['timedate']['DateWhere'],'down_resume','eid');
		
		$this->yunset('counttj',$CountTj);
		$this->yunset('toplist',$TopList);

		
		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','��������ͳ��');

		$this->yuntpl(array('admin/admin_tongji_downresume'));
	
	}
	function useridjob_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('userid_job',$_GET,'datetime');
		$List['all']['name'] = '����Ͷ��';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		$TopList['company'] = $TongJi->TopTen("userid_job",$Stats['timedate']['DateWhere'],"com_id","company");

		$TopList['resume'] = $TongJi->TopTen("userid_job",$Stats['timedate']['DateWhere'],"eid","expect");
		
		$CountTj = $TongJi->DataTj('resume_expect',$Stats['timedate']['DateWhere'],'userid_job','eid');
		
		$this->yunset('toplist',$TopList);
		$this->yunset('counttj',$CountTj);
		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','����Ͷ��ͳ��');

		$this->yuntpl(array('admin/admin_tongji_useridjob'));
	
	}
	function order_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('company_order',$_GET,'order_time',"`order_state`='2'","SUM(`order_price`) as count");
		$List['all']['name'] = '��ֵ���';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		
		
		$TopList['company'] = $TongJi->TopTen("company_order",$Stats['timedate']['DateWhere']." AND `order_state`='2'","uid","order",'10',"SUM(`order_price`) as count");
		 
		$CountTj = $TongJi->DataTj('order',$Stats['timedate']['DateWhere']." AND `order_state`='2'",'company_order','id');
		

		$this->yunset('toplist',$TopList);
		$this->yunset('counttj',$CountTj);

		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','��ֵ���ͳ��');

		$this->yuntpl(array('admin/admin_tongji_order'));
	
	}

	function pay_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('company_pay',$_GET,'pay_time');
		$List['all']['name'] = '���Ѽ�¼';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		
		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','���Ѽ�¼ͳ��');

		$this->yuntpl(array('admin/admin_tongji_pay'));
	
	}

	function job_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('company_job',$_GET,'sdate');
		$List['all']['name'] = '����ְλ';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];		
		
		$TopList['company'] = $TongJi->TopTen("company_job",$Stats['timedate']['DateWhere'],"uid","company");

		$CountTj = $TongJi->DataTj('job',$Stats['timedate']['DateWhere'],'company_job','id');
		
		$this->yunset('toplist',$TopList);
		$this->yunset('counttj',$CountTj);


		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','����ְλͳ��');

		$this->yuntpl(array('admin/admin_tongji_job'));
	
	}
	function resume_action(){

		$TongJi=$this->MODEL('tongji');
		$Stats = $TongJi->getTj('resume_expect',$_GET,'lastupdate');
		$List['all']['name'] = '��������';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];		
		$CountTj = $TongJi->DataTj('resume_expect',$Stats['timedate']['DateWhere'],'resume_expect','id');
		
		$this->yunset('toplist',$TopList);
		$this->yunset('counttj',$CountTj);


		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','����ְλͳ��');

		$this->yuntpl(array('admin/admin_tongji_resume'));
	
	}

	function rating_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('company_statis',$_GET,'sdate');
		$List['all']['name'] = '��Ա����';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		
		$TopList['company'] = $TongJi->TopTen("userid_job",$Stats['timedate']['DateWhere'],"com_id","company");

		$TopList['resume'] = $TongJi->TopTen("userid_job",$Stats['timedate']['DateWhere'],"eid","expect");
		
		$CountTj = $TongJi->DataTj('resume_expect',$Stats['timedate']['DateWhere'],'userid_job','eid');
		
		$this->yunset('toplist',$TopList);
		$this->yunset('counttj',$CountTj);


		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','��Ա����ͳ��');

		$this->yuntpl(array('admin/admin_tongji'));
	
	}
	function company_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('member',$_GET,'reg_date',"`usertype`='2'");
		$List['all']['name'] = '��ҵͳ��';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		
		$comStats = $TongJi->getTj('member',$_GET,'reg_date',"`usertype`='2' AND `status`='0'");
		$List['com']['name'] = '�������ҵ';
		$List['com']['list'] = $comStats['list'];
		$AllNum['com'] = $comStats['allnum'];


		$CountTj = $TongJi->DataTj('company',$Stats['timedate']['DateWhere'],'member','uid');
		
		$this->yunset('counttj',$CountTj);


		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','��ҵͳ��');

		$this->yuntpl(array('admin/admin_tongji_company'));
	
	}
	function ad_action(){

		$TongJi=$this->MODEL('tongji');
	
		$Stats = $TongJi->getTj('adclick',$_GET,'addtime');
		$List['all']['name'] = '�����';
		$List['all']['list'] = $Stats['list'];
		$AllNum['all'] = $Stats['allnum'];
		
		$TopList['ad'] = $TongJi->TopTen("adclick",$Stats['timedate']['DateWhere'],"aid","ad");

		$this->yunset('toplist',$TopList);

		$this->yunset('AllNum',$AllNum);
		$this->yunset('list',$List);
		$this->yunset('name','�����ͳ��');

		$this->yuntpl(array('admin/admin_tongji_ad'));
	
	}

	
}

?>