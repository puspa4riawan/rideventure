<?php include 'partials/html-head-start.php'; ?>
	<title>Vaksin Landing Imunisasi : Pilih Anak</title>
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
        <div class="landing-imunisasi-text" id="step02">
          <div class="landing-imunisasi-title">
            <h2 class="text-inherit">Data si Kecil</h2>
          </div>

          <div class="landing-imunisasi-content">
            <p>Silakan pilih data anak untuk memulai monitoring imunisasi.</p>

            <div class="form-group">
              <select class="bs-select-anak anak-jk" data-width="100%">
                <option data-icon="jk girl" data-subtext="3 bulan">Nama Anak Panjang Banget dah</option>
                <option data-icon="jk boy" data-subtext="3 bulan">Nama Anak</option>
                <option data-icon="jk girl" data-subtext="3 bulan">Nama Anak</option>
              </select>              
            </div>
            <div class="form-group">
              <p class="text-right mb-3"><a href="vaksin-landing-1a-tambah-anak.php">+ Tambah anak</a></p>              
            </div>

            <a href="vaksin-landing-3riwayat-pernah.php" class="btn btn-primary btn-capital btn-icon-right">Lanjutkan <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
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