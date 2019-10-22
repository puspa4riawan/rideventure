<?php include 'partials/html-head-start.php'; ?>
	<title>Smart Consultation</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-sc.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent" class="sc-page expert-list">
	<div class="container c-inner">
		<h2 class="subtitle">Pilih Ahli Kami</h2>
		<ul class="nav nav-tabs" id="articleTab" role="tablist">
		    <li class="nav-item">
		    	<a class="nav-link active" id="psikolog-tab" data-toggle="tab" href="#psikolog" role="tab" aria-controls="psikolog" aria-selected="true">Psikolog</a>
		  	</li>
		  	<li class="nav-item">
		   		<a class="nav-link" id="ginekologi-tab" data-toggle="tab" href="#ginekologi" role="tab" aria-controls="ginekologi" aria-selected="false">Ginekologi</a>
		  	</li>
		  	<li class="nav-item">
		   		<a class="nav-link" id="nutrisi-tab" data-toggle="tab" href="#nutrisi" role="tab" aria-controls="nutrisi" aria-selected="false">Nutrisi</a>
		  	</li>
		  	<li class="nav-item">
		   		<a class="nav-link" id="pediatrik-tab" data-toggle="tab" href="#pediatrik" role="tab" aria-controls="pediatrik" aria-selected="false">Pediatrik</a>
		  	</li>
		</ul>
	</div>
	<div class="tab-content expert-wrapper" id="articleTabContent">
		<div class="tab-pane fade show active" id="psikolog">
			<div class="container c-inner">
				<div class="intro">
					<div class="txt">
						<p>Punya pertanyaan seputar Psikologi Anak dan perkembangan sosial anak?</p>
					</div>
					<div class="btns">
						<a href="" class="btn btn-primary btn-capital">Tanya Sekarang <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
					</div>
				</div>
			</div>
			<div class="bg-emas-gr experts">
				<div class="container c-outer">
					<h2 class="subtitle">Ahli Psikologi Kami</h2>
					<div class="row">
						<div class="a-hero">
							<a href="">
								<div class="img">
									<img src="uploads/doctor-1.jpg">
								</div>
								<div class="txt">
									<h3 class="a-title">Rosdiana Setyaningrum, Mpsi, MHPed</h3>
								</div>
							</a>
							<a href="" class="btn-capital hidden-md-down">profil lengkap <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="ginekologi">ginekologi
		</div>
		<div class="tab-pane fade" id="nutrisi">nutrisi
		</div>
		<div class="tab-pane fade" id="pediatrik">pediatrik
		</div>
	</div>
</main>

<?php include 'partials/footerAbout.php'; ?>
<?php include 'partials/mainFooter.php'; ?>


<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	<script>
(function($){  
  if ($('.experts .a-hero').length == 1) {
  	$('.experts').addClass('text-center');
  	$('.experts .a-hero').addClass('mx-auto');
  }
})(jQuery);
	</script>
<?php include 'partials/html-end.php'; ?>