	<table cellspacing="0">
		<thead>
			<tr>
				<th width="5%"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')) ?></th>
				<th width="20%"><?php echo lang('categories:label_title') ?></th>
				<th width="10%" style="text-align: center;"><?php echo lang('categories:icon')?></th>
				<th width="5%" style="text-align: center;">Order</th>
				<th width="20%" style="text-align: center;"><?php echo lang('general:status_label') ?></th>
				<th width="30%" style="text-align: center;"><?php echo lang('global:actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php 
			foreach ($data_ as $value) : ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $value->categories_id) ?></td>
					<td><?php echo $value->title ?></td>
					<td style="text-align: center;">
						<?php 
							if($value->filename != '') {

                                $src = base_url($value->full_path);
                            }else {

                                $src = Asset::get_filepath_img('module::no-available-image.png');
                            }  
					 	?>
					 	<img src="<?php echo $src;?>" style="width: 50px; height: auto; background: #F3F3F3;">
					</td>
                	<td style="text-align: center;"><?php echo $value->order;?></td>
                	<td style="text-align: center;"><?php echo lang('general:'.$value->status.'_label') ?></td>
					<td style="padding-top:10px; text-align: center;">
                        <a href="<?php echo site_url(ADMIN_URL.'/article/admin_categories/edit/'.$value->categories_id) ?>" title="<?php echo lang('global:edit')?>" class="btn orange"><?php echo lang('global:edit')?></a>
                        <a href="javascript:void(0);" onclick=" $return_val = confirm($(this).attr('title')); if(!$return_val){return $return_val } var myForm =<?php echo htmlentities(json_encode(array('data_html'=>form_open(site_url(ADMIN_URL.'/article/'.$u_admin.'/delete/'),array('id'=>'deleteForm')).form_hidden('id',$value->categories_id).form_close()),JSON_HEX_APOS),ENT_QUOTES, 'UTF-8'); ?>;console.log(myForm); $('#deleteForm').remove();$('body').append(myForm.data_html);$('#deleteForm').trigger('submit');" title="<?php echo lang('global:delete')?>" class="btn red"><?php echo lang('global:delete')?></a>
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