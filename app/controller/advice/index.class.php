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
class index_controller extends common{
	function index_action(){
		$this->seo('advice');
		$this->yun_tpl(array('index'));
	}
	function savequestion_action(){
		session_start();
		if($_POST['infotype']==''){
			$this->ACT_layer_msg("��ѡ���������!",8);
		}elseif($_POST['username']==''){
			$this->ACT_layer_msg("����д��ϵ������!",8);
		}elseif($_POST['telphone']==''){
			$this->ACT_layer_msg("����д��ϵ�ֻ�!",8);
		}elseif($_POST['content']==''){
			$this->ACT_layer_msg("����д��������!",8);
		}elseif($_POST['authcode']==''){
			$this->ACT_layer_msg("����д��֤��!",8);
		}elseif(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode']){
			unset($_SESSION['authcode']);
			$this->ACT_layer_msg("��֤�����!",8);
		}else{
			$_POST['ctime']=time();
			$data=array(
					'username'=>$_POST['username'],
					'ctime'=>$_POST['ctime'],
					'infotype'=>$_POST['infotype'],
					'content'=>$_POST['content'],
					'mobile'=>$_POST['telphone']
			);
			$nid=$this->obj->insert_into("advice_question",$data);
			if($nid){
				$this->ACT_layer_msg("�ύ�ɹ�,��л��ķ�����",9,"index.php?m=advice");
			}else{
				$this->ACT_layer_msg("�ύʧ�ܣ���������д��",8,"index.php?m=advice");
			}
			
		} 
	}
}
?>