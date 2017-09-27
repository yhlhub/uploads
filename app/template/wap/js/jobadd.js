function checkinfo(){
	var linkphone='';
	var name=$.trim($("#name").val());
	var hy=$.trim($("#hy").val());
	var pr=$.trim($("#pr").val());
	var cityid=$.trim($("#cityid").val());
	var address=$.trim($("#address").val());
	var mun=$.trim($("#mun").val());
	var phone=$.trim($("#phone").val());
	var phonetwo=$.trim($("#phonetwo").val());
	var phonethree=$.trim($("#phonethree").val());
	var linktel=$.trim($("#linktel").val());
	var linkmail=$.trim($("#linkmail").val()); 
	if(linkmail==""){
		ifemail = true;
	}else{
		ifemail = check_email(linkmail);
	}
	iflinktel = isjsMobile(linktel);
	var linkqq=$.trim($("#linkqq").val()); 
	var content=UE.getEditor('content').hasContents();
	if(phonetwo){
		if(phone==''){
			layermsg("����д���ţ�");return false;
		}
		linkphone=phone+'-'+phonetwo; 
		if(phonethree){
			linkphone=linkphone+'-'+phonethree;
		}
	}
	if(name==''){layermsg("��������ҵ���ƣ�");return false;}
	if(hy==''){layermsg("��ѡ����ҵ��ҵ��");return false;}
	if(pr==''){layermsg("��ѡ����ҵ���ʣ�");return false;}
	if(cityid==''){layermsg("��ѡ�����ڵأ�");return false;}
	if(mun==''){layermsg("��ѡ����ҵ��ģ��");return false;}
	if(address==''){layermsg("����д��˾��ַ��");return false;}
	if(linkphone==''&&linktel==''){layermsg("��ϵ�绰����ϵ�ֻ�����һ�");return false;}
	if(iflinktel==false){layermsg('����д��ȷ�ֻ����룡');return false}
	if(ifemail==false){layermsg("����д��ȷ��ʽ�������䣡");return false;}
	if(content==''||content==false){layermsg("����д��ҵ��飡");return false;}
	if(linkqq&&(linkqq.length<6||linkqq.length>12)){
		layermsg("ֻ������6-12λQQ�ţ�");return false;
	}
}
function check_email(strEmail) {
	 var emailReg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/;
	 if (emailReg.test(strEmail))
	 return true;
	 else
	 return false;
}
function checkjob(id,type){
	if(id>0){
		$.post(wapurl+"?c=ajax&a=wap_job",{id:id,type:type},function(data){
			if(type==1){
				$("#job1_son").html(data);
			}else{
				$("#job_post").html(data);
			}
		})
	}else{
		if(type==1){
			$("#job1_son").html('<option value="">��ѡ��</option>');
		}
	}
	$("#job_post").html('<option value="">��ѡ��</option>');
}
function checkcity(id,type){
	if(id>0){
		$.post(wapurl+"?c=ajax&a=wap_city",{id:id,type:type},function(data){
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
			$("#cityid").html('<option value="">��ѡ��</option>');
			$("#cityshowth").hide();
		}
	}
	$("#three_cityid").html('<option value="">��ѡ��</option>');
}
function checkfrom() {
	if($.trim($("#name").val())==""){
		layermsg("��Ƹ���Ʋ���Ϊ�գ�");return false;
	}else if($.trim($("#job1_son").val())==""){
		layermsg("��ѡ��ְλ���");return false;
	}else if($.trim($("#cityid").val())==""){
		layermsg("��ѡ�����ص㣡");return false;
	}else if($.trim($("#days").val())<1){
		layermsg("����ȷ��д��Ƹ������");return false;
	}
	var minsalary=$.trim($("#minsalary").val());
	var maxsalary=$.trim($("#maxsalary").val());
	if($("#salary_type").attr("checked")!='checked'){
	if(minsalary==""||minsalary=="0"){
		layermsg("����д���ʣ�");return false;
	}
	if(maxsalary){
		if(parseInt(maxsalary)<=parseInt(minsalary)){
			layermsg('��߹��ʱ��������͹��ʣ�');return false;
		}
	}
	}
	var description=UE.getEditor('description').hasContents();  
	if(description==""||description==false){
		layermsg("ְλ��������Ϊ�գ�");return false;
	} 
	var islink=$("input[name='islink']").val();
	if(islink==2){
		var link_man=$.trim($("input[name='link_man']").val());
		var link_moblie=$.trim($("input[name='link_moblie']").val()); 
		if(link_man==''||link_moblie==''){
			layermsg('��ϵ�˼���ϵ�绰������Ϊ�գ�');return false;
		}
		if(link_moblie&& (isjsMobile(link_moblie)==false && !isjsTell(link_moblie))){
			layermsg('��ϵ�绰��ʽ����');return false;
		}
	} 
	var isemail=$("input[name='isemail']").val();
	if(isemail=='2'){
		var email=$.trim($("input[name='email']").val());
		if(email==''){
			layermsg('���������䣡');return false;
		}else if(check_email(email)==false){
			layermsg('�������ʽ����');return false;
		} 
	}
}
function check_email(strEmail) {
	 var emailReg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	 if (emailReg.test(strEmail))
	 return true;
	 else
	 return false;
 }