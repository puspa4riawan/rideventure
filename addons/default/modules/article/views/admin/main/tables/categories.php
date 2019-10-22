<table cellspacing="0">
	<thead>
		<tr>
			<th width="50%"><?php echo lang('categories:label_title') ?></th>
			<th width="25%" style="text-align: center;"><?php echo lang('general:status_label') ?></th>
			<th width="25%" style="text-align: center;"><?php echo lang('global:actions') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php 

		foreach ($data_categories as $value) : ?>
			<tr>
				<td><?php echo $value->title ?></td>
            	<td style="text-align: center;"><?php echo lang('general:'.$value->status.'_label') ?></td>
				<td style="padding-top:10px; text-align: center;">
                   <!--  <a href="<?php echo site_url(ADMIN_URL.'/article/admin_categories/edit/'.$value->categories_id) ?>" title="<?php echo lang('global:edit')?>" class="btn orange"><?php echo lang('global:edit')?></a>
					<a href="<?php echo site_url(ADMIN_URL.'/article/admin_categories/delete/'.$value->categories_id) ?>" title="<?php echo lang('global:delete')?>" class="btn red"><?php echo lang('global:delete')?></a> -->
					<a href="#" class="label label-primary" style="padding: 5px;" data-toggle="tooltip" data-original-title="edit"><i class="glyphicon glyphicon-pencil"></i></a>
					<a href="#" class="label label-danger" style="padding: 5px;"><i class="glyphicon glyphicon-remove"></i></a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>