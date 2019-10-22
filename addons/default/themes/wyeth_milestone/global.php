<?php include 'partials/html-head-start.php'; ?>
	<title>Global template</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="">
	<style>
	</style>
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent">

	<div class="container c-inner py-5">
		<h1>Global template</h1>
		<p class="lead">Silakan dipakai-ulang</p>
	</div>
	<div class="container c-inner">
		<div class="py-3">
			<h2>Typography</h2>
			<p>Standart paragraph. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe ea quam vitae, officia harum exercitationem, odit aut, nulla nesciunt quis adipisci? Consequuntur maxime consequatur velit reiciendis nesciunt, modi aliquam cumque.</p>
			<p class="lead">Lead Paragraph. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium rem, vero repellat ut velit deleniti perferendis officia ipsum deserunt inventore autem dolorem iusto illo suscipit? Eius deleniti nihil vero omnis.</p>
			<h1>h1. Jangan pakai di content, karena sudah dipakai di logo</h1>
			<h2>h2. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h2>
			<h3>h3. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h3>
			<h4>h4. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h4>
			<h5>h5. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h5>
			<h6>h6. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h6>

			<br>
			<p>Pakai class h1-h6 untuk apply fontsize</p>
		</div>

		<hr>

		<div class="py-3">
			<h2>Hero Banner</h2>
			<p class="lead">Slider otomatis jika ada swiper-slide lebih dari 1.</p>
			<p>Mobile size: 320x400. Desktop size: 1440x410. Perubahan image di breakpoint >768px. Text yang terlalu panjang akan dipotong dengan css text-clamp. Text-clamp di heading 3 baris, di paragraf 2 baris. Ubah posisi teks tambahkan <code>.txt-right</code> di <code>.txt</code></p>	
		</div>
	</div>
	<?php include 'partials/mainHero.php'; ?>	
	
	<div class="container c-inner">
		<hr class="mt-6">
		<div class="py-3">
			<h1>Article element</h1>
			<p class="lead">Ukuran lebar element akan mengikuti parent.</p>


			<h2 class="mt-5">Article hero (.a-hero)</h2>
			<p>Ukuran gambar bebas. Teks yang terlalu panjang dipotong text-clamp 2 baris.</p>
		</div>

		<div class="py-3">
			<div class="a-hero">
				<a href="">
					<div class="img">
						<img src="uploads/a01-m.jpg" alt="" class="hidden-md-up">
						<img src="uploads/a01-d.jpg" alt="" class="hidden-sm-down">				
					</div>
					<div class="txt">
						<h3 class="a-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ducimus voluptas, odit modi id eum quam sapiente, consequuntur alias, rerum perspiciatis distinctio commodi nihil tempore praesentium, quaerat pariatur quas optio?</h3>
						<i class="i circle-arrow-3" aria-hidden="true"></i>
					</div>
				</a>
			</div>
		</div>

		<hr>

		<div class="py-3">
			<h2>Article-list (.a-list)</h2>
			<p>Ukuran .img dan .txt dapat diatur lagi. Default 2/12. Ganti heading untuk atur font=size.</p>
		</div>

		<div class="py-3">
			<div class="a-list">
				<div class="atc">
					<div class="img">
						<a href="#to-article"><img src="uploads/a01-m.jpg" alt=""></a>
					</div>
					<div class="txt">
						<div>
							<p class="a-cate"><a href="#to-category">Category</a></p>
							<h4 class="a-title"><a href="#to-article">All element</a></h4>
							<div class="meta-bar">
								<span class="a-cate"><a href="#to-category" aria-hidden="true">Nutrisi</a></span>
								<span class="a-time">3 jam yang lalu</span>
							</div>
							<div class="meta-icon">
								<span class="a-views"><i class="i eye" aria-hidden="true"></i> 9.999 views</span>
								<span class="a-comments"><i class="i msg" aria-hidden="true"></i> 9.999 comments</span>
								<span class="a-time">5 hours ago</span>
							</div>
						</div>
						<a href="" id="to-article"><i class="i arrow-2" aria-hidden="true"></i></a>
					</div>
				</div>
				
				<a href="#to-article" class="atc">
					<div class="img">
						<img src="uploads/a01-m.jpg" alt="">
					</div>
					<div class="txt">
						<div>
							<h4 class="a-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non aperiam, voluptates asperiores fugiat.</h4>
						</div>
						<i class="i arrow-2"></i>
					</div>
				</a>

				<div class="atc">
					<div class="img">
						<a href="#to-article"><img src="uploads/a01-m.jpg" alt=""></a>
					</div>
					<div class="txt">
						<div>
							<h4 class="a-title"><a href="#to-article">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non aperiam, voluptates asperiores fugiat.</a></h4>
							<div class="meta-bar">
								<span class="a-cate"><a href="#to-category">Nutrisi</a></span>
								<span class="a-time">3 jam yang lalu</span>
							</div>
						</div>
						<a href="" id="to-article"><i class="i arrow-2" aria-hidden="true"></i></a>
					</div>
				</div>

				<div class="atc">
					<div class="txt">
						<div>
							<h4 class="a-title"><a href="#to-article">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non aperiam, voluptates asperiores fugiat.</a></h4>
							<div class="meta-bar">
								<span class="a-cate"><a href="#to-category">Nutrisi</a></span>
								<span class="a-time">3 jam yang lalu</span>
							</div>
						</div>
						<a href="" id="to-article"><i class="i arrow-2" aria-hidden="true"></i></a>
					</div>
				</div>

				<div class="atc">
					<div class="img">
						<a href="#to-article"><img src="uploads/a01-m.jpg" alt=""></a>
					</div>
					<div class="txt">
						<div>
							<p class="a-cate"><a href="#to-category">Category</a></p>
							<h4 class="a-title"><a href="#to-article">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non aperiam, voluptates asperiores fugiat.</a></h4>
							<div class="meta-icon">
								<span class="a-views"><i class="i eye" aria-hidden="true"></i> 9.999 views</span>
								<span class="a-comments"><i class="i msg" aria-hidden="true"></i> 9.999 comments</span>
								<span class="a-time">5 hours ago</span>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<hr>

		<div class="py-3">
			<h2>Article column</h2>
		</div>

		<div class="py-3">
			<div class="atc-col">
				<h2 class="h1">Ikut Serta</h2>
				<div class="row">
				<div class="a-hero col-6 col-lg-3">
					<a href="">
						<div class="img">
							<img src="uploads/ch-5.jpg">
						</div>
						<div class="txt">
							<h3 class="a-title">Mom Blogger</h3>
							<i class="i circle-arrow-3" aria-hidden="true"></i>
						</div>
					</a>
				</div>
				<div class="a-hero col-6 col-lg-3">
					<a href="">
						<div class="img">
							<img src="uploads/ch-5.jpg">
						</div>
						<div class="txt">
							<h3 class="a-title">E-Voucher</h3>
							<i class="i circle-arrow-3" aria-hidden="true"></i>
						</div>
					</a>
				</div>
				<div class="a-hero col-6 col-lg-3">
					<a href="">
						<div class="img">
							<img src="uploads/ch-5.jpg">
						</div>
						<div class="txt">
							<h3 class="a-title">Mom &amp; Jo</h3>
							<i class="i circle-arrow-3" aria-hidden="true"></i>
						</div>
					</a>
				</div>
				<div class="a-hero col-6 col-lg-3">
					<a href="">
						<div class="img">
							<img src="uploads/ch-5.jpg">
						</div>
						<div class="txt">
							<h3 class="a-title">Event minggu ini</h3>
							<i class="i circle-arrow-3" aria-hidden="true"></i>
						</div>
					</a>
				</div>
				</div>
			</div>
		</div>
	</div>
	
</main>


<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	<script>

	</script>
<?php include 'partials/html-end.php'; ?>