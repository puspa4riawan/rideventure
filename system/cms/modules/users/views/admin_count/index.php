<div class="one_full">
	<section class="title">
		<h4>User Count</h4>
	</section>

	<section class="item">
		<div class="content">
				<?php  echo $this->load->view('users/admin_count/partials/filters') ?>
	
				<?php echo form_open(ADMIN_URL.'/users/count/action') ?>
					<div id="filter-stage">
						<?php echo $this->load->view('users/admin_count/tables/table') ?>
					</div>
				<?php echo form_close() ?>
			
		</div>
	</section>
</div>
