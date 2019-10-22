<?php include 'partials/html-head-start.php'; ?>
	<title>Vaksin Homepage</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-vaksin.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent">
  <section class="bg-cream mainMargin-b">
    <div class="container c-inner mainPadding">
      <div class="vaksin-section-title text-emas3 text-center mb-4">
        <h2 class="text-inherit">Edit Data Anak</h2>
      </div>

      <div class="text-center mb-4">
        <div class="size-5rem mx-auto">
          <div class="anak-img"><img src="uploads/avatar-01.jpg" alt=""></div> 
        </div>

        <a href="" class="small">Ubah foto</a>       
      </div>

      <div class="row justify-content-center">
        <div class="col-sm-6 col-lg-4">
          <div class="form-group mb-4">
            <label for="" class="small strong mb-1">Nama</label>
            <input type="text" class="form-control" value="Abhiyan">
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-icon-right btn-capital w-100">Simpan perubahan <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="container c-inner mainPadding-b">
    <div class="vaksin-section-title text-emas3 text-center mb-4">
      <h2 class="text-inherit">Fitur Lainnya</h2>
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

    <div class="vaksin-fitur-card">
      <div class="bg hidden-sm-down" style="background-image: url('uploads/Ft_Mitos dan Fakta_Small.png');"></div>
      <div class="bg hidden-md-up" style="background-image: url('uploads/Ft_Mitos dan Fakta_Small-m.png');"></div>

      <div class="vaksin-fitur-card-text vaksin-fitur-card-text-left">
        <div class="vaksin-fitur-card-title">
          <h3 class="text-inherit">Mitos atau Fakta mengenai Imunisasi</h3>          
        </div>

        <p>Lengkapi wawasan Mam tentang mitos dan fakta imunisasi.</p>

        <a href="" class="btn btn-primary btn-icon-right btn-capital">Cari tahu sekarang <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
      </div>
    </div>
  </div>

</main>

<?php include 'partials/puIntroVaksin.php'; ?>
<?php include 'partials/puCatatTanggal.php'; ?>
<?php include 'partials/puJadwalImunisasiTerlaksana.php'; ?>

<?php include 'partials/footerAbout.php'; ?>

<?php include 'partials/mainFooter.php'; ?>


<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
  <script>
    var lg= 992;

    function fFlags(){
      if ( $('.flag-wrap').outerWidth() >= $(window).outerWidth() ) {
        $('.sw-vaksin-flag').mCustomScrollbar({
          axis: 'x',
          theme: 'dark',
          autoHideScrollbar: true,
          scrollbarPosition: 'outside'
        });
      } else {
        $('.sw-vaksin-flag').mCustomScrollbar('destroy');
      }
    }

    $(document).ready(function(){
      // open popup intro vaksin
      // $('#puIntroVaksin').modal('show');

      fFlags();

      varSwVaksin = new Swiper('.sw-vaksin .swiper-container', {
        centeredSlides: true,
        slidesPerView: 'auto',
        touchMoveStopPropagation:false,
        simulateTouch : false, 
        allowSwipeToNext: false, 
        allowSwipeToPrev: false,
        allowTouchMove: false,
        touchRatio: 0, 
        navigation: {
          nextEl: '.next-pane',
          prevEl: '.prev-pane',
        },
      });

      varSwVaksin.on( 'slideChangeTransitionStart', function(){
        console.log('blah');
        $('.flag[role="button"]').last().addClass('flag-mark');
        $('.flag[role="button"]').prevAll().removeClass('flag-mark');
      })

      varSwVaksin.on( 'slideNextTransitionStart', function () {
        // ubah ke button
        $('.flag').eq(varSwVaksin.activeIndex)
          .attr({
            'tabindex': '0',
            'role': 'button',
            'aria-label': 'Lihat riwayat vaksin bulan ke-' + (varSwVaksin.activeIndex + 1)
          })
          .addClass('flag-mark');

        // bulan sebelumnya ubah ke button
        $('.flag').eq((varSwVaksin.activeIndex - 1))
          .attr({
            'tabindex': '0',
            'role': 'button',
            'aria-label': 'Lihat riwayat vaksin bulan ke-' + (varSwVaksin.activeIndex)
          })
          .removeClass('flag-mark');

        // click prev bulan to slide
        $('.flag[role="button"]').click(function(){
          // console.log( $('.bulan').index(this) );
          varSwVaksin.slideTo( $('.flag').index(this) );
          $(this).addClass('flag-mark');
        })
      });

      $('.flag').eq(1).addClass('flag-complete');
      $('.flag').eq(2).addClass('flag-incomplete');

    });

    $(window).on('resize', function(){
      fFlags();
    });
  </script>

<?php include 'partials/html-end.php'; ?>