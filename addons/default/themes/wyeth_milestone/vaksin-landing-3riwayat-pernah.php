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
        <div class="landing-imunisasi-text" id="step03">
          <div class="landing-imunisasi-title">
            <h2 class="text-inherit">Riwayat Imunisasi</h2>
          </div>

          <div class="landing-imunisasi-content">
            <div class="form-group">
              Apakah [Nama Anak] sudah pernah melakukan imunisasi?
            </div>
            <div class="form-group">
              <label class="custom-control custom-radio">
                <input id="radio1" name="radio" type="radio" class="custom-control-input">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Sudah</span>
              </label>
              <label class="custom-control custom-radio">
                <input id="radio2" name="radio" type="radio" class="custom-control-input">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Belum</span>
              </label>
            </div>
            <div class="form-group">
              <a href="vaksin-landing-4riwayat-ingat.php" class="btn btn-primary btn-capital btn-icon-right w-75">Lanjutkan <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
            </div>
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