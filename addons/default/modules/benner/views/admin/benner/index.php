<div class="one_full">
	<section class="title">
		<h4><?php echo lang('benner:title') ?></h4>
	</section>

	<section class="item">
		<div class="content">
			<?php if ($data_) : ?>
				<?php  echo $this->load->view('admin/benner/partials/filters') ?>
	
				<?php echo form_open(ADMIN_URL.'/benner/'.$u_admin.'/action') ?>
					<div id="filter-stage">
						<?php echo $this->load->view('admin/benner/tables/table') ?>
					</div>
				<?php echo form_close() ?>
			<?php else : ?>
				<div class="no_data"><?php echo lang('general:no_data') ?></div>
			<?php endif ?>
		</div>
	</section>
</div>
