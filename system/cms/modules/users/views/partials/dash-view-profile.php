<div class="tab-pane <?= $page_active == 'profile' ? 'active' : ''; ?>" id="view-profile" role="tabpanel">
	<section class="inner">
		<h3 class="page-subtitle">Profile</h3>
		<div class="form-group row">
			<label class="col-form-label">Nama Lengkap</label>
			<div class="col-form-field">
				<p class="form-control-plaintext"><?=$profile->first_name.' '.$profile->last_name;?></p>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-form-label">Tanggal lahir</label>
			<div class="col-form-field">
				<p class="form-control-plaintext"><?=$profile->dob;?></p>
			</div>
		</div>
  	<div class="form-group row">
  		<label class="col-form-label">Nomor Handphone</label>
  		<div class="col-form-field">
  			<p class="form-control-plaintext"><?=$profile->phone;?></p>
  		</div>
  	</div>
  	<div class="form-group row">
  		<label class="col-form-label">Alamat</label>
  		<div class="col-form-field">
  			<p class="form-control-plaintext"><?=$profile->address_line1;?></p>
  		</div>
  	</div>
	</section>

	<?php if(!empty($child)) { ?>
	<section class="inner">
		<h3 class="page-subtitle">Data Buah Hati</h3>
		<div class="anak-list">
			<?php foreach ($child as $key => $cld) { ?>
				<div class="col-12 col-md-6">
					<div class="anak-item">
						<div class="anak-jk">
							<?php
							$gender ='';
							if ($cld['gender']) {
								$gender = $cld['gender']==1 ? 'boy' : 'girl';
							}
							?>
							<span class="jk <?=$gender;?>"></span>
						</div>
						<div class="anak-bio">
							<p class="anak-name"><?=$cld['name'];?></p>
							<div>
								<div class="meta-bar">
									<?php
									$from = new DateTime($cld['dob']);
									$to = new DateTime('today');
									$diff = $from->diff($to);
									?>
									<span class="anak-dob"><?=$diff->y!=0 ? $diff->y.' tahun ' : '';?></span>
									<span class="anak-age"><?=$diff->m!=0 ? $diff->m.' bulan' : '';?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
	 		<?php } ?>
	  	</div>
	 <?php } ?>
	</section>
</div>

<div class="tab-pane <?= $page_active == 'artikel' ? 'active' : ''; ?>" id="artikel" role="tabpanel">
	<section class="inner">
		<div class="a-list">
			<?php
			if (!empty($users_article)) {
				foreach ($users_article as $key => $article) {
					$_class = '';
					$_img = '';
					if ($article->template!='no-image' and (!(array)$article->as_bg)==false) {
						$_class = 'w-img';
						$_img = (!(array)$article->as_bg) ? '' : base_url($article->as_bg);
					}
			?>
					<div class="atc <?= $_class; ?>">
						<?php if (!empty($_class)) { ?>
							<a class="img" href="<?= $article->status == 'live' ? base_url('smart-stories/'.$article->slug) : 'javascript:void();'; ?>">
								<img src="<?= $_img; ?>" alt="">
							</a>
						<?php } ?>
						<div class="txt">
							<div>
								<h4 class="a-title"><a href="<?= ($article->status=='live') ? base_url('smart-stories/'.$article->slug) : 'javascript:void();'; ?>"><?= $article->title; ?></a></h4>
								<p class=""><?= $article->intro; ?></p>
								<div class="meta-bar">
									<span class="a-cate"><span><?= $article->categories; ?></span>
									<span class="a-time"><?= $article->created; ?></span>
									<span class="a-views">dibaca <?= $article->click; ?></span>
									<span class="a-comments">komentar <?= $article->count_comment; ?></span>
									<?php if ($this->current_user && $this->current_user->id == $article->authors_id) { ?>
										<span><a href="<?= base_url('dashboard/edit-artikel/'.$article->slug); ?>" data-slug="<?= $article->slug; ?>">Edit</a></span>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
			<?php
				}
			}
			?>
		</div>
	</section>
</div>
