function forgetpw(img){
	var username =  $.trim($("#username").val());
	if(username==""){
		layermsg('����д��ע��ʱ���û������ֻ��Ż����䣡', 2);return false;    
	}
	layer_load('ִ���У����Ժ�...');
	$.post(wapurl+"/index.php?c=forgetpw&a=checkuser",{username:username},function(data){
		layer.closeAll();
		var data=eval('('+data+')');
		var status=data.type; 
		var msg=data.msg; 
		if(status==1){
			$("#step1").hide();
			$("#step2").show();
			$("#nav2").attr("class","flowsfrist");
			$("#username_halt").html(data.username);
			if(data.email!=""){
				$("#email_halt").html(data.email);
			}else{
				$("#checkemail").hide();
			}
			if(data.moblie!=""){
				$("#moblie_halt").html(data.moblie);
			}else{
				$("#checkmoblie").hide();
			}
			$("input[name=uid]").val(data.uid);
		}else if(status==2){
			layermsg("�û��������ڣ�",2);return false;
		}else{
			layermsg(msg);return false;
		}
	});
	return true;
}
function send_str(img){
	 var username = $("#username").val();
	 var uid=$("input[name=uid]").val();
	 var sendtype=$("input[name=sendtype]:checked").val();
	 if(sendtype!="email" && sendtype!="moblie" && sendtype!="shensu"){
		 layermsg("��ѡ���һ����뷽ʽ��",2);return false;
	 }
	var authcode;
	var geetest_challenge;
	var geetest_validate;
	var geetest_seccode;
	var codesear=new RegExp('ǰ̨��¼');
	if(codesear.test(code_web)){
		if(code_kind==1){
			authcode=$.trim($("#checkcode").val());  
			if(!authcode){
				layermsg('����д��֤�룡');return false;
			}
		}else if(code_kind==3){
			geetest_challenge = $('input[name="geetest_challenge"]').val();
			geetest_validate = $('input[name="geetest_validate"]').val();
			geetest_seccode = $('input[name="geetest_seccode"]').val();
			if(geetest_challenge =='' || geetest_validate=='' || geetest_seccode==''){
				$("#popup-submit").trigger("click");
				layermsg('������ť������֤��');return false;
			}
		}
	}
	 if($.trim(username)=="") {
		layermsg('����д��ע��ʱ���û�����', 2);return false;
	 }else{
		layer_load('ִ���У����Ժ�...');
		$.post(wapurl+"/index.php?c=forgetpw&a=send",{username:username,uid:uid,authcode:authcode,sendtype:sendtype,geetest_challenge:geetest_challenge,geetest_validate:geetest_validate,geetest_seccode:geetest_seccode},function(data){
			layer.closeAll();
			var data=eval('('+data+')');
			if(data.type==1){
				if(sendtype=="shensu"){
					$("#password_cont").hide();
					$("#nav3").hide();
					$("#step2").hide();
					$("#shensu_i").html('3');
					$("#shensu_e").html('�������');
					$("#step2_shensu").show();
				}else{
					layermsg(data.msg)
					$(".password_cont").hide();
					$("#step3_"+sendtype).show();
					$("#step3_email_halt").html(data.email);
					$("#step3_moblie_halt").html(data.moblie);
					window.time=90;				
					window.timer=setInterval(function(){
						if(window.time<=0){
							clearInterval(window.timer);
							window.time=90;
							$('.step3_'+sendtype+'_timer').html('������·��ͣ���<a href="javascript:send_str();" class="password_a_dj ">�����ѻ�ȡ</a>');
						}else{
							window.time=window.time-1;
							$('.step3_'+sendtype+'_timer').html('������·��ͣ���<a href="javascript:;" class="password_a_dj ">'+window.time+' ������»�ȡ</a>');
						}
					},1000);	
				}			
			}else if(data.type==2){
				layermsg("�û��������ڣ�");
			}else{
				layermsg(data.msg);
				if(data.type==3){
					checkCode(img);
				}
			}
			return false;
		});
	 }
}
function checksendcode(){
	 var username = $("#username").val();
	 var uid=$("input[name=uid]").val();
	 var sendtype=$("input[name=sendtype]:checked").val();
	 var code=$("input[name=code_"+sendtype+"]").val();
	 if($.trim(username)=="") {
		layermsg('����д��ע��ʱ���û������ֻ��Ż����䣡', 2);return false;
	 }else{
		 layer_load('ִ���У����Ժ�...');
		$.post(wapurl+"/index.php?c=forgetpw&a=checksendcode",{username:username,uid:uid,sendtype:sendtype,code:code},function(data){
			layer.closeAll();
			var data=eval('('+data+')');			
			if(data.type=='1'){
				$(".password_cont").hide();
				$("#step4").show();
				$('.flowsteps li:eq(2)').addClass('flowsfrist');
			}else{
				layermsg(data.msg);return false;								
		    }
			return false;
		});
	 }
}
function editpw(){
	 var username = $("#username").val();
	 var uid=$("input[name=uid]").val();
	 var sendtype=$("input[name=sendtype]:checked").val();
	 var code=$("input[name=code_"+sendtype+"]").val();
	 var password=$.trim($("input[name=password]").val());
	 var passwordconfirm=$.trim($("input[name=passwordconfirm]").val());
	 if($.trim(username)=="") {
		layermsg('����д��ע��ʱ���û������ֻ��Ż����䣡', 2);return false;
	 }else if(password!=passwordconfirm){
		layermsg('�����������벻һ�£�', 2);return false;
	 }else if(password.length<6){
		layermsg('���볤�ȱ�����ڵ���6��', 2);return false;
	 }else{
		 layer_load('ִ���У����Ժ�...');
		$.post(wapurl+"/index.php?c=forgetpw&a=editpw",{username:username,uid:uid,sendtype:sendtype,code:code,password:password,passwordconfirm:passwordconfirm},function(data){
			layer.closeAll();
			var data=eval('('+data+')');
			layermsg(data.msg,2,function(){if(data.type=='1'){
				$(".password_cont").hide();
				$('.flowsteps li:eq(3)').addClass('flowsfrist');
				$("#step5").show();
			}});
			return false;
		});
	 }
}
function checklink(img){
	var username = $("#username").val();
	var linkman = $("#linkman").val();
	var linkphone = $("#linkphone").val();
	var linkemail = $("#linkemail").val();
	if(linkman==''){
		layermsg("����д��ϵ�ˣ�");return false;
	}
	if(linkphone==''){
		layermsg("����д��ϵ�绰��");return false;
	}else if(isjsMobile(linkphone)==false && isjsTell(linkphone)==false){
		layermsg("��ϵ�绰��ʽ����");return false;
	}
	var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if(linkemail==''){
	    layermsg("����д��ϵ���䣡");return false;
	}else if(!myreg.test(linkemail)){
		layermsg("�����ʽ����");return false;
	}
	var sendtype=$("input[name=sendtype]:checked").val();
	$.post(wapurl+"/index.php?c=forgetpw&a=checklink",{username:username,linkman:linkman,linkphone:linkphone,linkemail:linkemail,sendtype:sendtype},function(data){
			var data=eval('('+data+')');
			if(data.type==1){
				$(".password_cont").hide();
				$("#nav3").hide();
				$("#shensu_i").html('3');
				$("#shensu_e").html('�������');
				$('.flowsteps li:eq(3)').addClass('flowsfrist');
				$("#finish").show();
			}else{
				checkCode(img);
			}
	});
}