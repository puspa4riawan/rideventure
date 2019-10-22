<div class="full-width-div">
	<div class="row">
		<div class="one_full box-two">
			<section class="title">
				<h4><?php echo lang('kidsage:title') ?></h4>
			</section>

			<section class="item">
				<div class="content">
					<?php if ($data_kidsage) : ?>	
						<?php echo form_open(ADMIN_URL.'/article/admin_kidsage/action') ?>
							<div id="filter-stage">
								<?php echo $this->load->view('admin/main/tables/kidsage') ?>
							</div>
						<?php echo form_close() ?>
					<?php else : ?>
						<div class="no_data"><?php echo lang('general:no_data') ?></div>
					<?php endif ?>
				</div>
			</section>
		</div>

		<div class="one_full box-two">
			<section class="title">
				<h4><?php echo lang('categories:title') ?></h4>
				<a href="#" class="label label-info">see more <i class="glyphicon glyphicon-menu-right"></i></a>

			</section>

			<section class="item">
				<div class="content">
					<?php if ($data_categories) : ?>
						<?php echo form_open(ADMIN_URL.'/article/admin_categories/action') ?>
							<div id="filter-stage">
								<?php echo $this->load->view('admin/main/tables/categories') ?>
							</div>
						<?php echo form_close() ?>
					<?php else : ?>
						<div class="no_data"><?php echo lang('general:no_data') ?></div>
					<?php endif ?>
				</div>
			</section>
		</div>
	</div>	
</div>
<div class="one_full">
	<section class="title">
		<h4><?php echo lang('article:title') ?></h4>
	</section>

	<section class="item">
		<div class="content">
			<?php if ($data_article) : ?>	
				<?php echo form_open(ADMIN_URL.'/article/admin_kidsage/action') ?>
					<div id="filter-stage">
						<?php echo $this->load->view('admin/main/tables/kidsage') ?>
					</div>
				<?php echo form_close() ?>
			<?php else : ?>
				<div class="no_data"><?php echo lang('general:no_data') ?></div>
			<?php endif ?>
		</div>
	</section>
</div>
<div class="one_full">
	<section class="title">
		<h4><?php echo lang('comments:title') ?></h4>
	</section>

	<section class="item">
		<div class="content">
			<?php if ($data_comments) : ?>	
				<?php echo form_open(ADMIN_URL.'/article/admin_kidsage/action') ?>
					<div id="filter-stage">
						<?php echo $this->load->view('admin/main/tables/kidsage') ?>
					</div>
				<?php echo form_close() ?>
			<?php else : ?>
				<div class="no_data"><?php echo lang('general:no_data') ?></div>
			<?php endif ?>
		</div>
	</section>
</div>

<div class="one_full">
	<section class="title">
		<h4><?php echo lang('authors:title') ?></h4>
	</section>

	<section class="item">
		<div class="content">
			<?php if ($data_authors) : ?>	
				<?php echo form_open(ADMIN_URL.'/article/admin_kidsage/action') ?>
					<div id="filter-stage">
						<?php echo $this->load->view('admin/main/tables/kidsage') ?>
					</div>
				<?php echo form_close() ?>
			<?php else : ?>
				<div class="no_data"><?php echo lang('general:no_data') ?></div>
			<?php endif ?>
		</div>
	</section>
</div>
