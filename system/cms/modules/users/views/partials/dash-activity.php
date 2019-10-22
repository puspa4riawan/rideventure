<div class="tab-pane <?= $page_active == 'my-activity' ? 'active' : ''; ?>" id="my-activity" role="tabpanel">
	<section class="inner">
		<div class="judul">
			<h3 class="page-subtitle">My Activity <span class="tag"><?= $activity_count; ?></span></h3>
		</div>

		<?php if (is_file('./'.$e_voucher)) { ?>
			<a href="https://www.blibli.com/promosi/wnpc-redemptionpage?utm_source=wnpc&utm_medium=website" target="_blank"><img src="<?= site_url($e_voucher.'?v='.time()); ?>" class="img-fluid m-b-2"></a>
		<?php } ?>

		<?php $this->load->view('activity_list'); ?>

		<?php if (ceil($activity_all_count / $per_page) > 1) { ?>
			<div class="btns">
				<a href="" id="load-more" class="btn btn-primary btn-capital">Tampilkan lebih banyak <i class="fa fa-arrow-circle-o-right ml-2" aria-hidden="true"></i></a>
			</div>
		<?php } ?>
	</section>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var total_page = '<?= ceil($activity_all_count / $per_page); ?>';
		var page = 1;
		$(document).on('click', '.alert .action', function(){
			$this = $(this);
			$('.alert').find('.artikel-judul, .artikel-konten').hide();
			$this.parents('.alert').find('.artikel-judul, .artikel-konten').fadeIn();
			var id = $this.attr('data-id');
			var status = $this.attr('data-status');
			tmlft();
			if(!$this.parents('.alert').hasClass('alert-grey')){
				$.ajax({
					type:'POST',
					url: SITE_URL+'users/read_notif',
					dataType:'json',
					data:$.extend(tokens, {id:id, status:status}),
					success:function(res){
						$this.parents('.alert').removeClass('alert-red');
						$this.parents('.alert').removeClass('alert-yellow');
						$this.parents('.alert').addClass('alert-grey');
					},
			   	});
			}
		});

		$(document).on('click', '.action-answer', function(){
			$this = $(this);
			// $('.alert').find('.artikel-judul, .artikel-konten').hide();
			// $this.parents('.alert').find('.artikel-judul, .artikel-konten').fadeIn();
			var id = $this.attr('data-id');
			tmlft();
			if(!$this.parents('.alert').hasClass('alert-grey')){
				$.ajax({
					type:'POST',
					url: SITE_URL+'users/read_notif_answer',
					dataType:'json',
					data:$.extend(tokens, {id:id}),
					success:function(res){
						$this.parents('.alert').removeClass('alert-red');
						$this.parents('.alert').removeClass('alert-yellow');
						$this.parents('.alert').addClass('alert-grey');
					},
			   	});
			}
		});

		$(document).on('click', '#load-more', function(e){
			e.preventDefault();
			page += 1;
			tmlft();
			$.ajax({
				type:'POST',
				url: SITE_URL+'users/more_notif',
				dataType:'json',
				data:$.extend(tokens, {page:page}),
				success:function(res){
					if(res.status){
						$('.row.btns').before(res.data);
					}

					if(page==total_page){
						$('.row.btns').remove();
					}
				},
		   	});
		});
	});
</script>
