<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-27 22:23:16
         compiled from "D:\phpStudy\WWW\uploads\app\template\member\user\expectq.htm" */ ?>
<?php /*%%SmartyHeaderCode:2923859cbb454b6b125-71366923%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '77013fea745b99f09c64cf5f6b1b8c8def006824' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\member\\user\\expectq.htm',
      1 => 1500516816,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2923859cbb454b6b125-71366923',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user_style' => 0,
    'config' => 0,
    'style' => 0,
    'row' => 0,
    'industry_name' => 0,
    'industry_index' => 0,
    'v' => 0,
    'job_classname' => 0,
    'city_name' => 0,
    'city_index' => 0,
    'city_type' => 0,
    'userclass_name' => 0,
    'userdata' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cbb454df2e80_59195722',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cbb454df2e80_59195722')) {function content_59cbb454df2e80_59195722($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="yun_user_member_w1100">
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/index_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <link href="<?php echo $_smarty_tpl->tpl_vars['user_style']->value;?>
/images/yun_tck.css" type=text/css rel=stylesheet>
    <?php echo '<script'; ?>
 charset="utf-8" src="../js/kindeditor/kindeditor-min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 charset="utf-8" src="../js/kindeditor/lang/zh_CN.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/city.cache.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/search.js" type="text/javascript"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/class.public.js" type="text/javascript"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/job.cache.js" type="text/javascript"><?php echo '</script'; ?>
>
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/class.public.css" type="text/css">

    <?php echo '<script'; ?>
 language="javascript">
        var editor;
        KindEditor.ready(function (K) {
            editor = K.create('textarea[name="doc"]', {
                resizeType: 1,
                allowPreviewEmoticons: false,
                allowImageUpload: false,
                items: [
                    'bold', 'italic', 'underline',
                    'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                    'insertunorderedlist']
            });
        });
    <?php echo '</script'; ?>
>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        .cus_h70 {
            height: 70px;
        }
    </style>
    <div class="widemainbody">
        
        <div class="expectt_left fltL">
            <form name="MyForm" action='index.php?c=expectq&act=save' method="POST" target="supportiframe" onsubmit="return Checkexpectq();">
            <div class="expectt_left_tit"><span class="expectt_left_tit_s">�������</span><em class="expectt_left_tit_em"><font color="#FF0000">*</font> ����Ϊ������</em></div>
       
                <div class="formbox02">
                    <ul>
                        <li>
                            <div class="name"><font color="#FF0000">*</font> �������ƣ�</div>
                            <div class="text">
                                <input name="name" type="text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" maxlength="100" id='name' class="info_text" />
                            </div>
                        </li>
                        <li>
                            <div class="name"> <font color="#FF0000">*</font> ����������ҵ��</div>
                            <div class="text">
                                <div class="text_seclet text_seclet_cur" style="z-index:400">
                                <div class="yun_uesr_text">
                                    <input class="SpFormLBut text_seclet_w250 " type="button" <?php if ($_smarty_tpl->tpl_vars['row']->value['hy']) {?> value="<?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['row']->value['hy']];?>
" <?php } else { ?> value="��ѡ����ҵ" <?php }?> id="hy" onclick="search_show('job_hy');">
                                    <input type="hidden" id="hyid" name="hy" <?php if ($_smarty_tpl->tpl_vars['row']->value['hy']) {?> value="<?php echo $_smarty_tpl->tpl_vars['row']->value['hy'];?>
"<?php }?>/>
                                    <div class="cus_sel_opt_panel cu_sel_opt_panel_w200" style="display:none; z-index:301" id="job_hy">
                                        <ul>
                                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['industry_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                            <li><a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','hy','<?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');"> <?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </li>
                       <li>
                        <div class="name"><b>*</b> ����ְλ��</div>
                        <div class="text" style="width:400px; overflow:hidden">
                           <div class="yun_uesr_text yun_uesr_textw380">
                            <input type="button" <?php if ($_smarty_tpl->tpl_vars['job_classname']->value) {?>value="<?php echo $_smarty_tpl->tpl_vars['job_classname']->value;?>
"<?php } else { ?> value=" ��ѡ�� "<?php }?>style=" float:left;" class="expect_textw380" onclick="index_job(5,'#workadds_job','#job_class','left:100px;top:100px; position:absolute;');" id="workadds_job" >
                            <input name='job_classid' id='job_class' <?php if ($_smarty_tpl->tpl_vars['row']->value['job_classid']) {?> value="<?php echo $_smarty_tpl->tpl_vars['row']->value['job_classid'];?>
"<?php }?> type='hidden' />
                            </div>
                        </div>
                    </li>
                        <li>
                            <div class="name"> <font color="#FF0000">*</font> ���������ص㣺</div>
                            <div class="text">
                                
                                <div class="text_seclet text_seclet_cur fltL">
                                   <div class="yun_uesr_text">
                                    <input class="SpFormLBut text_seclet_w250" type="button" <?php if ($_smarty_tpl->tpl_vars['row']->value['provinceid']) {?> value="<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['row']->value['provinceid']];?>
" <?php } else { ?>value="��ѡ��"<?php }?> id="province" onclick="search_show('job_province');">
                                    <input type="hidden" id="provinceid" name="provinceid" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['provinceid'];?>
" />
                               
                                    <div class="cus_sel_opt_panel cu_sel_opt_panel_w200" style="display:none" id="job_province">
                                        <div style="width:100%;  overflow:auto; overflow-x:hidden">
                                            <ul class="Search_Condition_box_list">
                                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                                <li><a href="javascript:;" onclick="select_city('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','province','<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
','citys','city');"> <?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>     </div>
                                </div>
                                <div class="text_seclet text_seclet_cur fltL" style="margin-left:5px; margin-right:5px;">
                                   <div class="yun_uesr_text">
                                    <input class="SpFormLBut text_seclet_w250" type="button" <?php if ($_smarty_tpl->tpl_vars['row']->value['cityid']) {?> value="<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['row']->value['cityid']];?>
" <?php } else { ?>value="��ѡ��"<?php }?> id="citys" onclick="search_show('job_citys');">
                                    <input type="hidden" id="citysid" name="cityid" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['cityid'];?>
" />
                                    <div class="cus_sel_opt_panel cu_sel_opt_panel_w200" style="display:none" id="job_citys">
                                        <ul class="Search_Condition_box_list">
                                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_smarty_tpl->tpl_vars['row']->value['provinceid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                            <li><a href="javascript:;" onclick="select_city('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','citys','<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
','three_city','city');"> <?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                </div>
                                <div class="text_seclet text_seclet_cur fltL" <?php if ($_smarty_tpl->tpl_vars['row']->value['three_cityid']<1) {?>style="display:none;"<?php }?> id="cityshowth">
                                   <div class="yun_uesr_text">
                                    <input class="SpFormLBut text_seclet_w250" type="button" <?php if ($_smarty_tpl->tpl_vars['row']->value['three_cityid']) {?> value="<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['row']->value['three_cityid']];?>
" <?php } else { ?>value="��ѡ��"<?php }?> id="three_city" onclick="three_city_show('job_three_city');">
                                    <input type="hidden" id="three_cityid" name="three_cityid" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['three_cityid'];?>
" />
                                    <div class="cus_sel_opt_panel cu_sel_opt_panel_w200" style="display:none" id="job_three_city">
                                        <ul class="Search_Condition_box_list">
                                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_smarty_tpl->tpl_vars['row']->value['cityid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                            <li><a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','three_city','<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');"> <?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="name"><font color="#FF0000">*</font> н�ʴ�����</div>
                            <div class="text">
                                <div class="text_seclet text_seclet_cur2">
                                 <div>
                                    <input type="text" size="5" <?php if ($_smarty_tpl->tpl_vars['row']->value['minsalary']) {?> value="<?php echo $_smarty_tpl->tpl_vars['row']->value['minsalary'];?>
" <?php }?>  id="minsalary" name="minsalary" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" class=" info_textw100" placeholder="���н��"/>
                                   	<span class="info_textw100line">-</span>
                                    <input type="text" size="5" <?php if ($_smarty_tpl->tpl_vars['row']->value['maxsalary']) {?> value="<?php echo $_smarty_tpl->tpl_vars['row']->value['maxsalary'];?>
" <?php }?>  id="maxsalary" name="maxsalary" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" class=" info_textw100"  placeholder="���н��"/>
                                </div>
                            </div>
                            </div>
                        </li>
                        <li>
                            <div class="name"> <font color="#FF0000">*</font> �����������ʣ�</div>
                            <div class="text">
                                <div class="text_seclet text_seclet_cur3 re">
                                 <div class="yun_uesr_text">
                                    <input class="SpFormLBut text_seclet_w250" type="button" <?php if ($_smarty_tpl->tpl_vars['row']->value['type']) {?> value="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['row']->value['type']];?>
" <?php } else { ?> value="��ѡ��������" <?php }?>  id="type" onclick="search_show('job_type');">
                                    <input type="hidden" id="typeid" name="type" <?php if ($_smarty_tpl->tpl_vars['row']->value['type']) {?> value="<?php echo $_smarty_tpl->tpl_vars['row']->value['type'];?>
"<?php }?> />
                                    <div class="cus_sel_opt_panel cu_sel_opt_panel_w200 cus_h70" style="display:none" id="job_type">

                                        <ul class="Search_Condition_box_list">
                                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                            <li><a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','type','<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');"> <?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </li>
                        <li>
                            <div class="name"> <font color="#FF0000">*</font> ����ʱ�䣺</div>
                            <div class="text">
                                <div class="text_seclet text_seclet_cur4">
                                 <div class="yun_uesr_text">
                                    <input class="SpFormLBut text_seclet_w250" type="button" <?php if ($_smarty_tpl->tpl_vars['row']->value['report']) {?> value="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['row']->value['report']];?>
" <?php } else { ?> value="��ѡ�񵽸�ʱ��" <?php }?>  id="report" onclick="search_show('job_report');">
                                    <input type="hidden" id="reportid" name="report" <?php if ($_smarty_tpl->tpl_vars['row']->value['report']) {?> value="<?php echo $_smarty_tpl->tpl_vars['row']->value['report'];?>
"<?php }?> />
                                    <div class="cus_sel_opt_panel cu_sel_opt_panel_w200" style="display:none" id="job_report">
                                        <ul class="Search_Condition_box_list">
                                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_report']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                            <li><a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','report','<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');"> <?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </li>
                        <li>
                            <div class="name"> <font color="#FF0000">*</font> ��ְ״̬��</div>
                            <div class="text">
                                <div class="text_seclet text_seclet_cur3" style="z-index:50">
                                 <div class="yun_uesr_text">
                                    <input class="SpFormLBut text_seclet_w250" type="button" <?php if ($_smarty_tpl->tpl_vars['row']->value['jobstatus']) {?> value="<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['row']->value['jobstatus']];?>
" <?php } else { ?> value="��ѡ����ְ״̬" <?php }?>  id="jobstatus" onclick="search_show('job_jobstatus');">
                                    <input type="hidden" id="jobstatusid" name="jobstatus" <?php if ($_smarty_tpl->tpl_vars['row']->value['jobstatus']) {?> value="<?php echo $_smarty_tpl->tpl_vars['row']->value['jobstatus'];?>
"<?php }?> />
                                    <div class="cus_sel_opt_panel cu_sel_opt_panel_w200" style="display:none" id="job_jobstatus">
                                        <ul class="Search_Condition_box_list">
                                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['userdata']->value['user_jobstatus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['j']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                            <li><a href="javascript:;" onclick="selects('<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
','jobstatus','<?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
');"> <?php echo $_smarty_tpl->tpl_vars['userclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="name"> ����������ݣ�</div>
                            <div class="text">
                                <textarea name="doc" id="content" style="width:500px;height:160px;"><?php echo $_smarty_tpl->tpl_vars['row']->value['doc'];?>
</textarea>
                            </div>
                        </li>
                        <li>
                            <div class="name">&nbsp;</div>
                            <div class="text">
                                <input name="eid" type="hidden" value="<?php echo $_GET['e'];?>
" />
                                <input type="submit" name="submit" value=" �� ��" class="Verification_sc_bth2 uesr_submit" />
                            </div>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
        <div class="w920 fltR">
            <div class="w190  fltR">
                <div class="resumestatebox01 mt8">
                    <h2><span>�������˵��</span></h2>
                    <div class="resumestatebox02 mt8">
                        <div class="cont">
                            <div class="value_p">
                                �����������ֻ��ѡ�������ְ����Ȼ�������м��������ݿ��м��ɣ�
                                <hr size="1" />
                                ���ǲ����Ƽ����ַ�ʽ����Ϊ�����ṩ�˸��ӹ淶�ļ�����ʽ��һ��Ư���ļ�����������һ���˵�����̬�ȣ�ֱ��Ӱ�������ְ�ɹ��ʣ�
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
 language=javascript>
    function Checkexpectq() {
        if ($.trim($("#name").val()) == '') { layer.msg('����д��������', 2, 8); return false;}
        if ($.trim($("#job_class").val()) == '') { layer.msg('��ѡ������ְλ', 2, 8);  return false;}
        if ($.trim($("#hyid").val()) == '') { layer.msg('��ѡ��������ҵ', 2, 8);  return false;}
        if ($.trim($("#provinceid").val()) == '') {layer.msg('��ѡ�����ص�', 2, 8);  return false; }
        var min = $.trim($("#minsalary").val());
        var max = $.trim($("#maxsalary").val());
	    if (min == ''||min=='0') {layer.msg('����дн�ʴ���', 2, 8);  return false; }
	    if (max&&parseInt(max)<=parseInt(min)) {layer.msg('���н�ʱ���������н��', 2, 8);  return false; }
        if ($.trim($("#typeid").val()) == '') {layer.msg('��ѡ��������', 2, 8);  return false; }
		if ($.trim($("#reportid").val()) == '') {layer.msg('��ѡ�񵽸�ʱ��', 2, 8);  return false; }
		if ($.trim($("#jobstatusid").val()) == '') {layer.msg('��ѡ����ְ״̬', 2, 8);  return false; }
      
        layer.load('ִ���У����Ժ�...', 0);
    }
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
