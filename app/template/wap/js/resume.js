function show_div(id){
	$("#"+id).show();
}
function checkcity(id,type){
	if(id>0){
		$.post(wapurl+"/index.php?c=ajax&a=wap_city",{id:id,type:type},function(data){ 
			if(type==1){
				$("#cityid").html(data);
				$("#cityshowth").hide();
			}else{
				if(data){
					$("#cityshowth").attr('style','width:31%;');
					$("#three_cityid").html(data);
				}
			}
		})
	}else{
		if(type==1){
			$("#cityshowth").hide();
			$("#cityid").html('<option value="">��ѡ��</option>');
		}
	}
	$("#three_cityid").html('<option value="">��ѡ��</option>');
}
function checkinfo() {
	var name=$.trim($("input[name='name']").val());
	var sex=$.trim($("#sex").val());
	var birthday=$.trim($("input[name='birthday']").val());
	var edu=$.trim($("#edu").val());
	var exp=$.trim($("#exp").val());	
	var email=$.trim($("#email").val());
	var telphone=$.trim($("#telphone").val());
	var living=$.trim($("input[name='living']").val());
	var description=$.trim($("#description").val());
	if(email==""){
		ifemail = true;
	}else{
		ifemail = check_email(email);
	}
	iftelphone = isjsMobile(telphone);
	if(name==""){layermsg('����д������');return false;}
	if(sex==""){layermsg('��ѡ���Ա�');return false;}
	if(birthday==""){layermsg('����д�������£�');return false;}		
	if(edu==""){layermsg('��ѡ�����ѧ����');return false;}
	if(exp==""){layermsg('��ѡ�������飡');return false;}
	if($("#user_idcard").val()==1){
		 ifidcard = isIdCardNo(idcard);
		 if(ifidcard==false){layermsg('����ȷ��д���֤���룡');return false;}
	}	
	if(iftelphone==false){layermsg('����ȷ��д�ֻ����룡');return false;}
	if(living==""){layermsg('����д�־�ס�أ�');return false;}
	if(ifemail==false){layermsg('����д��ȷ��ʽ�����ʼ���');return false;}
	var returntype=false;
	$.ajax({ 
		async: false, 
		type : "POST", 
		url : "index.php?c=get_email_moblie", 
		dataType : 'json', 
		data:{'moblie':telphone,'email':email},
		success : function(data) {
			if(data.msg==1){
				returntype=true;
			}else{
				layermsg(data.msg);return false;
			}
		} 
	});
	return returntype;
}
function kresume(){	
    var name=$.trim($("input[name='name']").val());
    var hy=$.trim($("#hy").val());
	var job_classid=$.trim($("#job_classid").val());
	var provinceid=$.trim($("#provinceid").val());
	var cityid=$.trim($("#cityid").val());
	var three_cityid=$.trim($("#three_cityid").val());
	var minsalary=$.trim($("#minsalary").val());
	var maxsalary=$.trim($("#maxsalary").val());
	var report=$.trim($("#report").val());
	var type=$.trim($("#type").val());
	var jobstatus=$.trim($("#jobstatus").val());
	var uname=$.trim($("input[name='uname']").val());
	var sex=$.trim($("#sex").val());
	var birthday=$.trim($("#birthday").val());
	var edu=$.trim($("#edu").val());
	var exp=$.trim($("#exp").val());
	var telphone=$.trim($("#telphone").val());
	var email=$.trim($("#email").val());
	var living=$.trim($("#living").val());
	
	if(name==""){
		layermsg('����д�������ƣ�');return false;
	}
	if(hy==""){
		layermsg('��ѡ�������ҵ��');return false;
	}
	if(job_classid==""){
		layermsg('��ѡ������ְλ��');return false;
	}
	if(minsalary==""){
		layermsg('����д����н�ʣ�');return false;
	}
	if(maxsalary){
		if(parseInt(maxsalary)<=parseInt(minsalary)){
			layermsg('���н�ʱ���������н�ʣ�');return false;
		}
		
	}
	if(cityid==""){
		layermsg('��ѡ���������У�');return false;
	}
	if(type==""){
		layermsg('��ѡ�������ʣ�');return false;
	}
	if(report==""){
		layermsg('��ѡ�񵽸�ʱ�䣡');return false;
	}
	if(jobstatus==""){
		layermsg('��ѡ����ְ״̬��');return false;
	}		
	if(uname==""){
		layermsg("����д��ʵ������",2,8);return false;
	}
	if(sex==''){
		layermsg("��ѡ���Ա�",2,8);return false;
	}
	if(birthday==''){
		layermsg("��ѡ��������£�",2,8);return false;
	}
	if(edu==''){
		layermsg("��ѡ�����ѧ����",2,8);return false;
	}
	if(exp==''){
		layermsg("��ѡ�������飡",2,8);return false;
	}
	if(telphone==''){
		layermsg("����д�ֻ����룡",2,8);return false;
	}else{
	  var reg= /^[1][34578]\d{9}$/;
		 if(!reg.test($('#telphone').val())){
			layermsg("�ֻ������ʽ����",2,8);return false;
		 }
	}
	var myreg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	if(email!="" && !myreg.test($('#email').val())){
		layermsg("�����ʽ����",2,8);return false;
		return false;
	}
	if(living==''){
		layermsg("��ѡ���־�ס�أ�",2,8);return false;
	}
	var layerIndex=layer.open({
		type: 2,
		content: 'Ŭ��������'
	});
	$.post(wapurl + "/member/index.php?c=kresume", {name:name,hy:hy,job_classid:job_classid,provinceid:provinceid,cityid:cityid,three_cityid:three_cityid,minsalary:minsalary,maxsalary:maxsalary,report:report,type:type,jobstatus:jobstatus,uname:uname,sex:sex,birthday:birthday,edu:edu,exp:exp,email:email,telphone:telphone,living:living}, function (data) {
		layer.close(layerIndex);
		if(data==1){
			layermsg('����ɹ���',2,function(){window.location.href='index.php?c=resume';}); 
		}else if(data==2){
			layermsg('�ֻ��Ѵ��ڣ�');
		}else if(data==3){
			layermsg('�����Ѵ��ڣ�');
		}else if(data==4){
			layermsg('��ļ������Ѿ�����ϵͳ���õļ������ˣ�',2,function(){window.location.href='index.php?c=resume';});
		}else if(data==5){
			layermsg('���ȵ�¼���Կͻ�����������֤��');
		}else if(data==6){
			layermsg('�뽫��Ϣ��д������');
		}else if(data==7){
			layermsg('���н�ʱ���������н�ʣ�');
		}else{
			layermsg('����ʧ�ܣ�');
		}
	})
}
function convertFormToJson(formid){
	var elements=$("#"+formid).find("*");	
	var str = '';
	for(var i=0;i<elements.length;i++){
		if($(elements).eq(i).attr("name")){ 
			str=str+","+$(elements).eq(i)[0].name+':"'+$(elements).eq(i)[0].value+'"';
		}
	}
	if(str.length>0){
		str=str.substring(1);
	}
	var cToObj=eval("({"+str+"})");
	return cToObj;
}
function check_email(strEmail) {
	 var emailReg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/;
	 if (emailReg.test(strEmail))
	 return true;
	 else
	 return false;
 }
function checkshow(id){
	if(id=="expect"){
		$("#infobutton").show();
		$("#info").hide();
	}else if(id=="info"){
		$("#expectbutton").show();
		$("#expect").hide();
	}
	$("#"+id+"button").hide();
	$("#"+id).show();
} 
function saveexpect(){
	var hy=$.trim($("#hy").val());
	var job_classid=$.trim($("#job_classid").val());
	var provinceid=$.trim($("#provinceid").val());
	var cityid=$.trim($("#cityid").val());
	var three_cityid=$.trim($("#three_cityid").val());
	var minsalary=$.trim($("#minsalary").val());
	var maxsalary=$.trim($("#maxsalary").val());
	var report=$.trim($("#report").val());
	var type=$.trim($("#type").val());
	var jobstatus=$.trim($("#jobstatus").val());
	var eid=$.trim($("#eid").val());
	if(job_classid==""){
		layermsg('��ѡ������ְλ��');return false;
	}
	if(provinceid==""){
		layermsg('��ѡ���������У�');return false;
	}
	if(minsalary==""||minsalary=="0"){
		layermsg('����д����н�ʣ�');return false;
	}
	if(maxsalary&&parseInt(maxsalary)<=parseInt(minsalary)){
		layermsg('���н�ʱ���������н�ʣ�');return false;
	}
	var layerIndex=layer.open({
		type: 2,
		content: 'Ŭ��������'
	});
	$.post(wapurl + "/member/index.php?c=expect", {hy: hy, job_classid: job_classid, provinceid: provinceid, cityid: cityid, three_cityid: three_cityid, minsalary: minsalary, maxsalary: maxsalary, report: report,type:type,jobstatus:jobstatus,eid: eid }, function (data) {
		layer.close(layerIndex);
		if(data>0){
			layermsg('����ɹ���',2,function(){window.location.href='index.php?c=modify&eid='+eid;}); 
		}else{
			layermsg('����ʧ�ܣ�');
		}
	})
}

function checkskill(){
	var name=$.trim($("input[name='name']").val());
	var longtime=$.trim($("input[name='longtime']").val());
	if(name==""){
		layermsg('����д�������ƣ�');return false;
	}
	if(longtime==""||longtime=="0"){
		layermsg('����д����ʱ�䣡');return false;
	}
}
function checkdesc(){
	var desc=$.trim($("#description").val());
	if(desc==""){
		layermsg('����д�������ۣ�');return false;
	}
	var layerIndex=layer.open({
		type: 2,
		content: 'Ŭ��������'
	});
	$.post(wapurl + '/member/' + $("#descInfo").attr("action"), convertFormToJson("descInfo"), function (data) {
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}
function toDate(str){
    var sd=str.split("-");
    return new Date(sd[0],sd[1]);
}
function checkwork(){
	var name=$.trim($("input[name='name']").val());
	var sdate=$.trim($("input[name='sdate']").val()); 
	var edate=$.trim($("input[name='edate']").val()); 
	var title=$.trim($("input[name='title']").val());
	var content=$.trim($("textarea[name='content']").val());
	if(name==""){
		layermsg('����д��λ���ƣ�');return false;
	}
	if(sdate==""){
		layermsg('��ѡ����ְʱ�䣡');return false;
	}else if(edate){
		var st=toDate(sdate);
		var ed=toDate(edate);
		if(st>ed){ 	
			layermsg('��ȷ�������Ⱥ�˳��');return false;
		}
	}
	if(edate=="" && document.getElementById("ckendday").checked == false){
		layermsg('��ѡ����ְʱ�䣡');return false;
	}
	var layerIndex=layer.open({
		type: 2,
		content: 'Ŭ��������'
	});
	$.post(wapurl + '/member/' + $("#workInfo").attr("action"), convertFormToJson("workInfo"), function (data) {
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}
function checkproject(){
	var name=$.trim($("input[name='name']").val());
	var sdate=$.trim($("input[name='sdate']").val()); 
	var edate=$.trim($("input[name='edate']").val()); 
	var title=$.trim($("input[name='title']").val());
	var content=$.trim($("textarea[name='content']").val());
	if(name==""){
		layermsg('����д��Ŀ���ƣ�');return false;
	}
	if(sdate==""||edate==""){
		layermsg('����ȷ��д��Ŀʱ�䣡');return false;
	}
	if(edate){
		var st=toDate(sdate);
		var ed=toDate(edate);
		if(st>ed){ 	
			layermsg('��ȷ�������Ⱥ�˳��');return false;
		}
	}
	var layerIndex=layer.open({
		type: 2,
		content: 'Ŭ��������'
	});
	$.post(wapurl + '/member/' + $("#projectInfo").attr("action"), convertFormToJson("projectInfo"), function (data) {
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}
function checkedu(){
	var name=$.trim($("input[name='name']").val());
	var sdate=$.trim($("input[name='sdate']").val()); 
	var edate=$.trim($("input[name='edate']").val()); 
	var education=$.trim($("#education").val());
	var title=$.trim($("input[name='title']").val());
	var specialty=$.trim($("input[name='specialty']").val());
	if(name==""){
		layermsg('����дѧУ���ƣ�');return false;
	}
	if(sdate==""||edate==""){
		layermsg('����ȷ��д��Уʱ�䣡');return false;
	}
	if(edate){
		var st=toDate(sdate);
		var ed=toDate(edate);
		if(st>ed){ 	
			layermsg('��ȷ�������Ⱥ�˳��');return false;
		}
	}
	var layerIndex=layer.open({
		type: 2,
		content: 'Ŭ��������'
	});
	$.post(wapurl+'/member/'+$("#eduInfo").attr("action"),convertFormToJson("eduInfo"),function(data){
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}
function checktraining(){
	var name=$.trim($("input[name='name']").val());
	var sdate=$.trim($("input[name='sdate']").val()); 
	var edate=$.trim($("input[name='edate']").val()); 
	var title=$.trim($("input[name='title']").val());
	var content=$.trim($("textarea[name='content']").val());
	if(name==""){
		layermsg('����д��ѵ���ģ�');return false;
	}
	if(sdate==""||edate==""){
		layermsg('����ȷ��д��ѵʱ�䣡');return false;
	}
	if(edate){
		var st=toDate(sdate);
		var ed=toDate(edate);
		if(st>ed){ 	
			layermsg('��ȷ�������Ⱥ�˳��');return false;
		}
	}
	var layerIndex=layer.open({
		type: 2,
		content: 'Ŭ��������'
	});
	$.post(wapurl + '/member/' + $("#trainingInfo").attr("action"), convertFormToJson("trainingInfo"), function (data) {
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}
function checkcert(){
	var name=$.trim($("input[name='name']").val());
	var sdate=$.trim($("input[name='sdate']").val()); 
	var edate=$.trim($("input[name='edate']").val()); 
	var title=$.trim($("input[name='title']").val());
	var content=$.trim($("textarea[name='content']").val());
	if(name==""){
		layermsg('����д֤��ȫ�ƣ�');return false;
	}
	if(sdate==""){
		layermsg('����д֤��䷢ʱ�䣡');return false;
	}
	if(title==""){
		layermsg('����д�䷢��λ��');return false;
	}
	if(content==""){
		layermsg('����д֤��������');return false;
	}
	var layerIndex=layer.open({
		type: 2,
		content: 'Ŭ��������'
	});
	$.post(wapurl + '/member/' + $("#certInfo").attr("action"), convertFormToJson("certInfo"), function (data) {
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}
function checkother(){
	var name=$.trim($("input[name='name']").val());
	var content=$.trim($("textarea[name='content']").val());
	if(name==""){
		layermsg('����д�������⣡');return false;
	}
	var layerIndex=layer.open({
		type: 2,
		content: 'Ŭ��������'
	});
	$.post(wapurl + '/member/' + $("#otherInfo").attr("action"), convertFormToJson("otherInfo"), function (data) {
		layer.close(layerIndex);
		var jsonData=eval("("+data+")"); 
		if(jsonData.url){
			layermsg(jsonData.msg,2,function(){window.location.href=jsonData.url;}); 
		}else{
			layermsg(jsonData.msg);
		}
	});
	return false;
}
function ckresume(type){
	var val=$("#"+type).find("option:selected").text(); 
	$('.'+type).html(val); 
}
function check_show(id){
	$('#'+id).toggle();
}
function ckenddays(id){ 
	if($("#ckendday").attr("checked")=='checked'){
		$('#'+id).val('');
	}
}
$(function(){
	$(".changetag").live('click',function(){
		
		var tag=$(this).attr('tag-class');
		if(tag=='1'){
			$(this).addClass('resume_pop_bq_cur');
			$(this).attr('tag-class','2');
		}else{
			$(this).removeClass('resume_pop_bq_cur');
			$(this).attr('tag-class','1');
		}
		var tag_value;
		var tagi = 0;
		$(".resume_pop_bq_cur").each(function(){
			if($(this).attr('tag-class')=='2'){
				var info =$(this).attr("data-tag");
		        tag_value+=","+info;
				tagi++;

			}
		});
		if(tagi>5){
			layermsg('���ֻ��ѡ�����', 2,8);
			if(tag=='1'){
				$(this).removeClass('resume_pop_bq_cur');
			}
			return false;
		}
		if(tag_value){ 
		    tag_value = tag_value.replace("undefined,","");
		    $("#tag").val(tag_value); 
	    }else{
			$("#tag").val(''); 
		}
	});
	$('.checkboxAddBton').click(function(){

		var ntag = $('#addfuli').val();
		var tagid = $('#tag').val();
		if(tagid && tagid.split(',').length>=5){

			layermsg('���ֻ��ѡ�����', 2,8);
		}else{
			var error=0;
			if(ntag.length>=2 && ntag.length<=8){
				$('.changetag').each(function(){
					var otag = $(this).attr('data-tag');
					if(ntag == otag){
						layermsg('��ͬ��ǩ�Ѵ��ڣ���ѡ���������д��', 2,8);
						error = 1;
					}
				});
				if(error==0){
					$('.resume_pop_bq ul').append('<li class="changetag  resume_pop_bq_cur" data-tag="'+ntag+'" tag-class="2"><em>'+ntag+'</em></li>');
					
					var tag_value;
					$(".resume_pop_bq_cur").each(function(){
						if($(this).attr('tag-class')=='2'){
							var info =$(this).attr("data-tag");
							tag_value+=","+info;
						}
					});
					tag_value = tag_value.replace("undefined,","");
					$("#tag").val(tag_value); 
				}
				$('#addfuli').val('');
				
			}else{
				layermsg('������2-8����ǩ�ַ���', 2,8);
			}
		}
	});
});