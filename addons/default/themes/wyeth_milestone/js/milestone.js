/* global variable */
var interval;
var loginCaptcha;
var registerCaptcha;
var onloadCallback = function() {
	// if($('#loginCaptcha').length){
	// 	loginCaptcha = grecaptcha.render('loginCaptcha', {
	// 		'sitekey' : captchaKey,
	// 	});
	// }

	// if($('#registerCaptcha').length){
	// 	registerCaptcha = grecaptcha.render('registerCaptcha', {
	// 		'sitekey' : captchaKey,
	// 	});
	// }

	// if($('#contactCaptcha').length){
	// 	contactCaptcha = grecaptcha.render('contactCaptcha', {
	// 		'sitekey' : captchaKey,
	// 	});
	// }
};
var registerUploaderProfile;
var _registerProfilePic = false;
var _previousUrl = window.location.pathname;
var _uriTriggerLogin = '/login';
var _uriTriggerRegister = '/register';
var _uriTriggerThanks = '/thanks';

/* check client activity
* if there is no activity force logout
*/
function tmlft(){
    if(interval){
        clearInterval(interval);
    }

    $.ajax({
        url: BASE_URL+'tmlft',
        type: 'post',
        dataType: 'json',
        data: $.extend(tokens, {}),
        success: function (data) {
            if(data.status=='true'){
                var tmlft = data.tmlft;
                var lft = parseInt(tmlft);
                var counter = 0;
                interval = setInterval(function() {
                    counter++;
                    if (counter == (lft-20)) {
                    	afsmailqueue();
                    }

                    if (counter == lft) {
                        clearInterval(interval);
                        // window.location.href = SITE_URL+'login';
						
						// hasil SA 14-11-2018
						window.location.href = SITE_URL+'logout';
                    }
                }, 1000);
            }
        }
    });
}

/* check client afs
* set email queue before logout
*/
function afsmailqueue(){
	$.ajax({
        url: BASE_URL+'afs-finder/afsmail',
        type: 'post',
        dataType: 'json',
        data: $.extend(tokens, {
        	afsmail: 'afsmail'
        }),
        success: function (data) {
        }
    });
}

/* login & register popup
* section login
*/
function doLogin(){
	if(!login_register){
		tamp_last();
		$('#puLoginRegister .nav-link').removeClass('active');
		$('#puLoginRegister .tab-pane').removeClass('show active');
		$('#puLoginRegister .nav-link').attr('aria-selected', false);
		$('#puLoginRegister #tab-login').addClass('active');
		$('#puLoginRegister #login-pane').addClass('show active');
		$('#puLoginRegister #tab-login').attr('aria-selected', true);
		$('#puLoginRegister').modal();
	} else {
		$('#loginRegister #login-pane').click();
	}
	ga('send', 'event', 'register_login', 'login', 'link');
}

/* login & register popup
* section register
*/
function doRegister(){
	if(!login_register) {
		tamp_last();
		$('#puLoginRegister .nav-link').removeClass('active');
		$('#puLoginRegister .tab-pane').removeClass('show active');
		$('#puLoginRegister .nav-link').attr('aria-selected', false);
		$('#puLoginRegister #tab-register').addClass('active');
		$('#puLoginRegister #register-pane').addClass('show active');
		$('#puLoginRegister #tab-register').attr('aria-selected', true);
		$('#puLoginRegister').modal();

		// setTimeout(function(){
		// }, 400);

		$('#puLoginRegister').on('shown.bs.modal', function (e) {
			setTimeout(function() {
				initCrop($('#profile-image'));
				initRegisterSimpleUpload(document.getElementById('btn-register-profile'));
			}, 100);
		})
	} else {
		$('#loginRegister #register-pane').click();
	}
	// ga('send', 'event', 'register_login', 'register', 'link');
}

/* set last url */
function tamp_last(){
	var last_url = window.location.href;
    $.ajax({
        type: "POST",
        url: SITE_URL+'tamp_last',
        data: $.extend(tokens,{last_url:last_url}),
        dataType: 'json',
        async: false,
        success: function(ret){

        },
    });
}

/* init crop image */
function initCrop(elemt) {
	elemt.cropper({
		aspectRatio: 1 / 1,
		viewMode: 3,
        dragMode: 'move',
        autoCropArea: 1,
        restore: false,
        guides: false,
        highlight: false,
        background: false,
		cropBoxMovable: false,
		cropBoxResizable: false,
		minContainerWidth: 176,
		cropped: function(e) {

		},
	});
}

/* init ajax fileupload */
function initRegisterSimpleUpload(btnUpload) {
	var registerUploaderProfile = new ss.SimpleUpload({
		button: btnUpload,
		url: SITE_URL+'submit-guest-profilepic',
		name: 'userprofilpic',
		multipart: true,
		responseType: 'json',
		data:tokens,
		noParams: true,
		allowedExtensions: ['jpg', 'jpeg', 'png'],
	 	onComplete: function(filename, response) {
        	if(response['status']==true) {
        		createBase64(response['uri_path'], function(base64Img) {
        			$('#profile-image').cropper('reset').cropper('replace', base64Img);
        			lastProfileImageUrl 	= response['uri_path'];
        			lastProfileImagePath 	= response['upload_dir'];
        			lastProfileImageName 	= response['file_name'];

        			$('input[name="register-profile-filename"]').val(response['file_name']);
        			$('input[name="register-profile-pathname"]').val(response['upload_dir']);

        			_registerProfilePic = true;
        		});
        	}
	 	},
	  	endXHR: function(filename, response) {
        	// console.log(filename);
        	// console.log(response);
      	},
	});
}

/* create base64 image */
function createBase64(url, callback, outputFormat) {
	var img = new Image();
	img.crossOrigin = 'Anonymous';
	img.onload = function() {
		var canvas = document.createElement('CANVAS');
		var ctx = canvas.getContext('2d');
		var dataURL;
		canvas.height = this.height;
		canvas.width = this.width;
		ctx.drawImage(this, 0, 0);
		dataURL = canvas.toDataURL(outputFormat);
		callback(dataURL);
		canvas = null;
	};
	img.src = url;
}

/* merge object */
function merge_options(obj1,obj2){
    var obj3 = {};
    for (var attrname in obj1) { obj3[attrname] = obj1[attrname]; }
    for (var attrname in obj2) { obj3[attrname] = obj2[attrname]; }
    return obj3;
}

/* submit register */
function submitReg($image, _profPic){
	_validRegisterFirstName=false;
	var first_name = $('#register-pane input[name=first_name]').val();
	if(first_name==''){
		_validRegisterFirstName=false;
		$('#register-pane input[name=first_name]').removeClass('is-valid');
		$('#register-pane input[name=first_name]').addClass('is-invalid');
		$('#register-pane #register-feedback-first_name').html('Nama Depan dibutuhkan.');
	}else{
		$('#register-pane input[name=first_name]').removeClass('is-invalid');
		$('#register-pane input[name=first_name]').addClass('is-valid');
		$('#register-pane #register-feedback-first_name').html('');
		_validRegisterFirstName=true
	}

	_validRegisterLastName=false;
	var last_name = $('#register-pane input[name=last_name]').val();
	if(last_name==''){
		_validRegisterLastName=false;
		$('#register-pane input[name=last_name]').removeClass('is-valid');
		$('#register-pane input[name=last_name]').addClass('is-invalid');
		$('#register-pane #register-feedback-last_name').html('Nama Belakang dibutuhkan.');
	}else{
		_validRegisterLastName=true
		$('#register-pane input[name=last_name]').removeClass('is-invalid');
		$('#register-pane input[name=last_name]').addClass('is-valid');
		$('#register-pane #register-feedback-last_name').html('');
	}

	_validRegisterGender=false;
	var gender = $('#register-pane select[name=gender] option:selected').val();
	if(gender==''){
		_validRegisterGender=false;
		$('#register-pane input[name=gender]').removeClass('is-valid');
		$('#register-pane input[name=gender]').addClass('is-invalid');
		$('#register-pane #register-feedback-gender').html('Pilih Jenis Kelamin.');
	}else{
		_validRegisterGender=true;
		$('#register-pane input[name=gender]').removeClass('is-invalid');
		$('#register-pane input[name=gender]').addClass('is-valid');
		$('#register-pane #register-feedback-gender').html('');
	}

	_validRegisterEmail=false;
	var email = $('#register-pane input[name=email]').val();
	if(email==''){
    	_validRegisterEmail=false;
    	$('#register-pane input[name=email]').removeClass('is-valid');
		$('#register-pane input[name=email]').addClass('is-invalid');
		$('#register-pane #register-feedback-email').html('Email Harus Diisi.');
	}else{
		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        if (filter.test(email)){
        	_validRegisterEmail=true;
        	$('#register-pane input[name=email]').removeClass('is-invalid');
			$('#register-pane input[name=email]').addClass('is-valid');
			$('#register-pane #register-feedback-email').html('');
        }else{
        	_validRegisterEmail=false;
        	$('#register-pane input[name=email]').removeClass('is-valid');
			$('#register-pane input[name=email]').addClass('is-invalid');
			$('#register-pane #register-feedback-email').html('Alamat email tidak valid.');
        }
	}

	_validRegisterChildren=false;
	var _isChild = $('#register-pane input[name=is_anak]:checked').val();
	var _anakItem = 0;
	if(_isChild==1){
		_anakItem = $('#register-pane .anak-item').length;
		if(_anakItem>0) {
			_namaAnak		=[];
			_dobAnak		=[];
			_genderAnak		=[];

			for (_anak = 1; _anak <= _anakItem; _anak++) {
				_namaAnak[_anak] 	= $('input[name="nama_anak['+_anak+']"]').val();
				_dobAnak[_anak] 	= $('input[name="dob_anak['+_anak+']"]').val();
				_genderAnak[_anak] 	= $('input[name="gender_anak['+_anak+']"]').val();
			}
			_validRegisterChildren=true;
		} else {
			_validRegisterChildren=false;
		}
	}

	_validRegisterPregnant=false;
	var pregnant = $('#register-pane input[name=pregnant]:checked').val();
	var pregnancy_age = $('#register-pane select[name=pregnancy_age] option:selected').val();
	if(pregnant==1){
		if(pregnancy_age==0){
			_validRegisterPregnant=false;
			$('#register-pane select[name=pregnancy_age]').removeClass('is-valid');
			$('#register-pane select[name=pregnancy_age]').addClass('is-invalid');
			$('#register-pane #register-feedback-pregnancy_age').html('Usia Kehamilan harus diisi.');
		}else{
			_validRegisterPregnant=true;
			$('#register-pane select[name=pregnancy_age]').removeClass('is-invalid');
			$('#register-pane select[name=pregnancy_age]').addClass('is-valid');
			$('#register-pane #register-feedback-pregnancy_age').html('');
		}
	}else{
		_validRegisterPregnant=true;
		$('#register-pane select[name=pregnancy_age]').removeClass('is-invalid');
		$('#register-pane select[name=pregnancy_age]').addClass('is-valid');
		$('#register-pane #register-feedback-pregnancy_age').html('');
	}

	_validRegisterPhone=false;
	var phone = $('#register-pane input[name=phone]').val();
	if(phone==''){
		_validRegisterPhone=false;
		$('#register-pane input[name=phone]').removeClass('is-valid');
		$('#register-pane input[name=phone]').addClass('is-invalid');
		$('#register-pane #register-feedback-phone').html('Nomor telepon harus diisi.');
	}else{
		if(phone.length<10 || phone.length>13){
			_validRegisterPhone=false;
			$('#register-pane input[name=phone]').removeClass('is-valid');
			$('#register-pane input[name=phone]').addClass('is-invalid');
			$('#register-pane #register-feedback-phone').html('Nomor telepon terdiri dari 10 - 13 angka.');
		}else{
			_validRegisterPhone=true;
			$('#register-pane input[name=phone]').removeClass('is-invalid');
			$('#register-pane input[name=phone]').addClass('is-valid');
			$('#register-pane #register-feedback-phone').html('');
		}
	}

	_validRegisterPassword=false;
	var password = $('#register-pane input[name=password]').val();
	if(password==''){
		_validRegisterPassword=false;
		$('#register-pane input[name=password]').removeClass('is-valid');
		$('#register-pane input[name=password]').addClass('is-invalid');
		$('#register-pane #register-feedback-password').html('Password harus diisi.');
	}else{
		if(password.length<8 || password.length>20){
			_validRegisterPassword=false;
			$('#register-pane input[name=password]').removeClass('is-valid');
			$('#register-pane input[name=password]').addClass('is-invalid');
			$('#register-pane #register-feedback-password').html('Password terdiri dari 6 - 20 karakter.');
		}else{
			_validRegisterPassword=true;
			$('#register-pane input[name=password]').removeClass('is-invalid');
			$('#register-pane input[name=password]').addClass('is-valid');
			$('#register-pane #register-feedback-password').html('');
		}
	}

	_validRegisterRepeatPassword=false;
	var rpassword = $('#register-pane input[name=rpassword]').val();
	if(rpassword==''){
		_validRegisterRepeatPassword=false;
		$('#register-pane input[name=rpassword]').removeClass('is-valid');
		$('#register-pane input[name=rpassword]').addClass('is-invalid');
		$('#register-pane #register-feedback-rpassword').html('Ulangi Password harus diisi.');
	}else{
		if(rpassword.length<8 || rpassword.length>20){
			_validRegisterRepeatPassword=false;
			$('#register-pane input[name=rpassword]').removeClass('is-valid');
			$('#register-pane input[name=rpassword]').addClass('is-invalid');
			$('#register-pane #register-feedback-rpassword').html('Ulangi Password terdiri dari 6 - 20 karakter.');
		}else if(password!=rpassword){
			_validRegisterRepeatPassword=false;
			$('#register-pane input[name=rpassword]').removeClass('is-valid');
			$('#register-pane input[name=rpassword]').addClass('is-invalid');
			$('#register-pane #register-feedback-rpassword').html('Ulangi Password harus sama dengan Password.');
		}else{
			_validRegisterRepeatPassword=true;
			$('#register-pane input[name=rpassword]').removeClass('is-invalid');
			$('#register-pane input[name=rpassword]').addClass('is-valid');
			$('#register-pane #register-feedback-rpassword').html('');
		}
	}

	_validRegisterTnC=false;
	var tnc = 0;
	if(!$('#register-pane input[name=tnc]').is(':checked')){
		_validRegisterTnC=false;
		$('#register-pane input[name=tnc]').removeClass('is-valid');
		$('#register-pane input[name=tnc]').addClass('is-invalid');
		$('#register-pane #register-feedback-tnc').html('Anda harus menyetujui Syarat & Ketentuan.');
	}else{
		tnc = 1;
		_validRegisterTnC=true;
		$('#register-pane input[name=tnc]').removeClass('is-invalid');
		$('#register-pane input[name=tnc]').addClass('is-valid');
		$('#register-pane #register-feedback-tnc').html('');
	}

	_validRegisterCaptcha=true;
	var captcha = '';
	// var captcha = grecaptcha.getResponse(registerCaptcha);
	// if(!captcha){
	// 	_validRegisterCaptcha=false;;
	// 	$('#register-pane #register-feedback-captcha').html('Capcha harus diisi');
 //    }else{
 //    	_validRegisterCaptcha=true;
	// 	$('#register-pane #register-feedback-captcha').html('');
 //    }

  	if($('#registered_from_blog').length>0) {
	  	var registered_from_blog 	= $('#registered_from_blog').val();
	  	var bio 					= $('#sort-bio').val();
		var links					= $('#links').val();

		if(Boolean(registered_from_blog)){
			_validRegisterBio=false;
			if(bio.length<1){
				_validRegisterBio=false;
			}else{
				if(bio.length>200){
					_validRegisterBio=false;
				}else{
					_validRegisterBio=true;
				}
			}

			var dokumen = $('#attachment-file').val();
			if(dokumen.length>0){
			}else{
			}
		}

		_validRegister = [_validRegisterFirstName, _validRegisterLastName, _validRegisterGender, _validRegisterPhone, _validRegisterEmail, _validRegisterPassword, _validRegisterRepeatPassword, _validRegisterPregnant, _validRegisterTnC, _validRegisterCaptcha, _validRegisterBio];
	} else {
		_validRegister = [_validRegisterFirstName, _validRegisterLastName, _validRegisterGender, _validRegisterPhone, _validRegisterEmail, _validRegisterPassword, _validRegisterRepeatPassword, _validRegisterPregnant, _validRegisterTnC, _validRegisterCaptcha];
	}

	if(jQuery.inArray(false, _validRegister) === -1) {
		if($('#registered_from_blog').length>0) {
			if (Boolean(registered_from_blog)) {
				var secure = true;
				var link = $('#links').val();
				var facebook = $('#facebook').val();
				var instagram = $('#instagram').val();
				var attachment = $( '#attachment-file' )[0].files[0];
				$('#register-pane .links').html('');
				$('#register-pane .facebook').html('');
				$('#register-pane .instagram').html('');
				$('#register-pane .size').html('');
				if (link != '') {
					var regex = new RegExp("^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?");

					if(!regex.test(link)){
						secure = false;
						$('#register-pane .links').html('<p>Format : http://www.domain.com</p>');
					}
				}

				if (facebook != '') {
					var regex_fb =  new RegExp("(?:(?:http|https):\/\/)?(?:www.)?facebook.com\/?");
					if (!regex_fb.test(facebook)) {
						secure = false;
						$('#register-pane .facebook').html('<p>Format : https://www.facebook.com/user_id</p>');
					}
				}

				if (instagram != '') {
					var regex_ig =  new RegExp("(?:(?:http|https):\/\/)?(?:www.)?instagram.com\/?");
					if (!regex_ig.test(instagram)) {
						secure = false;
						$('#register-pane .instagram').html('<p>Format : https://www.instagram.com/user_id</p>');
					}
				}

				if (typeof attachment != 'undefined') {
					if (Boolean(attachment['size'])) {
						if (attachment['size'] > 2000000) {
							secure = false;
							$('#register-pane .attachment').html('<p>Max : 2 Mb</p>');
						}
					}
				}

				if (!secure) {
					$('#register-pane .ex').addClass('has-danger');
					return;
				}

				var formdata = new FormData($('#form-register-blog')[0]);
				formdata.append( 'file', $( '#attachment-file' )[0].files[0] );

				$.ajax({
					type:'POST',
					url: SITE_URL+'do-blog-register',
					dataType:'json',
					data:formdata,
					processData: false,
					contentType: false,
					success:function(res){
						if(res.status=='success'){
							//window.location.href = res.url;
							$('#puThankYou #puThankYouLabel').html('Registrasi Sukses');
							$('#puThankYou .modal-body').html('Terima kasih telah mendaftar di Parenting Club. <br>Yuk cek email Anda untuk mengaktifkan akun.');

							$('#puLoginRegister').modal('hide');
							$('#register-pane input').val('');

							// grecaptcha.reset(registerCaptcha);
							fbq('track', "PageView");
							fbq('track', 'CompleteRegistration');
							ga('send', 'event', 'register_login', 'register', 'link');

							if (res.from_utm == '1') {
								ga('send', 'event', 'acquisition', 'registration', res.utm_source);
							}

							setTimeout(function() {
								window.location.href = BASE_URL+'thank-you-blog';
							}, 400);
						}else if(res.status=='sms_verify'){
							$('#puSms').modal();
							// grecaptcha.reset(registerCaptcha);
						}else{
							if(res.message){
								// error message
							}else{
								$.each(res.error, function(i, val){
									// error message
								});
							}
							// grecaptcha.reset(registerCaptcha);
						}
					},
			   	});

			   	return;
			}
		}

		var image = '';
		if(_profPic) {
			imagep = $image.cropper('getCroppedCanvas');

			cropper_data1 	= $image.cropper('getData');
			cropper_data2 	= $image.cropper('getImageData');
			baseProfileImage = {
				'lastProfileImageUrl' : lastProfileImageUrl,
				'lastProfileImagePath' : lastProfileImagePath,
				'lastProfileImageName' : lastProfileImageName
			};

			cropper_data3	= merge_options(cropper_data2, cropper_data1);
			image	= merge_options(cropper_data3, baseProfileImage);
		}

		if(_anakItem>0) {
			_registerPost = {
				image:image,
				first_name:first_name,
				last_name:last_name,
				email:email,
				phone:phone,
				password:password,
				rpassword:rpassword,
				pregnant:pregnant,
				pregnancy_age:pregnancy_age,
				tnc:tnc,
				captcha:captcha,
				gender:gender,
				is_child:_isChild,
				namaanak:_namaAnak,
				dobanak:_dobAnak,
				genderanak:_genderAnak,
			}
		} else {
			_registerPost = {
				image:image,
				first_name:first_name,
				last_name:last_name,
				email:email,
				phone:phone,
				password:password,
				rpassword:rpassword,
				pregnant:pregnant,
				pregnancy_age:pregnancy_age,
				tnc:tnc,
				captcha:captcha,
				gender:gender
			}
		}

		$('.invalid-feedback').hide();
		$.ajax({
			type:'POST',
			url: SITE_URL+'do-register',
			dataType:'json',
			data:$.extend(tokens, _registerPost),
			success:function(res){
				if(res.status=='success'){
					$('#puThankYou #puThankYouLabel').html('Registrasi Sukses');
					$('#puThankYou .modal-body').html('Terima kasih telah mendaftar di Parenting Club. <br>Yuk cek email Anda untuk mengaktifkan akun.');

					$('#puLoginRegister').modal('hide');
					$('#register-pane input').val('');

					// grecaptcha.reset(registerCaptcha);
					// fbq('track', "PageView");
					// fbq('track', 'CompleteRegistration');
					// ga('send', 'event', 'register_login', 'register', 'link');


					if (res.from_utm == '1') {
						ga('send', 'event', 'acquisition', 'registration', res.utm_source);
					}
					setTimeout(function() {
						window.location.href = BASE_URL+'thank-you';
					}, 400);
					// $('#puThankYou').modal();
				}else if(res.status=='sms_verify'){
					$('#puSms').modal();
					// grecaptcha.reset(registerCaptcha);
				}else{
					if(res.message){
						// error message
					}else{
						$.each(res.error, function(i, val){
							// $('input[name="'+i+'"]').addClass('is-invalid');
							$('#register-feedback-'+i).html(val);
							$('#register-feedback-'+i).show();
						});
					}
					// grecaptcha.reset(registerCaptcha);
				}
			},
	   });
	}else{
		// error message
	}
}

function shareFB(url, title, description, image) {
	console.log(url);
	console.log(title);
	console.log(description);
	console.log(image);
	FB.ui({
        method: 'share_open_graph',
        action_type: 'og.shares',
        action_properties: JSON.stringify({
            object: {
                'og:url': url,
                'og:title': title,
                'og:description': description,
                'og:image': image
            }
        })
    },
    function (response) {
    	// Action after response
    });
}

function shareTW(url, description) {
    var length = 110;
    var body = description;

    if (body.length > length) {
        body = body.substring(0, length);
        body += '...';
    }

    var data = encodeURIComponent(url)+'&text='+encodeURIComponent(body);
    var width  = 575,
        height = 400,
        left   = (screen.width - width) / 2,
        top    = (screen.height - height) / 2,
        url    = 'https://twitter.com/share?url='+data,
        opts   =    'status=1'+
                    ',width='+width+
                    ',height='+height+
                    ',top='+top+
                    ',left='+left;

    window.open(url, 'twitter', opts);

    return false;
}

function getExperts(submit, sctype) {
    var tpl = '<option value="">Pilih Dokter</option>';

    if (submit.category != '') {
        $.ajax({
            url: SITE_URL + 'smart-consultation/get_experts',
            data: $.extend(tokens, submit),
            dataType: 'json',
            type: 'POST',
            success: function(result) {
                if (result.status) {
                    $.each(result.data, function(index, value) {
                        tpl += '<option value="'+value.doctor_slug+'">'+value.doctor_fullname+'</option>';
                    });

                    $('#expert-data-'+sctype).html(tpl).selectpicker('refresh');
                }
            }
        });
    } else {
        $('#expert-data-'+sctype).html(tpl).selectpicker('refresh');
    }
}

function askSCQuestion() {
    $('#ask_subject_global').removeClass('is-invalid');
    $('#ask_subject_glob_error').html('');
    $('#ask_value_global').removeClass('is-invalid');
    $('#ask_value_glob_error').html('');
    $('#select-category-global').parent().removeClass('is-invalid');
    $('#expert-data-global').parent().removeClass('is-invalid');
    $('#puSC').modal();
}

function submitSCQuestion(submit, type) {
    $.ajax({
        type: 'POST',
        url: SITE_URL+'smart-consultation/ask',
        data: $.extend(tokens, submit),
		dataType: 'json',
		beforeSend: function(){
			if (type == 'landing') {
				$('#ask-btn-top').attr('disabled','disabled');
				$('#ask-btn-top').prop('disabled', true);
			}
			if (type == 'global') {
				$('#submit-sc-question').attr('disabled','disabled');
				$('#submit-sc-question').prop('disabled', true);
			}
		},
		complete: function(){
			if (type == 'landing') {
				$('#ask-btn-top').removeAttr('disabled');
				$('#ask-btn-top').prop('disabled', false);
			}
			if (type == 'global') {
				$('#submit-sc-question').removeAttr('disabled');
				$('#submit-sc-question').prop('disabled', false);
			}
		},
        success: function(ret) {
            tmlft();
            if (ret.status == true) {
                if (type == 'global') {
                    $('#puSC').modal('hide');
                    $('#puSC input[name=ask_subject]').val('');
                    $('#puSC textarea[name=ask_value]').val('');
                    $('#puSC input[name=doctor_id]').val('');
                    $('#puSC input[name=milestone]').val('');
                    $('#puSC input[name=ask_category]').val('');
                    $('#select-category-global').val('').selectpicker('refresh');
                    $('#expert-data-global').html('<option value="">Pilih Expert</option>').selectpicker('refresh');
                }

                if (type == 'landing') {
                    $('input[name=ask_subject]').val('').removeClass('is-invalid');
                    $('textarea[name=ask_value]').val('').removeClass('is-invalid');
                    $('#select-category-landing').parent().removeClass('is-invalid');
                    $('#select-category-landing').val('').selectpicker('refresh');
                    $('#expert-data-landing').parent().removeClass('is-invalid');
                    $('#expert-data-landing').html('<option value="">Pilih Expert</option>').selectpicker('refresh');
                }

                // $('#puGlobal .img-responsive').hide();
                $('#puGlobal .modal-title').html('Terima kasih atas pertanyaan Anda!');
                $('#puGlobal .modal-body').html($('#pop-msg').data('pop-up-msg'));
                $('#puGlobal').modal();
            } else if (ret.status == 'needlogin') {
                if (type == 'global') {
                    $('#puSC').modal('hide');
                }

                doLogin();
            } else {
                if (type == 'global') {
                    $.each(ret.error, function(i, value) {
                        if (value) {
                            $('#'+i+'_global').addClass('is-invalid');
                            $('#puSC select[name='+i+']').parent().addClass('is-invalid');
                            $('#'+i+'_glob_error').html(value);
                        } else {
                            $('#'+i+'_global').removeClass('is-invalid');
                            $('#puSC select[name='+i+']').parent().removeClass('is-invalid');
                            $('#'+i+'_glob_error').html('');
                        }
                    });
                }

                if (type == 'landing') {
                    $.each(ret.error, function(i, value) {
                        if (value) {
                            $('input[name='+i+']').addClass('is-invalid');
                            $('textarea[name='+i+']').addClass('is-invalid');
                            $('select[name='+i+']').parent().addClass('is-invalid');
                            $('#'+i+'_error').html(value);
                        } else {
                            $('input[name='+i+']').removeClass('is-invalid');
                            $('textarea[name='+i+']').removeClass('is-invalid');
                            $('select[name='+i+']').parent().removeClass('is-invalid');
                            $('#'+i+'_error').html('');
                        }
                    });
                }
            }
        }
    });
}

var action_delay = (function() {
	var timer = 0;

	return function(callback, ms) {
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	};
})();

function santizeInput(input) {
	var output = input.replace(/<script[^>]*?>.*?<\/script>/gi, '').
				 replace(/<[\/\!]*?[^<>]*?>/gi, '').
				 replace(/<style[^>]*?>.*?<\/style>/gi, '').
				 replace(/<![\s\S]*?--[ \t\n\r]*>/gi, '');
    return output;
};

$(document).ready(function() {
	tmlft();
	
	// $(document).ready(function() {
	    // Detect ios 11_x_x affected  
	    // NEED TO BE UPDATED if new versions are affected
	    var ua = navigator.userAgent,
	    iOS = /iPad|iPhone|iPod/.test(ua),
	    iOS11 = /OS 11_0_1|OS 11_0_2|OS 11_0_3|OS 11_1|OS 11_1_1|OS 11_1_2|OS 11_2|OS 11_2_1/.test(ua);

	    // ios 11 bug caret position
	    if ( iOS && iOS11 ) {

	        // Add CSS class to body
	        $("body").addClass("iosBugFixCaret");

	    }

	// });
	$('body').on('click', 'a#tab-register', function(e) {
		setTimeout(function() {
			initCrop($('#profile-image'));
			initRegisterSimpleUpload(document.getElementById('btn-register-profile'));
		}, 100);
		e.preventDefault();
	});

	$('body').on('click', '#login-pane .loginBtn', function(e){
		e.preventDefault();

		email = $('#login-pane input[name=email]').val();
		if(email=='') {
			$('#login-pane input[name=email]').removeClass('is-valid');
			$('#login-pane input[name=email]').addClass('is-invalid');
			$('#login-pane #login-feedback-email').html('Email Harus Diisi.');
        	_validEmail=false;
		} else {
			var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            if (filter.test(email)) {
				$('#login-pane input[name=email]').removeClass('is-invalid');
				$('#login-pane input[name=email]').addClass('is-valid');
				$('#login-pane #login-feedback-email').html('');
                _validEmail=true;
            } else {
			$('#login-pane input[name=email]').removeClass('is-valid');
				$('#login-pane input[name=email]').addClass('is-invalid');
				$('#login-pane #login-feedback-email').html('Alamat email tidak valid.');
        		_validEmail=false;
            }
		}

		password = $('#login-pane input[name=password]').val();
		if(password=='') {
			$('#login-pane input[name=password]').removeClass('is-valid');
			$('#login-pane input[name=password]').addClass('is-invalid');
			$('#login-pane #login-feedback-password').html('Password dibutuhkan.');
			_validPassword=false;
		} else {
			$('#login-pane input[name=password]').removeClass('is-invalid');
			$('#login-pane input[name=password]').addClass('is-valid');
			$('#login-pane #login-feedback-password').html('');
			_validPassword=true;
		}

		// captcha = grecaptcha.getResponse(loginCaptcha);
		captcha = '';
		_validCaptcha = true;
		// if(!captcha) {
		// 	// $('#login-pane input[name=password]').removeClass('is-valid');
		// 	// $('#login-pane input[name=password]').addClass('is-invalid');
		// 	$('#login-pane #login-feedback-captcha').html('Capcha harus diisi.');
  //           _validCaptcha=false;
  //       } else {
  //       	$('#login-pane .captcha').hide();
  //       	_validCaptcha=true;
  //       }

		remember = 0;
		if($('#login-pane input[name=remember]').is(':checked')){
			remember = 1;
		}

		_validLogin = [_validEmail, _validPassword, _validCaptcha];

		if(jQuery.inArray(false, _validLogin) === -1) {
			$('#login-pane .global-form-error').hide();
			$.ajax({
				type: "POST",
				url: SITE_URL+'do-login',
				data: $.extend(tokens,{
					email:email,
					password:password,
					captcha:captcha,
					remember:remember}),
				dataType: 'json',
				success: function(ret){
					if(ret.status==false){
						if(ret.error) {
							// $.each(ret.error, function(i, val){
							// 	$('#login-pane .'+i).parents('.form-group').removeClass('has-success');
							// 	$('#login-pane .'+i).parents('.form-group').addClass('has-danger');
							// 	$('#login-pane .'+i).html(val);
							// 	$('#login-pane .'+i).show();
							// });
						} else {
							$('#login-pane .global-form-error').html(ret.message);
							$('#login-pane .global-form-error').show();
						}
						// grecaptcha.reset(loginCaptcha);
					} else {
	                    window.location.href=ret.url;
					}
				},
			});
		}
	});

	$('body').on('click', '#register-pane input[name=is_anak]', function(){
		if($(this).val()==1){
			$('#register-pane .register-anak').show();
		} else {
			$('#register-pane .register-anak').hide();
		}
	});

	$('body').on('click', '#register-pane input[name=pregnant]', function(){
		if($(this).val()==1) {
			$('#register-pane .hamil').show();
		} else {
			$('#register-pane .hamil').hide();
		}
	});

	$('body').on('click', '.register-tambah-anak', function(e) {
		_registerAnakGender = $('input[name="register-jk-anak"]').is(':checked');
		_registerAnakName 	= $('input[name="register-nama-anak"]').val();
		_registerAnakDob 	= $('input[name="register-dob-anak"]').val();
		_registerAnakList 	= parseInt($('#anak-list').attr('data-listanak'));
		console.log(_registerAnakDob);

		if(_registerAnakGender==false) {
			_validAnakGender=false;
			$('#register-pane input[name=register-jk-anak]').removeClass('is-valid');
			$('#register-pane input[name=register-jk-anak]').addClass('is-invalid');
			$('#register-pane #register-feedback-anak-jk').html('Pilih jenis kelamin');
		} else {
			_validAnakGender=true;
			$('#register-pane input[name=register-jk-anak]').removeClass('is-invalid');
			$('#register-pane input[name=register-jk-anak]').addClass('is-valid');
			$('#register-pane #register-feedback-anak-jk').html('');
		}

		if(_registerAnakName=='') {
			_validAnakName=false;
			$('#register-pane input[name=register-nama-anak]').removeClass('is-valid');
			$('#register-pane input[name=register-nama-anak]').addClass('is-invalid');
			$('#register-pane #register-feedback-anak-nama').html('Nama diperlukan.');
		} else {
			_validAnakName=true;
			$('#register-pane input[name=register-nama-anak]').removeClass('is-invalid');
			$('#register-pane input[name=register-nama-anak]').addClass('is-valid');
			$('#register-pane #register-feedback-anak-nama').html('');
		}

		if(_registerAnakDob=='') {
			_validAnakDob=false;
			$('#register-pane input[name=register-dob-anak]').removeClass('is-valid');
			$('#register-pane input[name=register-dob-anak]').addClass('is-invalid');
			$('#register-pane #register-feedback-anak-dob').html('Tanggal lahir diperlukan.');
		} else {
			_validAnakDob=true;
			$('#register-pane input[name=register-dob-anak]').removeClass('is-invalid');
			$('#register-pane input[name=register-dob-anak]').addClass('is-valid');
			$('#register-pane #register-feedback-anak-dob').html('');
		}

		_ctAnak = $('#anak-list .anak-item').length;
		if(_ctAnak<=2) {
			_validCtAnak=true;
		} else {
			_validCtAnak=false;
		}

		_validAnak = [_validAnakGender, _validAnakName, _validAnakDob, _validCtAnak];
		if(jQuery.inArray(false, _validAnak) !== -1) {
			return false;
		} else {
			_dobAnak = [];
			_registerAnakList = _registerAnakList+1;
			jk = 'boy';
			if(_registerAnakGender==2) {
				jk = 'girl';
			}

			$.ajax({
		        url: BASE_URL+'register-dob-anak',
		        type: 'post',
		        dataType: 'json',
		        data: $.extend(tokens, {
		        	check_date: _registerAnakDob,
		        	name:_registerAnakName,
		        	dob:_registerAnakDob,
		        	gender:_registerAnakGender,
		        }),
		        success: function (data) {
		            if(data.status=='true'){
		            	html = '<div class="anak-item" id="data-anak'+_registerAnakList+'" data-anak'+_registerAnakList+'dob="'+data.date+'" data-anak'+_registerAnakList+'name="'+_registerAnakName+'" data-anak'+_registerAnakList+'gender="'+_registerAnakGender+'">'+
									'<div class="anak-jk">'+
										'<span class="jk '+jk+'"></span>'+
									'</div>'+
									'<div class="anak-bio">'+
										'<p class="anak-name">'+_registerAnakName+'</p>'+
										'<div>'+
											'<div class="meta-bar">'+
												'<span class="anak-dob">'+data.indodate+'</span>'+
												'<span class="anak-age">'+data.old+'</span>'+
											'</div>'+
											'<div class="actions">'+
												'<a href="javascript:void(0);" class="data-anak-action" data-action="delete" data-anak="'+_registerAnakList+'">Hapus</a>'+
												'<a href="javascript:void(0);" class="data-anak-action" data-action="edit" data-anak="'+_registerAnakList+'">Edit</a>'+
											'</div>'+
										'</div>'+
									'</div>'+
									'<input type="hidden" name="nama_anak['+_registerAnakList+']" value="'+_registerAnakName+'">'+
									'<input type="hidden" name="dob_anak['+_registerAnakList+']" value="'+data.date+'">'+
									'<input type="hidden" name="gender_anak['+_registerAnakList+']" value="'+_registerAnakGender+'">'+
								'</div>';
						$('input[name="register-nama-anak"]').val();
						$('input[name="register-dob-anak"]').val();
						$('#anak-list').attr('data-listanak', _registerAnakList);
						$('#anak-list').append(html);
		            }
		        }
		    });
		}

		e.preventDefault();
	});

	$('body').on('click', '.data-anak-action', function(e) {
		_action 	= $(this).attr('data-action');
		_anak 		= $(this).attr('data-anak');
		_gender 	= $(this).attr('data-anak'+_anak+'gender');
		_name 		= $(this).attr('data-anak'+_anak+'name');
		_dob 		= $(this).attr('data-anak'+_anak+'dob');
		_ctanak 	= parseInt($('#anak-list').attr('data-listanak'));

		if(_action=='delete') {
			_ctanak = _ctanak-1;
			$('#anak-list').attr('data-listanak', _ctanak);
			$('#data-anak'+_anak).remove();
		} else if(_action=='edit') {
			$('#data-anak'+_anak).hide();
			$('input[name="register-nama-anak"]').val('');
			$('input[name="register-nama-anak"]').text('');
			$('input[name="register-dob-anak"]').val('');
			$('input[name="register-dob-anak"]').text('');
		}

		e.preventDefault();
	});

	$('body').on('click', '#btn-register-profile', function(e){
		e.preventDefault();
		$('#registerProfileInput').click();
	});

	$('body').on('click', '#register-pane .registerBtn', function(e){
		submitReg($('#profile-image'), _registerProfilePic);
		e.preventDefault();
	});

	$('body').on('click', '.share-to-fb', function(e) {
		e.preventDefault();
		e.stopPropagation();
        e.stopImmediatePropagation();

        var url = $(this).data('url'),
        	title = $(this).data('title'),
        	description = $(this).data('description'),
        	image = $(this).data('image');

    	shareFB(url, title, description, image);
	});

	$('body').on('click', '.share-to-tw', function(e) {
		e.preventDefault();
		e.stopPropagation();
        e.stopImmediatePropagation();

        var url = $(this).data('url'),
        	description = $(this).data('description');

    	shareTW(url, description);
	});

    $('#select-category-global').on('change', function(e) {
        e.preventDefault();

        getExperts({category: $(this).val()}, 'global');
    });

    /* popup state */
    if(window.location.pathname.indexOf(_uriTriggerRegister) !== -1) {
    	doRegister();
    } else if(window.location.pathname.indexOf(_uriTriggerLogin) !== -1) {
    	doLogin();
    } else if(window.location.pathname.indexOf(_uriTriggerThanks) !== -1) {
    	$('#puThankYou').modal('show');
    }

    $('#puLoginRegister').on('shown.bs.modal', function() {
    	if($('#login-pane').is('.show')) {
        	window.history.pushState("object or string", "Title", _uriTriggerLogin);
    	} else {
        	window.history.pushState("object or string", "Title", _uriTriggerRegister);
    	}
    });
    $('#puLoginRegister').on('hide.bs.modal', function(){
        window.history.pushState("object or string", "Title", _previousUrl);
    });

    $('#puThankYou').on('shown.bs.modal', function() {
        window.history.pushState("object or string", "Title", _uriTriggerThanks);
    });
    $('#puThankYou').on('hide.bs.modal', function(){
        window.history.pushState("object or string", "Title", _previousUrl);
    });
    /* /.popup state */

    $('#searchbox-search').keyup(function() {
    	var value = $(this).val(),
    		html = '';

		action_delay(function(){
			if (value == '') {
	    		$('#searchbox-suggesstion').html(html);
	    		$('.sboxdesk').removeClass('suggest');
	    	} else {
	    		$.ajax({
	    			url: BASE_URL+'suggestion',
			        type: 'post',
			        dataType: 'json',
			        data: $.extend(tokens, {search: value}),
			        success: function (result) {
			        	if (result.status) {
			    			for (var i = 0; i < result.data.length; i++) {
			    				html += '<li><a href="'+result.data[i].url+'" class="search-view-article">'+result.data[i].title+'</a></li>';
			    			}

			    			$('#searchbox-suggesstion').html(html).show();
			    		} else {
			    			$('#searchbox-suggesstion').html('<li>'+result.message+'</li>').show();
			    		}
			        }
	    		});
	    	}
		}, 500);
    });

    $(document).on('click', '.slider-do-register', function(e) {
    	e.preventDefault();

    	doRegister();
    });

    $('#searchbox-search').on('blur', function() {
    	$('#searchbox-suggesstion').html('').hide();
	});
	
	$('body').on('click', '.dismiss-perenting-popup', function (evt) {
		_section_popup = evt.currentTarget.dataset.parentingpopup;

		if (typeof(Storage) !== "undefined") {
			localStorage.removeItem('section_popup'+_section_popup);
			localStorage.setItem('section_popup'+_section_popup, _section_popup);
		}
	});
});


$(window).on('load', function () {
	if(puReg){
		doRegister();
	}
});