<div class="tab-pane <?= $page_active == 'settings' ? 'active' : ''; ?>" id="settings" role="tabpanel">
	<section class="inner">
		<div class="judul">
			<h3 class="page-subtitle">Account Settings</h3>
			<p>Pengaturan akun Parenting Club Anda.</p>
		</div>
		<div class="form-group row">
			<label class="col-4 col-form-label">Email</label>
			<div class="col-8">
				<input type="text" name="email" class="form-control" disabled value="<?= isset($this->current_user->email) ? $this->current_user->email : ''; ?>">
				<p class="form-text invalid-feedback email"></p>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-4 col-form-label">Password</label>
			<div class="col-8" id="pass-change">
				<button class="btn btn-capital btn-emas btn-sm" id="pass-change-btn">Change password <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
			</div>
			<div class="col-8" id="pass-input">
				<input type="password" name="old_password" class="form-control" placeholder="Current password">
				<p class="form-text invalid-feedback old_password"></p><br>
				<input type="password" name="password" class="form-control" placeholder="New password">
				<p class="form-text invalid-feedback password"></p><br>
				<input type="password" name="r_password" class="form-control" placeholder="Repeat new password">
				<p class="form-text invalid-feedback r_password"></p><br>
				<button class="btn btn-capital btn-primary btn-sm" id="pass-cancel">Cancel <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-4 col-form-label">Notification</label>
			<div class="col-8">
				<div class="notif-setting">
					<!-- <label class="checkbox">
					  <input type="checkbox" checked data-toggle="toggle" data-onstyle="yellow" data-offstyle="grey-2" data-width="200" data-height="40">
					</label> -->
					<label class="switch">
					  	<input type="checkbox" class="<?= $profile->notif == 'on' ? 'on' : 'off'; ?>" <?= $profile->notif == 'on' ? '' : 'checked'; ?>>
					  	<span class="slider"></span>
					</label>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-4 col-form-label">Social Media</label>
			<div class="col-8 btn-social">
				<?php if (!$profile->fb_id) { ?>
					<a href="<?= site_url('dashboard/link-fb'); ?>" class="btn btn-capital btn-facebook">Hubungkan dengan <i class="fa fa-facebook fa-fw" aria-hidden="true"></i></a>
				<?php } else { ?>
					<a href="<?= site_url('dashboard/unlink-fb'); ?>" class="btn btn-capital btn-facebook">Terhubung dengan <i class="fa fa-facebook fa-fw" aria-hidden="true"></i></a>
				<?php } ?>
				<!-- <?php if (!$profile->tw_id) { ?>
					<a href="<?= site_url('dashboard/link-tw'); ?>" class="btn btn-capital btn-twitter">Hubungkan dengan <i class="fa fa-twitter fa-fw" aria-hidden="true"></i></a>
				<?php } else { ?>
					<a href="<?= site_url('dashboard/unlink-tw'); ?>" class="btn btn-capital btn-twitter">Terhubung dengan <i class="fa fa-twitter fa-fw" aria-hidden="true"></i></a>
				<?php } ?> -->
			</div>
		</div>
		<div class="form-group btns">
			<button class="btn btn-primary btn-capital btn-lg" id="updateSettings">Update setting <i class="fa fa-arrow-circle-o-right ml-2" aria-hidden="true"></i></button>
		</div>
	</section>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#pass-change-btn').click(function(e) {
			$('#pass-change').hide();
			$('#pass-input').show();
			$('#updateSettings').addClass('change-pass');
		});

		$('#pass-cancel').click(function(e) {
			$('#pass-change').show();
			$('#pass-input').hide();
			$('#updateSettings').removeClass('change-pass');
		});

		$(document).on('click', '.notif-setting .switch input', function(){
			var status = $(this).hasClass('off') ? 'on' : 'off';

			if (status == 'off') {
				$(this).attr('class', status).removeAttr('checked');
			} else {
				$(this).attr('class', status).prop('checked');
			}

			$.ajax({
				type:'POST',
				url: SITE_URL+'dashboard/set-notif',
				dataType:'json',
				data:$.extend(tokens, {status:status}),
				success:function(res) {
					tmlft();
				}
		   	});
		});

		$(document).on('click', '#updateSettings', function() {
			var check = $(this).hasClass('change-pass');

			if (check) {
				var submit = {
					old_password: $('input[name=old_password]').val(),
					password: $('input[name=password]').val(),
					r_password: $('input[name=r_password]').val()
				};

				$.ajax({
					type:'POST',
					url: SITE_URL+'users/settings',
					dataType:'json',
					data:$.extend(tokens, submit),
					success:function(res) {
						tmlft();

						if (res.status) {
							// $('#puGlobal .img-responsive').hide();
							$('#puGlobal .modal-title').html('Sukses');
							$('#puGlobal .modal-body').html(res.message);
							$('#puGlobal').modal();
							$('#pass-cancel').click();
						} else {
							$.each(res.errors, function(i, error){
								$('input[name="'+i+'"]').addClass('is-invalid');
								$('.'+i).html(error);
							});
						}
					}
				});
			}
		});

		$(document).on('click', '#pass-cancel', function() {
			$('input[name=old_password]').val('').removeClass('is-invalid');
			$('input[name=password]').val('').removeClass('is-invalid');
			$('input[name=r_password]').val('').removeClass('is-invalid');
			$('.old_password').html('');
			$('.password').html('');
			$('.r_password').html('');
		});
	});
</script>
