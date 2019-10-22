<?php if ($tools) { ?>
    <div class="fitur <?= str_replace('wy', 'fitur', $tools->icon_class); ?>">
        <a href="<?= $tools->url; ?>">
            <i class="wy <?= $tools->icon_class; ?>"></i>
            <div class="img">
                <img src="<?= site_url($tools->path.'/'.$tools->image_mobile); ?>">
            </div>
            <div class="txt">
                <h3 class="a-title"><?= $tools->title; ?> <i class="i arrow-1" aria-hidden="true"></i></h3>
                <p><?= $tools->text_home; ?></p>
            </div>
        </a>
    </div>
<?php } ?>
