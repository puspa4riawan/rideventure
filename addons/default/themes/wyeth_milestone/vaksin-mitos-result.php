<?php include 'partials/html-head-start.php'; ?>
	<title>Vaksin Homepage</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-vaksin.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent">
  <section class="bg-cream mainMargin-b">
    <div class="container c-inner mainPadding-t">
      <div class="vaksin-section-title text-emas3 mb-3 text-center">
        <h2 class="text-inherit">Mitos atau Fakta Imunisasi</h2>
      </div>

      <p class=" text-center">Seberapa jauh anda mengetahui mitos dan fakta seputar imunisasi? Cari tahu sekarang.</p>

      <div class="vaksin-mf-card my-5">
        <div class="vaksin-section-title text-emas3 mb-3 text-center">
          <h2 class="text-inherit">Selamat!</h2>
        </div>

        <p class="text-center mb-5">Mam telah menyelesaikan semua pertanyaan. <br>Mam berhasil menjawab 3 dari 5 pertanyaan.</p>

        <h4 class="small strong text-center mb-3">Nilai anda</h4>
        <div class="vaksin-mf-score text-success">
          <span>100</span>
        </div>
      </div>

      <div class="form-row pb-5">
        <div class="col-12 col-md-6 mx-auto">
          <a href="vaksin-home.php" class="btn btn-primary w-100 btn-capital btn-icon-left">Kembali ke beranda imunisasi <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
        </div>
      </div>
      
    </div>
  </section>

  <div class="container c-inner mainPadding-b">
    <div class="vaksin-section-title text-emas3 text-center mb-4">
      <h2 class="text-inherit">Fitur Lainnya</h2>
    </div>

    <div class="vaksin-fitur-card">
      <div class="bg hidden-sm-down" style="background-image: url('uploads/Ft_Kalender Imunisasi_Small.png');"></div>
      <div class="bg hidden-md-up" style="background-image: url('uploads/Ft_Kalender Imunisasi_Small-m.png');"></div>

      <div class="vaksin-fitur-card-text vaksin-fitur-card-text-left">
        <div class="vaksin-fitur-card-title">
          <h3 class="text-inherit">Kalender Imunisasi</h3>          
        </div>

        <p>Pastikan Mam selalu ingat jadwal imunisasi si Kecil dengan kalender imunisasi yang dilengkapi segala manfaat imunisasi.</p>

        <a href="vaksin-landing-imunisasi.php" class="btn btn-primary btn-icon-right btn-capital">Cari tahu sekarang <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
      </div>
    </div>

    <div class="vaksin-fitur-card">
      <div class="bg hidden-sm-down" style="background-image: url('uploads/Ft_5W1H_Small.png');"></div>
      <div class="bg hidden-md-up" style="background-image: url('uploads/Ft_5W1H_Small-m.png');"></div>

      <div class="vaksin-fitur-card-text vaksin-fitur-card-text-right">
        <div class="vaksin-fitur-card-title">
          <h3 class="text-inherit">Kenapa si Kecil harus Imunisasi?</h3>
        </div>

        <p>Pelajari lebih dalam tentang imunisasi agar si Kecil selalu sehat terbebas wabah penyakit yang bisa diantisipasi jauh-jauh hari.</p>

        <a href="" class="btn btn-primary btn-icon-right btn-capital">Cari tahu sekarang <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
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

      $('.vaksin-mf-btns .btn').on('click', function(){
        $('.vaksin-mf-collapse').collapse('show');
        $('.vaksin-mf-btns').collapse('hide');
      })

    });
	</script>
<?php include 'partials/html-end.php'; ?>