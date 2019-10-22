$(document).ready(function() {
	
	$('body').on('click', '.button-submit-newsletter', function(e) {
        _email = $('input#input-newsletter').val();
        _campaign = $('input#input-newsletter').attr('data-campaign');
        _recap_token = $('#recap_token').val();
        if(_email == ''){
        	var newslaterdiv = $('#get-newsletter')[0].childNodes[1];
        	$(newslaterdiv).after('<p align="center" style="color:red;" id="email_kosong">* alamat email masih kosong </p>');
        	setTimeout(function(){ 
        		$('#email_kosong').remove();
        		$('input#input-newsletter').attr('placeholder','input alamat email disini')
        		$('input#input-newsletter').focus();
        	}, 3000);
        	return;
        }
		$.ajax({
			type: "POST",
			url: SITE_URL+'campaign/subscriber',
            data: $.extend({
                email:_email,
                campaign:_campaign,
                recap_token: _recap_token
            }, tokens),
			dataType: 'json',
			success: function(res) {
				var newslaterdiv = $('#get-newsletter')[0].childNodes[1];
				if(res.status == 'error'){
					$.each(res.error,function(key,value){
						if(value != ''){
							$(newslaterdiv).after(value);
						}	
					});
				}else{
					$(newslaterdiv).after('<p align="center" id="return_message">'+res.message+'</p>');
					
				}

				setTimeout(function(){ 
	        		$('#return_message').remove();
	        		$('input#input-newsletter').val('');
	        		runRecaptcha();
	        	}, 3000);
			},
        });
	});
});