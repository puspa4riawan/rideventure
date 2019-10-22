<div id="main-container" class="dash">
	<div class="container">
		<div class="col-md-4 dash-aside">
			<div class="row ava-head user-info">
				<div class="col-xs-2 col-md-8 img-head fix-ratio" ratio="1:1">
				<?php
				if($profile->photo_profile) {
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
					<h2 class="page-subtitle"><?php echo ucwords($profile->first_name); ?></h2>
					<p class="user-status">Mam with <?=count($child)?> kids</p>
					<p class="user-membership">Member since <?php echo format_date(strtotime($profile->created), 'F d, Y'); ?></p>
					<?php if($group_id==3){ ?>
						<p class="user-badge">Verified Contributor</p>
					<?php } ?>
				</div>
			</div>
			<ul class="nav nav-pills nav-stacked dash-nav" role="tablist">
			  	<li class="nav-item">
		  			<a class="nav-link <?php echo $page_active=='profile' ? 'active' : ''; ?>" data-toggle="pill" href="#profile" role="tab">Profile</a>
			  	</li>
			  	<?php if($group_id==3){ ?>
				  	<li class="nav-item">
		  				<a class="nav-link <?php echo $page_active=='artikel' ? 'active' : ''; ?>" data-toggle="pill" href="#artikel" role="tab">Artikel <span class="tag"><?=count((array)$users_article);?></span></a>
				  	</li>
				<?php } ?>
			</ul>
		</div>
		<div class="col-md-8 dash-main">
			<div class="tab-content">
				<div class="tab-pane <?php echo $page_active=='profile' ? 'active' : ''; ?>" id="profile" role="tabpanel">
				  	<section>
						<h3 class="page-subtitle">Profile</h3>
						<div class="form-group row">
							<label class="col-md-4 col-form-label">Nama Lengkap</label>
							<div class="col-md-6">
								<p class="form-control-static"><?php echo ucwords($profile->display_name); ?></p>
							</div>
						</div>
						<!-- <div class="form-group row">
							<label class="col-md-4 col-form-label">Tanggal lahir</label>
							<div class="col-md-6">
								<p class="form-control-static"><?php //echo $profile->dob!='' ? $profile->dob : '-'; ?></p>
							</div>
						</div> -->
						<div class="form-group row">
							<label class="col-md-4 col-form-label">Profesi</label>
							<div class="col-md-6">
								<p class="form-control-static"><?php echo $profile->profesi!='' ? $profile->profesi : '-'; ?></p>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 col-form-label">Short Biography</label>
							<div class="col-md-6">
								<p class="form-control-static"><?php echo $profile->bio!='' ? $profile->bio : '-'; ?></p>
							</div>
						</div>
					  	<!--<div class="form-group row">
					  		<label class="col-md-4 col-form-label">Nomor Handphone</label>
					  		<div class="col-md-6">
					  			<p class="form-control-static"><?php //echo $profile->phone; ?></p>
					  		</div>
					  	</div>
					  	<div class="form-group row">
					  		<label class="col-md-4 col-form-label">Alamat</label>
					  		<div class="col-md-6">
					  			<p class="form-control-static"><?php //echo $profile->address_line1!='' ? $profile->address_line1 : '-'; ?></p>
					  		</div>
					  	</div>-->
					  	<div class="form-group row">
					  		<label class="col-md-4 col-form-label">Akun Facebook</label>
					  		<div class="col-md-6">
					  			<p class="form-control-static"><?php echo $profile->fb_account!='' ? '<a href="'.$profile->fb_account.'" target="_blank">'.$profile->fb_account.'</a>' : '-'; ?></p>
					  		</div>
					  	</div>
					  	<div class="form-group row">
					  		<label class="col-md-4 col-form-label">Akun Twitter</label>
					  		<div class="col-md-6">
					  			<p class="form-control-static"><?php echo $profile->tw_account!='' ? '<a href="'.$profile->tw_account.'" target="_blank">'.$profile->tw_account.'</a>' : '-'; ?></p>
					  		</div>
					  	</div>
					  	<div class="form-group row">
					  		<label class="col-md-4 col-form-label">Akun Instagram</label>
					  		<div class="col-md-6">
					  			<p class="form-control-static"><?php echo $profile->ig_account!='' ? '<a href="'.$profile->ig_account.'" target="_blank">'.$profile->ig_account.'</a>' : '-'; ?></p>
					  		</div>
					  	</div>
					  	<div class="form-group row">
					  		<label class="col-md-4 col-form-label">Website</label>
					  		<div class="col-md-6">
					  			<p class="form-control-static"><?php echo $profile->website!='' ? '<a href="'.$profile->website.'" target="_blank">'.$profile->website.'</a>' : '-'; ?></p>
					  		</div>
					  	</div>
				  	</section>

				  	<section>
					  	<h3 class="page-subtitle">Data Buah Hati</h3>
					  	<div class="row">
					  		<?php
					  			if($child){
					  				foreach ($child as $key => $value) {
					  					$dob = explode('-', $value['dob']);

					  		?>
					  		<div class="col-md-6 anak-item">
					  			<div class="clearfix">
						  			<div class="anak-jk">
						  				<?php
						  					$gender ='';
						  					if($value['gender']){
						  						$gender = $value['gender']==1 ? 'boy' : 'girl';
						  					}
						  					echo '<div class="jk '.$gender.'"></div>'
						  				?>
						  			</div>
						  			<div class="anak-info">
						  				<p class="anak-nama"><?=$value['name']?></p>
						  				<p class="anak-umur">
						  					<!--<span><?php //echo $dob[2].' '.$month[$dob[1]].' '.$dob[0]; ?></span>-->
						  					<span>
						  						<?php
						  							$from = new DateTime($value['dob']);
													$to = new DateTime('today');

													$diff = $from->diff($to);
													echo $diff->y!=0 ? $diff->y.' tahun ' : '';
													echo $diff->m!=0 ? $diff->m.' bulan' : '';
						  						?>
						  					</span>
						  				</p>
						  			</div>
					  			</div>
					  		</div>
					  		<?php
					  				}
					  			}else{
					  				echo '<div class="col-md-6">No Child</div>';
					  			}
					  		?>
					  	</div>
				  	</section>
			  	</div>
			  	<div class="tab-pane <?php echo $page_active=='artikel' ? 'active' : ''; ?>" id="artikel" role="tabpanel">
					<section>
						<div class="judul">
					  		<h3 class="page-subtitle">Artikel</h3>
						</div>
						<?php
						if (!empty($users_article)) {
							foreach ($users_article as $key => $article) {
								if ($article->template!='no-image' and (!(array)$article->as_bg)==false) {
						?>
									<div class="row artikel">
										<div class="col-md-3 artikel-img">
							  			<div class="embed-responsive embed-responsive-1by1">
							  					<?=(!(array)$article->as_bg) ? '' : '<img src="'.base_url($article->as_bg).'">';?>
											</div>

										</div>
										<div class="col-md-9 artikel-detail">
											<h4 class="artikel-judul"><a href="<?=base_url('smart-stories/'.$article->slug);?>"><?=$article->title;?></a></h4>
											<div class="artikel-konten"><?=$article->intro;?></div>
											<div class="action"><span><?=$article->categories;?></span><span><?=$article->created;?></span><span>dibaca <?=$article->click;?></span><span>komentar <?=$article->count_comment;?></span><a href="">Edit</a></div>
										</div>
									</div>
								<?php } else { ?>
									<div class="row artikel">
										<div class="col-md-12 artikel-detail">
											<h4 class="artikel-judul"><a href="<?=base_url('smart-stories/'.$article->slug);?>"><?=$article->title;?></a></h4>
											<div class="artikel-konten"><?=$article->intro;?></div>
											<div class="action"><span><?=$article->categories;?></span><span><?=$article->created;?></span><span>dibaca <?=$article->click;?></span><span>komentar <?=$article->count_comment;?></span><a href="">Edit</a></div>
										</div>
									</div>
						<?php 	}
							}
						}
						?>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var segment2 = '<?php echo $this->uri->segment(2); ?>';
	var segment3 = '<?php echo $this->uri->segment(3); ?>';
	$(document).ready(function(){
		$('.nav-link').on('click', function(){
			var page = $(this).attr('href');
			page = page.replace(/\#/g, '');
			if(!segment3){
				segment3 = page;
				page = segment2+'/'+page;
			}
			history.pushState('', page.toUpperCase, page);
		});
	});
</script>