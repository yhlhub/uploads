$(document).ready(function(){


var handlerPopup = function (captchaObj) {
	// �ɹ��Ļص�
	
	captchaObj.onSuccess(function () {

		var validate = captchaObj.getValidate();
		
		if(validate){
			$("input[name='geetest_challenge']").val(validate.geetest_challenge);
			$("input[name='geetest_validate']").val(validate.geetest_validate);
			$("input[name='geetest_seccode']").val(validate.geetest_seccode);

			//�ύ����
			var type = $('#popup-captcha').attr('data-type');
			var dataid = $('#popup-captcha').attr('data-id');
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
	
	// ����֤��ӵ�idΪcaptcha��Ԫ����
	
	captchaObj.appendTo("#popup-captcha");
	// ����ӿڲο���http://www.geetest.com/install/sections/idx-client-sdk.html

};

if($("#popup-captcha").length>0){
	$.ajax({
			url: weburl+"/index.php?m=geetest&t=" + (new Date()).getTime(), // ���������ֹ����
			type: "get",
			dataType: "json",
			success: function (data) {
				// ʹ��initGeetest�ӿ�
				// ����1�����ò���
				// ����2���ص����ص��ĵ�һ��������֤�����֮�����ʹ������appendTo֮����¼�
				initGeetest({
					gt: data.gt,
					challenge: data.challenge,
					product: "popup", // ��Ʒ��ʽ��������float��embed��popup��ע��ֻ��PC����֤����Ч
					width:"100%",
					offline: !data.success, // ��ʾ�û���̨��⼫��������Ƿ�崻���һ�㲻��Ҫ��ע
					new_captcha: data.new_captcha
				}, handlerPopup);
			}
	});
}

});