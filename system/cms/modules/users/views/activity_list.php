<?php
foreach ($activity as $key => $value) {
	if(isset($value->comments_id)) {
		$me = $this->current_user->id;
		$color = 'alert-secondary';
		if($value->article_author==$me){
			$text = 'You commented on your post';
			$text = $value->authors_id!=$me ? $value->display_name.' commented on your post' : $text;
			$color = $value->authors_read==0 ? 'alert-danger' : $color;
			$status = 'authors';
		}else{
			$text = $value->display_name.' commented on this post';
			$text = $value->authors_id==$me ? 'You commented on this post' : $text;
			$color = $value->reply_read==0 ? 'alert-warning' : $color;
			$status = 'reply';
		}
?>
		<div class="alert <?=$color?>">
		  	<div class="action" style="cursor:pointer;" data-id="<?php echo $value->comments_id; ?>" data-status="<?php echo $status ?>"><span><?php echo $text ?></span><span><?php echo strtolower(timespan($value->created_on, time(), 2)); ?> yang lalu</span></div>
		  	<h3 class="artikel-judul" style="display: :none;"><?php echo $value->title; ?></h3>
			<div class="artikel-konten" style="display: :none;"><?php echo $value->intro; ?></div>
		</div>
<?php
	} elseif(isset($value->ask_id)) {
		$color = $value->notif_read==0 ? 'alert-warning' : 'alert-secondary';
		$text  = 'Your question has been answered';
?>
		<div class="alert <?=$color?>">
		  	<div class="action-answer" style="cursor:pointer;" data-id="<?php echo $value->answer_id; ?>">
		  		<span><?=$text;?></span>
		  		<?php if($value->answer_status=='publish') { ?>
		  		<span><a href="<?php echo site_url('smart-consultation/'.$value->speciality_slug.'/'.$value->ask_slug);?>">View</a></span>
		  		<?php } ?>
		  	</div>
		  	<h3 class="artikel-judul" ><?php echo $value->ask_subject; ?></h3>
			<div class="artikel-konten" ><?php echo $value->ask_value; ?></div>&nbsp;
			<div class="artikel-konten" ><?php echo $value->answer_value; ?></div>
		</div>
<?php
	}
}
?>