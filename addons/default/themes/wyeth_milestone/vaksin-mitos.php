<?php include 'partials/html-head-start.php'; ?>
	<title>Vaksin Homepage</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-vaksin.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent">
  <div class="progress pb w-100">
    <!-- note: ubah aria-valuenow -->
    <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" aria-describedby="progress-txt">
      <div class="progress-txt"><span class="persen"></span><span class="hidden-xs-down"> Completed</span></div>        
    </div>
  </div>

  <section class="bg-cream mainMargin-b">
    <div class="container c-inner mainPadding-t">
      <div class="vaksin-section-title text-emas3 mb-3 text-center">
        <h2 class="text-inherit">Mitos atau Fakta Imunisasi</h2>
      </div>

      <p class=" text-center">Seberapa jauh anda mengetahui mitos dan fakta seputar imunisasi? Cari tahu sekarang.</p>

      <div class="vaksin-mf-card my-5">
        <div class="vaksin-mf-statement text-center h5">
          <h3 class="text-inherit strong">Anak tidak boleh imunisasi saat demam</h3>
        </div>

        <div class="vaksin-mf-btns text-center collapse fade show ">
          <button class="btn btn-outline-success btn-wider btn-capital" type="button">Fakta</button>
          <button class="btn btn-outline-primary btn-wider btn-capital" type="button">Mitos</button>
        </div>

        <div class="vaksin-mf-collapse collapse fade" id="MitosFakta01">
          <div class="vaksin-mf-correct text-center">
            <div class="text-success h2 mb-5">
              <h4 class="text-inherit text-uppercase strong">Fakta</h4>
            </div>

            <p>Faktanya, anak demam boleh diimunisasi bila demamnya tidak terlalu tinggi. Menurut CDC dan AAP, anak yang sakit ringan tetap boleh diimunisasi. Sakit ringan yang dimaksud misalnya demam kurang dari 38.3°C, batuk pilek, infeksi telinga, diare ringan, dan kondisi umum anak baik.</p>
          </div>
        </div>
      </div>

      <div class="form-row pb-5">
        <div class="col-6">
          <a href="" class="btn btn-link btn-capital btn-icon-right pl-0"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Sebelumnya</a>
        </div>
        <div class="col-6 text-right">
          <a href="" class="btn btn-link btn-capital btn-icon-left pr-0 disabled">Selanjutnya <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
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