<?php include 'partials/html-head-start.php'; ?>
	<title>Vaksin Homepage</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-vaksin.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent">
  <div class="bg-cream">
    <div class="container c-inner mainPadding text-center">
      <h2 class="subtitle mb-4">Informasi Jenis Imunisasi</h2>
      <p class="lead">Pada halaman informasi jenis imunisasi Mams dapat melihat informasi seputar imunisasi yang akan dilakukan oleh si kecil, mulai dai informasi usia ideal imunisasi dilakukan, berapa jumlah imunisasi yang harus dilakukan dan informasi-informasi bermanfaat lainnya.</p>
    </div>

    <div class="container c-inner mainPadding-b">
      <div class="imunisasi-info">
        <div class="imunisasi-info-nama">Hepatitis B</div>
        <div class="imunisasi-info-usia">Usia 0-4 Bulan</div>
        <div class="imunisasi-info-interval">4x imunisasi</div>
        <div class="imunisasi-info-btns"><a class="btn btn-link strong letterspace-50" href="vaksin-informasi-imunisasi-detail.php">Lihat</a></div>
      </div>

      <div class="imunisasi-info">
        <div class="imunisasi-info-nama">Japanese Encephalitis</div>
        <div class="imunisasi-info-usia">Usia 2 -18 Tahun</div>
        <div class="imunisasi-info-interval">3 Tahun 1x Imunisasi</div>
        <div class="imunisasi-info-btns"><a class="btn btn-link strong letterspace-50" href="">Lihat</a></div>
      </div>

      <div class="imunisasi-info">
        <div class="imunisasi-info-nama">Hepatitis B</div>
        <div class="imunisasi-info-usia">Usia 0-4 Bulan</div>
        <div class="imunisasi-info-interval">4x imunisasi</div>
        <div class="imunisasi-info-btns"><a class="btn btn-link strong letterspace-50" href="">Lihat</a></div>
      </div>

      <div class="imunisasi-info">
        <div class="imunisasi-info-nama">Hepatitis B</div>
        <div class="imunisasi-info-usia">Usia 0-4 Bulan</div>
        <div class="imunisasi-info-interval">4x imunisasi</div>
        <div class="imunisasi-info-btns"><a class="btn btn-link strong letterspace-50" href="">Lihat</a></div>
      </div>

      <div class="imunisasi-info">
        <div class="imunisasi-info-nama">Hepatitis B</div>
        <div class="imunisasi-info-usia">Usia 0-4 Bulan</div>
        <div class="imunisasi-info-interval">4x imunisasi</div>
        <div class="imunisasi-info-btns"><a class="btn btn-link strong letterspace-50" href="">Lihat</a></div>
      </div>
    </div>
  </div>

  <div class="bg-gray-100 mainPadding mb-5">
    <div class="container c-inner">
      <div class="card imunisasi-info-tabel-card">
        <div class="card-header text-center">
          <h2 class="subtitle mb-4">Kalender Imunisasi</h2>
        </div>
        <div class="card-body">
          <div class="img">
            <img src="uploads/algoritma-kalenadar-vaksinasi.jpg" alt="" class="img-fluid">
            <a href="uploads/algoritma-kalenadar-vaksinasi.jpg" data-toggle="modal" data-target="#puImageScrollable" class="btn btn-sm btn-secondary btn-icon-left hidden-md-up btn-zoom"><i class="fa fa-search-plus" aria-hidden></i>Zoom</a>
          </div>
        </div>
        <div class="card-footer">
          <p class="strong mb-2">Keterangan</p>
          <p class="small">Cara membaca kolom usia: <br> Apabila 2 (kotak hijau) berarti usia 2 bulan (60 hari) sampai dengan 2 bulan 29 hari (89hari)</p>
          <div class="form-row imunisasi-info-keterangan">
            <div class="col">
              <span class="bg-success"></span> Optimal
            </div>
            <div class="col">
              <span class="bg-catchup"></span> Catch up
            </div>
            <div class="col">
              <span class="bg-booster"></span> Booster
            </div>
            <div class="col">
              <span class="bg-endemis"></span> Daerah dengan angka kejadian tinggi
            </div>
          </div>
          <p class="strong small">Diambil dari sumber : Kalender IDAI</p>
        </div>
      </div>
    </div>
  </div>

  <div class="container c-inner mainPadding-b">

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
      <div class="bg hidden-sm-down" style="background-image: url('uploads/Ft_Mitos-dan-Fakta_Small-flip.jpg');"></div>
      <div class="bg hidden-md-up" style="background-image: url('uploads/Ft_Mitos dan Fakta_Small-m.png');"></div>

      <div class="vaksin-fitur-card-text vaksin-fitur-card-text-right">
        <div class="vaksin-fitur-card-title">
          <h3 class="text-inherit">Mitos atau Fakta mengenai Imunisasi</h3>          
        </div>

        <p>Lengkapi wawasan Mam tentang mitos dan fakta imunisasi.</p>

        <a href="" class="btn btn-primary btn-icon-right btn-capital">Cari tahu sekarang <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
      </div>
    </div>
    
  </div>

</main>

  <!-- Modal -->
<div class="modal fade" id="puImageScrollable" tabindex="-1" role="dialog" aria-label="Popup image" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-custom" role="document">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>

      <div class="modal-body">
        <img src="uploads/algoritma-kalenadar-vaksinasi.jpg" alt="">
      </div>
    </div>
  </div>
</div>

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