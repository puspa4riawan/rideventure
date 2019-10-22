<?php include 'partials/html-head-start.php'; ?>
	<title>Vaksin Homepage</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-vaksin.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent">
  <section class="bg-cream mainMargin-b">
    <div class="container c-inner text-center mainPadding">
      <div class="vaksin-section-subtitle text-body">
        <h2 class="text-inherit strong">Mam, yuk hitung jadwal imunisasi si kecil</h2>
      </div>

      <p>Kami akan membantu Mam mengingat jadwal pemberian imunisasi sekaligus memberikan panduan lengkap imunisasi. Untuk memulai, lengkapi dulu riwayat imunisasi si kecil ya Mam.</p>
    </div>

    <div class="container c-inner text-center mainPadding-b">
      <div class="vaksin-section-title text-emas3">
        <h2 class="text-inherit">Riwayat Imunisasi</h2>
      </div>

      <div class="anak-wrap border-0">
        <div class="btn-group bootstrap-select bs-select-anak anak-jk w-100">
          <div class="btn dropdown-toggle btn-input">
            <span class="filter-option">
              <div class="anak-img"><img src="uploads/avatar-01.jpg" alt=""></div>
              <span>
                Nama Anak Panjang Banget dah
                <small class="text-muted">3 bulan</small> 
              </span>
            </span>
          </div>
        </div>
        
      </div>

    </div>

    <div class="sw-vaksin-flag">
      <div class="flag-wrap">
        <div class="bulans">
          <button class="flag bulan"><span>1</span></button>
          <button class="flag bulan"><span>2</span></button>
          <button class="flag bulan"><span>3</span></button>
          <button class="flag bulan"><span>4</span></button>
          <button class="flag bulan"><span>5</span></button>
          <button class="flag bulan"><span>6</span></button>
          <button class="flag bulan"><span>9</span></button>
          <button class="flag bulan"><span>12</span></button>
          <button class="flag bulan"><span>15</span></button>
          <button class="flag bulan"><span>18</span></button>
          <button class="flag bulan"><span>24</span></button>
        </div>
        <div class="tahuns">
          <button class="flag tahun"><span>3</span></button>
          <button class="flag tahun"><span>5</span></button>
          <button class="flag tahun"><span>6</span></button>
          <button class="flag tahun"><span>7</span></button>
          <button class="flag tahun"><span>8</span></button>
          <button class="flag tahun"><span>9</span></button>
          <button class="flag tahun"><span>10</span></button>
          <button class="flag tahun"><span>12</span></button>
          <button class="flag tahun"><span>18</span></button>
        </div>
      </div>
    </div>

    <div class="sw-vaksin py-5">
      <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide sw-vaksin-pane">
              <div class="sw-vaksin-wrap">
                <div class="vaksin-section-title text-emas3 mb-1">
                  <h3 class="text-inherit">Riwayat Imunisasi</h3>
                </div>

                <ul class="imunisasi-list">
                  <li class="imunisasi imunisasi-next">
                    <div class="imunisasi-wrap">
                      <div class="imunisasi-name">Hepatitis B</div>
                      <div class="imunisasi-dose">Dosis 1/3</div>
                    </div>
                  </li>
                  <li class="imunisasi">
                    <div class="imunisasi-wrap">
                      <div class="imunisasi-name">Hepatitis B</div>
                      <div class="imunisasi-dose">Dosis 1/3</div>
                      <div class="imunisasi-btns">
                        <button class="btn btn-outline-success" data-toggle="modal" data-target="#puCatatTanggal">Sudah</button>
                        <button class="btn btn-outline-danger">Belum</button>
                      </div>
                    </div>
                  </li>
                  <li class="imunisasi imunisasi-complete">
                    <div class="imunisasi-wrap">
                      <div class="imunisasi-name">Hepatitis B <i class="icon-check-green" aria-hidden="true"></i></div>
                      <div class="imunisasi-dose">Dosis 1/3</div>
                      <div class="imunisasi-date">12 Desember 2018</div>
                      <div class="imunisasi-btns">
                        <button class="btn btn-text-gray" title="Edit detail" data-toggle="modal" data-target="#puCatatTanggal"><i class="fa fa-edit" aria-label="Edit"></i></button>
                        <button class="btn btn-text-gray" title="Reminder Me"><i class="fa fa-bell" aria-label="Reminder"></i></button>
                      </div>
                    </div>
                  </li>
                  <li class="imunisasi imunisasi-incomplete">
                    <div class="imunisasi-wrap">
                      <div class="imunisasi-name">Hepatitis B <i class="icon-times-red" aria-hidden="true"></i></div>
                      <div class="imunisasi-dose">Dosis 1/3</div>
                      <div class="imunisasi-date">12 Desember 2018</div>
                      <div class="imunisasi-btns">
                        <button class="btn btn-text-gray" title="Edit detail" data-toggle="modal" data-target="#puCatatTanggal"><i class="fa fa-edit" aria-label="Edit"></i></button>
                        <button class="btn btn-text-gray" title="Reminder Me"><i class="fa fa-bell" aria-label="Reminder"></i></button>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div class="swiper-slide sw-vaksin-pane">Slide 02<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 03<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 04<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 05<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 06<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 09<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 12<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 15<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 18<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 24<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 3<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 5<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 6<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 7<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 8<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 9<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 10<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 12<button class="next-pane">Next</button></div>
            <div class="swiper-slide sw-vaksin-pane">Slide 18<button class="next-pane">Next</button></div>
        </div>
      </div>
    </div>
    
    <button class="next-pane">Next</button> <!-- ignore -->

    <div class="container c-inner text-center">
      <p class="pb-5">
        <a href="" class="btn btn-primary btn-icon-right btn-capital btn-maw20rem" data-toggle="modal" data-target="#puJadwalImunisasi">Selesai <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
      </p>
      
      <p class="pb-5">
        <a href="vaksin-landing-tidak-ingat.php">Lewati proses ini</a>
      </p>
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
<?php include 'partials/puJadwalImunisasi.php'; ?>

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