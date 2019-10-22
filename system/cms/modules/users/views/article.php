<div class="tab-pane <?php echo $page_active=='view-artikel' ? 'active' : ''; ?>" id="view-artikel" role="tabpanel">
	<section>
		<div class="judul">
	  		<h3 class="page-subtitle">Artikel Anda</h3>
		  	<div class="row">
		  		<div class="col-md-8 p-r-0">
		  			Ayo berbagi cerita pengalaman Anda dalam mendukung kepintaran dan tumbuh kembang si Kecil.
		  		</div>
		  		<div class="col-md-4">
		  			<a href="#tulis-article" class="btn btn-red round w-100 btn-link"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Tulis artikel</a>
		  		</div>
		  	</div>
		</div>
		<?php
		if (!empty($users_article)) {
			foreach ($users_article as $key => $article) {
				if ($article->template!='no-image' and (!(array)$article->as_bg)==false) {
		?>
					<div class="row artikel">
						<div class="col-md-3 artikel-img">
			  			<div class="embed-responsive embed-responsive-1by1">
			  					<?=(!(array)$article->as_bg) ? '' : '<img src="'.base_url($article->as_bg).'">';?>
							</div>

						</div>
						<div class="col-md-9 artikel-detail">
							<h4 class="artikel-judul"><a href="<?=($article->status=='live') ? base_url('smart-stories/'.$article->slug) : '#';?>"><?=$article->title;?></a></h4>
							<div class="artikel-konten"><?=$article->intro;?></div>
							<div class="action"><span><?=$article->categories;?></span><span><?=$article->created;?></span><span>dibaca <?=$article->click;?></span><span>komentar <?=$article->count_comment;?></span><a href="<?=base_url('dashboard/edit-article/'.$article->slug);?>" class="none-btn-link" data-slug="<?=$article->slug;?>">Edit</a></div>
						</div>
					</div>
				<?php } else { ?>
					<div class="row artikel">
						<div class="col-md-12 artikel-detail">
							<h4 class="artikel-judul"><a href="<?=($article->status=='live') ? base_url('smart-stories/'.$article->slug) : '#';?>"><?=$article->title;?></a></h4>
							<div class="artikel-konten"><?=$article->intro;?></div>
							<div class="action"><span><?=$article->categories;?></span><span><?=$article->created;?></span><span>dibaca <?=$article->click;?></span><span>komentar <?=$article->count_comment;?></span><a href="<?=base_url('dashboard/edit-article/'.$article->slug);?>" class="none-btn-link" data-slug="<?=$article->slug;?>">Edit</a></div>
						</div>
					</div>
		<?php 	}
			}
		}
		?>
	</section>
</div>
