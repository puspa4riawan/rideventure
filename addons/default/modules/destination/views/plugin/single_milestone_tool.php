<?php if (!empty($type) && $tools) { ?>
    <?php $_type = $type == 'desktop' ? 'hidden-lg-up' : 'hidden-md-down'; ?>
    <a href="<?= $tools->url; ?>" class="btn-fitur <?= $_type; ?>">
        <i class="i si cal"></i>
        <div class="txt">
            <small><?= $tools->text_home; ?></small>
            <h4 class="a-title">
                <?= $tools->title; ?><i class="i arrow-1" aria-hidden="true"></i>
            </h4>
        </div>
    </a>
<?php } ?>
