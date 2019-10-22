<?php include 'partials/html-head-start.php'; ?>
	<title>Vaksin Landing Imunisasi</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-vaksin.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent">
  <div class="landing-imunisasi mainMargin-b">
    <div class="bg hidden-sm-down" style="background-image: url('uploads/bg-landing-imunisasi.png');"></div>
    <div class="bg hidden-md-up" style="background-image: url('uploads/bg-landing-imunisasi-m.png');"></div>

    <div class="landing-imunisasi-wrap">
      <div class="container c-inner">
        <div class="landing-imunisasi-text" id="step00">
          <div class="landing-imunisasi-title">
            <h2 class="text-inherit">Hi Mams, Selamat Datang di Kalender Imunisasi</h2>
          </div>

          <div class="landing-imunisasi-content">
            <p>Kami akan membantu Mam mengingat jadwal pemberian imunisasi sekaligus memberikan panduan lengkap imunisasi. Untuk memulai, lengkapi riwayat imunisasi si kecil jika pernah melakukan imunisasi.</p>

            <a href="vaksin-landing-imunisasi-pre.php" class="btn btn-primary btn-capital btn-icon-right">Cari tahu sekarang <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>

<?php include 'partials/puIntroVaksin.php'; ?>

<?php include 'partials/footerAbout.php'; ?>

<?php include 'partials/mainFooter.php'; ?>


<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	<script>
    $(document).ready(function(){
      // open popup intro vaksin
      // $('#puIntroVaksin').modal('show');
    });
	</script>
<?php include 'partials/html-end.php'; ?>