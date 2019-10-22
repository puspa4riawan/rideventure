<table cellspacing="0">
	<thead>
		<tr>
			<th width="15%"><?php echo lang('kidsage:label_title') ?></th>
			<th width="10%"><?php echo lang('kidsage:icon'); ?></th>
			<th width="15%" style="text-align: center;"><?php echo lang('general:status_label') ?></th>
			<th width="25%" style="text-align: center;"><?php echo lang('global:actions') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php 

		foreach ($data_kidsage as $value) : ?>
			<tr>
				<td><?php echo $value->title ?></td>
				<td>
					<?php
						if($value->full_path != '') {

							echo '<img src="'.$value->full_path.'" style="width: 100px; height: auto;">';
						}else {

							$src = Asset::get_filepath_img('module::no-available-image.png');
                        	echo '<img src="'.$src.'" style="width: 100px; height: auto;">';
						}
					?>
				</td>
            	<td style="text-align: center;"><?php echo lang('general:'.$value->status.'_label') ?></td>
				<td style="padding-top:10px; text-align: center;">
                    <a href="<?php echo site_url(ADMIN_URL.'/article/admin_kidsage/edit/'.$value->kidsage_id) ?>" title="<?php echo lang('global:edit')?>" class="btn orange"><?php echo lang('global:edit')?></a>
					<a href="<?php echo site_url(ADMIN_URL.'/article/admin_kidsage/delete/'.$value->kidsage_id) ?>" title="<?php echo lang('global:delete')?>" class="btn red"><?php echo lang('global:delete')?></a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>