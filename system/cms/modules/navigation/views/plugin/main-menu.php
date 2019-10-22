<ul id="mainNav">
	<?php foreach ($links as $key => $link) { ?>
	<li>
		<?php if(in_array($link['link_type'],array('page','url'))) { ?>
			<a href="<?=$link['url'];?>"><?=$link['title'];?></a>
		<?php } else { ?>
			<a href="<?=site_url($link['uri']);?>"><?=$link['title'];?></a>
		<?php } ?>

		<?php if(array_key_exists('children', $link)) {
		if(!empty($link['children'])) {
		echo "<ul>";
			foreach ($link['children'] as $key => $child) {
		?>
			<li>
				<?php if($child['link_type']=='divider') { ?>
					<?=$child['title'];?>
				<?php } else if(in_array($child['link_type'],array('page','url'))) { ?>
					<?=$child['title'];?>
				<?php } else { ?>
					<a href="<?=site_url($child['uri']);?>"><?=$child['title'];?></a>
				<?php } ?>
			</li>
		<?php }
		echo "</ul>";
			}
		} ?>
	</li>
	<?php  } ?>
</ul>