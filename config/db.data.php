<?php
/*
* $Author ��PHPYUN�����Ŷ�
*
* ����: http://www.phpyun.com
*
* ��Ȩ���� 2009-2017 ��Ǩ�γ���Ϣ�������޹�˾������������Ȩ����
*
* ���������δ����Ȩǰ���£�����������ҵ��Ӫ�����ο����Լ��κ���ʽ���ٴη�����
 * ע:���ļ�Ϊϵͳ�ļ����벻Ҫ�޸�
 */
$arr_data = array (
	'pay' => array ('alipay'=>'֧����','wxpay'=>'΢��֧��','tenpay'=>'�Ƹ�ͨ','bank'=>'����ת��','alipaydual'=>'֧����˫�ӿ�','alipayescow'=>'��������','adminpay'=>'����Ա��ֵ','balance'=>'���֧��','admincut'=>'����Ա�ۿ�','wapalipay'=>'֧�����ֻ�֧��'),
	'source' => array ('1'=>'��ҳ','2'=>'�ֻ�','3'=>'App','4'=>'΢��','6'=>'�ɼ�','7'=>'Excel����','8'=>'QQ��¼','9'=>'΢��ɨһɨ','10'=>'΢��','11'=>'PC����Ͷ��','12'=>'WAP����Ͷ��'),	
	'sex' => array ('3'=>'����','1'=>'��','2'=>'Ů'),	
	'paystate' => array ('<font color=red>֧��ʧ��</font>','<font color=green>�ȴ�����</font>','<font color=blsue>֧���ɹ�</font>','<font color=#c30ad9>�ȴ�ȷ��</font>'),
	'cache' => array ('1'=>'����','2'=>'��ҵ','3'=>'ְλ','4'=>'���˻�Ա����','5'=>'��ҵ��Ա����','6'=>'����','7'=>'��վ����','8'=>'SEO����','9'=>'��վ','10'=>'�ؼ���','11'=>'��������','12'=>'���ŷ���','13'=>'��ҳ�����','14'=>'���','15'=>'��ְ����','16'=>'��Ʒ����','17'=>'���ݿ�','18'=>'�ʼ�������'),
	'faceurl' => '/config/face/',
	'imface' => array ('CNM'=>'shenshou_org.gif','SM'=>'horse2_org.gif','FU'=>'fuyun_org.gif','GL'=>'geili_org.gif','WG'=>'wg_org.gif','VW'=>'vw_org.gif','XM'=>'panda_org.gif','TZ'=>'rabbit_org.gif','OTM'=>'otm_org.gif','JU'=>'j_org.gif','HF'=>'hufen_org.gif','LW'=>'liwu_org.gif','HH'=>'smilea_org.gif','XX'=>'tootha_org.gif','HH2'=>'laugh.gif','TZA'=>'tza_org.gif','KL'=>'kl_org.gif','WBS'=>'kbsa_org.gif','CJ'=>'cj_org.gif','HX'=>'shamea_org.gif','ZY'=>'zy_org.gif','BZ'=>'bz_org.gif','BS2'=>'bs2_org.gif','LOVE'=>'lovea_org.gif','LEI'=>'sada_org.gif','TX'=>'heia_org.gif','QQ'=>'qq_org.gif','SB'=>'sb_org.gif','TKX'=>'mb_org.gif','LD'=>'ldln_org.gif','YHH'=>'yhh_org.gif','ZHH'=>'zhh_org.gif','XU'=>'x_org.gif','cry'=>'cry.gif','WQ'=>'wq_org.gif','T'=>'t_org.gif','DHQ'=>'k_org.gif','BBA'=>'bba_org.gif','N'=>'angrya_org.gif','YW'=>'yw_org.gif','CZ'=>'cza_org.gif','88'=>'88_org.gif','SI'=>'sk_org.gif','HAN'=>'sweata_org.gif','sl'=>'sleepya_org.gif','SJ'=>'sleepa_org.gif','P'=>'money_org.gif','SW'=>'sw_org.gif','K'=>'cool_org.gif','HXA'=>'hsa_org.gif','H'=>'hatea_org.gif','GZ'=>'gza_org.gif','YD'=>'dizzya_org.gif','BS'=>'bs_org.gif','ZK'=>'crazya_org.gif','HX2'=>'h_org.gif','YX'=>'yx_org.gif','NM'=>'nm_org.gif','XIN'=>'hearta_org.gif','SX'=>'unheart.gif','PIG'=>'pig.gif','ok'=>'ok_org.gif','ye'=>'ye_org.gif','good'=>'good_org.gif','no'=>'no_org.gif','Z'=>'z2_org.gif','go'=>'come_org.gif','R'=>'sad_org.gif','lz'=>'lazu_org.gif','CL'=>'clock_org.gif','ht'=>'m_org.gif','dg'=>'cake.gif'),
	'datacall' => array(
		'resume'=>array('����','order'=>array('id desc'=>'���¼���','hits desc'=>'���ż���','lastedit desc'=>'����ʱ��'),'field'=>array('resumename'=>'��������','name'=>'����','url'=>'����','birthday'=>'����','edu'=>'ѧ��','lastedit'=>'����ʱ��','hits'=>'�������','big_pic'=>'��ͷ��','small_pic'=>'Сͷ��','email'=>'EMAIL','tel'=>'�绰','moblie'=>'�ֻ�','hy'=>'����������ҵ','hyurl'=>'����������ҵ����','job_classid'=>'��������ְλ','report'=>'����ʱ��','salary'=>'����нˮ','type'=>'������������','gz_city'=>'���������ص�(����-�Ͼ�)','domicile'=>'�������ڵ�','living'=>'�־�ס��','exp'=>'��������','address'=>'��ϸ��ַ','description'=>'���˼��','idcard'=>'���֤����','homepage'=>'������ҳ/����')),
		'member'=>array('�û�','order'=>array('uid desc'=>'�����û�','login_date desc'=>'����¼ʱ��','login_hits desc'=>'�����û�'),'field'=>array('name'=>'�û���','url'=>'����','email'=>'EMAIL','moblie'=>'�ֻ�','usertype'=>'�û�����','hits'=>'��¼����','reg_date'=>'ע��ʱ��','login_date'=>'��¼ʱ��'),'where'=>array('usertype'=>array('0'=>'�û�����','1'=>'�����û�','2'=>'��ҵ�û�'))),
		'company'=>array('��˾','order'=>array('uid desc'=>'������ҵ','hits desc'=>'������ҵ','lastedit desc'=>'����ʱ��'),'field'=>array('companyname'=>'��˾����','url'=>'��˾����','hy'=>'��ҵ','hy_url'=>'��ҵ����','pr'=>'��˾����','city'=>'��ҵ��ַ','mun'=>'��ҵ��ģ','address'=>'��ҵ��ַ','linkphone'=>'�̶��绰','linkmail'=>'��ϵ����','sdate'=>'����ʱ��','money'=>'ע���ʽ�','zip'=>'��������','linkman'=>'��ϵ��','job_num'=>'ְλ��','linkqq'=>'��ϵQQ','linktel'=>'��ϵ�绰','website'=>'��ҵ��ַ','logo'=>'��ҵLOGO')),
		'job'=>array('ְλ','order'=>array('id desc'=>'����ְλ','hits desc'=>'����ְλ','rec_time desc'=>'�Ƽ�ְλ','urgent_time desc'=>'����ְλ','lastedit desc'=>'����ʱ��'),'field'=>array('jobname'=>'ְλ����','companyname'=>'��˾����','url'=>'ְλ����','com_url'=>'��˾����','hy'=>'������ҵ','hy_url'=>'��ҵ����','num'=>'��Ƹ����','jobtype'=>'ְλ����','edu'=>'ѧ��Ҫ��','age'=>'����Ҫ��','report'=>'����ʱ��','exp'=>'��������','lang'=>'����Ҫ��','salary'=>'�ṩ��н','welfare'=>'��������','time'=>'����ʱ��','city'=>'�����ص�')),
		'zph'=>array('��Ƹ��','order'=>array('id desc'=>'������Ƹ��'),'field'=>array('title'=>'��Ƹ�����','url'=>'����','organizers'=>'���췽','time'=>'�ٰ�ʱ��','address'=>'�ٰ�᳡','phone'=>'��ѯ�绰','linkman'=>'��ϵ��','website'=>'��ַ','logo'=>'��Ƹ��LOGO','com_num'=>'������ҵ��')),
		'news'=>array('����','order'=>array('a.id desc'=>'��������','a.hits desc'=>'��������'),'field'=>array('title'=>'���ű���','url'=>'����','keyword'=>'�ؼ���','author'=>'����','time'=>'����ʱ��','hits'=>'�����','description'=>'����','thumb'=>'����ͼ','source'=>'��Դ')),
		'ask'=>array('�ʴ�','order'=>array('id desc'=>'�����ʴ�','answer_num desc'=>'�����ʴ�'),'field'=>array('title'=>'�ʴ����','url'=>'�ʴ�����','content'=>'�ʴ�����','name'=>'������','time'=>'����ʱ��','answer_num'=>'�ش�����','img'=>'������ͷ��','user_url'=>'����������')),
		'link'=>array('��������','order'=>array('id desc'=>'��������','link_sorting desc'=>'����(��ǰС��)','link_sorting asc'=>'����(Сǰ���)'),'field'=>array('link_name'=>'����','link_url'=>'����','link_src'=>'ͼƬ��ַ(ͼƬ����ʹ��)'),'where'=>array('img_type'=>array('0'=>'��������','1'=>'��������','2'=>'ͼƬ����'))),
		'once'=>array('������Ƹ','order'=>array('id desc'=>'���µ�����Ƹ','lastedit desc'=>'����ʱ��'),'field'=>array('jobname'=>'ְλ����','companyname'=>'��˾����','mans'=>'��Ƹ����','require'=>'��ƸҪ��','phone'=>'��ϵ�绰','linkman'=>'��ϵ��','address'=>'��ϵ��ַ','time'=>'����ʱ��')),
		'tiny'=>array('�չ�����2','order'=>array('id desc'=>'�����չ�����','lastedit desc'=>'����ʱ��'),'field'=>array('name'=>'����','url'=>'����','sex'=>'�Ա�','exp'=>'��������','job'=>'ӦƸְλ','mobile'=>'��ϵ�绰','describe'=>'����˵��','time'=>'����ʱ��')),
		'keyword'=>array('���Źؼ���','order'=>array('num desc'=>'��������'),'field'=>array('name'=>'�ؼ�������','url'=>'����','num'=>'��������'),'where'=>array('keytype'=>array('0'=>'�ؼ�������','1'=>'������Ƹ','3'=>'ְλ','4'=>'��˾','5'=>'����')))
	),
	'seomodel'=>array('index'=>'��ҳ','job'=>'�ҹ���','part'=>'��ְ','company'=>'��˾','resume'=>'���˲�','article'=>'���Ź���','hr'=>'������','zph'=>'��Ƹ��','ask'=>'�ʴ�','evaluate'=>'����','once'=>'������Ƹ','tiny'=>'�չ�����','redeem'=>'�̳�','map'=>'��ͼ','special'=>'ר����Ƹ','login'=>'��¼ע��','other'=>'����'
	),
	'modelconfig'=>array('job'=>'�ҹ���','resume'=>'���˲�','part'=>'��ְ','company'=>'����ҵ','wap'=>'�ֻ���','article'=>'��Ѷ','announcement'=>'����','hr'=>'������','zph'=>'��Ƹ��','ask'=>'�ʴ�','evaluate'=>'����','once'=>'������Ƹ','tiny'=>'�չ�����','redeem'=>'�̳�','map'=>'��ͼ','special'=>'ר����Ƹ','login'=>'��¼','reg'=>'ע��','error'=>'��������'
	),
    'msgreturn'=>array('0'=>'ok','1'=>'�������ȱʧ','2'=>'���������ʽ����','3'=>'�˻�����','4'=>'�ؼ�������','5'=>'δ�ҵ���Ӧid��ģ��','6'=>'���ģ��ʧ��','7'=>'ģ�岻����','8'=>'ͬһ�ֻ���30�����ظ��ύ��ͬ����','9'=>'ͬһ�ֻ���5�������ύ��ͬ�����ݳ���3��','10'=>'�ֻ��ź���������','11'=>'�ӿڲ�֧��GET��ʽ����','12'=>'�ӿڲ�֧��POST��ʽ����','13'=>'Ӫ��������ͣ����','14'=>'����ʧ��','15'=>'ǩ����ƥ��','16'=>'ǩ����ʽ����ȷ','17'=>'24Сʱͬһ�ֻ��ŷ��ʹ�����������','-1'=>'�Ƿ���apikey','-2'=>'APIû��Ȩ��','-3'=>'IPû��Ȩ��','-4'=>'���ʴ�������','-5'=>'����Ƶ�ʳ���','-50'=>'δ֪�쳣','-51'=>'ϵͳ��æ','-52'=>'��ֵʧ��','-53'=>'�ύ����ʧ��','-54'=>'��¼�Ѵ���','-55'=>'��¼������','-57'=>'�û���ͨ���̶�ǩ�����ܣ���ǩ��δ����'   
    ),
	'seoconfig'=>array(
		'public'=>array(
			'webname'=>'��վ����',
			'webkeyword'=>'��վ�ؼ���',
			'webdesc'=>'��վ����',
			'weburl'=>'��ַ',
			'city'=>'��ǰ����',
			'seacrh_class'=>'�������'
		),
		'other'=>array(
			'spename'=>'ר������', 
		),
		'news'=>array(
			'news_class'=>'�������',
			'news_title'=>'���ű���',
			'news_keyword'=>'���Źؼ���',
			'news_source'=>'������Դ',
			'news_author'=>'��������',
			'news_desc'=>'��������',
		),
		'company'=>array(
			'company_name'=>'��ҵ����',
			'company_name_desc'=>'��ҵ���',
			'company_product'=>'��ҵ��Ʒ',
			'company_news'=>'��ҵ����',
			'company_news_desc'=>'��ҵ��������',
			'industry_class'=>'��ҵ���',
		),
		'job'=>array(
			'industry_class'=>'��ҵ���',
			'job_class'=>'ְλ���',
			'job_name'=>'ְλ����',
			'job_desc'=>'ְλ����',
		),
		'part'=>array(
			'part_name'=>'��ְ����',
		),
		'zph'=>array(
			'zph_title'=>'��Ƹ�����',
			'zph_desc'=>'��Ƹ������',
		),
		'ask'=>array(
			'ask_title'=>'�ʴ����',
			'ask_desc'=>'�ʴ�����',
			'ask_class_name'=>'��������',
		),
		'resume'=>array(
			'resume_username'=>'��������',
			'resume_job'=>'��������ְλ',
			'resume_city'=>'������������',
		),
		'tiny'=>array(
			'tiny_username'=>'�չ���������',
			'tiny_job'=>'�չ�����ְλ',
			'tiny_desc'=>'�չ���������',
		),
		'once'=>array(
			'once_name'=>'��������',
			'once_job'=>'������Ƹְλ',
			'once_desc'=>'������Ƹ����',
		),
		'hr'=>array(
			'hr_class'=>'�������',
			'hr_desc'=>'�������',
		    'hr_name'=>'����������',
		),
		'gg'=>array(
			'gg_title'=>'�������',
			'gg_desc'=>'��������',
		)
	)

);
?>