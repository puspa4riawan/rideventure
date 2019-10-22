<div id="main-container" class="dash">
	<div class="container">
		<?php $this->load->view('menu'); ?>
		<div class="col-md-8 dash-main">
			<div class="tab-content">
				<?php if($this->current_user->group_id==3){ $this->load->view('article');$this->load->view('tulis-article');$this->load->view('edit-article'); }	?>
				<?php $this->load->view('edit'); ?>
				<?php $this->load->view('my_activity'); ?>
				<?php $this->load->view('settings'); ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var segment1 = '<?php echo $this->uri->segment(1); ?>';
	var segment2 = '<?php echo $this->uri->segment(2); ?>';
	$(document).ready(function(){
		$('.dash-aside .nav-link, .btn-link').on('click', function(e){
			var page = $(this).attr('href');
			page = page.replace(/\#/g, '');
			$('.tab-pane').removeClass('active');
			if (page=='tulis-article') {
				$('#tulis-artikel').addClass('active');
				$('#view-artikel').removeClass('active');
				$('#edit-artikel').removeClass('active');
				fixRatio();
			} else if (page=='view-artikel') {
				$('#tulis-artikel').removeClass('active');
				$('#edit-artikel').removeClass('active');
				$('#view-artikel').addClass('active');
			} else if (page=='edit-article') {
				// slug = e.currentTarget.dataset.slug;
				$('#tulis-artikel').removeClass('active');
				$('#view-artikel').removeClass('active');
				$('#edit-artikel').addClass('active');
			}
			$('#'+page).addClass('active');
			
			if(segment2==''){
				segment2 = page;
				page = segment1+'/'+page;
			}
			
			history.pushState('', page.toUpperCase, page);
			setTimeout(function(){
				$(window).resize();
    		}, 200);
		});
	});
</script>