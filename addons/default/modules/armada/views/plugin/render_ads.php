<div class="ads">
    <?php if ($ads && isset($ads[0])) { ?>
        <a href="<?= $ads[0]->url; ?>" target="_blank"><img src="<?= site_url($ads[0]->full_path); ?>"></a>
    <?php } ?>
</div>
