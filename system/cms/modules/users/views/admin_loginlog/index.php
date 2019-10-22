<div class="one_full">
	<section class="title">
		<h4>Login Log</h4>
	</section>

	<section class="item">
		<div class="content">
			<?php if ($data_) : ?>
				<?php  echo $this->load->view('admin_loginlog/partials/filters') ?>
	
				<?php echo form_open(ADMIN_URL.'/users/login_log/action') ?>
					<div id="filter-stage">
						<?php echo $this->load->view('admin_loginlog/tables/table') ?>
					</div>
				<?php echo form_close() ?>
			<?php else : ?>
				<div class="no_data">No Data Found</div>
			<?php endif ?>
		</div>
	</section>
</div>
