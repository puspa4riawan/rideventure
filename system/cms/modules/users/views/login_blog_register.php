<div id="main-container">
	<div class="lr" id="loginRegister">
      	<div class="modal-header">
    		<h4 class="modal-title">Yuk bergabung & jadi Mam Writer</h4>
    		<p class="blogger-text">Apakah Mam senang menulis di blog seputar parenting dan tumbuh kembang si Kecil? Kini Parenting Club membuka kesempatan bagi Mam untuk menjadi Mam Writer sehingga Mam dapat berbagi pengalaman kepada Mam lainnya melalui Parenting Club.</p>
			<ul class="nav nav-tabs" role="tablist">
			  	<li class="nav-item">
			    	<a class="nav-link <?php echo $login_register=='login' ? 'active' : ''; ?>" data-toggle="tab" id="login-menu" href="#login" role="tab">Login</a>
			  	</li>
			  	<li class="nav-item">
			    	<a class="nav-link active <?php echo $login_register=='register' ? 'active' : ''; ?>" data-toggle="tab" id="register-menu" href="#register" role="tab">Register</a>
			  	</li>
			</ul>
  		</div>

		<div class="modal-body">
			<div class="tab-content">
			  	<div class="tab-pane <?php echo $login_register=='login' ? 'active' : ''; ?>" id="login" role="tabpanel">
				  	<div class="container-fluid">
					  	<div class="btns">
					  		<a href="{{url:site uri='fb-connect'}}" class="btn btn-fb">Login dengan <i class="fa fa-facebook fa-fw" aria-hidden="true"></i></a>
					  		<a href="{{url:site uri='tw-connect'}}" class="btn btn-tw">Login dengan <i class="fa fa-twitter fa-fw" aria-hidden="true"></i></a>
					  	</div>
					  	<form>
							<div class="form-group"><div class="form-control-feedback global"></div></div>
					  		<div class="form-group">
					  			<label class="sr-only" for="login-email">Email</label>
					  			<input type="text" name="email" id="login-email" onkeypress="return emailValidation(event)" class="form-control" placeholder="Email" autocomplete="off">
					  			<div class="form-control-feedback email"></div>
					  		</div>
					  		<div class="form-group">
					  			<div class="input-group">
						  			<input type="password" name="password" id="login-password" class="form-control" placeholder="Password" autocomplete="off">
						  			<label class="sr-only" for="login-password">Password</label>
						  			<span class="input-group-btn show-password" data-toggle="buttons">
										<label class="btn btn-white">
											<input type="checkbox" autocomplete="off"><i class="fa fa-eye fa-lg" aria-hidden="true"></i><span class="sr-only">Show/hide Password</span>
										</label>
									</span>
						  		</div>
					  			<div class="form-control-feedback password"></div>
					  		</div>
					  		<div class="form-group">
						  		<div id="loginCaptcha"></div>
								<div class="form-control-feedback captcha"></div>
							</div>
				  		  	<div class="form-check">
							    <label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="remember">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description">Ingat saya</span>
								</label>
							</div>
							<a href="{{url:site uri='forgot-password'}}" class="lupa">Lupa password?</a>
							<div class="form-group">
								<button class="btn btn-red loginBtn" type="button">Login</button>
							</div>
					  	</form>
				  	</div>
			  	</div>

			  	<div  class="tab-pane active<?php echo $login_register=='register' ? 'active' : ''; ?>" id="register" role="tabpanel">
				  	<div class="container-fluid">
		  				<form id="form-register-blog">
		  					<?php $csrf = array(
							        'name' => $this->security->get_csrf_token_name(),
							        'hash' => $this->security->get_csrf_hash()
							);?>
							<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
		  					<input type="hidden" id="registered_from_blog" value="1">
		  					<?php
					            $name = $phone = $email = '';
				                $me = $this->session->userdata('me');
				                $first_name = isset($me['first_name']) ? $me['first_name']:'';
				                $last_name = isset($me['last_name']) ? $me['last_name']:'';
				                $phone  = isset($me['phone']) ? $me['phone']:'';
				                $email  = isset($me['email']) ? $me['email']:'';
					        ?>
					        <div class="form-group"><div class="form-control-feedback global"></div></div>
		  					<div class="form-group">
		  						<label for="reg-namadepan" class="sr-only">Nama Depan (diperlukan)</label>
		  						<input type="text" id="reg-namadepan" onkeypress="return allLetterspace(event)" class="form-control" name="first_name" required placeholder="Nama Depan *" value="<?php echo $first_name; ?>" autocomplete="off">
		  						<div class="form-control-feedback first_name"></div>
		  					</div>
		  					<div class="form-group">
		  						<label for="reg-namabelakang" onkeypress="return allLetterspace(event)" class="sr-only">Nama Belakang (diperlukan)</label>
		  						<input type="text" id="reg-namabelakang" class="form-control" name="last_name" required placeholder="Nama Belakang *" value="<?php echo $last_name; ?>" autocomplete="off">
		  						<div class="form-control-feedback last_name"></div>
		  					</div>
		  					<div class="form-group">
		  						<label for="reg-gender" class="sr-only">Jenis Kelamin (diperlukan)</label>
		  						<select class="selectpicker" data-style="btn-white" data-width="100%" name="gender">
		  							<option value="">Pilih Jenis Kelamin</option>
		  							<option value="m">Pria</option>
		  							<option value="f">Wanita</option>
		  						</select>
		  						<div class="form-control-feedback gender"></div>
		  					</div>
		  					<div class="form-group">
		  						<label for="reg-nohp" class="sr-only">Nomor Handphone (diperlukan)</label>
		  						<input type="tel" id="reg-nohp" onkeypress="return numeric(event)" class="form-control" name="phone" required placeholder="Nomor Handphone *" value="<?php echo $phone; ?>" autocomplete="off">
		  						<div class="form-control-feedback phone"></div>
		  					</div>
		  					<div class="form-group">
		  						<label for="reg-email" class="sr-only">Email (diperlukan)</label>
		  						<input type="text" id="reg-email" onkeypress="return emailValidation(event)" class="form-control" name="email" required placeholder="Email *" value="<?php echo $email; ?>" autocomplete="off">
		  						<div class="form-control-feedback email"></div>
		  					</div>

		  					<div class="form-group">
		  						<label for="sort-bio" class="sr-only">Tentang diri Anda & mengapa ingin jadi Mam Writer</label>
		  						<!-- <input type="text" id="sort-bio" class="form-control" name="sort-bio" required placeholder="Sort Bio" value="" autocomplete="off"> -->
									<div class="info-character">Maksimum Karakter: <div id="chars">200</div></div>
									<textarea style="height: 10em" placeholder="Tentang diri Anda & mengapa ingin jadi Mam Writer" class="form-control" name="sort_bio" id="sort-bio" autocomplete="off" maxlength="200"></textarea>
									<div class="form-control-feedback sort-bio"></div>
		  					</div>

		  					<div class="form-group ex">
		  						<label for="links" class="sr-only">Alamat Blog Anda</label>
		  						<input type="text" id="links" class="form-control" name="links"  placeholder="Alamat Blog Anda" value="" autocomplete="off">
		  						<div class="form-control-feedback links">
		  							<medium class="textform text-muted">Format: http://www.domain.com</medium>
		  						</div>
		  					</div>

		  					<div class="form-group ex">
		  						<label for="facebook" class="sr-only">Akun Facebook</label>
		  						<input type="text" id="facebook" class="form-control" name="facebook" placeholder="Akun Facebook" value="" autocomplete="off">
		  						<div class="form-control-feedback facebook">
		  							<medium class="textform text-muted">Format: https://www.facebook.com/user_id</medium>
		  						</div>
		  					</div>

		  					<div class="form-group ex">
		  						<label for="instagram" class="sr-only">Akun Instagram</label>
		  						<input type="text" id="instagram" class="form-control" name="instagram" placeholder="Akun Instagram" value="" autocomplete="off">
		  						<div class="form-control-feedback instagram">
		  							<medium class="textform text-muted">Format: https://www.instagram.com</medium>
		  						</div>
		  					</div>

		  					<div class="form-group ex">
		  						<div class="input-group">
			  						<input  readonly="" type="text" id="attachment" class="form-control" name="attachment" required placeholder="Upload contoh tulisan" autocomplete="off">
			  						<label for="attachment" class="sr-only">Upload contoh tulisan</label>
		  							<span class="input-group-btn" onclick="$('#attachment-file').click()" data-toggle="buttons">
											<label class="btn btn-white">
												<i class="fa fa-file fa-lg" aria-hidden="true"></i>
											</label>
										</span>

									</div>
									<div class="form-control-feedback attachment">
										<medium class="textform text-muted">Max: 2 Mb | FileType: jpg, jpeg, png & pdf</medium>
	  							</div>
									<div class="form-control-feedback dokumen"></div>
		  					</div>
							<input id="attachment-file" accept="image/*, application/pdf" name="file" type="file" style="display: none;" autocomplete="off">

		  					<medium class="textform text-muted">Password minimal 8 Karakter, yang berisi angka, huruf dan karakter simbol</medium>
		  					<div class="form-group">
		  						<div class="input-group">
			  						<input type="password" id="reg-password" class="form-control" name="password" required placeholder="Password *" autocomplete="off">
			  						<label for="reg-password" class="sr-only">Password (diperlukan)</label>
		  							<span class="input-group-btn show-password" data-toggle="buttons">
										<label class="btn btn-white">
											<input type="checkbox" autocomplete="off"><i class="fa fa-eye fa-lg" aria-hidden="true"></i><span class="sr-only">Show/hide Password</span>
										</label>
									</span>
								</div>
							    <!-- <label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description">Perlihatkan Password</span>
								</label> -->
								<div class="form-control-feedback password"></div>
		  					</div>
		  					<div class="form-group">
		  						<div class="input-group">
			  						<input type="password" id="reg-rpassword" class="form-control" name="rpassword" required placeholder="Ulangi Password *" autocomplete="off">
			  						<label for="reg-password" class="sr-only">Ulangi Password (diperlukan)</label>
		  							<span class="input-group-btn show-password" data-toggle="buttons">
										<label class="btn btn-white">
											<input type="checkbox" autocomplete="off"><i class="fa fa-eye fa-lg" aria-hidden="true"></i><span class="sr-only">Show/hide Password</span>
										</label>
									</span>
		  						</div>
							    <!-- <label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description">Perlihatkan Password</span>
								</label> -->
								<div class="form-control-feedback rpassword"></div>
		  					</div>

		  					<div style="display: none;" class="form-group m-t-1">
			  					<span class="modal-title">Apakah Anda Sudah Punya Anak?</span>
			  					<div class="form-check">
				  					<label class="custom-control custom-radio">
										<input name="is_anak" value="1" type="radio" class="custom-control-input">
										<span class="custom-control-indicator"></span>
										<span class="custom-control-description">Ya</span>
									</label>
									<label class="custom-control custom-radio">
										<input name="is_anak" value="0" type="radio" class="custom-control-input" checked>
										<span class="custom-control-indicator"></span>
										<span class="custom-control-description">Tidak</span>
									</label>
			  					</div>
			  				</div>
		  					<div class="form-group anak" style="display:none;">
		  						<div class="anak-inputs row m-x-0">
			  						<div class="form-group col-md-6">
				  						<label for="reg-anak" class="sr-only">Nama Anak (diperlukan)</label>
				  						<input type="text" id="reg-anak"  onkeypress="return allLetterspace(event)" class="form-control" name="child_name" placeholder="Nama anak">
			  							<div class="form-control-feedback child_name"></div>
			  						</div>
			  						<div class="form-group col-md-6">
				  						<label for="reg-jk" class="sr-only">Tanggal Lahir Anak (diperlukan)</label>
				  						<input type="text" id="reg-jk" class="form-control pickdate" name="child_dob" placeholder="Tanggal lahir">
			  							<div class="form-control-feedback child_dob"></div>
			  						</div>
			  					</div>
		  					</div>

		  					<div style="display: none;" class="form-inline m-t-1">
			  					<span class="modal-title">Apakah Anda Sedang Hamil?</span>
			  					<div class="form-check">
				  					<label class="custom-control custom-radio">
										<input name="pregnant" value="1" type="radio" class="custom-control-input">
										<span class="custom-control-indicator"></span>
										<span class="custom-control-description"> Ya</span>
									</label>
									<label class="custom-control custom-radio">
										<input name="pregnant" value="0" type="radio" class="custom-control-input" checked>
										<span class="custom-control-indicator"></span>
										<span class="custom-control-description"> Tidak</span>
									</label>
			  					</div>
			  				</div>
		  					<div class="form-group hamil" style="display:none;">
							    <!--<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="pregnant">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description">Saya sedang hamil dengan masa kandungan</span>
								</label>-->
								<label>Saya sedang hamil dengan masa kandungan</label>
		  						<select class="selectpicker" data-style="btn-white" name="pregnancy_age">
		  							<option value="0">Pilih Usia</option>
		  							<option value="1">Trisemester I</option>
		  							<option value="2">Trisemester II</option>
		  							<option value="3">Trisemester III</option>
		  						</select>
								<div class="form-control-feedback pregnancy_age"></div>
		  					</div>

							<div class="form-group">
		  						<div id="registerCaptcha"></div>
		  						<div class="form-control-feedback captcha"></div>
		  					</div>

				  		 	<div class="form-check m-t-1">
							    <label class="custom-control custom-checkbox">
									<input type="hidden" class="custom-control-input" name="tnc" value="0">
									<input type="checkbox" class="custom-control-input" name="tnc" value="1">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description">Saya setuju dengan <a href="{{url:site uri=''}}">Syarat dan Ketentuan</a> Wyeth Nutrition</span>
								</label>
								<div class="form-control-feedback tnc"></div>
							</div>
							<div class="form-group">
								<button class="btn btn-red registerBtn" type="button">Register Blogger Parentingclub</button>
							</div>
		  				</form>
				  	</div>
			  	</div>
			</div>
		</div>
	</div><!-- /.modal-content -->
</div>
<script type="text/javascript">
	$(document).ready(function(){
		if(login_register=='register'){
			var $image = $('#register #image');
			var add_image=false;
			if(!$('#register #image').hasClass('cropper-hidden')){
				initCrop($image);
			}
		}

		tamp_last();

		$('#puGlobal').on('hide.bs.modal', function (e){
			window.location.reload();
		});

		var elem = $("#chars");
		$("#sort-bio").limiter(200, elem);
	});

	$(function() {
     $("#attachment-file").change(function (){
       var fileName = $(this).val();
       $("#attachment").val(fileName);
     });
  });

	(function($) {
		$.fn.extend( {
			limiter: function(limit, elem) {
				$(this).on("keyup focus", function() {
					setCount(this, elem);
				});
				function setCount(src, elem) {
					var chars = src.value.length;
					if (chars > limit) {
						src.value = src.value.substr(0, limit);
						chars = limit;
					}
					elem.html( limit - chars );
				}
				setCount($(this)[0], elem);
			}
		});
	})(jQuery);

</script>


<style type="text/css">
	.info-character{
		color: #818a91;
		display: inline-block;
		margin-left: 20px;
	}
	#chars{
		display: inline-block;
		/*font-size:11px;*/
	}

	@media screen and (min-width: 768px){

		.lr #register form{
	    	width: 320px;
	    	margin: auto;
		}
	}
</style>
