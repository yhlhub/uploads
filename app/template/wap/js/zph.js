
$(document).ready(function(){
	$(".fairs_disp_position").hover(function(){
		var aid=$(this).attr("aid");
		content=$("#showstatus"+aid).html();
		$("#showstatus"+aid).show();		
	},function(){
		var aid=$(this).attr("aid");
		content=$("#showstatus"+aid).html();
		$("#showstatus"+aid).hide();
	})   
});
function clickzph(id,zid,price){ 
	var usertype=$("#usertype").val();
	if(usertype>0){
		if(usertype!=2){
			layermsg("ֻ����ҵ�û��ſ���Ԥ��չλ��");return false;
		}
	}
	var stime=$("#zph_stime").val();
	var etime=$("#zph_etime").val();
	if(stime<'0' && etime>'0'){
		layermsg('��Ƹ���Ѿ���ʼ��');return false;
	}else if(etime<'0'){
		layermsg("��Ƹ���Ѿ�������");return false;
	} 
	layer_load('ִ���У����Ժ�...');
	$.post(wapurl+"/index.php?c=ajax&a=ajaxzphjob",{zid:zid,id:id},function(data){
		layer.closeAll();
		var data=eval('('+data+')');
		if(data.status=='1'){
			layermsg(data.msg);
		}else if(data.html){ 
			if(data.addjobnum=='1'){
				$("#zphaddjob").html('<a href="'+wapurl+'member/index.php?c=jobadd" class="Corporate_box_tj" target="_blank">����ְλ</a>');
			}else{
				$("#zphaddjob").html('<a href="javascript:void(0)"  onclick="jobaddurl(\''+data.addjobnum+'\',\''+data.integral_job+'\',\''+data.integral_pricename+'\')" class="Corporate_box_tj">����ְλ</a>');
			}
			$("#joblist").html(data.html);
			$("#bid").val(id);
			$("#zph_price").html(price);
			content=$("#TB_window").html();
			$("#TB_window").html('');
			layer.open({
				type : 1,
				title :'Ԥ����Ƹ��', 
				closeBtn : [0 , true],
				area : ['320px','308px'],
				content:content,
				cancal:$("#TB_window").html(content)
			}); 
		}
	}) 
}
function jobaddurl(num,integral_job,integral_pricename){ 
	if(num==0){
		var msg='�ײ������꣬���ȹ����Ա��';
		layer.open({
			content: msg,
			btn: ['ȷ��', 'ȡ��'],
			yes: function(){location.href=wapurl+'/index.php?c=rating';}
		});
	}else if(num==2){
		var msg='�ײ������꣬������������۳�'+integral_job+' '+integral_pricename+'���Ƿ������';
		layer.open({
			content: msg,
			btn: ['ȷ��', 'ȡ��'],
			yes: function(){location.href=wapurl+'/member/index.php?c=jobadd';}
		});
	}
}
function submitzph(){
	var bid=$("#bid").val();
	var zid=$("#zid").val();
	var jobid=get_comindes_jobid();
	layer_load('ִ���У����Ժ�...');
	$.get(wapurl+"/index.php?c=ajax&a=zphcom&bid="+bid+"&zid="+zid+"&jobid="+jobid, function(data){
		var data=eval('('+data+')');
		var status=data.status;
		var content=data.content;
		layer.closeAll();
		if(status==0){
			layermsg(content);
		}else{
			layermsg(content,2,function(){location.reload();});
		} return false;
	})
}
function get_comindes_jobid(){
	var codewebarr="";
	$("input[name=checkbox_job]:checked").each(function(){
		if(codewebarr==""){codewebarr=$(this).val();}else{codewebarr=codewebarr+","+$(this).val();}
	});
	return codewebarr;
}