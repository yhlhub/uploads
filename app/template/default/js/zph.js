function showyuding(id){
	$(".order_two").hide();
	$("#showstatus"+id).show();
}
function hideyuding(id){
	$("#showstatus"+id).hide();
}
$(document).ready(function(){
	$(".fairs_disp_position").hover(function(){
		var aid=$(this).attr("aid");
		$(this).addClass("zph_popup");
		$(".order_two").hide();
		$("#showstatus"+aid).show();
	},function(){
		
		var aid=$(this).attr("aid");
		$(this).removeClass("zph_popup");
		$("#showstatus"+aid).hide();
	})   
})
function clickzph(id,zid,price){ 
	var usertype=$("#usertype").val();
	if(usertype>0){
		if(usertype!=2){
			layer.msg("ֻ����ҵ�û��ſ���Ԥ��չλ��",2,8);return false;
		}
	}else{
		showlogin('2');return false;
	} 
	var stime=$("#zph_stime").val();
	var etime=$("#zph_etime").val();
	if(stime<'0' && etime>'0'){
		layer.msg('��Ƹ���Ѿ���ʼ��', 2,8);return false;
	}else if(etime<'0'){
		layer.msg("��Ƹ���Ѿ�������", 2,8);return false;
	} 
	layer.load('ִ���У����Ժ�...',0);
	$.post(weburl+"/index.php?m=ajax&c=ajaxzphjob",{zid:zid,id:id},function(data){
		layer.closeAll();
		var data=eval('('+data+')');
		if(data.status=='1'){
			layer.msg(data.msg,3,8);
		}else if(data.html){ 
		    layer.confirm(data.msg,function(){
				if(data.addjobnum=='1'){
					$("#zphaddjob").html('<a href="'+weburl+'/member/index.php?c=jobadd" class="Corporate_box_tj" target="_blank">����ְλ</a>');
				}else{
					$("#zphaddjob").html('<a href="javascript:void(0)"  onclick="jobaddurl(\''+data.addjobnum+'\',\''+data.integral_job+'\',\''+data.integral_pricename+'\')" class="Corporate_box_tj">����ְλ</a>');
				}
				$("#joblist").html(data.html);
				$("#bid").val(id);
				$("#zph_price").html(price);
				layer.closeAll();
				$.layer({
					type : 1,
					title :'Ԥ����Ƹ��', 
					offset: [($(window).height() - 300)/2 + 'px', ''],
					closeBtn : [0 , true],
					border : [10 , 0.3 , '#000', true],
					area : ['380px','345px'],
					page : {dom :"#TB_window"}
				}); 
			});
		}
	}) 
}
function jobaddurl(num,integral_job,integral_pricename){ 
	if(num==0){
		var msg='�ײ������꣬���ȹ����Ա��<br>��������<a href="'+weburl+'/member/index.php?c=right&act=added" style="color:red;">������ֵ��</a>��';
		layer.confirm(msg, function(){ 
			window.open(weburl+'/index.php?c=right');  
		});
	}else if(num==2){
		var msg='�ײ������꣬������������۳�'+integral_job+' '+integral_pricename+'����������<a href="'+weburl+'/member/index.php?c=right&act=added" style="color:red">������ֵ��</a>���Ƿ������';
		layer.confirm(msg, function(){
			window.open(weburl+'/member/index.php?c=jobadd');   
		});
	}
}

function submitzph(){
	var bid=$("#bid").val();
	var zid=$("#zid").val();
	var jobid=get_comindes_jobid();
	layer.load('ִ���У����Ժ�...',0);
	$.get(weburl+"/index.php?m=ajax&c=zphcom&bid="+bid+"&zid="+zid+"&jobid="+jobid, function(data){
		var data=eval('('+data+')');
		var status=data.status;
		var content=data.content;
		layer.closeAll();
		if(status==0){
			layer.msg(content, 2,8);
		}else{
			layer.msg(content, 2,9,function(){location.reload();});
		} return false;
	})
}