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
class resumeout_controller extends user{
    function index_action(){
        $rows=$this->obj->DB_select_all("resume_expect","`uid`='".$this->uid."'","id,name");
        $urlarr=array("c"=>"resumeout","page"=>"{{page}}");
        $pageurl=Url('member',$urlarr);
        $out=$this->get_page("resumeout","`uid`='".$this->uid."' order by id desc",$pageurl,"10");
        $this->public_action();
        $this->yunset('rows',$rows);
        $this->yunset('out',$out);
        $this->user_tpl('resumeout');
    }
    
    function send_action() {
        $_POST=$this->post_trim($_POST);
        if($_POST['submit']){
            if($_POST['resume']==''){
                $this->ACT_layer_msg('��ѡ�����',8);
            }
            $email=$_POST['email'];
            if($email==''){
                $this->ACT_layer_msg('����������',8);
            }elseif ($this->CheckRegEmail($email)==false){
                $this->ACT_layer_msg('�����ʽ����',8);
            }
            if($_POST['comname']==''){
                $this->ACT_layer_msg('��������ҵ����',8);
            }
            if ($_POST['jobname']==''){
                $this->ACT_layer_msg('������ְλ����',8);
            }
            if($this->config['sy_email_set']!="1"){
                $this->ACT_layer_msg('��վ�ʼ�������������!',8);
            }
            if($_COOKIE["sendresume"]==$_POST['resume']){
                $this->ACT_layer_msg('�벻ҪƵ�������ʼ���ͬһ�������ͼ��Ϊ�����ӣ�',8);
            }
            $resume=$this->obj->DB_select_once("resume","`uid`='".$this->uid."'","name");
            $data=array('uid'=>$this->uid,'comname'=>$_POST['comname'],'jobname'=>$_POST['jobname'],'recipient'=>$_POST['comname'],'email'=>$email,'datetime'=>time(),'resume'=>$_POST['resumename']);
            
            $contents=file_get_contents($this->config['sy_weburl']."/resume/index.php?c=sendresume&id=".$_POST['resume']);
			$emailData['to'] = $email;
			$emailData['subject'] = "�ҿ�����˾������".$_POST['jobname']."�������Լ�һ�ݼ�����";
			$emailData['content'] = $contents;
			$emailData['uid'] = '';
			$emailData['name'] = $data['recipient'];
			$emailData['cuid'] = $this->uid;
			$emailData['cname'] = $resume['name'];
			$sendid = $this->sendemail($emailData);

            if($sendid){
                $this->obj->insert_into('resumeout',$data);
                $this->ACT_layer_msg('���ͳɹ�',9,'index.php?c=resumeout');
            }else{
                $this->ACT_layer_msg('�ʼ����ʹ��� ԭ��1���䲻���� 2��վ�ر��ʼ�����',8);
            }
        }
    }
    function del_action(){
            if($_GET['id']){
            $nid=$this->obj->DB_delete_all("resumeout","`id`='".(int)$_GET['id']."' AND `uid`='".$this->uid."'"," ");
            $this->obj->member_log("ɾ�������ⷢ��¼");
            if($nid){
	            $this->layer_msg('ɾ���ɹ���',9);
            }else{
	            $this->layer_msg('ɾ��ʧ�ܣ�',8);
            }
        }
    }
}
?>