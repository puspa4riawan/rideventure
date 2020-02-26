<?php if(!empty($tools)) { ?>
<div class="ikutserta">
	<div class="container c-inner">
		<h2 class="h1">Event & Promo</h2>
		<div class="sw">
			<div class="sw-c swiper-container">
				<div class="sw-w swiper-wrapper">
					<?php foreach ($tools as $key => $tool) { ?>
					<div class="swiper-slide a-hero">
						<a href="<?=$tool->url;?>" target="_blank">
							<div class="img">
								<img src="<?=site_url($tool->path.'/'.$tool->image_desktop);?>">
							</div>
							<div class="txt">
								<h3 class="a-title"><?=$tool->title;?></h3>
								<i class="i circle-arrow-3" aria-hidden="true"></i>
							</div>
						</a>
					</div>
					<?php } ?>
				</div>
			</div>
			<div class="swiper-prev i wy-prev" aria-hidden="true"></div>
			<div class="swiper-next i wy-next" aria-hidden="true"></div>	
		</div>
	</div>
</div>
<?php } ?>