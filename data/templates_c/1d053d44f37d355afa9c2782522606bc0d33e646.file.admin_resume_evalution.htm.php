<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-27 00:09:11
         compiled from "D:\phpStudy\WWW\uploads\app\template\admin\admin_resume_evalution.htm" */ ?>
<?php /*%%SmartyHeaderCode:3250159ca7ba72e35c3-36425798%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d053d44f37d355afa9c2782522606bc0d33e646' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\admin\\admin_resume_evalution.htm',
      1 => 1506441549,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3250159ca7ba72e35c3-36425798',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'rows' => 0,
    'v' => 0,
    'pagenav' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ca7ba73cf215_59689773',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ca7ba73cf215_59689773')) {function content_59ca7ba73cf215_59689773($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<link href="images/reset.css" rel="stylesheet" type="text/css" />
<link href="images/system.css" rel="stylesheet" type="text/css" />
<link href="images/table_form.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/admin_public.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/show_pub.js"><?php echo '</script'; ?>
>
<title>��̨����</title>
</head>
<body class="body_ifm">
<div class="infoboxp">
<div class="infoboxp_top_bg"></div>
  <form action="index.php" name="myform" method="get">
    <input name="m" value="admin_resume_evalution" type="hidden"/> 
      <div class="admin_Filter"> <span class="complay_top_span fl">�������۹���</span>
		</div> 
  </form>
 <?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
  
  <div class="table-list">
    <div class="admin_table_border">
      <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
      <form action="index.php" name="myform" id='myform' method="get" target="supportiframe">
        <input name="m" value="admin_resume_evalution" type="hidden"/>
        <input name="c" value="del" type="hidden"/>
        <table width="100%">
          <thead>
            <tr class="admin_table_top">
              <th style="width:20px;"><label for="chkall"><input type="checkbox" id='chkAll'  onclick='CheckAll(this.form)'/></label></th>
              <th>
      			  <?php if ($_GET['order']=="asc") {?>
        			  <a href="index.php?m=admin_resume_evalution&order=desc">���<img src="images/sanj.jpg"/></a>
                <?php } else { ?>
                <a href="index.php?m=admin_resume_evalution&order=asc">���<img src="images/sanj2.jpg"/></a>
               <?php }?>
      			  </th>
              <th align="left" style="width:200px;">��������</th>
              <th align="left" style="width:100px;">�û�����</th>
              <th align="left">������˾����</th>
              <th align="left" style="width:100px;">����������</th>
              <th align="left" style="width:70px;">���۵ȼ�</th>
              <th align="left" style="width:70px;">���۷���</th>
      			  <th align="left" style="width:100px;">����ʱ��</th>
              <th align="center" class="admin_table_th_bg">����</th>
            </tr>
          </thead>
          <tbody>
          <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
          <tr align="center" id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  name='del[]' onclick='unselectall()' rel="del_chk" /></td>
            <td align="left" class="td1" style="text-align:center;"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td> 
            <td align="left"><?php echo mb_substr($_smarty_tpl->tpl_vars['v']->value['resume_name'],0,20,'gbk');?>
</td>  
            <td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['uname'];?>
</td>
            <td align="left"><?php echo mb_substr($_smarty_tpl->tpl_vars['v']->value['com_name'],0,20,'gbk');?>
</td>
            <td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['by_username'];?>
</td>
            <td align="left"><?php if ($_smarty_tpl->tpl_vars['v']->value['grade']==1) {?>����<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['grade']==2) {?>�м�<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['grade']==3) {?>�߼� <?php } else {
}?></td>
            <td align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['score'];?>
</td>
			      <td align="left"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['created_at'],"%Y-%m-%d");?>
</td>
			 
            <td><span onClick="showdiv4('houtai_div','<?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['reply'];?>
')" class="admin_cz_sc" style="cursor:pointer;"> Ԥ��</span> | <a href="javascript:void(0)" onClick="layer_del('ȷ��Ҫɾ����', 'index.php?m=admin_resume_evalution&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" class="admin_cz_sc">ɾ��</a></td>
        
          </tr>
         
          <?php } ?>
          <tr style="background:#f1f1f1;">
            <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
            <td colspan="2" >
            <label for="chkAll2">ȫѡ</label>&nbsp;
            <input  class="admin_submit4" type="button" name="delsub" value="ɾ����ѡ" onClick="return really('del[]')" /></td>
            <td colspan="7" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
          </tr>
            </tbody>
        </table>
		<input type="hidden" name="pytoken"  id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
      </form>
    </div>
  </div>
</div>
<!-- <div id="houtai_div" style=" display:none;height:180px; ">
	<form id="formstatus" method="post" target="supportiframe" action="index.php?m=admin_company_job&c=status">
	  <table class="table_form "  id="infobox"> 
			<tr><td>�������ݣ�</td><td><textarea name="beizhu"  style="width:300px;height:80px;border:1px solid #ddd;"id="beizhu"  class="text" readonly></textarea ></td></tr>
			<tr><td>�ظ����ݣ�</td><td><textarea name="reply" id="reply" style="width:300px;height:80px;border:1px solid #ddd;"  class="text" readonly></textarea></td></tr> 
	  </table>
	  <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
	 </form>
</div>  --> 
</body>
</html><?php }} ?>
