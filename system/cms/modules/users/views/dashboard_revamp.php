<div class="container c-inner">
	<div class="row">
		<?php $this->load->view('menu_revamp'); ?>
		<div class="dash-main">
			<div class="tab-content">
				<?php if ($this->current_user->group_id == 3) {
					$this->load->view('users/partials/dash-view-artikel');
					$this->load->view('users/partials/dash-tulis-artikel');
					$this->load->view('users/partials/dash-edit-artikel');
					$this->load->view('users/partials/dash-activity');
				} ?>
				<?php if ($this->current_user->group_id == 2) {
					$this->load->view('users/partials/dash-activity');
				} ?>
				<?php if ($this->current_user->group_id == 5 || $this->current_user->group_id == 6) {
					$this->load->view('users/partials/dash-expert');
				} ?>
				<?php $this->load->view('users/partials/dash-edit-profile'); ?>
				<?php $this->load->view('users/partials/dash-settings'); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
    	<?php $_class = $expert ? 'profile-dashboard expert-dashboard' : 'profile-dashboard'; ?>
    	$('#mainContent').addClass('<?= $_class; ?>');
    });
</script>
<script type="text/javascript">
	var segment1 = '<?= $this->uri->segment(1); ?>';
	var segment2 = '<?= $this->uri->segment(2); ?>';
	$(document).ready(function() {
		$('.dash-aside .nav-link').on('click', function(e) {
			var page = $(this).attr('href').replace(/\#/g, '');

			$('.tab-pane').removeClass('active');

            if (page == 'tulis-artikel') {
				$('#tulis-artikel').addClass('active');
				$('#view-artikel').removeClass('active');
				$('#edit-artikel').removeClass('active');
				fixRatio();
			} else if (page == 'view-artikel') {
				$('#tulis-artikel').removeClass('active');
				$('#edit-artikel').removeClass('active');
				$('#view-artikel').addClass('active');
			} else if (page == 'edit-artikel') {
				// slug = e.currentTarget.dataset.slug;
				$('#tulis-artikel').removeClass('active');
				$('#view-artikel').removeClass('active');
				$('#edit-artikel').addClass('active');
			}
			$('#'+page).addClass('active');

			if (segment2 == '') {
				segment2 = page;
				page = segment1+'/'+page;
			} else {
				page = segment1+'/'+page;
			}

			history.pushState({}, '', SITE_URL+page);
			setTimeout(function() {
				$(window).resize();
    		}, 200);
		});
	});
</script>
