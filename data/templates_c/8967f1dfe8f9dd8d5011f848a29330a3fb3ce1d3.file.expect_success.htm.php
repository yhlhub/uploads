<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-27 22:24:51
         compiled from "D:\phpStudy\WWW\uploads\app\template\member\user\expect_success.htm" */ ?>
<?php /*%%SmartyHeaderCode:61659cbb4b386b448-94154565%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8967f1dfe8f9dd8d5011f848a29330a3fb3ce1d3' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\member\\user\\expect_success.htm',
      1 => 1489137122,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '61659cbb4b386b448-94154565',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'style' => 0,
    'id' => 0,
    'info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cbb4b397b8d7_64037182',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cbb4b397b8d7_64037182')) {function content_59cbb4b397b8d7_64037182($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/index_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/job.cache.js" type="text/javascript"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/class.public.css" type="text/css">
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/class.public.js" type="text/javascript"><?php echo '</script'; ?>
> 
<form action="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/member/?c=expect&act=add" method="post" target="supportiframe">
 
 <div class="news_expect">
<div class="news_expect_cont">

<div class="news_expect_last_msg"><span class="news_expect_last_msg_s">��ϲ�������������ɹ�</span></div>


<div class="news_expect_content">
<div class="news_expect_last_content">
<div class="news_expect_last_wzd">
<span class="news_expect_last_wzd_span">���������ȣ�</span>
<div class="member_index_resume_t_wzd"> <span class="member_index_resume_t_wz_b"> <em class="ember_index_resume_t_wz_c" style="width:55%"></em> </span> <span class="member_index_resume_t_wz_n">55%</span> </div><a href="<?php echo smarty_function_url(array('m'=>'resume','c'=>'show','id'=>'`$id`'),$_smarty_tpl);?>
" target="_blank" class="member_index_resume_yl">����Ԥ�� </a></div>
<div class="news_expect_last_p">��ҵ������Щ��Ϣ�����������в���</div>
<div class="news_expect_last_sub">
<a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
#work_upbox" class="news_expect_last_sub_a">��������   </a>
<a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
#edu_upbox" class="news_expect_last_sub_a">��������  </a>
<a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
#training_upbox" class="news_expect_last_sub_a">��ѵ����  </a>
<a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
#skill_upbox" class="news_expect_last_sub_a">ְҵ���� </a>
<a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
#project_upbox" class="news_expect_last_sub_a">��Ŀ���� </a>
<a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
#other_upbox" class="news_expect_last_sub_a">������Ϣ  </a>
<a href="index.php?c=expect&e=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
#description_upbox" class="news_expect_last_sub_a">��������  </a>
<?php if ($_smarty_tpl->tpl_vars['info']->value['photo']=='') {?>
<a href="index.php?c=uppic" class="news_expect_last_sub_a">�ϴ�ͷ��  </a>
<?php }?>
</div>

<div class="news_expect_last_search">��Ҳ����ֱ��ȥ�������ʵ�ְλ��<a href="<?php echo smarty_function_url(array('m'=>'job'),$_smarty_tpl);?>
" target="_blank" class="news_expect_last_subjob">ְλ����</a><a href="index.php" class="news_expect_last_a">�����ҵ���ְ��ҳ>></a></div>



</div>
</div>
</div>
</div>
</form>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
