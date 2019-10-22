<fieldset id="filters">
	<legend><?php echo lang('global:filters') ?></legend>

	<?php echo form_open('', '', array('f_module' => $module_details['slug'])) ?>
        
		<ul>
			<li class="">
        		<label for="f_status"><?php echo lang('general:status_label') ?></label>
        		<?php echo form_dropdown('f_status', array(0 => lang('global:select-all'), 'draft'=>lang('general:draft_label'), 'live'=>lang('general:live_label'))) ?>
			</li>

			<li class="" style="top: -8px;">
				<label for="f_category"><?php echo lang('category:label_title') ?></label>
				<?php echo form_input('f_keywords', '', 'style="width: 95%;"') ?>
			</li>
		</ul>
	<?php echo form_close() ?>

    <!-- <button id="export_data" class="btn blue">Export</button> -->
</fieldset>

<script type="text/javascript">
    $(document).ready(function(){
        $('#export_data').click(function(){
            var status = $('select[name="f_status"]').val();
            if (status == '') { status = 0 }

            window.location.href = SITE_URL+ADMIN_URL+'/category/export_data/'+status;
        });
    });
</script>