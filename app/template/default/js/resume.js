
$(document).ready(function(){ 
	$("input[name='background_type']").click(function(){
		if($(this).val()=='1'){
			$(".resume_background_color").hide();
			$(".resume_background_image").show();
		}else if($(this).val()=='2'){
			$(".resume_background_image").hide();
			$(".resume_background_color").show();
		}else{
			$(".resume_background_color").show();
			$(".resume_background_image").show();
		}
	});
})

function for_link(eid,url,todown){
	var i=layer.load('ִ���У����Ժ�...',0);
	$.post(url,{eid:eid},function(data){
		layer.closeAll();
		var data=eval('('+data+')');
		var status=data.status;
		if(status==1){
			var i =$.layer({ 
				area:['auto','auto'],
				dialog:{
					msg:'����ְλ��ſ������ؼ���',
					btns:2,
					type:4,
					btn:['ǰȥ����','�������'],
					yes:function(){window.location.href=weburl+"/member/index.php?c=jobadd";window.event.returnValue = false;return false;},
					no:function(){layer.close(i);window.location.href=window.location.href;}
				}
			});
		}else if(status==2){
			if(data.usertype=='2'){
				layer.confirm(data.msg, function(){layer.closeAll();down_integral(eid,data.uid,downurl);});
			}
		}else if(status==3){ 
			if(todown){ 
				$("#for_link .btn").hide();
			    window.location.href =todown;
			} 
			$("#for_link .city_1").html(data.html);
			$.layer({
				type : 1,
				title : "�鿴��ϵ��ʽ", 
				offset: [($(window).height() - 150)/2 + 'px', ''],
				closeBtn : [0 , true],
				border : [10 , 0.3 , '#000', true],
				area : ['350px','auto'],
				page : {dom :"#for_link"}
			});
		}else if(status==4){
			layer.confirm(data.msg, function(){showpacklist();});
		}else if(status==5){
			if(todown){ 
				$("#for_link .btn").hide();
			    window.location.href =todown;
			} 
		}  
	});
}
function showpacklist(){
	$.post(weburl+"/index.php?m=ajax&c=getrating",{},function(data){
		$("#ratinglist").html(data);
		layer.closeAll();
		$.layer({
			type : 1,
			title : "������ֵ��", 
			offset: ['10px', ''],
			closeBtn : [0 , true],
			border : [10 , 0.3 , '#000', true],
			area : ['540px','auto'],
			page : {dom :"#packlist"}
		});
	})
}
function checkpack(){
	var comvip=$("input[name=comvip]:checked").val();
	if(comvip>0){
		return true;
	}else{
		layer.msg("����ѡ����ֵ����",2,8);return false;
	}
}
function check_comvip(price){
	$(".Download_resume_tips_f").html("��"+price);
	$(".Download_resume_tips_jine").show();
}

function down_integral(eid,uid,url){
	$.post(url,{type:"integral",eid:eid,uid:uid},function(data){ 
		var data=eval('('+data+')');
		var status=data.status;
		var integral=data.integral;
		if(status==5){
			layer.confirm('������'+integral+integral_pricename+'���������ؼ������Ƿ��ֵ��', function(){window.location.href =weburl+"/member/index.php?c=pay";window.event.returnValue = false;return false; }); 
		}else if(status==3 || status==6){
			$("#for_link .city_1").html(data.html);
			$.layer({
				type : 1,
				title : "�鿴��ϵ��ʽ", 
				offset: [($(window).height() - 150)/2 + 'px', ''],
				closeBtn : [0 , true],
				border : [10 , 0.3 , '#000', true],
				area : ['350px','auto'],
				page : {dom :"#for_link"}
			});
		}else{
			layer.msg(data.msg, 2, 8);return false;
		}
	})
}

function settemplate(msg,url){ 
	layer.confirm(msg, function(){
		var i=layer.load('ִ���У����Ժ�...',0);
		$.ajaxSetup({cache:false});
		$.get(url,function(data){
			layer.close(i);
			var data=eval('('+data+')');
			if(data.st=='8'){
				layer.msg(data.msg, Number(data.tm), Number(data.st),function(){layer.closeAll();});return false;	 
			}else{
				layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.href=data.url;});return false;
			}
		});
	}); 
}
function add_user_talent(uid,usertype){
	if(usertype=="2"){
		$.layer({
			type : 1,
			title : "��ӱ�ע", 
			closeBtn : [0 , true],
			border : [10 , 0.3 , '#000', true],
			area : ['380px','200px'],
			page : {dom :"#talent_pool_beizhu"}
		});
	}else if(usertype==""){
		showlogin('2');
	}else{
		layer.msg('ֻ����ҵ�û����ſ��Բ�����',2,8);return false;
	}
}
function talent_pool(uid,eid,url){
	var remark=$("#remark").val();
	$.post(url,{eid:eid,uid:uid,remark:remark},function(data){
		if(data=='0'){
			layer.msg('ֻ����ҵ�û����ſ��Բ�����',2,8);
		}else if(data=='1'){
			layer.msg('����ɹ���',2,9,function(){layer.closeAll();location.reload();});
		}else if(data=='2'){
			layer.msg('�ü����Ѽ��뵽�˲ſ⣡',2,8,function(){layer.closeAll();});
		}else{
			layer.msg('�Բ��𣬲�������',2,8);
		}
	});
}
function addjob(){
	var i =$.layer({ 
				area:['auto','auto'],
				dialog:{
					msg:'����ְλ��ſ������ؼ���',
					btns:2,
					type:4,
					btn:['ǰȥ����','�������'],
					yes:function(){window.location.href=weburl+"/member/index.php?c=jobadd";window.event.returnValue = false;return false;},
					no:function(){layer.close(i);window.location.href=window.location.href;}
				}
			});
}
function dayin(){
	$("#operation_box").hide();
	window.print();
}