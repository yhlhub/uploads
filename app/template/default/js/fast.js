function post_pass(img){
	var pw=$("#pw").val();
	var code=$("#code").val();
	var tid=$("#tid").val();
	var type=$("#type").val();
	if(pw==""){
		layer.msg('����������', 2, 8);return false; 
	}
	if(code==""){
		layer.msg('��������֤��', 2, 8);return false; 
	}
	$.post("index.php?m=once&c=ajax",{pw:pw,code:code,tid:tid,type:type},function(data){
		if(data==1){
			layer.msg('��֤�����', 2, 8);
			checkCode(img);
			return false; 
		}else if(data==2){
			layer.msg('�������', 2, 8);return false; 
		}else if(data==3){
			layer.msg('ˢ�³ɹ���', 2, 9,function(){window.location.reload();}); 
		}else if(data==5){
			layer.msg('�Բ������Ѵﵽһ�����ˢ�´�����', 2, 9,function(){window.location.reload();});
		}else if(data==4){
			layer.msg('ɾ���ɹ���', 2, 9);
			window.location.href=$("#gourl").val();
		}else{
			layer.closeAll(); 
			var data=eval('('+data+')');
			$("#id").val(data.id);
			$("#title").val(data.title);			
			$("#companyname").val(data.companyname);			
			$("#sdate").val(formatDate(data.sdate));
			$("#edate").val(data.edate);
			$("#phone").val(data.phone);
			$("#linkman").val(data.linkman);			
			$("#require").val(data.require);
			$("#provinceid").val(data.provinceid);
			$("#citysid").val(data.cityid);
			if(data.three_cityid){
				$("#cityshowth").show();
				$("#three_cityid").val(data.three_cityid);
				$("#three_city").val(data.three_cityname);
			}
			$("#province").val(data.provincename);
			$("#citys").val(data.cityname);
			$("#password").val(pw);
			$("#botton").val('�޸�'); 
			var kind=$("#code_kind").val();
			if(kind==1){
				checkCode('vcodeimgs');
			}			
			$.layer({
				type : 1,
				title :'�޸���Ƹ��Ϣ', 
				offset: [($(window).height() - 550)/2 + 'px', ''],
				closeBtn : [0 , true],
				border : [10 , 0.3 , '#000', true],
				zIndex:9999,
				area : ['590px','620px'],
				page : {dom :"#fabufast"}
			}); 
		}
	})
}
function check_once_job(){
		var password=$("#password").val().length;
		var id=$("#id").val();
		var companyname=$("input[name=companyname]").val();
		var title=$("#title").val();
		var linkman=$("input[name=linkman]").val();
		var phone=$.trim($("input[name=phone]").val());
		var reg_phone= (/^[1][34578]\d{9}$|^([0-9]{3,4}\-)?[0-9]{7,8}$/);
		var cityid=$("input[name=cityid]").val();
		var edate=$("input[name=edate]").val();
		if($.trim(title)==""){
			layer.msg('����д������Ƹ�ĸ�λ', 2, 8);return false; 
		}
		if($.trim(companyname)==""){
			layer.msg('����д��������', 2, 8);return false; 
		}
		if($.trim(linkman)==""){
			layer.msg('����д��ϵ��', 2, 8);return false;  
		}
		if(!phone){
		    layer.msg('����д��ϵ�绰��', 2, 8);return false; 
		}
		if(phone){
		    if(!reg_phone.test(phone)){
			    layer.msg('����ȷ��д��ϵ�绰', 2, 8);return false; 
			} 
		}
		if($.trim($("#require").val())==""||$.trim($("#require").val())=='����д��Ƹ�ľ���Ҫ���磺�Ա�ѧ�������䣬�������飬���ʴ����������Ϣ'){ 
			layer.msg('����д��ƸҪ��', 2, 8);return false;
		}
		if(cityid==''){
			layer.msg('��ѡ�����ص�', 2, 8);return false;
		}
	    if(!edate){
			layer.msg('����д��Ч�ڣ�', 2, 8);return false;
	    }
		if(password<"4"){
			layer.msg('���벻������4λ', 2, 8);return false;
		}
		var codesear=new RegExp('������Ƹ');
		if(codesear.test(code_web)){
		if(code_kind==1){
			var authcode=$("#authcode").val();
			if(!authcode){
				layer.msg('��������֤��', 2, 8);return false; 
			}
		}else if(code_kind==3){
			var geetest_challenge = $('input[name="geetest_challenge"]').val();
			var geetest_validate = $('input[name="geetest_validate"]').val();
			var geetest_seccode = $('input[name="geetest_seccode"]').val();
			if(geetest_challenge =='' || geetest_validate=='' || geetest_seccode==''){
				$("#popup-submit").trigger("click");
				layer.msg('������ť������֤��', 2, 8);return false; 
			}
		}}
		return true;
}
function check_once_keyword(){
	if($("#Fastkeyword").val()=="" || $("#Fastkeyword").val()=="��������������"){ 
		layer.msg('�������������ݣ�', 2, 8);return false;
	}
}
function formatDate(d){
	var  now=new  Date(parseInt(d) * 1000);
	var  year=now.getFullYear();
	var  month=now.getMonth()+1;
	var  date=now.getDate();
	var  hour=now.getHours();
	var  minute=now.getMinutes();
	var  second=now.getSeconds();
	return  year+"-"+month+"-"+date;
}

function showdd(type,id,img){
	$("#tid").val(id);
	$("#type").val(type);
	$("#pw").val('');
	$("#code").val('');
	checkCode(img);
	$.layer({
		type : 1,
		title :'��֤����', 
		offset: [($(window).height() - 200)/2 + 'px', ''],
		closeBtn : [0 ,true], 
		border : [10 , 0.3 , '#000', true],
		area : ['350px','220px'],
		page : {dom :"#postpw"}
	});  
}

function check_resume_tiny(){ 
	var password=$("#password").val().length;
	var id=$("#id").val();
	var username=$("#username").val();
	if($.trim(username)==""){ 
		layer.msg('����д����', 2, 8);return false; 
	}	
	if($("#sex").val()==''){
		layer.msg('��ѡ���Ա�',2,8);return false;
	}
	var mobile=$.trim($("input[name=mobile]").val());
	if(!mobile){ 
		layer.msg('����д�ֻ�����', 2, 8);return false; 
	}else{
		var reg= /^[1][34578]\d{9}$/;   
		if(!reg.test(mobile)){ 
			layer.msg('�ֻ������ʽ����', 2, 8);return false;
		}
	}
	var exp=$.trim($("input[name=exp]").val());
	if($.trim(exp)==""){
		layer.msg('��ѡ�������ޣ�',2,8);return false;
	}
	var job=$("input[name=job]").val();
	if($.trim(job)==""){
		layer.msg('����д����ʲô������', 2, 8);return false; 
	}	
	if(id==""){
		if(password<"4"){
			layer.msg('����ȷ�������룡', 2, 8);return false; 
		}
	}
	var codesear=new RegExp('������Ƹ');
	if(codesear.test(code_web)){
		if(code_kind==1){
			var authcode=$("#authcode").val();
			if(!authcode){
				layer.msg('��������֤��', 2, 8);return false; 
			}
		}else if(code_kind==3){
			var geetest_challenge = $('input[name="geetest_challenge"]').val();
			var geetest_validate = $('input[name="geetest_validate"]').val();
			var geetest_seccode = $('input[name="geetest_seccode"]').val();
			
			if(geetest_challenge =='' || geetest_validate=='' || geetest_seccode==''){
				$("#popup-submit").trigger("click");
				layer.msg('������ť������֤��', 2, 8);return false; 
			}
		}
	}
}
function post_password(url,img){
	var pw=$("#pw").val();
	var code=$("#code").val();	
	var tid=$("#tid").val();
	var type=$("#type").val();
	if(pw==""){
		layer.msg('����������', 2, 8);return false; 
	}
	if(code==""){
		layer.msg('��������֤��', 2, 8);return false; 
	}
	layer.load('ִ���У����Ժ�...',0);
	$.post(url,{pw:pw,code:code,tid:tid,type:type},function(data){ 
		layer.closeAll();
		if(data==1){
			layer.msg('��֤�����', 2, 8);checkCode(img);return false; 
		}else if(data==2){
			layer.msg('�������', 2, 8);checkCode(img);return false; 
		}else if(data==3){
			layer.msg('ˢ�³ɹ���', 2, 9,function(){window.location.reload();}); 
		}else if(data==4){
			layer.msg('ɾ���ɹ���', 2, 9,function(){window.location.href=$("#gourl").val();}); 
		}else{ 
			$(".add").hide();
			var data=eval('('+data+')');
			$("#id").val(data.id);
			$("#username").val(data.username);
			$("#sex").val(data.sex);
			if(data.sex==1){
			$("#sex"+data.sex).addClass("yun_info_sex_cur");
			}else if(data.sex==2){
			$("#sex"+data.sex).addClass("yun_info_sex_cur");	
			}			
			$("#exp").val(data.expname);
			$("#expid").val(data.exp);
			$("#job").val(data.job);
			$("#mobile").val(data.mobile);
			$("#qq").val(data.qq);
			$("#production").val(data.production);
			$("#password").val(pw);			
			$("#botton").val('�޸�'); 
			$.layer({
				type : 1,
				title :'�޸��չ�����', 
				offset: [($(window).height() - 550)/2 + 'px', ''],
				closeBtn : [0 , true],
				border : [10 , 0.3 , '#000', true],
				area : ['590px','550px'],
				zIndex:99999,
				page : {dom :"#fabufast1"}
			});  
		}
	})
}

function showfabu(){
	$("#id").val('');
	$("#title").val('');
	$("#companyname").val('');
	$("#sdate").val('');
	$("#edate").val('');
	$("#phone").val('');
	$("#linkman").val('');
	$("#require").val('����д��Ƹ�ľ���Ҫ���磺�Ա�ѧ�������䣬�������飬���ʴ����������Ϣ');
	$("#password").val('');
	$(".add").show();
	if($("#authcode").val()!='12345')
	{
		$("#authcode").val('');
	}
	
	$("#botton").val("����");  
	$.layer({
		type : 1,
		title :'������Ƹ��Ϣ', 
		offset: [($(window).height() - 535)/2 + 'px', ''],
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['590px','610px'],
		zIndex:99999,
		page : {dom :"#fabufast"}
	}); 
}

function showfabu1(){
	$("#id").val('');
	$("#username").val('');
	$("#password").val('');
	$("#sex").val('');
	$("#exp").val('��ѡ��');
	$("#job").val('');
	$("#mobile").val('');
	$("#qq").val('');
	$("#production").val('');
	
	if($("#authcode").val()!='12345')
	{
		$("#authcode").val('');
	}
	$("#botton").val("����"); 
	$.layer({
		type : 1,
		title :'�����չ�����', 
		offset: [($(window).height() - 550)/2 + 'px', ''],
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['590px','520px'],
		zIndex:9999,
		page : {dom :"#fabufast1"}
	});  	 
} 
function search_once_show(id){
	if($("#"+id).hasClass('none')){
		$("#"+id).removeClass('none');
	}else{
		$("#"+id).addClass('none');
	}
}
function select_once_city(id,type,name,gettype,ptype){
	$("#job_"+type).addClass('none');
	$("#"+type).val(name);
	$("#" + type + "id").val(id);
	$("#"+type).val(name);
	$("#" + type + "id").val(id);
	$('#by_citysid').html('');
	if(type=='province'){
		$("#citys").val('��ѡ��');
		$("#three_city").val('��ѡ��');
		$("#citysid").val('');
		$("#three_cityid").val('');
		$("#cityshowth").hide();
	}
	var url=weburl+"/index.php?m=ajax&c=ajax_once_city";
	$.post(url,{id:id,gettype:gettype,ptype:ptype},function(data){
		if(gettype=="citys"){
			$("#"+gettype).val("��ѡ�����");
			
			$("#three_cityid").val('');
			$("#cityshowth").hide();
		}
		if(gettype=="three_city"){
			
			if(data!=''){
				$("#"+gettype).val("��ѡ������");
				$("#cityshowth").show();
			}else{
				$("#cityshowth").hide();
			}
		}
		$("#job_"+gettype).html(data);
	})
}
function selects_once(id,type,name){
	$("#job_"+type).addClass('none');
	$("#"+type).val(name);
	$("#"+type+"id").val(id);
}
$(function () {
	$('body').click(function (evt) {
		if($(evt.target).parents("#job_province").length==0 && evt.target.id != "province") {
		   $("#job_province").addClass('none');
		}
		if($(evt.target).parents("#job_citys").length==0 && evt.target.id != "citys") {
		   $("#job_citys").addClass('none');
		}
		if($(evt.target).parents("#job_three_city").length==0 && evt.target.id != "three_city") {
		   $("#job_three_city").addClass('none');
		}
	})
})