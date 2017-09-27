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
class weixin_model extends model{
   
 
	function myMsg($wxid='')
	{
		$userBind = $this->isBind($wxid);
		
		if($userBind['bindtype']=='1')
		{
			$Return['centerStr'] = "<Content><![CDATA[".iconv('gbk','utf-8',"������û���µ���Ϣ��")."]]></Content>";
			
		}else{

			$Return['centerStr'] = $userBind['cenetrTpl'];
		}
		$Return['MsgType']   = 'text';
		return $Return;
	}
	
	
	function Audition($wxid='')
	{
		$userBind = $this->isBind($wxid);
		if($userBind['bindtype']=='1')
		{
			$Aud = $this->DB_select_all("userid_msg","`uid`='".$userBind['uid']."' ORDER BY `datetime` DESC limit 5");
			
			if(is_array($Aud) && !empty($Aud))
			{
				foreach($Aud as $key=>$value)
				{
					$Info['title'] = iconv('gbk','utf-8',"��".$value['fname']."����������\n����ʱ�䣺".date('Y-m-d H:i:s'));
					$Info['pic']   = $this->config['sy_weburl'].'/data/upload/wx/jt.jpg';
					$Info['url']   = $this->config['sy_weburl']."/wap/member/index.php?c=invite";
					$List[]        = $Info;
				}
				$Msg['title'] = iconv('gbk','utf-8','��������');
				$Msg['pic'] = $this->config['sy_weburl'].'/'.$this->config['sy_wx_logo'];
				$Msg['url'] = $this->config['sy_weburl']."/wap/member/index.php?c=invite";
				$Return['centerStr'] = $this->Handle($List,$Msg);
				$Return['MsgType']   = 'news';

			}else{

				$Return['centerStr'] ='<Content><![CDATA['.iconv('gbk','utf-8','���������������').']]></Content>';
				$Return['MsgType']   = 'text';
			}
			return $Return;
		}else{
			$Return['MsgType']   = 'text';
			$Return['centerStr'] = $userBind['cenetrTpl'];
			return $Return;
		}
	}
	
	function ApplyJob($wxid='')
	{
		$userBind = $this->isBind($wxid,2);
		if($userBind['bindtype']=='1')
		{
			
			$Apply = $this->DB_select_all("userid_job","`com_id`='".$userBind['uid']."' AND `is_browse`='1' ORDER BY `datetime` DESC limit 5");
			
			if(is_array($Apply) && !empty($Apply))
			{
				foreach($Apply as $key=>$value)
				{
					$uid[] = $value['uid'];
				}
				
				$userList = $this->DB_select_all("resume","`uid` IN (".@implode(',',$uid).")","`uid`,`name`,`edu`,`exp`");
				if(is_array($userList)){
					
					foreach($userList as $key=>$value)
					{
						$resumeList[$value['uid']] = $value;
					}
				}
				include(PLUS_PATH."/user.cache.php");
				foreach($Apply as $key=>$value)
				{
					$Info['title'] = iconv('gbk','utf-8',"��".$resumeList[$value['uid']]['name']."��".$userclass_name[$resumeList[$value['uid']]['edu']]."/".$userclass_name[$resumeList[$value['uid']]['exp']]."��������\n����������ְλ��".$value['job_name']."\nͶ��һ�ݼ���\nͶ��ʱ�䣺".date('Y-m-d H:i',$value['datetime']));
					$Info['pic']   = $this->config['sy_weburl'].'/data/upload/wx/jt.jpg';
					$Info['url']   = $this->config['sy_weburl']."/wap/member/index.php?c=invite";
					$List[]        = $Info;
				}
				$Msg['title'] = iconv('gbk','utf-8','����Ͷ��');
				$Msg['pic'] = $this->config['sy_weburl'].'/'.$this->config['sy_wx_logo'];
				$Msg['url'] = $this->config['sy_weburl']."/wap/member/index.php?c=invite";
				$Return['centerStr'] = $this->Handle($List,$Msg);
				$Return['MsgType']   = 'news';

			}else{

				$Return['centerStr'] ='<Content><![CDATA['.iconv('gbk','utf-8','������޼���Ͷ��').']]></Content>';
				$Return['MsgType']   = 'text';
			}
			
			return $Return;
		}else{
			$Return['MsgType']   = 'text';
			$Return['centerStr'] = $userBind['cenetrTpl'];
			return $Return;
		}
	}
	
	function PartApply($wxid='')
	{
		$userBind = $this->isBind($wxid,2);
		if($userBind['bindtype']=='1')
		{
			
			$Apply = $this->DB_select_all("part_apply","`comid`='".$userBind['uid']."' AND `status`='1' ORDER BY `ctime` DESC limit 5");
			
			if(is_array($Apply) && !empty($Apply))
			{
				foreach($Apply as $key=>$value)
				{
					$uid[] = $value['uid'];
					$jobid[] = $value['jobid'];
				}
				
				$partJob = $this->DB_select_all("partjob","`uid`='".$userBind['uid']."' AND `id` IN (".@implode(',',$jobid).")","`id`,`name`");
				if(is_array($partJob)){
					
					foreach($partJob as $key=>$value)
					{
						$jobname[$value['id']] = $value['name'];
					}
				}
			
				$userList = $this->DB_select_all("resume","`uid` IN (".@implode(',',$uid).")","`uid`,`name`,`edu`,`exp`");
				if(is_array($userList)){
					
					foreach($userList as $key=>$value)
					{
						$resumeList[$value['uid']] = $value;
					}
				}
				include(PLUS_PATH."/user.cache.php");
				foreach($Apply as $key=>$value)
				{
					$Info['title'] = iconv('gbk','utf-8',"��".$resumeList[$value['uid']]['name']."��".$userclass_name[$resumeList[$value['uid']]['edu']]."/".$userclass_name[$resumeList[$value['uid']]['exp']]."��������\n������ְ��".$jobname[$value['jobid']]."\n����ʱ�䣺".date('Y-m-d H:i',$value['ctime']));
					$Info['pic']   = $this->config['sy_weburl'].'/data/upload/wx/jt.jpg';
					$Info['url']   = $this->config['sy_weburl']."/wap/member/index.php?c=partapply";
					$List[]        = $Info;
				}
				$Msg['title'] = iconv('gbk','utf-8','��ְ����');
				$Msg['pic'] = $this->config['sy_weburl'].'/'.$this->config['sy_wx_logo'];
				$Msg['url'] = $this->config['sy_weburl']."/wap/member/index.php?c=partapply";
				$Return['centerStr'] = $this->Handle($List,$Msg);
				$Return['MsgType']   = 'news';

			}else{

				$Return['centerStr'] ='<Content><![CDATA['.iconv('gbk','utf-8','������ޱ���').']]></Content>';
				$Return['MsgType']   = 'text';
			}
			
			return $Return;
		}else{
			$Return['MsgType']   = 'text';
			$Return['centerStr'] = $userBind['cenetrTpl'];
			return $Return;
		}
	}

	function lookResume($wxid='')
	{
		$userBind = $this->isBind($wxid);
		if($userBind['bindtype']=='1')
		{
			$Aud = $this->DB_select_all("look_resume","`uid`='".$userBind['uid']."'  ORDER BY `datetime`  DESC limit 5");
			if(is_array($Aud) && !empty($Aud))
			{
				
				foreach($Aud as $key=>$value)
				{
					$comid[] = $value['com_id'];
				}
				$comids =pylode(',',$comid);
		
				if($comids){
					$comList = $this->DB_select_all('company','`uid` IN ('.$comids.')','`uid`,`name`');
					if(is_array($comList)){
						foreach($comList as $key=>$value)
						{
							$comname[$value['uid']] = $value['name'];
						}
					}
					foreach($Aud as $key=>$value)
					{
						$Info['title'] = iconv('gbk','utf-8', "�鿴��ҵ����".$comname[$value['com_id']]."��\n�鿴ʱ�䣺".date('Y-m-d H:i:s',$value['datetime']));
						$Info['pic']   = $this->config['sy_weburl'].'/data/upload/wx/jt.jpg';
						$Info['url']   = $this->config['sy_weburl']."/wap/member/index.php?c=look";
						$List[]        = $Info;
					}
					$Msg['title'] = iconv('gbk','utf-8','����鿴�ҵļ���');
					$Msg['pic'] = $this->config['sy_weburl'].'/'.$this->config['sy_wx_logo'];
					$Msg['url'] = $this->config['sy_weburl']."/wap/member/index.php?c=look";
					$Return['centerStr'] = $this->Handle($List,$Msg);
					$Return['MsgType']   = 'news';
				}else{
					$Return['centerStr']='<Content><![CDATA['.iconv('gbk','utf-8','�Ѿ��ܾ�û��˾�鿴���ļ����ˣ�').']]></Content>';
					$Return['MsgType']   = 'text';
				}
			}else{

				$Return['centerStr']='<Content><![CDATA['.iconv('gbk','utf-8','�Ѿ��ܾ�û��˾�鿴���ļ����ˣ�').']]></Content>';
				$Return['MsgType']   = 'text';
			}
			return $Return;

		}else{

			
			$Return['MsgType']   = 'text';
			$Return['centerStr'] = $userBind['cenetrTpl'];
			return $Return;
		}
	}
	
	function refResume($wxid='')
	{
		$userBind = $this->isBind($wxid);
		if($userBind['bindtype']=='1')
		{
			$Resume = $this->DB_select_num("resume_expect","`uid`='".$userBind['uid']."'");
			
			if($Resume>0)
			{
				$this->DB_update_all("resume_expect","`lastupdate`='".time()."'","`uid` = '".$userBind['uid']."'");
				$Return['centerStr']="<Content><![CDATA[".iconv('gbk','utf-8',"����ˢ�³ɹ�\nˢ��ʱ��").":".date('Y-m-d H:i:s')."]]></Content>";

			}else{

				$Return['centerStr']='<Content><![CDATA['.iconv('gbk','utf-8','�����������ļ�����').']]></Content>';
				
			}
		}else{

			$Return['centerStr'] = $userBind['cenetrTpl'];
			
		}
		$Return['MsgType']   = 'text';
		return $Return;
	}

	
	function refJob($wxid='')
	{
		$userBind = $this->isBind($wxid,2);
		if($userBind['bindtype']=='1')
		{
			
			$jobNum = $this->DB_select_num('company_job',"`uid`='".$userBind['uid']."' AND `state`='1' AND `status`<>1");
			if($jobNum>0){
				
				$membeStatis = $this->DB_select_once('company_statis',"`uid`='".$userBind['uid']."'");
				$refIntegral = $this->config['integral_jobefresh']*$jobNum;
				
				if($membeStatis['rating_type']=='2'){
					if($membeStatis['vip_etime']>=time()){
						
						$this->DB_update_all('company_job',"`lastupdate`='".time()."'","`uid`='".$userBind['uid']."' AND `state`='1' AND `status`<>1");
						$msg = 'ְλˢ����ɣ����ι�ˢ��'.$jobNum."��ְλ��";
					}else{

						$useIntegral = 1;
					}
				}else{
					
					if(($membeStatis['vip_etime']<1 || $membeStatis['vip_etime']>=time()) && $membeStatis['breakjob_num']>=$jobNum){

						$this->DB_update_all('company_job',"`lastupdate`='".time()."'","`uid`='".$userBind['uid']."' AND `state`='1' AND `status`<>1");

						
						$this->DB_update_all('company_statis',"`breakjob_num`='".($membeStatis['breakjob_num']-$jobNum)."'","`uid`='".$userBind['uid']."'");

						$msg = 'ְλˢ����ɣ����ι�ˢ��'.$jobNum."��ְλ��";
					}else{
						$useIntegral = 1;
					}
				}
				if($useIntegral=='1'){
					
					if($this->config['com_integral_online']=='1'){
							
						if($this->config['integral_jobefresh_type']=='2'){
							
							
							if($membeStatis['integral']>=$refIntegral){
								
								$this->DB_update_all('company_job',"`lastupdate`='".time()."'","`uid`='".$userBind['uid']."' AND `state`='1' AND `status`<>1");
								
								$this->DB_update_all('company_statis',"`integral`='".($membeStatis['integral']-$refIntegral)."'","`uid`='".$userBind['uid']."'");
							}else{

								$msg = "����ˢ�¹���".$refIntegral."".$this->config['integral_pricename']."�����ȳ�ֵ��";
							}
						}else{
							$msg = "Ȩ�޲��㣬������Ա�����ܸ������";
						}
						
					}else{
						$msg = "Ȩ�޲��㣬������Ա�����ܸ������";
					}
				}
			}else{
				$msg = '��û��������Ƹ��ְλ��';
			}
			$Return['centerStr']='<Content><![CDATA['.iconv('gbk','utf-8',$msg).']]></Content>';
		}else{

			$Return['centerStr'] = $userBind['cenetrTpl'];
			
		}
		$Return['MsgType']   = 'text';
		return $Return;
	}

	
	function searchJob($keyword)
	{

		$keyword = trim($keyword);
		
		include(PLUS_PATH."/city.cache.php");
		if($keyword)
		{
			$keywords = @explode(' ',$keyword);
		
			if(is_array($keywords))
			{
				foreach($keywords as $key=>$value)
				{
					$iscity = 0;
					if($value!='')
					{
						foreach($city_name as $k=>$v)
						{
							if(strpos($v,iconv('utf-8','gbk',trim($value)))!==false)
							{
								$CityId[] = $k;
								$iscity = 1;
							}
						}
						if($iscity==0)
						{
							$searchJob[] = "(`name` LIKE '%".iconv('utf-8','gbk',trim($value))."%') OR (`com_name` LIKE '%".iconv('utf-8','gbk',trim($value))."%')";
						}
					}
				}
				
				$searchWhere = "`state`='1' AND `sdate`<='".time()."' AND `edate`>= '".time()."' AND `status`<>'1' AND `r_status`<>'2'";
				if(!empty($searchJob))
				{
					$searchWhere .=  " AND (".implode(' OR ',$searchJob).")";
				}
				if(!empty($CityId))
				{
					$City_id = pylode(',',$CityId);
					$searchWhere .= " AND (`provinceid` IN (".$City_id.") OR `cityid` IN (".$City_id.") OR `three_cityid` IN (".$City_id."))";
				}
				$jobList = $this->DB_select_all("company_job",$searchWhere." order by `lastupdate` desc limit 5","`id`,`name`,`com_name`");
			}
		}	
	
		if(is_array($jobList) && !empty($jobList))
		{

			foreach($jobList as $key=>$value)
			{
				$Info['title'] = iconv('gbk','utf-8',"��".$value['name']."��\n".$value['com_name']);
				$Info['pic'] = $this->config['sy_weburl'].'/data/upload/wx/jt.jpg';
				$Info['url'] = Url("wap",array('c'=>'job','a'=>'view','id'=>$value['id']));
				$List[]     = $Info;
			}
			$Msg['title'] = iconv('gbk','utf-8','�롾').$keyword.iconv('gbk','utf-8','����ص�ְλ');
			$Msg['pic'] = $this->config['sy_weburl'].'/'.$this->config['sy_wx_logo'];
			$Msg['url'] = Url('wap',array('c'=>'job','keyword'=>urlencode(iconv('utf-8','gbk',$keyword))));
			
			$Return['centerStr'] = $this->Handle($List,$Msg);
			$Return['MsgType']   = 'news';
		}else{

			$Return['centerStr'] = '<Content><![CDATA['.iconv('gbk','utf-8','δ�ҵ����ʵ�ְλ��').']]></Content>';
			$Return['MsgType']   = 'text';
		}
		
		return $Return;
		
	}
	
	
	function searchKeyword($keyword)
	{
		$keyword = iconv('utf-8','gbk',trim($keyword));
		if($keyword)
		{													
			$searchWhere = "(`keyword` LIKE '%".trim($keyword)."%')";																							
			$keywordList = $this->DB_select_once("wxzdkeyword",$searchWhere,"`id`,`keyword`,`content`");			
		}	
		if(!empty($keywordList))
		{		
			$Return['centerStr'] = '<Content><![CDATA['.iconv('gbk','utf-8',$keywordList['content']).']]></Content>';
			$Return['MsgType']   = 'text';
		}		
		return $Return;				
	}
	
	
	function bindUser($wxid='')
	{
	
		$bindType = $this->isBind($wxid);
		$Return['MsgType']   = 'text';
		$Return['centerStr'] = $bindType['cenetrTpl'];
		return $Return;
		
	}
	function getWxUser($wxid){
		 global $config;
		
		
		$Token = getToken($config);
	
		$Url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$Token.'&openid='.$wxid.'&lang=zh_CN';
		$CurlReturn  = CurlPost($Url);
		$UserInfo    = json_decode($CurlReturn,true);

		return $UserInfo;
	
	}
	
	function isBind($wxid='',$usertype=1)
	{	
	
		if($wxid)
		{
			
			$UserInfo    = $this->getWxUser($wxid);
			$wxid        = $wxid;
			$unionid	 = $UserInfo['unionid'];
			$User = $this->DB_select_once("member","`wxid`='".$wxid."' OR (`unionid`<>'' AND `unionid`='".$unionid."' )","`uid`,`username`,`usertype`,`wxid`,`unionid`");
			if($User['unionid']!='' && $User['wxid']!=$wxid)
			{
				$User = $this->DB_update_all("member","`wxid`='".$wxid."'","`uid`='".$User['uid']."'");
			}
		}
		if($User['uid']>0)
		{
			
			$urlLogin = $this->config['sy_wapdomain']."/index.php?c=login&bind=1&wxid=".$wxid."&unionid=".$unionid;
			if($User['usertype']!=$usertype)
			{
				switch($usertype){
					case '1':
						$User['cenetrTpl'] = "<Content><![CDATA[".iconv('gbk','utf-8',"����".$this->config['sy_webname']."�ʺţ�".$User['username']."Ϊ��ҵ�ʺţ����¼���ĸ����ʺŽ��а󶨣� \n\n\n ��Ҳ����<a href=\"".$urlLogin."\">�������</a>���а������ʺ�")."]]></Content>";
					break;
					case '2':
						$User['cenetrTpl'] = "<Content><![CDATA[".iconv('gbk','utf-8',"����".$this->config['sy_webname']."�ʺţ�".$User['username']."Ϊ�����ʺţ����¼������ҵ�ʺŽ��а󶨣� \n\n\n ������<a href=\"".$urlLogin."\">�������</a>���н�������ʺ�")."]]></Content>";
					break;

				}
				
			}else{
				$User['bindtype'] = '1';
				$User['cenetrTpl'] = "<Content><![CDATA[".iconv('gbk','utf-8',"����".$this->config['sy_webname']."�ʺţ�".$User['username']."�ѳɹ��󶨣� \n\n\n ��Ҳ����<a href=\"".$urlLogin."\">�������</a>���н���������ʺ�")."]]></Content>";
			}
			
		}else{

			
			$urlLogin = $this->config['sy_wapdomain']."/index.php?c=login&wxid=".$wxid."&unionid=".$unionid;
			$User['cenetrTpl'] = '<Content><![CDATA['.iconv('gbk','utf-8','����û�а��ʺţ�<a href="'.$urlLogin.'">�������</a>���а�!').']]></Content>';
		}

		return $User;
	}
	
	function recJob()
	{

		$JobList = $this->DB_select_all("company_job","`sdate`<='".time()."' AND `edate`>= '".time()."' AND `status`<>1 AND `r_status`<>2 AND `rec_time`>'".time()."' order by `lastupdate` desc limit 5","`id`,`name`,`com_name`,`lastupdate`");
		
		if(is_array($JobList) && !empty($JobList))
		{
			foreach($JobList as $key=>$value)
			{
				$Info['title'] = iconv('gbk','utf-8',"��".$value['name']."��\n".$value['com_name']);
				$Info['pic'] = $this->config['sy_weburl'].'/data/upload/wx/jt.jpg';
				$Info['url'] = Url("wap",array('c'=>'job','a'=>'view','id'=>$value['id']));
				$List[]        = $Info;
			}
			$Msg['title'] = iconv('gbk','utf-8','�Ƽ�ְλ');
			$Msg['pic'] = $this->config['sy_weburl'].'/'.$this->config['sy_wx_logo'];
			$Msg['url'] = Url("wap",array('c'=>'job'));
			$Return['centerStr'] = $this->Handle($List,$Msg);
			$Return['MsgType']   = 'news';
			
		}else{
			$Return['centerStr'] ='<Content><![CDATA['.iconv('gbk','utf-8','û�к��ʵ�ְλ��').']]></Content>';
			$Return['MsgType']   = 'text';
		}
		
		return $Return;
	}
	
	
	function Handle($List,$Msg)
	{

		$articleTpl = '<Content><![CDATA['.$Msg['title'].']]></Content>';

		$articleTpl .= '<ArticleCount>'.(count($List)+1).'</ArticleCount><Articles>';

		$centerTpl = "<item>
		<Title><![CDATA[%s]]></Title>  
		<Description><![CDATA[%s]]></Description>
		<PicUrl><![CDATA[%s]]></PicUrl>
		<Url><![CDATA[%s]]></Url>
		</item>";

		$articleTpl.=sprintf($centerTpl,$Msg['title'],'',$Msg['pic'],$Msg['url']); 

		foreach($List as $value)
		{	
			$articleTpl.=sprintf($centerTpl,$value['title'],'',$value['pic'],$value['url']);
		}
		$articleTpl .= '</Articles>';
		return $articleTpl;
	}
	
	function valid($echoStr,$signature,$timestamp,$nonce)
    {
        if($this->checkSignature($signature,$timestamp,$nonce)){
        	echo $echoStr;	
        	exit;
        }
    }
	
	
	function checkSignature($signature, $timestamp,$nonce)
	{   		
		$token = $this->config['wx_token'];
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature  && $token!=''){
			return true;
		}else{
			return false;
		}
	}
	
	function ArrayToString($obj,$withKey=true,$two=false)
	{
		if(empty($obj))	return array();
		$objType=gettype($obj);
		if ($objType=='array') {
			$objstring = "array(";
			foreach ($obj as $objkey=>$objv) {
				if($withKey)$objstring .="\"$objkey\"=>";
				$vtype =gettype($objv) ;
				if ($vtype=='integer') {
				  $objstring .="$objv,";
				}else if ($vtype=='double'){
				  $objstring .="$objv,";
				}else if ($vtype=='string'){
				  $objv= str_replace('"',"\\\"",$objv);
				  $objstring .="\"".$objv."\",";
				}else if ($vtype=='array'){
				  $objstring .="".$this->ArrayToString($objv,false).",";
				}else if ($vtype=='object'){
				  $objstring .="".$this->ArrayToString($objv,false).",";
				}else {
				  $objstring .="\"".$objv."\",";
				}
			}
			$objstring = substr($objstring,0,-1)."";
			return $objstring.")\n";
		}
	}
	function markLog($wxid,$wxuser,$content,$reply){

		$this->DB_insert_once("wxlog","`wxid`='".$wxid."',`wxuser`='".$wxuser."',`content`='".$content."',`reply`='".$reply."',`time`='".time()."'");
	}

	
	function sendWxTemplate($wxid,$tempid,$url,$data){
       global $config;
		
	  
		$Token = getToken($config);
		
		
		$wxUrl = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$Token;
		
		
		$templateDate = array("touser"=>$wxid,
							  "template_id"=>$tempid,
							  "url"=>$url,
							  "topcolor"=>"#FF0000",
							  "data"=>$data
						);
		
		$CurlReturn  = CurlPost($wxUrl,json_encode($templateDate));


		$UserInfo    = json_decode($CurlReturn);
		
		
    }
	
	function sendWxJob($uid,$jobid){
       
		global $config;
		if($config['wx_xxtz']!='1'  || !$config['wx_mbsqzw'])
		{
			return true;
		}
		if($uid && $jobid)
		{
			$Tempid = $config['wx_mbsqzw'];
			
			if(is_array($jobid))
			{
				$Jids = pylode(",",$jobid);

			}else{
				
				$Jids = pylode(",",@explode(',',$jobid));

			}
			
			
			$comList = $this->DB_select_all("company_job","`id` IN (".$Jids.")","`uid`,`com_name`,`name`");
			
			if(is_array($comList) && !empty($comList))
			{

				foreach($comList as $value){
				
					$Mid[]					= $value['uid'];
					$Comname[$value['uid']] = $value['com_name'];
					$Jobname[$value['uid']][] = $value['name'];
				}

				$usertList = $this->DB_select_all("member","`uid` IN (".@implode(',',$Mid).") ","`uid`,`wxid`");
				
				if(is_array($usertList) && !empty($usertList))
				{

					$Expect = $this->DB_select_once("resume_expect","`uid` = '".(int)$uid."' AND `defaults`='1'");
					include PLUS_PATH."/city.cache.php";
					include PLUS_PATH."/user.cache.php";
					foreach($usertList as $value){
						
						
						$First		= iconv("gbk","utf-8",$Comname[$value['uid']].'�����ã���������ְλ��'.@implode(',',$Jobname[$value['uid']]).' �յ�һ���¼���!');
						$Iname		= iconv("gbk","utf-8",$Expect['uname']);
						$Edu		= iconv("gbk","utf-8",$userclass_name[$Expect['edu']]);
						$Exp		= iconv("gbk","utf-8",$userclass_name[$Expect['exp']]);
						$City		= iconv("gbk","utf-8",$city_name[$Expect['provinceid']]." ".$city_name[$Expect['cityid']]." ".$city_name[$Expect['three_cityid']]);
						if($Expect['maxsalary']>0){
							$Sarlary	= iconv("gbk","utf-8",$Expect['minsalary'].'-'.$Expect['maxsalary']);
						}elseif($Expect['minsalary']>0){
							$Sarlary	= iconv("gbk","utf-8",$Expect['minsalary'].'����');
						}else{
							$Sarlary	= iconv("gbk","utf-8",'����');
						}
						$Remark		= iconv("gbk","utf-8",'�������¼ '.$config['sy_webname'].' ��ʱ����!');

						$TempDate['first']	= array('value'=>$First,'color'=>'');
						$TempDate['keyword1']	= array('value'=>$Iname,'color'=>'');
						$TempDate['keyword2']	= array('value'=>$Edu,'color'=>'');
						$TempDate['keyword3']	= array('value'=>$Exp,'color'=>'');
						$TempDate['keyword4']	= array('value'=>$City,'color'=>'');
						$TempDate['keyword5']	= array('value'=>$Sarlary,'color'=>'');
						$TempDate['remark']	= array('value'=>$Remark,'color'=>'');
						$Url = Url('wap',array("c"=>"login"));
					
						
						$this->sendWxTemplate($value['wxid'],$Tempid,$Url,$TempDate);
						
					}
				}
			}
		}
    }
	
	function sendWxresume($data){
       
	   global $config;
		if($config['wx_xxtz']!='1' || !$config['wx_mbyqms'])
		{
			return true;
		}
		if($data['uid'])
		{
			$Tempid = $config['wx_mbyqms'];
			
			
			$userInfo = $this->DB_select_once("member","`uid` = '".$data['uid']."'","username,wxid");
			
			if(is_array($userInfo))
			{	
				
				$First		= iconv("gbk","utf-8",$userInfo['username'].'����ϲ��!���յ���˾��������������');
				$Job		= iconv("gbk","utf-8",$data['jobname']);
				$Company	= iconv("gbk","utf-8",$data['fname']);
				$Time		= iconv("gbk","utf-8",$data['intertime']);
				$Address	= iconv("gbk","utf-8",$data['address']);
				$Contact	= iconv("gbk","utf-8",$data['linkman']);
				$Tel		= iconv("gbk","utf-8",$data['linktel']);
				$Remark		= iconv("gbk","utf-8",$data['content'].' �������¼ '.$config['sy_webname'].' ��ʱ����!');

				$TempDate['first']	= array('value'=>$First,'color'=>'');
				$TempDate['job']	= array('value'=>$Job,'color'=>'');
				$TempDate['company']	= array('value'=>$Company,'color'=>'');
				$TempDate['time']	= array('value'=>$Time,'color'=>'');
				$TempDate['address']	= array('value'=>$Address,'color'=>'');
				$TempDate['contact']	= array('value'=>$Contact,'color'=>'');
				$TempDate['tel']	= array('value'=>$Tel,'color'=>'');
				$TempDate['remark']	= array('value'=>$Remark,'color'=>'');
				$Url = Url('wap',array('c'=>'login'));
				$this->sendWxTemplate($userInfo['wxid'],$Tempid,$Url,$TempDate);
			}
		}
    }

	
	function sendWxPay($data){
      
	   global $config;
		if($config['wx_xxtz']!='1' || !$config['wx_mbcztx'])
		{
			return true;
		}
		if($data['wxid'])
		{
			$Tempid = $config['wx_mbcztx'];
			
			
			$First		= iconv("gbk","utf-8",$data['first']);
			$UserName	= iconv("gbk","utf-8",$data['username']);
			$Order		= $data['order'];
			$Price		= $data['price'];
			$Time		= $data['time'];
			$PayType	= iconv("gbk","utf-8",$data['paytype']);
			$Info		= iconv("gbk","utf-8",$data['info']);
			$Remark		= iconv("gbk","utf-8",'��л����֧��,�������¼ '.$config['sy_webname'].' !');

			$TempDate['first']	= array('value'=>$First,'color'=>'');
			$TempDate['keyword1']	= array('value'=>$UserName,'color'=>'');
			$TempDate['keyword2']	= array('value'=>$Price,'color'=>'');
			$TempDate['keyword3']	= array('value'=>$Info,'color'=>'');
			$TempDate['keyword4']	= array('value'=>$PayType,'color'=>'');
			$TempDate['keyword5']	= array('value'=>$Time,'color'=>'');
			$TempDate['remark']	= array('value'=>$Remark,'color'=>'');
			$Url = Url('wap',array('c'=>'login'));

			$this->sendWxTemplate($data['wxid'],$Tempid,$Url,$TempDate);
		}
    }

	
	function sendWxJobStatus($data){
        
	    global $config;
		if($config['wx_xxtz']!='1' || !$config['wx_mbzwsh'])
		{
			return true;
		}
	
		if($data['jobid'] && $data['state']>0)
		{
			$Tempid = $config['wx_mbzwsh'];
			
			
			$User = $this->DB_select_all('company_job',"`id` IN (".pylode(',',$data['jobid']).")","`uid`,`com_name`,`name`");
			
			if(is_array($User)){
				foreach($User as $key=>$value){
					
					$JobName[$value['uid']][] = $value['name'];
					$Uid[] = $value['uid'];
					$ComName[$value['uid']] = $value['com_name'];
					
				}
				
				$Uid = array_unique($Uid);
				switch($data['state']){
					case '1':$Status='���ͨ��';
					break;
					case '3':$Status='��˲�ͨ��';
					break;
				}
				$Member = $this->DB_select_all('member',"`uid` IN (".pylode(',',$Uid).")","`wxid`,`uid`");
				
				if(is_array($Member)){
					foreach($Member as $key=>$value){
						
						$data['first'] = '�𾴵� '.$ComName[$value['uid']].',����!��������ְλ��һ���µ�״̬֪ͨ��';
						
						$First		= iconv("gbk","utf-8",$data['first']);
						$JobName	= iconv("gbk","utf-8",@implode(',',$JobName[$value['uid']]));
						$Status		= iconv("gbk","utf-8",$Status);
						$Body		= iconv("gbk","utf-8",$data['statusbody']);

						$Remark		= iconv("gbk","utf-8",'�������¼ '.$config['sy_webname'].' !');

						$TempDate['first']	= array('value'=>$First,'color'=>'');
						$TempDate['keyword1']	= array('value'=>$JobName,'color'=>'');
						$TempDate['keyword2']	= array('value'=>$Status,'color'=>'');
						$TempDate['keyword3']	= array('value'=>$Body,'color'=>'');
						$TempDate['remark']	= array('value'=>$Remark,'color'=>'');
						$Url = Url('wap',array('c'=>'login'));

						$this->sendWxTemplate($value['wxid'],$Tempid,$Url,$TempDate);
					}
				}
			}
		}
    }
	
	function sendWxPart($data){
      
	   global $config;
		if($config['wx_xxtz']!='1' || !$config['wx_mbjzbm'])
		{
			return true;
		}
		if($data['wxid'])
		{
			$Tempid = $config['wx_mbjzbm'];
			
			$First		= iconv("gbk","utf-8",$data['first']);
			$UserName	= iconv("gbk","utf-8",$data['username']);
			$Order		= $data['order'];
			$Price		= $data['price'];
			$Info		= iconv("gbk","utf-8",$data['info']);
			$Remark		= iconv("gbk","utf-8",'��л����֧��,�������¼ '.$config['sy_webname'].' !');

			$TempDate['first']	= array('value'=>$First,'color'=>'');
			$TempDate['keyword1']	= array('value'=>$UserName,'color'=>'');
			$TempDate['keyword2']	= array('value'=>$Order,'color'=>'');
			$TempDate['keyword3']	= array('value'=>$Price,'color'=>'');
			$TempDate['keyword4']	= array('value'=>$Info,'color'=>'');
			$TempDate['remark']	= array('value'=>$Remark,'color'=>'');
			$Url = Url('wap',array('c'=>'login'));

			$this->sendWxTemplate($data['wxid'],$Tempid,$Url,$TempDate);
		}
    }
	function applyWxQrcode($wxloginid=''){
		global $config;
		if($config['wx_author']=='1'){
			if($wxloginid){
			
				
				$wxqrcode = $this->DB_select_once('wxqrcode',"`wxloginid`='".$wxloginid."' AND `status`='0'");
			}
			
			if($wxqrcode['time']>=(time()-86000)){
				
				$ticket =  "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($wxqrcode['ticket']);

			}else{

				$randStr = time().rand(1000,9999);
				
				$Url  = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.getToken();
				$Data['expire_seconds']     = 86400;
				$Data['action_name']        = 'QR_STR_SCENE';
				$Data['action_info']['scene']['scene_str'] = $randStr;
				
				$CurlReturn  = CurlPost($Url,json_encode($Data));
				
				$Return       = json_decode($CurlReturn,true);
				
				
				if($Return['ticket']){
					$this->DB_insert_once("wxqrcode","`wxloginid`='".$randStr."',`ticket`='".$Return['ticket']."',`time`='".time()."',`status`='0'");
					
					setcookie("wxloginid",$randStr,time()+86000);

					$ticket = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($Return['ticket']);
				}

			}
		}
		return $ticket;
	
   }
	function isWxlogin($wxid,$wxloginid){
      
	    global $config;
		$userBind = $this->isBind($wxid);
		if($userBind['uid']>0){
			
			$this->DB_update_all("wxqrcode","`status`='1',`wxid`='".$wxid."',`unionid`='".$userBind['unionid']."'","`wxloginid`='".$wxloginid."'");
			return true;
		}else{
			
			return false;
		}
    }

	function getWxLoginStatus($wxloginid){
		
		if($wxloginid){
		
			$status = $this->DB_select_once("wxqrcode","`wxloginid`='".$wxloginid."' AND `status`='1'");
		
			if($status['wxid'] || $status['unionid']){
				$member = $this->DB_select_once("member","`wxid`='".$status['wxid']."' OR (`unionid`<>'' AND `unionid`='".$status['unionid']."' ) ");
			}
		}
		return $member;
	
	}
}
?>