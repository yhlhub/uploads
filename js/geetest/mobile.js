$(document).ready(function(){


var handlerPopupMobile = function (captchaObj) {
	// �ɹ��Ļص�
	captchaObj.appendTo("#popup-captcha-mobile");

	captchaObj.onSuccess(function () {
		
		var validate = captchaObj.getValidate();
		
		if(validate){
			
			$("input[name='geetest_challenge']").val(validate.geetest_challenge);
			$("input[name='geetest_validate']").val(validate.geetest_validate);
			$("input[name='geetest_seccode']").val(validate.geetest_seccode);

			//$("#mask, #popup-captcha-mobile").hide();

			//�ύ����
			var type = $('#popup-captcha-mobile').attr('data-type');
			var dataid = $('#popup-captcha-mobile').attr('data-id');
			//�ύ��
			if(type=='submit'){
				//$('#'+dataid).submit();
			}else{
				//ģ����
				//$("#"+dataid).trigger("click");
			}
		}

	});
	$("#popup-submit").click(function(){
		$("input[name='geetest_challenge']").val('');
		$("input[name='geetest_validate']").val('');
		$("input[name='geetest_seccode']").val('');
		captchaObj.reset();
	});
	
	
	
	// ����ӿڲο���http://www.geetest.com/install/sections/idx-client-sdk.html

};

if($("#popup-captcha-mobile").length>0){

	$.ajax({
			url: wapurl+"/index.php?c=geetest&t=" + (new Date()).getTime(), // ���������ֹ����
			type: "get",
			dataType: "json",
			success: function (data) {
				// ʹ��initGeetest�ӿ�
				// ����1�����ò���
				// ����2���ص����ص��ĵ�һ��������֤�����֮�����ʹ������appendTo֮����¼�
				initGeetest({
					gt: data.gt,
					challenge: data.challenge,
					offline: !data.success, // ��ʾ�û���̨��⼫��������Ƿ�崻���һ�㲻��Ҫ��ע
					width:"100%",
					new_captcha: data.new_captcha
				}, handlerPopupMobile);
			}
	});
}

});