<fieldset id="filters">
	<legend><?php echo lang('global:filters') ?></legend>

	<?php echo form_open('', '', array('f_module' => $module_details['slug'])) ?>
		<ul>
			<li>
				<label for="f_from">From</label>
				<?php echo form_input('f_from') ?>
			</li>
			<li>
				<label for="f_to">To</label>
				<?php echo form_input('f_to') ?>
			</li>			
			
		</ul>
		<!-- <ul>
			<li>
				<label for="f_kids">Mom With</label>
				<?php echo form_dropdown('f_kids', array(''=>'Select Options', 1=>'One Kid', 2=>'Two Kisd', 3=>'Three Kids')) ?>
			</li>
			<li>
				<label for="f_kidsage">Kids Age</label>
				<?php echo form_dropdown('f_kidsage', array(''=>'Select Options', 1=>'0-2 Years', 2=>'3-4 Years', 3=>'5-6 Years')) ?>
			</li>			
		</ul> -->
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