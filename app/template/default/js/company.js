function notuser(){
	$.layer({
		type : 1,
		title :'��վ��ʾ',  
		area : ['350px','auto'],
		page : {dom :"#notuser"}
	}); 
}
function switching(url){
	layer.closeAll();
	$.get(url,function(msg){
		if(msg==1 || msg.indexOf('script')){
			if(msg.indexOf('script')){
				$('#uclogin').html(msg);
			}
			layer.msg('���ѳɹ��˳���', 2, 9,function(){showlogin('1')});
		}else{
			layer.msg('�˳�ʧ�ܣ�', 2, 8,function(){location.reload();});
		}
	});
}
function applyjobuid(){
	$.layer({
		type : 1,
		fix: false,
		maxmin: false,
		shadeClose: true,
		title :'��������ְλ', 
		offset: [($(window).height() - 550)/2 + 'px', ''],
		closeBtn : [0 , true], 
		area : ['520px','530px'],
		page : {dom :"#applydiv"}
	})
}
function OnLogin(){
    layer.closeAll();
	showlogin('1');
}
function checkaddresume(url){  
    var jobid= $.trim($("#jobid").val());
	var name=$.trim($("#uname").val())+"���˼���";
	var uname=$.trim($("#uname").val());
	var sex=$("#sex").val();
	var birthday=$.trim($("#birthday").val());
	var edu=$.trim($("#educid").val());
	var exp=$.trim($("#expid").val());
	var telphone=$.trim($("#telphone").val());
	var email=$.trim($("#email").val());
	var type=$.trim($("#typeid").val());
	var report=$.trim($("#reportid").val());
	
	if(uname==""){
		parent.layer.msg("����д��ʵ������",2,8);return false;
	}
	if(sex==""){
		parent.layer.msg("����д�Ա�",2,8);return false;
	}
	if(edu==""){
		parent.layer.msg("��ѡ�����ѧ����",2,8);return false;
	}
	if(exp==""){
		parent.layer.msg("��ѡ�������飡",2,8);return false;
	}
	if(type==""){
		parent.layer.msg("��ѡ�������ʣ�",2,8);return false;
	}
	if(report==""){
		parent.layer.msg("��ѡ�񵽸�ʱ�䣡",2,8);return false;
	}
	if(telphone==''){
		parent.layer.msg("����д�ֻ����룡",2,8);return false;
	}else{
		
	  var reg= /^[1][34578]\d{9}$/; 
		 if(!reg.test(telphone)){
			parent.layer.msg("�ֻ������ʽ����",2,8);return false;
		 }else{
			var returntype;
			$.ajax({ 
				async: false, 
				type : "POST", 
				url : weburl+"/index.php?m=register&c=regmoblie", 
				dataType : 'text', 
				data:{'moblie':telphone},
				success : function(data) {
					if(data!=0){
						returntype=1;
					}
				} 
			});
			if(returntype==1){
				parent.layer.msg("�ֻ������ѱ�ʹ�ã�",2,8);return false;
			}
		 }
	}
	var jobload=parent.layer.load('�����У����Ժ�...',0);
	$.post(url,{name:name,uname:uname,sex:sex,birthday:birthday,edu:edu,exp:exp,telphone:telphone,email:email,type:type,report:report,jobid:jobid},function(data){ 
		layer.closeAll(); 
		if(data>0){ 
			$("#resumeid").val(data);
			$.layer({
				type : 1,
				title :'����ע��', 
				offset: [($(window).height() - 550)/2 + 'px', ''],
				closeBtn : [0 , true],
				border : [10 , 0.3 , '#000', true],
				area : ['400px','280px'],
				page : {dom :"#userregdiv"}
			}); 
		}else{ 
			parent.layer.msg(data,2,8);return false;
		}
	})
}
function checkreg(img,url){
	var password=$("#reg_password").val();
	var authcode=$("#reg_authcode").val();
	var resumeid=$("#resumeid").val();
	var jobid=$("#jobid").val();
	if(password==""){
		parent.layer.msg("���������룡",2,8);return false;
	}else if(password.length<6 || password.length>20 ){
		parent.layer.msg("������6��20λ���룡",2,8);return false;
	}
	if(authcode==""){
		parent.layer.msg("��������֤�룡",2,8);return false;
	}
	var loadi=layer.load('�����У����Ժ�...',0);
	$.post(url,{password:password,authcode:authcode,resumeid:resumeid,jobid:jobid},function(data){
		layer.close(loadi);  
		if(data==1){
			parent.layer.msg('����ɹ���', 2, 9,function(){parent.location.reload();}); 
		}else if(data==3){
			parent.layer.msg("��֤�����!",2,8,function(){checkCode(img);}); 
		}else{
			parent.layer.msg("����ʧ��!", 2, 8,function(){parent.location.reload();}); 
		}
	})
}
function ckjobreg(id){
	var telphone=$.trim($("#telphone").val());
	var email=$.trim($("#email").val());
	if(id==1){
		if(telphone==''){
			parent.layer.msg("����д�ֻ����룡",2,8);return false;
		}else{
			 var reg= /^[1][34578]\d{9}$/; 
			 if(!reg.test(telphone)){
				parent.layer.msg("�ֻ������ʽ����",2,8);return false;
			 }else{
				 $.post(weburl+"/index.php?m=register&c=regmoblie",{moblie:telphone},function(data){
					if(data!=0){	
						parent.layer.msg("�ֻ������ѱ�ʹ�ã�",2,8);return false;
					}
				});	
			 }
		}
	}else{
		if(email==''){
			parent.layer.msg("����д��ϵ���䣡",2,8);return false;
		}else{
			var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		   if(!myreg.test(email)){
				parent.layer.msg("�����ʽ����",2,8);return false; 
		   }else{
			   $.post(weburl+"/index.php?m=register&c=ajaxreg",{email:email},function(data){
					if(data!=0){
						parent.layer.msg("�����ѱ�ʹ�ã�",2,8);return false;
					}
				});	
		   }
		}
	}
}