	<table cellspacing="0">
		<thead>
			<tr>
				<th width="5%"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')) ?></th>
				<th width="10%"><?php echo lang('articles:label_title') ?></th>
				<th width="20%"><?php echo lang('categories:title') ?></th>
				<th width="40%"><?php echo lang('articles:desc') ?></th>
				<th width="10%" style="text-align: center;"><?php echo lang('general:status_label') ?></th>
				<th width="15%" style="text-align: center;"><?php echo lang('global:actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($data_ as $value) : ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $value->article_id) ?></td>
					<td><?php echo $value->title; ?></td>
					<td>
					<?php

						$selected_category = (array) explode(",", $value->categories_id);
						foreach ($category as $cat) {
							if(in_array($cat->id,$selected_category)) {
								echo '* '.$cat->name.'<br />';
							}
						}
					?>
					</td>
					<td><?php echo $value->description; ?></td>
					<!-- <td>
						<?php
						if($value->featured==1){
							$featured = 'YES';
						} else {
							$featured = 'NO';
						}
						?>
						<span class="info-featured"><?php echo $featured; ?></span><br /><br />
						<input type="button" name="" value="Update" class="set-featured" data-id="<?php echo $value->article_id; ?>" data-featured="<?php echo ($value->featured==null) ? 1 : 0; ?>" />
					</td> -->
					

                	<td style="text-align: center;"><?php echo lang('general:'.$value->status.'_label') ?></td>
					<td style="padding-top:10px; text-align: center;">
                        <a href="<?php echo ADMIN_URL.'/article/'.$u_admin.'/edit/'.$value->article_id ?>" title="<?php echo lang('global:edit')?>" class="btn orange"><?php echo lang('global:edit')?></a>
                        <a href="javascript:void(0);" onclick=" $return_val = confirm($(this).attr('title')); if(!$return_val){return $return_val } var myForm =<?php echo htmlentities(json_encode(array('data_html'=>form_open(site_url(ADMIN_URL.'/article/'.$u_admin.'/delete/'),array('id'=>'deleteForm')).form_hidden('id',$value->article_id).form_close()),JSON_HEX_APOS),ENT_QUOTES, 'UTF-8'); ?>;console.log(myForm); $('#deleteForm').remove();$('body').append(myForm.data_html);$('#deleteForm').trigger('submit');" title="<?php echo lang('global:delete')?>" class="btn red"><?php echo lang('global:delete')?></a>
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
