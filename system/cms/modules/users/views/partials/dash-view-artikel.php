<div class="tab-pane <?= $page_active == 'view-artikel' ? 'active' : ''; ?>" id="view-artikel" role="tabpanel">
	<section class="inner">
		<div class="judul">
			<h3 class="page-subtitle">Artikel Anda</h3>
			<p class="mb-2">Ayo berbagi cerita pengalaman Anda dalam mendukung kepintaran dan tumbuh kembang si Kecil.</p>
			<a href="javascript:void();" class="btn btn-capital btn-primary d-block w-100" id="write-new-article"><i class="fa fa-pencil-square-o mr-2" aria-hidden="true"></i>Tulis artikel</a>
		</div>

		<div class="a-list">
			<?php
			if (!empty($users_article)) {
				foreach ($users_article as $key => $article) {
					$_class = '';
					$_img = '';
					if ($article->template!='no-image' and (!(array)$article->as_bg)==false) {
						$_class = 'w-img';
						$_img = (!(array)$article->as_bg) ? '' : base_url($article->as_bg);
					}
			?>
					<div class="atc <?= $_class; ?>">
						<?php if (!empty($_class)) { ?>
							<a class="img" href="<?= $article->status == 'live' ? base_url('smart-stories/'.$article->slug) : 'javascript:void();'; ?>">
								<img src="<?= $_img; ?>" alt="">
							</a>
						<?php } ?>
						<div class="txt">
							<div>
								<h4 class="a-title"><a href="<?= ($article->status=='live') ? base_url('smart-stories/'.$article->slug) : 'javascript:void();'; ?>"><?= $article->title; ?></a></h4>
								<p class=""><?= $article->intro; ?></p>
								<div class="meta-bar">
									<span class="a-cate"><span><?= $article->categories; ?></span>
									<span class="a-time"><?= $article->created; ?></span>
									<span class="a-views">dibaca <?= $article->click; ?></span>
									<span class="a-comments">komentar <?= $article->count_comment; ?></span>
									<span><a href="<?= base_url('dashboard/edit-artikel/'.$article->slug); ?>" data-slug="<?= $article->slug; ?>">Edit</a></span>
								</div>
							</div>
						</div>
					</div>
			<?php
				}
			}
			?>
		</div>
	</section>
</div>

<script>
	$(document).ready(function() {
		$('body').on('click', '#write-new-article', function() {
			$('.new-article').click();
		});
	});
</script>
