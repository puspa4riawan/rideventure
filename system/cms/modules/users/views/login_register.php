<div id="main-container">
	<div class="lr" id="loginRegister">
      	<div class="modal-header">
    		<h4 class="modal-title">Yuk bergabung di Parenting Club</h4>
			<ul class="nav nav-tabs" role="tablist">
			  	<li class="nav-item">
			    	<a class="nav-link <?php echo $login_register=='login' ? 'active' : ''; ?>" data-toggle="tab" id="login-menu" href="#login" role="tab">Login</a>
			  	</li>
			  	<li class="nav-item">
			    	<a class="nav-link <?php echo $login_register=='register' ? 'active' : ''; ?>" data-toggle="tab" id="register-menu" href="#register" role="tab">Register</a>
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

			  	<div class="tab-pane <?php echo $login_register=='register' ? 'active' : ''; ?>" id="register" role="tabpanel">
				  	<div class="container-fluid">
					  	<div class="btns">
					  		<a href="{{url:site uri='fb-connect'}}" class="btn btn-fb">Register dengan <i class="fa fa-facebook fa-fw" aria-hidden="true"></i></a>
					  		<a href="{{url:site uri='tw-connect'}}" class="btn btn-tw">Register dengan <i class="fa fa-twitter fa-fw" aria-hidden="true"></i></a>
					  	</div>
				  		<div class="row">
				  			<div class="col-md-6">
				  				<h3 class="modal-title">Gambar Profile</h3>
				  				<p>Upload foto profil terbaik Anda dan si Kecil di sini.</p>
				  				<div class="fix-ratio w-100 m-b-1" ratio="1:1">
				  					<img id="image" src="{{theme:image_url file='default-img.jpg'}}" style="width:100%;max-width:100%">
				  				</div>
				  				<div class="btns">
				  					<input type="file" id="inputImage" class="sr-only" name="file" accept="image/*">
				  					<a href="javascript:void(0)" class="btn btn-red" id="uploadBtn">Upload Foto</a>
				  				</div>
				  			</div>
				  			<div class="col-md-6">
				  				<form>
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
				  					<span>Password minimal 8 Karakter, yang berisi angka, huruf dan karakter simbol</span>
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

				  					<div class="form-group m-t-1">
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

				  					<div class="form-inline m-t-1">
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
											<input type="checkbox" class="custom-control-input" name="tnc">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description">Saya setuju dengan <a href="{{url:site uri=''}}">Syarat dan Ketentuan</a> Wyeth Nutrition</span>
										</label>
										<div class="form-control-feedback tnc"></div>
									</div>
									<div class="form-group">
										<button class="btn btn-red registerBtn" type="button">Register</button>
									</div>
				  				</form>
				  			</div>
				  		</div>
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
	});
</script>
