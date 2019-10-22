<?php include 'partials/html-head-start.php'; ?>
	<title>Article List</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-article.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent" class="p-article">
	<div class="container c-inner atc-list">
		<div class="row">
				<main class="col-12 col-lg-8">
					<h2 class="subtitle">Article List</h2>
					<div class="filter">
					  <select class="bs-select" title="Filter by" data-width="auto">
						  <option>Tumbuh kembang</option>
						  <option>Nutrisi</option>
						  <option>Relish</option>
						  <option>Nutrisi</option>
						  <option>Relish</option>
						  <option>Nutrisi</option>
						  <option>Relish</option>
						</select>
					  <select class="bs-select" title="Sort by" data-width="auto">
						  <option>Terbaru</option>
						  <option>Terpopuler</option>
						</select>						
					</div>

					<div class="a-list">
						<a href="#to-article" class="atc">
							<div class="img">
								<img src="uploads/a01-m.jpg" alt="">
							</div>
							<div class="txt">
								<div>
									<h4 class="a-title">All element</h4>
									<div class="meta-bar">
										<span class="a-cate">Nutrisi</span>
										<span class="a-time">3 jam yang lalu</span>
									</div>
								</div>
								<i class="i arrow-2"></i>
							</div>
						</a>
						<a href="#to-article" class="atc">
							<div class="img">
								<img src="uploads/a01-m.jpg" alt="">
							</div>
							<div class="txt">
								<div>
									<h4 class="a-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fuga odit at reiciendis soluta repudiandae magni, debitis quaerat eum. Delectus laborum corrupti rerum, quasi et, quisquam! Ipsa, voluptatibus. Maxime, a, libero.</h4>
									<div class="meta-bar">
										<span class="a-cate">Nutrisi</span>
										<span class="a-time">3 jam yang lalu</span>
									</div>
								</div>
								<i class="i arrow-2"></i>
							</div>
						</a>
						<div class="fitur">
							<a href="">
								<i class="wy wy-ovulation"></i>
								<div class="img">
									<img src="uploads/ch-5.jpg">
								</div>
								<div class="txt">
									<h3 class="a-title">Mom Blogger</h3>
									<i class="i circle-arrow-3" aria-hidden="true"></i>
								</div>
							</a>
						</div>
						<a href="#to-article" class="atc">
							<div class="img">
								<img src="uploads/a01-m.jpg" alt="">
							</div>
							<div class="txt">
								<div>
									<h3 class="a-title">All element</h4>
									<div class="meta-bar">
										<span class="a-cate">Nutrisi</span>
										<span class="a-time">3 jam yang lalu</span>
									</div>
								</div>
								<i class="i arrow-2"></i>
							</div>
						</a>
					</div>
					<a href="" class="btn-more">Selengkapnya <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>

				</main>

				<aside class="col-12 col-lg-4 hidden-sm-down">
					<div class="ads">
						<img src="img/ard-1.jpg">
					</div>
					<div class="a-list">
						<h3 class="widget-title">Smart Consultation</h3>
						<p>Pertanyaan seputar parenting dan tumbuh kembang anak</p>
						<a href="#to-article" class="atc">
							<div class="txt">
								<div>
									<p class="a-cate">Category</p>
									<h4 class="a-title">All element</h4>
									<div class="meta-icon">
										<span class="a-views"><i class="i eye" aria-hidden="true"></i> 9.999 views</span>
										<span class="a-comments"><i class="i msg" aria-hidden="true"></i> 9.999 comments</span>
										<span class="a-time">5 hours ago</span>
									</div>
								</div>
							</div>
						</a>
						<a href="#to-article" class="atc">
							<div class="txt">
								<div>
									<p class="a-cate">Category</p>
									<h4 class="a-title">All element</h4>
									<div class="meta-icon">
										<span class="a-views"><i class="i eye" aria-hidden="true"></i> 9.999 views</span>
										<span class="a-comments"><i class="i msg" aria-hidden="true"></i> 9.999 comments</span>
										<span class="a-time">5 hours ago</span>
									</div>
								</div>
							</div>
						</a>
						<a href="#to-article" class="atc">
							<div class="txt">
								<div>
									<p class="a-cate">Category</p>
									<h4 class="a-title">All element</h4>
									<div class="meta-icon">
										<span class="a-views"><i class="i eye" aria-hidden="true"></i> 9.999 views</span>
										<span class="a-comments"><i class="i msg" aria-hidden="true"></i> 9.999 comments</span>
										<span class="a-time">5 hours ago</span>
									</div>
								</div>
							</div>
						</a>
						<a href="" class="btn btn-primary btn-capital">Tanya Sekarang <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
					</div>
				</aside>
			
		</div>
	</div>
</main>

<?php include 'partials/footerAbout.php'; ?>
<?php include 'partials/mainFooter.php'; ?>


<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	<script>

	</script>
<?php include 'partials/html-end.php'; ?>