<div id="main-container">
	<div class="lr" id="loginRegister">
      	<div class="modal-header">
    		<h4 class="modal-title">Yuk bergabung di Parenting Club</h4>
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
		  					

		  					<div class="form-group">
		  						<div class="input-group">
			  						<input readonly="" type="text" id="attachment" class="form-control" name="attachment" required placeholder="Attachment" autocomplete="off">
			  						<label for="attachment" class="sr-only">Attachment</label>
		  							<span class="input-group-btn" onclick="$('#attachment-file').click()" data-toggle="buttons">
										<label class="btn btn-white">
											<i class="fa fa-file fa-lg" aria-hidden="true"></i>
										</label>
									</span>
								</div>
		  					</div>
							<input id="attachment-file" name="file" type="file" style="display: none;" autocomplete="off">

		  					
							<div class="form-group">
								<button class="btn btn-red registerBtnTemp" type="button">Register</button>
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
	});

	$(function() {
     $("#attachment-file").change(function (){
       var fileName = $(this).val();
       $("#attachment").val(fileName);
     });
  });
</script>


<style type="text/css">
	@media screen and (min-width: 768px){

		.lr #register form{
	    	width: 320px;
	    	margin: auto;
		}
	}
</style>