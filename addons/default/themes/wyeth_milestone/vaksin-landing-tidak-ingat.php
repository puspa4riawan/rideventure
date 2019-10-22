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
        <div class="landing-imunisasi-text" id="step04a">
          <div class="landing-imunisasi-title text-body">
            <h2 class="text-inherit strong">Mam tidak ingat tanggal imunisasi si kecil?</h2>
          </div>

          <div class="landing-imunisasi-content">
            <p>Untuk sementara waktu kami mengganggap Mam belum melakukan imunisasi untuk si kecil atau menghitung jadwal imunisasi berdasarkan tanggal lahir si kecil. Kami sarankan untuk berkonsultasi dengan dokter si kecil untuk menginput tanggal imunisasi.</p>

            <a href="vaksin-landing-1tambah-anak.php" class="btn btn-primary btn-capital btn-icon-right">Saya mengerti <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
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