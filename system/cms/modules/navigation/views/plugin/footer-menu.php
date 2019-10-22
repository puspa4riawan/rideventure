<?php foreach ($links as $key => $link) { ?>
    <?php $target = !empty($link['target']) ? 'target="'.$link['target'].'"' : ''; ?>
	<a href="<?=(in_array($link['link_type'],array('page','url'))) ? $link['url'] : site_url($link['uri']);?>" <?= $target; ?>><?=$link['title'];?></a>
<?php } ?>