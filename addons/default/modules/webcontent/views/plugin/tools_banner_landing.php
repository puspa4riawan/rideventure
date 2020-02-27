<?php foreach ($tools as $tool) { ?>
    <?php if ($tool->status == 'live') { ?>
        <div class="fitur  <?= str_replace('wy', 'fitur', $tool->icon_class); ?>">
            <a href="<?= $tool->url; ?>">
                <i class="wy <?= $tool->icon_class; ?>"></i>
                <div class="img">
                    <img src="<?= site_url($tool->path.'/'.$tool->image_mobile); ?>">
                </div>
                <div class="txt">
                    <h3 class="a-title"><?= $tool->title; ?> <i class="i arrow-1" aria-hidden="true"></i></h3>
                    <p><?= $tool->text_home; ?></p>
                </div>
            </a>
        </div>
    <?php } ?>
<?php } ?>
