function getshow(id,title){
	var moblie=$("#linktel").val();
	$("input[name=moblie]").val(moblie);
	var email=$("#linkmail").val();
	$("input[name=email]").val(email);
	$.layer({
		type : 1,
		title :title,
		closeBtn : [0 , true],
		border : [10 , 0.3 , '#000', true],
		area : ['500px','auto'],
		page : {dom :"#"+id}
	});
}
function sendmoblie(){
	if($("#send").val()=="1"){
		return false;
	}
	var moblie=$("input[name=moblie]").val();
	var mobile=$("input[name=mobile]").val();
	var reg= /^[1][34578]\d{9}$/; 
	if(moblie==''){
		layer.msg('�ֻ��Ų���Ϊ�գ�',2,8);return false;
	}else if(mobile==moblie){
		layer.msg('����µĺ��룡',2,8);return false;
	}else if(!reg.test(moblie)){
		layer.msg('�ֻ������ʽ����',2,8);return false;
	}  
	var i=layer.load('ִ���У����Ժ�...',0);
	$.ajaxSetup({cache:false});
	$.post(weburl+"/member/index.php?m=ajax&c=mobliecert", {str:moblie},function(data) {
		layer.close(i);
		if(data=="���ͳɹ�!"){ 
			layer.msg('���ͳɹ���',2,9,function(){send(121);}); 
		}else if(data==1){
			layer.msg('ͬһ�ֻ���һ�췢�ʹ����ѳ���', 2, 8);
		}else if(data==2){
			layer.msg('ͬһIPһ�췢�ʹ����ѳ���', 2, 8);
		}else if(data==3){
			layer.msg('����֪ͨ�ѹرգ�����ϵ����Ա��',2,8);
		}else if(data==4){
			layer.msg('��û�����ö��ţ�����ϵ����Ա��',2,8);
		}else if(data==5){
			layer.msg('�벻Ҫ�ظ����ͣ�',2,8);
		}else{
			layer.msg(data,2,8);
		}
	})
}
function send(i){
	i--;
	if(i==-1){
		$("#time").html("���»�ȡ");
		$("#send").val(0)
	}else{
		$("#send").val(1)
		$("#time").html(i+"��");
		setTimeout("send("+i+");",1000);
	}
}
function check_moblie(){
	var moblie=$("input[name=moblie]").val();
	
	if(moblie==""){ 
		layer.msg('�������ֻ����룡',2,8,function(){getshow('moblie','���ֻ�����');});return false;
	}
	var code=$("#moblie_code").val();
	if(code==""){ 
		layer.msg('�����������֤�룡',2,8,function(){getshow('moblie','���ֻ�����');});return false;
	}
	
	layer.load('ִ���У����Ժ�...',0);
	$.ajaxSetup({cache:false});
	$.post("index.php?c=binding&act=save",{moblie:moblie,code:code},function(data){
		if(data==1){
			if($("#info").val()==1){
				$("#bdphone").html("<input type=\"text\" size=\"35\" name=\"linktel\" value=\""+moblie+"\" class=\"com_info_text\" style=\"width:250px;background:#D3D3D3;\" readonly=\"readonly\"/><a href=\"javascript:void(0)\"  onclick=\"getshow('moblie','���ֻ�����');\" class=\"com_set_a\" >���°�</a>");
				layer.closeAll();
				layer.msg('�ֻ��󶨳ɹ���',2,9); 
			}else{
				layer.msg('�ֻ��󶨳ɹ���',2,9,function(){location.reload();}); 
			}
		}else if(data==3){
			layer.msg('������֤�벻��ȷ��',2,8,function(){$("#moblie_code").val('');});
		}else{
			layer.msg('��������',2,8); 
		}
	})
}
function sendbemail(img){
	var email=$("input[name=email]").val();
	var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/; 
	if(email==''){
		layer.msg('���䲻��Ϊ�գ�',2,8,function(){getshow('email','������');});return false;
	}else if(!myreg.test(email)){
		layer.msg('�����ʽ����',2,8,function(){getshow('email','������');});return false;
	}
	var authcode=$("input[name=email_code]").val();
	if(authcode==""){
		layer.msg('��֤�벻��Ϊ�գ�',2,8,function(){getshow('email','������');});return false;
	}
	
	layer.load('ִ���У����Ժ�...',0);
	$.ajaxSetup({cache:false});
	$.post(weburl+"/member/index.php?m=ajax&c=emailcert",{email:email,authcode:authcode},function(data){
		if(data){
			if(data=="4"){
				layer.msg('��֤�벻��ȷ��',2,8,function(){checkCode(img);});
			}
			if(data=="3"){
				layer.msg('�ʼ�û�����ã�����ϵ����Ա��',2,8);
			}
			if(data=="2"){
				layer.msg('�ʼ�֪ͨ�ѹرգ�����ϵ����Ա��',2,8);
			}
			if(data=="1"){
				if($("#info").val()==1){
					$("#bdmail").html("<input type=\"text\" size=\"35\" name=\"linkmail\" value=\""+email+"\" class=\"com_info_text\" style=\"width:250px;background:#D3D3D3;\" readonly=\"readonly\"/><a href=\"javascript:void(0)\"  onclick=\"getshow('email','������');\" class=\"com_set_a\" >���°�</a>");
					layer.closeAll();
					layer.msg('�ʼ��ѷ��͵������䣬��ע�������֤��',2,9);
				}else{
					layer.msg('�ʼ��ѷ��͵������䣬��ע�������֤��',2,9,function(){location.reload();});
				}
			}
		}else{
			layer.msg('�����µ�¼��',2,8,function(){window.location.href =weburl;});
		} 
	})
}
function check_company_cert(){
	if($.trim($("#company_name").val())==''){
		layer.msg('��ҵȫ�Ʋ���Ϊ�գ�',2,8);
		return false;
	}
	if($.trim($("#com_cert").val())==''){
		layer.msg('���ϴ�Ӫҵִ�գ�',2,8);
		return false;
	}
	layer.load('ִ���У����Ժ�...',0);return true;
}
function check_user_cert(){
	if($.trim($("#idcard").val())==''){
		layer.msg('����д���֤���룡',2,8);return false;
	}
	if(checkIdcard($.trim($("#idcard").val()))==false){
		layer.msg('����д��ȷ���֤���룡',2,8);return false;
	}
	if($("#user_cert").val()==''){
		layer.msg('���ϴ����֤��Ƭ��',2,8);return false;
	}
	layer.load('ִ���У����Ժ�...',0);return true;
}
function getyyzz(title,width,height){
	$.layer({
		type : 1,
		title :title,
		closeBtn : [0 , true], 
		offset: ['150px', ''],
		border : [10 , 0.3 , '#000', true],
		area : [width+'px',height+'px'],
		page : {dom :"#yyzz"}
	});
}
