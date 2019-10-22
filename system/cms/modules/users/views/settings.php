<div class="tab-pane  <?php echo $page_active=='settings' ? 'active' : ''; ?>" id="settings" role="tabpanel">
	<section>
		<div class="judul">
			<h3 class="page-subtitle">Settings</h3>
			<p>Pengaturan akun Parenting Club Anda.</p>		
		</div>
		<?php echo form_open(); ?>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label">Email</label>
			<div class="col-md-9">
				<input type="text" name="email" class="form-control round" value="<?php echo isset($this->current_user->email) ? $this->current_user->email : ''; ?>" disabled>
				<p class="error email" style="display: none;"></p>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-md-3 col-form-label">Password</label>
			<div class="col-md-9" id="pass-change">
				<button type="button" class="btn btn-grey-2 btn-sm round" id="pass-change-btn">Change password</button>
			</div>
			<div class="col-md-9" id="pass-input">
				<input type="password" name="old_password" class="form-control" placeholder="Current password">
				<p class="error old_password" classstyle="display: none;"></p>
				<input type="password" name="password" class="form-control m-t-1" placeholder="New password">
				<p class="error password" classstyle="display: none;"></p>
				<input type="password" name="r_password" class="form-control m-t-1" placeholder="Repeat new password">
				<p class="error r_password" classstyle="display: none;"></p>
				<button type="button" class="btn btn-grey-2 round btn-sm" id="pass-cancel">Cancel</button>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label">Notification</label>
			<div class="col-md-9">
				<div class="notif-setting">
					<label class="checkbox">
						<input type="checkbox" data-toggle="toggle" data-onstyle="yellow" data-offstyle="grey-2" data-width="200" data-height="40" <?php echo $profile->notif=='on' ? 'checked' : ''; ?>>
					</label>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-md-3 col-form-label">Social Media</label>
			<div class="col-md-9">
				<?php
					if(!$profile->fb_id){
						echo '<a href="'.site_url('dashboard/link-fb').'" class="btn btn-fb round">Hubungkan dengan <i class="fa fa-facebook fa-fw" aria-hidden="true"></i></a>';
					}else{
						echo '<a href="'.site_url('dashboard/unlink-fb').'" class="btn btn-fb round">Terhubung dengan <i class="fa fa-facebook fa-fw" aria-hidden="true"></i></a>';
					}

					if(!$profile->tw_id){
		  				echo '<a href="'.site_url('dashboard/link-tw').'" class="btn btn-tw round">Terhubung dengan <i class="fa fa-twitter fa-fw" aria-hidden="true"></i></a>';
					}else{
		  				echo '<a href="'.site_url('dashboard/unlink-tw').'" class="btn btn-tw round">Hubungkan dengan <i class="fa fa-twitter fa-fw" aria-hidden="true"></i></a>';
					}
				?>
			</div>
		</div>
		<div class="form-group btns">
			<button class="btn btn-red btn-lg round" type="button" id="updateSettings">Update setting</button>
		</div
	<?php echo form_close(); ?>
	</section>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '.notif-setting .toggle.btn', function(){
			var status = $(this).hasClass('off') ? 'off' : 'on';
			$.ajax({
				type:'POST',
				url: SITE_URL+'dashboard/set-notif',
				dataType:'json',
				data:$.extend(tokens, {status:status}),
				success:function(res){
					tmlft();
				},
		   });
		});

		$(document).on('click', '#updateSettings', function(){
			var old_password = $('input[name=old_password]').val();
			var password = $('input[name=password]').val();
			var r_password = $('input[name=r_password]').val();

			$.ajax({
				type:'POST',
				url: SITE_URL+'users/settings',
				dataType:'json',
				data:$.extend(tokens, {old_password:old_password, password:password, r_password:r_password}),
				success:function(res){
					tmlft();
					if(res.status){
						$('#puGlobal .modal-title').html('Sukses');
						$('#puGlobal .modal-body').html(res.message);
						$('#puGlobal').modal();
						$('#pass-cancel').click();
					}else{
						$.each(res.errors, function(i, error){
							$('.'+i).html(error)
							$('.'+i).show()
						});
					}
				},
		   	});
		});

		$(document).on('click', '#pass-cancel', function(){
			$('input[name=old_password]').val('');
			$('input[name=password]').val('');
			$('input[name=r_password]').val('');
			$('.old_password').hide();
			$('.password').hide();
			$('.r_password').hide();
		});
	});
</script>