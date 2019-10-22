<?php include 'partials/html-head-start.php'; ?>
	<title>Vaksin Landing Imunisasi : Tambah Anak</title>
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
        <div class="landing-imunisasi-text" id="step01">
          <div class="landing-imunisasi-title">
            <h2 class="text-inherit">Lengkapi Data si Kecil</h2>
          </div>

          <div class="landing-imunisasi-content">
            <div class="form-anak">
              <div class="form-group">
                <div class="foto-upload">
                  <div class="anak-img"><!-- <img src="uploads/avatar-01.jpg" alt=""> --></div>
                  <input type="file" class="foto-upload-input" id="fotoUpload">
                  <label class="foto-upload-control" for="fotoUpload">Tambahkan foto si kecil</label>
                </div>
              </div>
              <div class="form-group">
                <label class="sr-only">Nama Anak (diperlukan)</label>
                <input type="text" class="form-control" placeholder="Nama Anak" required>
              </div>
              <div class="form-group">
                <label class="sr-only">Tanggal lahir anak (diperlukan)</label>
                <input type="text" class="form-control bs-dob" placeholder="Tanggal lahir" required>
              </div>
              <div class="anak-jk">
                <label class="custom-control">
                  <input id="jk-boy" name="jk" type="radio" class="custom-control-input" checked>
                  <span class="jk boy"></span>
                  <span class="custom-control-description">Laki-laki</span>
                </label>
                <label class="custom-control">
                  <input id="jk-girl" name="jk" type="radio" class="custom-control-input">
                  <span class="jk girl"></span>
                  <span class="custom-control-description">Perempuan</span>
                </label>
              </div>
              <a href="vaksin-landing-2pilih-anak.php" class="btn btn-primary btn-capital btn-icon-right">Cari tahu sekarang <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>

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