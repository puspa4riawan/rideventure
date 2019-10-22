<main id="mainContent" class="p-forgotPass">
	<div class="container c-inner mainPadding">
		<div class="row">
			<div class="col-12 col-md-6 mx-auto">
				<?php
  				if($message = $this->session->flashdata('success')){
  					echo '<div class="alert alert-success" role="alert">'.$message.'</div>';
  				}
	  			?>
				<?php echo form_open(); ?>
					<div class="form-group mb-4">
						<label for=""><strong>Password</strong></label>
						<input class="form-control" type="password" name="password" value="<?php echo isset($data->password) ? $data->password: ''; ?>" placeholder>
						<?php if($error = form_error('password')){ echo '<p class="error password">'.$error.'</p>'; } ?>
					</div>
					<div class="form-group mb-4">
						<label for=""><strong>Repeat Password</strong></label>
						<input class="form-control" type="password" name="r_password" value="<?php echo isset($data->r_password) ? $data->r_password: ''; ?>" placeholder>
						<?php if($error = form_error('r_password')){ echo '<p class="error r_password">'.$error.'</p>'; } ?>
					</div>
					<div class="form-group">
						<button class="btn btn-primary btn-lg btn-capital" type="submit">Reset Password <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</main>