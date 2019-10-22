<?php include 'partials/html-head-start.php'; ?>
	<title>SSF School</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-ssf.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent" class="p-ssf">
	<div class="sch-intro">
		<div class="container c-inner">
			<p>Melalui Smart School Finder, kini Anda dapat menemukan pilihan sekolah terbaik yang akan membantu mendukung kepintaran Si Kecil.</p>
		</div>
	</div>
	<div class="sch-main bg-gray-300">
		<div class="map-wrap">
			<div id="map" style="background-color: #f5eee0;">ceritanya ini map, nanti hapus aja stylenya</div>
		</div>
		<div class="bs-container c-outer">
			<div class="row-0">
				<div class="sch-form">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Cari sekolah...">
		        <i class="fa fa-search fa-fw"></i><span class="sr-only">Cari</span>
					</div>
					<div class="pilihan">
						<label class="custom-control custom-radio">
						  <input name="tipeSekolah" type="radio" class="custom-control-input" value="Nasional">
						  <span class="custom-control-indicator"></span>
						  <span class="custom-control-description">Nasional</span>
						</label>
						<label class="custom-control custom-radio">
						  <input name="tipeSekolah" type="radio" class="custom-control-input" value="Internasional">
						  <span class="custom-control-indicator"></span>
						  <span class="custom-control-description">Internasional</span>
						</label>						
					</div>

				</div>
				<div class="sch-result">
					<div class="btn btn-primary btn-capital">Login untuk mengetahui kepintaran anak anda <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></div>
				</div>
				
			</div>
		</div>
	</div>
</main>

<?php include 'partials/mainFooter.php'; ?>


<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	<script>
	</script>
<?php include 'partials/html-end.php'; ?>
