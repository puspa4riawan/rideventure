	<table cellspacing="0">
		<thead>
			<tr>
				<th width="5%"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')) ?></th>
				<th width="20%">Name</th>
				<th width="25%">Email</th>
				<th width="25%">Reason</th>
				<th width="15%">Date</th>
				<th width="10%">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			foreach ($data_ as $value) : ?>
				<tr>
					<td><?=form_checkbox('action_to[]', $value->id);?></td>
					<td><?=$value->name;?></td>
					<td><?=$value->email;?></td>
					<td><?=$value->reason;?></td>
                	<td><?=$value->created_at;?></td>
                	<td><button class="btn blue resolveBtn" data-id="<?php echo $value->id; ?>">Resolve</button></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<?php $this->load->view('admin/partials/pagination') ?>

	<div class="hidden">
		<div id="message">
			
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.resolveBtn', function(e){
				e.preventDefault();
				var id = $(this).attr('data-id');
				$.ajax({
			        type: "POST",
			        url: SITE_URL+ADMIN_URL+'/users/login_log/resolve',
			        data: $.extend({id:id}, tokens),
			        dataType: 'json',
			        success: function(res){
			        	$('#message').html(res.message);
						$.colorbox({
							scrolling	: false,
							inline		: true,
							href		: '#message',
							width		: '25%',
							height		: 'auto',
						});
			        },
			    });
			});
		});
	</script>