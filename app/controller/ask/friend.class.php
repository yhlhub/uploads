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
class friend_controller extends ask_controller{
	function myquestion_action(){		
		$uid=(int)$_GET['uid'];				
		if($uid==''){
			$uid=$this->uid;
		}
		$this->yunset("myuid",$uid);
		$this->yunset("navtype",'myquestion');
		$M=$this->MODEL('ask');
		$info=$M->GetQuestionOne(array('uid'=>(int)$_GET['uid']));
		$username=$this->obj->DB_select_once('member',"`uid`='".$uid."'","`uid`,`username`");
		if($this->uid==$uid){
			$data['nickname']=$this->username;
		}elseif($info['nickname']){
			$data['nickname']=$info['nickname'];
		}elseif($username['username']){
			$data['nickname']=$username['username'];
		}
		$this->data=$data;
		$this->seo("myquestio");
		$this->ask_tpl('myquestion');
	}
	function myanswer_action(){
		$M=$this->MODEL('ask');
		$uid=(int)$_GET['uid'];
		if($uid==''){
			$uid=$this->uid;
		}
		$this->yunset("myuid",$uid);
		$pageurl=Url('ask',array("c"=>$_GET['c'],'a'=>$_GET['a'],'uid'=>$uid,"page"=>"{{page}}"));
		$rows=$M->get_page("answer","`uid`='".$uid."' order by `add_time` desc",$pageurl,"10");
		if($rows['total']){
			foreach($rows['rows'] as $v){
				$qid[]=$v['qid'];
			}
			$question=$M->GetQuestionList(array("`id` in (".pylode(',',$qid).")"),array('field'=>'`id` as `qid`,`title`'));
			foreach($rows['rows'] as $key=>$val){
				foreach($question as $k=>$v){
					if($val['qid']==$v['qid']){
						$rows['rows'][$key]['title']=$v['title'];
						$rows['rows'][$key]['qid']=$v['qid'];
					}
				}
			}
		}
 		$this->yunset($rows);
		$this->yunset("navtype","myquestion");
		
		
		$username=$this->obj->DB_select_once('member',"`uid`='".$uid."'","`uid`,`username`");
		$info=$M->GetQuestionOne(array('uid'=>(int)$_GET['uid']),array('field'=>'nickname'));
		if($this->uid==$uid){
			$data['nickname']=$this->username;
		}elseif($info['nickname']){
			$data['nickname']=$info['nickname'];
		}elseif($username['username']){
			$data['nickname']=$username['username'];
		}
		$this->data=$data;
		$this->seo("myanswer");
		$this->ask_tpl('myanswer');
 	}
	
	function attenquestion_action(){
		$M=$this->MODEL('ask');	
		$uid=(int)$_GET['uid'];
		if($uid==''){
			$uid=$this->uid;
		}
		$this->yunset("myuid",$uid);
        $atnlist=$M->GetAttentionList(array('uid'=>$uid,'type'=>1),array('field'=>'ids'));
		$ids=array_filter(@explode(',',$atnlist['ids']));
		if(count($ids)){
			$pageurl=Url('ask',array("c"=>$_GET['c'],'a'=>$_GET['a'],'uid'=>$uid,"page"=>"{{page}}"));
			$rows=$M->get_page("question","`id` in (".pylode(',',$ids).") order by `add_time` desc",$pageurl,"10");
		}
		$this->yunset($rows);
		$this->yunset("navtype",'myquestion');
		$username=$this->obj->DB_select_once('member',"`uid`='".$uid."'","`uid`,`username`");
		$info=$M->GetQuestionOne(array('uid'=>(int)$_GET['uid']),array('field'=>'nickname'));
		if($this->uid==$uid){
			$data['nickname']=$this->username;
		}elseif($info['nickname']){
			$data['nickname']=$info['nickname'];
		}elseif($username['username']){
			$data['nickname']=$username['username'];
		}
		$this->data=$data;
		$this->seo('attenquestion');
		$this->ask_tpl('attenquestion');
	}
	function attention_action(){
		$M=$this->MODEL('ask');
		if($this->uid==''||$this->username==''){
			$this->layer_msg('���ȵ�¼��',8,0,$_SERVER['HTTP_REFERER']);
		}
		$this->is_login();
		$id = (int)$_POST['id'];
		$type = (int)$_POST['type'];
		if($id==''&&(int)$_GET['id']){
			$id=(int)$_GET['id'];
			$type=1;
		}
		$isset=$M->GetAttentionList(array('uid'=>$this->uid,'type'=>$type));
		$ids=@explode(',',$isset['ids']);
		if($type=='1'){
			$info=$M->GetQuestionOne(array('id'=>$id),array('field'=>"`id`,`title`,`uid`,`atnnum`"));
			$gourl=Url('ask',array("c"=>"content","id"=>$info['id']));
			$content="��ע��<a href=\"".$gourl."\" target=\"_blank\">��".$info['title']."��</a>��";
			$n_contemt="ȡ���˶�<a href=\"".$gourl."\" target=\"_blank\">��".$info['title']."��</a>�Ĺ�ע��";
			$log="��ע�ˡ�".$info['title']."��";
			$n_log="ȡ���˶ԡ�".$info['title']."��";
		}else{
			$info=$M->GetQclassOnce(array('id'=>$id),array('field'=>"`id`,`name`,`atnnum`"));
			$content="��ע�ˡ�".$info['name']."����";
			$n_contemt="ȡ���ˡ�".$info['name']."����";
			$log="��ע��".$info['name'];
			$n_log="ȡ���˶�".$info['name']."</a>�Ĺ�ע��";
		}
		if($info['uid']==$this->uid){
			$this->layer_msg('���ܹ�ע�Լ����������⣡',8,0,$_SERVER['HTTP_REFERER']);
		}else{
			$data['uid']=$this->uid;
			$data['type']=$type;
			$arr['isadd']=1;
			if($ids[0]==''){
				$data['ids']=$id;
				$nid=$M->AddAttention($data);
			} else if(in_array($id,$ids)&&$ids[0]){
				$nids=array();
				foreach($ids as $val){
					if($val!=$id&&$val&&in_array($val,$nids)==false){
						$nids[]=$val;
					}
				}
				$arr['isadd']=0;
				$data['ids']=pylode(',',$nids);
				$nid=$M->UpdateAttention($data,array("id"=>$isset['id']));
			}else if(in_array($id,$ids)==false&&$ids[0]>0){
				$ids[]=$id;
				$data['ids']=pylode(',',$ids);
				$nid=$M->UpdateAttention($data,array("id"=>$isset['id']));
			}else if(in_array($_POST['id'],$ids)==false&&$ids[0]<1){
				$nid=$M->UpdateAttention(array("ids"=>$id),array("id"=>$isset['id']));
			}
			if($nid){
				if($data['type']=='1'){
					if($arr['isadd']){
						$atnnum=$info['atnnum']+1;
						$M->UpdateQuestion(array("atnnum"=>$atnnum),array("id"=>$info['id']));
					}else{
						$atnnum=$info['atnnum']-1;
						$M->UpdateQuestion(array("atnnum"=>$atnnum),array("id"=>$info['id']));
					}
				}
				if($data['type']=='2'){
					include(LIB_PATH."cache.class.php");
					$cacheclass= new cache(PLUS_PATH,$this->obj);
					$makecache=$cacheclass->ask_cache("ask.cache.php");
				}
				$sql['uid']=$this->uid;
				$sql['content']=$content;
				$sql['ctime']=time();
				$sql['type']=2;
				$Friend=$this->MODEL("friend");
				$Friend->InsertFriendState($sql);
				$M->member_log($log);
				if($atnnum<0){$atnnum=0;}
				if($_GET['id']){
					$this->layer_msg('�����ɹ���',9,0,$_SERVER['HTTP_REFERER']);
				}else{
					$this->layer_msg('�����ɹ���',9,0,$atnnum,$arr['isadd']);
				}
			}else{
				$this->layer_msg('����ʧ�ܣ�',8,0,$_SERVER['HTTP_REFERER']);
			}
		}
	}
	function delattention_action(){
		$M=$this->MODEL('ask');
		$atnlist=$M->GetAttentionList(array('uid'=>$this->uid,'type'=>(int)$_GET['type']),array('field'=>'id'));
        $nids=@explode(',',$atnlist['ids']);
		foreach($nids as $k=>$v){
			if($_POST['id']!=$v&&$v){
				$upid[]=$v;
			}
		}
		if(count($upid)){
			$nid=$M->UpdateAttention(array("ids"=>pylode(',',$upid)),array("uid"=>$this->uid));
			if($nid){
				$M->member_log("ɾ����ע������");
				$this->layer_msg('�����ɹ���',9,0,$_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg('����ʧ�ܣ�',8,0,$_SERVER['HTTP_REFERER']);
			}
		}else{
			$M->DeleteAttention(array("`uid`='".$this->uid."'"));
			$M->member_log("ɾ����ע������");
			$this->layer_msg('�����ɹ���',9,0,$_SERVER['HTTP_REFERER']);
		}
	}
	function delask_action(){
		$id=(int)$_GET['id'];
		if($id){
			$AskM=$this->MODEL('ask');
			
			if($_GET['type']==1){
				$result=$AskM->DeleteAnswer(array("id"=>$id,"uid"=>$this->uid));
			}else{
				$result=$AskM->DeleteQuestion(array("id"=>$id,"uid"=>$this->uid));
			}
			$result?$this->layer_msg('�����ɹ���',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('����ʧ�ܣ�',8,0,$_SERVER['HTTP_REFERER']);
		}
	}
}
?>