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
						<label for=""><strong>Email</strong></label>
						<input class="form-control" type="email" name="email" value="<?php echo isset($data->email) ? $data->email: ''; ?>">
						<?php if($error = form_error('email')){ echo '<p class="error email">'.$error.'</p>'; } ?>
					</div>
					<div class="form-group">
						<button class="btn btn-primary btn-lg btn-capital" type="submit">Forgot Password <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</main>