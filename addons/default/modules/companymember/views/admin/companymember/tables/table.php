	<table cellspacing="0">
		<thead>
			<tr>
				<th width="5%"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')) ?></th>
				<th width="10%">Name</th>
				<th width="10%">Position</th>
				<th width="10%">Email</th>
				<th width="40%">Address</th>
				<th width="10%" style="text-align: center;"><?php echo lang('general:status_label') ?></th>
				<th width="15%" style="text-align: center;"><?php echo lang('global:actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($data_ as $value) : ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $value->id) ?></td>
					<td><?php echo $value->full_name; ?></td>
					<td><?php echo $value->position; ?></td>
					<td><?php echo $value->email; ?></td>
					<td><?php echo $value->address; ?></td>
					
					

                	<td style="text-align: center;"><?php echo lang('general:'.$value->status.'_label') ?></td>
					<td style="padding-top:10px; text-align: center;">
                        <a href="<?php echo ADMIN_URL.'/'.$module_url.'/edit/'.$value->id ?>" title="<?php echo lang('global:edit')?>" class="btn orange"><?php echo lang('global:edit')?></a>
                        <a href="javascript:void(0);" onclick=" $return_val = confirm($(this).attr('title')); if(!$return_val){return $return_val } var myForm =<?php echo htmlentities(json_encode(array('data_html'=>form_open(site_url(ADMIN_URL.'/'.$module_url.'/delete/'),array('id'=>'deleteForm')).form_hidden('id',$value->id).form_close()),JSON_HEX_APOS),ENT_QUOTES, 'UTF-8'); ?>;console.log(myForm); $('#deleteForm').remove();$('body').append(myForm.data_html);$('#deleteForm').trigger('submit');" title="<?php echo lang('global:delete')?>" class="btn red"><?php echo lang('global:delete')?></a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<?php $this->load->view('admin/partials/pagination') ?>

	<br>

	<div class="table_action_buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete', 'publish'))) ?>
	</div>
