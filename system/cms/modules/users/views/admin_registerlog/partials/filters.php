<fieldset id="filters">
	<legend><?php echo lang('global:filters') ?></legend>

	<?php echo form_open('', '', array('f_module' => $module_details['slug'])) ?>
		<ul>
			<li>
				<label for="f_keywords">Keywords</label>
				<?php echo form_input('f_keywords') ?>
			</li>
			<li>
				<label for="f_from">From</label>
				<?php echo form_input('f_from') ?>
			</li>
			<li>
				<label for="f_to">To</label>
				<?php echo form_input('f_to') ?>
			</li>			
			<li class="" style="top: -15px;">
				<?php echo anchor(current_url() . '#', lang('buttons:cancel'), 'class="btn blue"') ?>
			</li>
		</ul>
	<?php echo form_close() ?>
</fieldset>
<script type="text/javascript">
	$( "input[name='f_from']" ).datepicker({
        dateFormat: "yy-mm-dd",
        onSelect : function(selected){
            $("input[name='f_from']").trigger('datepicking')
            $("input[name='f_to']").datepicker("option","minDate", selected)
            $("input[name='f_from']").trigger('keyup');
        }
    });
    $( "input[name='f_to']" ).datepicker({
        dateFormat: "yy-mm-dd",
        onSelect : function(selected){
            $("input[name='f_to']").trigger('datepicking')
            $("input[name='f_from']").datepicker("option","maxDate", selected)
            $("input[name='f_to']").trigger('keyup');
        }
    });
</script>