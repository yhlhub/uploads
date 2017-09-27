<?php
/*
* $Author £ºPHPYUN¿ª·¢ÍÅ¶Ó
*
* ¹ÙÍø: http://www.phpyun.com
*
* °æÈ¨ËùÓÐ 2009-2017 ËÞÇ¨öÎ³±ÐÅÏ¢¼¼ÊõÓÐÏÞ¹«Ë¾£¬²¢±£ÁôËùÓÐÈ¨Àû¡£
*
* Èí¼þÉùÃ÷£ºÎ´¾­ÊÚÈ¨Ç°ÌáÏÂ£¬²»µÃÓÃÓÚÉÌÒµÔËÓª¡¢¶þ´Î¿ª·¢ÒÔ¼°ÈÎºÎÐÎÊ½µÄÔÙ´Î·¢²¼¡£
 */
class admin_resume_evaluation_controller extends common{

	function set_search(){

		$lo_time=array('1'=>'����','3'=>'�������','7'=>'�������','15'=>'�������','30'=>'���һ����');
		$search_list[]=array("param"=>"time","name"=>'����ʱ��',"value"=>$lo_time);
		$f_time=array('1'=>'����','2'=>'�м�','3'=>'�߼�');
		$search_list[]=array("param"=>"grade","name"=>'���۵ȼ�',"value"=>$f_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		$this->set_search();

		$selectSql = 'select a.id,a.com_name,a.grade,a.score,a.created_at,a.content,b.username as uname,c.name as resume_name,d.username as by_username ';
		$countSql = 'select count(a.id) as num';
		$from = ' from '.$this->def.'resume_evalution a,';
		$from .= $this->def.'member b,';
		$from .= $this->def.'resume_expect c,';
		$from .= $this->def.'member d ';

		$where=' where a.uid=b.uid and a.by_uid=d.uid and c.id=a.resume_id ';
		if($_GET['time']){
			if($_GET['time']=='1'){
				$where.=" and a.`created_at` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and a.`created_at` >= '".strtotime('-'.(int)$_GET['time'].'day')."'";
			}
			$urlarr['time']=$_GET['time'];
		}
		if($_GET['grade']){
			$where.=" and a.`grade` = ".$_GET['grade'];
			$urlarr['grade']=$_GET['grade'];
		}
	
		if($_GET['order'])
		{
			$order=$_GET['order'];
		}else{
			$order="desc";
		}

		$page_url['order']=$_GET['order'];
		$page_url['page']="{{page}}";
		$pageurl=Url($_GET['m'],$page_url,'admin');

		$selectSql .= $from .' '.$where . ' order by a.id '.$order; 
		$countSql .= $from .' '.$where; 

        $M=$this->MODEL();
		$mes_list = $M->get_page_by_sql($selectSql,$countSql,$pageurl);
	
		$this->yunset($mes_list);
		$this->yunset("get_type", $_GET);
		$this->yuntpl(array('admin/admin_resume_evalution'));
	}

	function del_action(){
		$this->check_token();
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($del)){
			    	foreach($del as $v){
			    	   $this->del_member($v);
			    	}
					$layer_type='1';
					$del=implode(",",$del);
		    	}else{
		    		 $this->del_member($del);
					 $layer_type='0';
		    	}
				$this->layer_msg("��������(ID:".$del.")ɾ���ɹ���",9,$layer_type,$_SERVER['HTTP_REFERER'],2,1);
	    	}else{
				$this->layer_msg("��ѡ����Ҫɾ������Ϣ��",8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	}
	function del_member($id)
	{
		return $this->obj->DB_delete_all("resume_evalution","`id`='".$id."'" );
	}

}
?>