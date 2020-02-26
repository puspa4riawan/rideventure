<div class="fitpar">
    <div class="container c-inner">
      <h2 class="h1">Fitur Parenting</h2>
      <div class="sw">
        <div class="sw-c swiper-container">
          <div class="sw-w swiper-wrapper">
            <?php foreach ($tools as $tool) { ?>
              <div class="swiper-slide fitur <?= str_replace('wy', 'fitur', $tool->icon_class); ?>">
                <a href="<?= $tool->url; ?>">
                  <i class="wy <?= $tool->icon_class; ?>"></i>
                  <div class="img">
                    <img src="<?= site_url($tool->path.'/'.$tool->image_desktop); ?>">
                  </div>
                  <div class="txt">
                    <h3 class="a-title"><?= $tool->title; ?> <i class="i arrow-1" aria-hidden="true"></i></h3>
                    <p><?= $tool->text_home; ?></p>
                  </div>
                </a>
              </div>
            <?php } ?>
          </div>
        </div>
        <?php if (count($tools) > 1) { ?>
          <div class="swiper-prev i wy-prev" aria-hidden="true"></div>
          <div class="swiper-next i wy-next" aria-hidden="true"></div>
        <?php } ?>
      </div>
    </div>
</div>
