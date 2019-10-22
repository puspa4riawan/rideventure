<div class="col-md-4 dash-aside">
	<div class="row ava-head user-info">
		<div class="col-xs-2 col-md-8 img-head fix-ratio" ratio="1:1">
			<?php if($profile->photo_profile) {
				if(file_exists($profile->photo_profile)) {
					$prof_pic = site_url($profile->photo_profile);
				} else {
					$prof_pic = '{{ theme:image_url file=\'anak-none.jpg\' }}';
				}
			} else {
				$prof_pic = '{{ theme:image_url file=\'anak-none.jpg\' }}';
			}
			?>
			<img src="<?=$prof_pic; ?>" alt="">
		</div>
		<div class="col-xs-10 col-md-12">
			<h2 class="page-subtitle"><?php echo ucwords($this->current_user->first_name); ?></h2>
			<p class="user-status"><?php echo $this->current_user->gender=='f' ? 'Mam' : 'Pap'; ?> with <?=count($child)?> kids</p>
			<p class="user-membership">Member since <?php echo format_date(strtotime($profile->created), 'F d, Y'); ?></p>
			<?php if($this->current_user->group_id==3){ ?>
				<p class="user-badge">Verified Contributor</p>
			<?php } ?>
		</div>
	</div>
	<ul class="nav nav-pills nav-stacked dash-nav" role="tablist">
	  	<?php if($this->current_user->group_id==3){ ?>
		  	<li class="nav-item">
		  		<a class="nav-link <?php echo ($page_active=='view-artikel' or $page_active=='tulis-article' or $page_active=='edit-article') ? 'active' : ''; ?>" data-toggle="pill" href="#view-artikel" role="tab">My Article <span class="tag" id="ct-ar"><?=count((array)$users_article);?></span></a>
		  	</li>
		<?php } ?>
		<li class="nav-item">
			<a class="nav-link <?php echo $page_active=='my-activity' ? 'active' : ''; ?>" data-toggle="pill" href="#my-activity" role="tab">My Activity <span class="tag"><?php echo $activity_count; ?></span></a>
		</li>
		<li class="nav-item">
			<a class="nav-link <?php echo $page_active=='edit-profile' ? 'active' : ''; ?>" data-toggle="pill" href="#edit-profile" role="tab">Edit Profile</a>
		</li>
	  	<li class="nav-item">
			<a class="nav-link <?php echo $page_active=='settings' ? 'active' : ''; ?>" data-toggle="pill" href="#settings" role="tab">Settings</a>
		</li>
	</ul>
</div>