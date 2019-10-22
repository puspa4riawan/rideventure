<fieldset id="filters">
	<legend><?php echo lang('global:filters') ?></legend>

	<?php echo form_open('', '', array('f_module' => $module_details['slug'])) ?>
		<ul>
			<li class="">
        		<label for="f_status"><?php echo lang('general:status_label') ?></label>
        		<?php echo form_dropdown('f_status', array(0 => lang('global:select-all'), 'draft'=>lang('general:draft_label'), 'live'=>lang('general:live_label'))) ?>
    		</li>
			<li class="" style="top: 12px;">
				<label for="f_category"><?php echo lang('categories:label_title') ?></label>
				<?php echo form_input('f_keywords', '', 'style="width: 95%;"') ?>
			</li>

			<li class="" style="top: -15px;">
				<?php echo anchor(current_url() . '#', lang('buttons:cancel'), 'class="btn blue"') ?>
			</li>
		</ul>
	<?php echo form_close() ?>
</fieldset>