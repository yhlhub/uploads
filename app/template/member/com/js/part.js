function CheckPost_part(){
	if($.trim($("#name").val())==""||$("#name").val()==$("#name").attr('placeholder')){
		layer.msg("�������ְ���ƣ�",2,8);return false;
	}
	if($.trim($("#typeid").val())==""&&$.trim($("#part_type_val").val())==""){
		layer.msg("��ѡ���ְ���ͣ�",2,8);return false;
	}
	if($.trim($("#number").val())<1||$("#number").val()==$("#number").attr('placeholder')){
		layer.msg("��������Ƹ������",2,8);return false;
	}
	var chk_value =[];
	$('input[name="worktime[]"]:checked').each(function(){
		chk_value.push($(this).val());
	});
	if(chk_value.length==0){
		layer.msg("��ѡ���ְʱ�䣡",2,8);return false;
	}
	var sdate=$("#sdate").val();
	var edate=$("#edate").val();
	var today=$("#today").val();
	var timetype=$("input[name='timetype']:checked").val();
	if(timetype){
		if(sdate==""||sdate==$("#sdate").attr('placeholder')){
			layer.msg("��ѡ��ʼ���ڣ�",2,8);return false;
		}
	}else{
		if(sdate=="" ||sdate==$("#sdate").attr('placeholder')){
			layer.msg("��ѡ��ʼ���ڣ�",2,8);return false;
		} 
		if(edate==""||edate==$("#edate").attr('placeholder')){
			layer.msg("��ѡ��������ڣ�",2,8);return false;
		} 
		if(toDate(edate).getTime()<toDate(sdate).getTime() || toDate(edate).getTime()<toDate(today).getTime()){
			layer.msg("����ȷѡ�������ڣ�",2,8);return false;
		}
	}	
	if(!timetype){
		var end=$("#deadline").val();
		var st=toDate(today).getTime();
		var ed=toDate(end).getTime();
		if(end==''||end==$("#deadline").attr('placeholder')){
			layer.msg("��ѡ������ֹʱ�䣡",2,8);return false;
		}else if(ed<=st){ 
			layer.msg("������ֹʱ�䲻��С�ڵ�ǰʱ�䣡",2,8);return false;
		}			
	}
	if($.trim($("#salary").val())==""||$.trim($("#salary").val())<1 ||$("#salary").val()==$("#salary").attr('placeholder')){
		layer.msg("������н��ˮƽ��",2,8);return false;
	}
	if($.trim($("#salary_typeid").val())=="" && $.trim($("#user_salary_val").val())==""){
		layer.msg("��ѡ��нˮ���ͣ�",2,8);return false;
	}
	
	if($.trim($("#billing_cycleid").val())=="" && $.trim($("#user_billing_val").val())==""){
		layer.msg("��ѡ��������ڣ�",2,8);return false;
	}
	var html = editor.text();
	if($.trim(html)==""){
		layer.msg("�������ְ���ݣ�",2,8);return false;
	}
	if($.trim($("#citysid").val())==""){
		layer.msg("��ѡ�����ص㣡",2,8);return false;
	}	
	if($.trim($("#address").val())==""||$("#address").val()==$("#address").attr('placeholder')){
		layer.msg("��������ϸ��ַ��",2,8);return false;
	}
	if($.trim($("#map_x").val())==""||$.trim($("#map_y").val())==""){
		layer.msg("��ѡ���ͼ��",2,8);return false;
	}		
	if($.trim($("#linkman").val())==""||$("#linkman").val()==$("#linkman").attr('placeholder')){
		layer.msg("��������ϵ�ˣ�",2,8);return false;
	}
	if($.trim($("#linktel").val())==""||$("#linktel").val()==$("#linktel").attr('placeholder')){
		layer.msg("��������ϵ�ֻ���",2,8);return false;
	}
	var iftelphone = isjsMobile($.trim($("#linktel").val()));
	if(iftelphone==false){layer.msg('����ȷ��д��ϵ�ֻ���',2,8);return false;}
}
function change(){
	if($("#timetype").attr("checked")=='checked'){
		$("#edate").hide();
		$("#dline").hide();
	}else{
	    $("#dline").show();
		$("#edate").show();
	}
}