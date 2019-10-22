<div class="container">
	<fieldset id="filters">
		<?php echo form_open('') ?>
		<?php echo form_hidden('f_module', $module_details['slug']) ?>
			<ul class="export-user">
				<li>
					<?php echo '<b>Tanggal Awal</b><br />'; ?>
					<?php echo form_input('f_date_start','','class="form-control"') ?>
				</li>
				<li>
					<?php echo '<b>Tanggal Akhir</b><br />'; ?>
					<?php echo form_input('f_date_end','','class="form-control"') ?>
				</li>
				<li>
					<?php echo '<b>Keperluan</b><br />'; ?>
					<input type="radio" class="keperluan" name="fa_keperluan" value="all_user"> All User<br>
					<input type="radio" class="keperluan" name="fa_keperluan" value="active_user"> Active User<br>
					<input type="radio" class="keperluan" name="fa_keperluan" value="fa_pending"> Ability Finder Pending<br>
					<input type="radio" class="keperluan" name="fa_keperluan" value="fa"> Ability Finder<br>
					<input type="radio" class="keperluan" name="fa_keperluan" value="one_year_child_noquiz"> All Child Above One Year<br>
					<input type="radio" class="keperluan" name="fa_keperluan" value="one_year_child"> Child Above One Year Finish SSF<br>
				</li>
				<li>
					<a href="javascript:void(0);" title="Export Data" class="btn btn-red round" id="export-data">Export Data CSV</a>
					&nbsp;&nbsp;&nbsp;
					<a href="javascript:void(0);" title="Export Data" class="btn btn-red round" id="export-data-json">Export Data JSON</a>
				</li>
			</ul>
		<?php echo form_close() ?>
	</fieldset>
	<fieldset id="filters">
		<h3>Export Data Ask The Expert</h3>
		<?php echo form_open('5x7-u9r') ?>
		<?php echo form_hidden('f_module', $module_details['slug']) ?>
			<ul class="export-user">
				<li>
					<?php echo '<b>Tanggal Awal</b><br />'; ?>
					<?php echo form_input('f_from','','class="form-control"') ?>
				</li>
				<li>
					<?php echo '<b>Tanggal Akhir</b><br />'; ?>
					<?php echo form_input('f_to','','class="form-control"') ?>
				</li>
				<li>
					<?php echo '<b>Dokter</b><br />'; ?>
					<?php echo form_dropdown('f_doctor',array(''=>'Pilih Dokter')+$doctor, '','class="form-control"') ?>
				</li>
				<li>
					<?php echo '<b>Status</b><br />'; ?>
					<?php echo form_dropdown('f_status',array(''=>'Pilih Status', 'publish'=>'Publish', 'unpublish'=>'UnPublish'), '','class="form-control"') ?>
				</li>
				<li>
					<?php echo '<b>Keyword</b><br />'; ?>
					<?php echo form_input('f_keywords','','class="form-control"') ?>
				</li>
				<li>
					<input type="submit" value="Export Data" class="btn btn-red round" id="export-data-ae">
				</li>
			</ul>
		<?php echo form_close() ?>
	</fieldset>
</div>

<script type="text/javascript">
	$( "input[name='f_date_start']" ).datepicker({
    	format: "yyyy-mm-dd",
    	onSelect : function(selected){
    		$("input[name='f_date_start']").trigger('datepicking');
    		$("input[name='f_date_end']").datepicker("option","minDate", selected);
    		$("input[name='f_date_start']").trigger('keyup');
    	}
    });
    $( "input[name='f_date_end']" ).datepicker({
    	format: "yyyy-mm-dd",
    	onSelect : function(selected){
    		$("input[name='f_date_end']").trigger('datepicking');
    		$("input[name='f_date_start']").datepicker("option","maxDate", selected);
    		$("input[name='f_date_end']").trigger('keyup');
    	}
    });

    $( "input[name='f_from']" ).datepicker({
    	format: "yyyy-mm-dd",
    	onSelect : function(selected){
    		$("input[name='f_from']").trigger('datepicking');
    		$("input[name='f_to']").datepicker("option","minDate", selected);
    		$("input[name='f_from']").trigger('keyup');
    	}
    });
    $( "input[name='f_to']" ).datepicker({
    	format: "yyyy-mm-dd",
    	onSelect : function(selected){
    		$("input[name='f_to']").trigger('datepicking');
    		$("input[name='f_from']").datepicker("option","maxDate", selected);
    		$("input[name='f_to']").trigger('keyup');
    	}
    });
	
	$('#export-data').click(function(){
		var date_from = $( "input[name='f_date_start']" ).val();
			if(date_from==''){ date_from=0; }
		var date_end = $( "input[name='f_date_end']" ).val();
			if(date_end==''){ date_end=0; }
		keperluan = $('input[name="fa_keperluan"]:checked').val();

		window.location.href=SITE_URL+'5x7-u7r/'+date_from+'/'+date_end+'?keperluan='+keperluan;
	});

	$('#export-data-json').click(function(){
		var date_from = $( "input[name='f_date_start']" ).val();
			if(date_from==''){ date_from=0; }
		var date_end = $( "input[name='f_date_end']" ).val();
			if(date_end==''){ date_end=0; }
		keperluan = $('input[name="fa_keperluan"]:checked').val();

		window.location.href=SITE_URL+'5x7-u8r/'+date_from+'/'+date_end+'?keperluan='+keperluan;
	});
</script>