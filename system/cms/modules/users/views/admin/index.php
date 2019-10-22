<section class="title">
	<h4><?php echo lang('user:list_title') ?></h4>
</section>

<section class="item">
	<div class="content">

		<?php template_partial('filters') ?>

		<?php echo form_open(ADMIN_URL.'/users/action') ?>
			<div class="table_action_buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('activate', 'delete') )) ?>
				<button type="submit" name="btnAction" value="verify_blogger" class="btn green" disabled="">
					<span>Verify Blogger</span>
				</button>
				<button type="submit" name="btnAction" value="verify_expert" class="btn green" disabled="">
					<span>Verify Expert</span>
				</button>
			</div>

			<div id="filter-stage">
				<?php template_partial('tables/users') ?>
			</div>

			<div class="table_action_buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('activate', 'delete') )) ?>
				<button type="submit" name="btnAction" value="verify_blogger" class="btn green" disabled="">
					<span>Verify Blogger</span>
				</button>
				<button type="submit" name="btnAction" value="verify_expert" class="btn green" disabled="">
					<span>Verify Expert</span>
				</button>
			</div>

		<?php echo form_close() ?>
	</div>
</section>
