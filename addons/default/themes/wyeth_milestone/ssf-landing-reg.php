<?php include 'partials/html-head-start.php'; ?>
	<title>SSF Landing</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-ssf.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-reg.php'; ?>

<main id="mainContent" class="p-ssf">
	<div class="container c-inner mainPadding text-center">
    <h2 class="subtitle">Siapkah si Kecil untuk Belajar Progresif?</h2>
    <p class="lead">Sinergikan 3 aspek penting dalam perkembangannya agar si Kecil siap untuk belajar sesuai kehebatannya!</p>
	</div>
	<div class="container c-inner mainPadding">
		<div class="landing">
      <section class="about">
        <img src="img/ssf-mpe.jpg" alt="" class="hidden-sm-down">
        <img src="img/ssf-mpe-m.jpg" alt="" class="hidden-md-up">
        <div class="overlay-txt">
          <div>
            <h2 class="subtitle">8 Tipe Kehebatan si Kecil</h2>
            <p>jika kamu menilai seekor ikan dari kemampuannya memanjat pohon. Maka ia akan meyakini seumur hidupnya bahwa ia adalah orang yang bodoh<br>-Albert Einstein</p>
            <p>Setiap anak lahir dengan kemampuan dan kehebatannya masing-masing, Penting bagi Mam dan Pap untuk mendeteksi kemampuan dan kehebatan si Kecil sejak dini untuk bantu optimalkan proses belajar progresifnya. Konsep <strong>Multiple Intelligences</strong> bantu kenali kehebatan yang dimilki si Kecil.</p>
            <p class="strong">Word Smart, Number Smart, picture smart, music smart, body smart, nature smart, self smart, dan people smart</p>
            <!-- <a href="javascript:void(0)" class="btn btn-mpe">&gt;&gt;</a> -->
          </div>
        </div>
        <div class="txt">
          <div>
            <h2 class="subtitle">8 tipe si Kecil Hebat</h2>
            <p>Cari tahu sejak dini kehebatannya dan dapatkan rekomendasi stimulasi yang tepat</p>
            <p><a id="btn-ssf-more" href="ssf-about.php" class="btn btn-primary btn-capital">Info lebih lanjut <i class="fa fa-arrow-circle-o-right ml-2" aria-hidden="true"></i></a></p>
          </div>
        </div>
      </section>
			<section class="tools hidden-xs-up">
				<img src="img/ssf-img-tools.jpg" alt="">
				<div class="txt col-lg-8">
					<div>
						<h2 class="subtitle">Smart Strength Finder Tool</h2>
						<p>Smart Strength Finder adalah tool yang dirancang oleh Thomas Armstrong, Ph. D yang dapat membantu Mam dan Pap mengenali kepintaran si Kecil. Jawab pertanyaan seputar perilaku si Kecil di sini dan lakukan tesnya secara berkala.</p>
						<p class="mt-2"><a class="btn btn-primary btn-capital" href="ssf-tool.php" >Cari tahu kepintarannya <i class="fa fa-arrow-circle-o-right ml-2" aria-hidden="true"></i></a></p>						
					</div>
				</div>
			</section>
			<section class="tools">
				<img src="img/ssf-img-tools.jpg" alt="">
				<div class="txt col-lg-8">
					<div>
						<h2 class="subtitle">Smart Strength Finder Tool</h2>
						<p>Anda telah mengenali kepintaran si Kecil. Lakukan tes kepintaran si Kecil secara berkala sesuai tahapan usianya:</p>
						<ul>
							<li>Usia si Kecil kurang dari 2 tahun: Sekali dalam 3 bulan</li>
							<li>Usia si Kecil lebih dari 2 tahun   :  Sekali dalam 6 bulan</li>
						</ul>
  					<div class="anak-list">
  						<div class="anak-item">
	  						<div class="anak-img"><img src="uploads/avatar-01.jpg" alt=""></div>
  							<div class="anak-bio">
  								<div class="anak-info">
	  								<p class="anak-name">Lorem ipsum</p>
	  								<p class="anak-age">2 tahun, 9 bulan</p>
  								</div>
  								<div class="btns">
  									<a href="" class="btn btn-emas btn-capital">Tes Kembali <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
  									<a href="" class="btn btn-primary btn-capital">Hasil <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
  								</div>
  							</div>
  						</div>
  						<div class="anak-item">
	  						<div class="anak-img"><img src="uploads/avatar-01.jpg" alt=""></div>
  							<div class="anak-bio">
  								<div class="anak-info">
	  								<p class="anak-name">Lorem ipsum</p>
	  								<p class="anak-age">2 tahun, 9 bulan</p>
  								</div>
  								<div class="btns">
  									<a href="" class="btn btn-emas btn-capital">Tes Kembali <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
  									<a href="" class="btn btn-primary btn-capital">Hasil <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
  								</div>
  							</div>
  						</div>
  						<div class="anak-item">
	  						<div class="anak-img"><img src="uploads/avatar-01.jpg" alt=""></div>
  							<div class="anak-bio">
  								<div class="anak-info">
	  								<p class="anak-name">Lorem ipsum</p>
	  								<p class="anak-age">2 tahun, 9 bulan</p>
  								</div>
  								<div class="btns">
  									<a href="" class="btn btn-emas btn-capital">Tes Baru <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
  								</div>
  							</div>
  						</div>
	     				<div class="btns"><button class="btn btn-primary btn-capital"><i class="fa fa-plus fa-lg mr-2" aria-hidden="true"></i>Tambahkan data anak dan kenali kepintarannya</button></div>
  					</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</main>

<?php include 'partials/mainFooter.php'; ?>


<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	<script>
	$(document).ready(function () {
		$("body").on({
		    mouseenter: function () {
		       $(this).addClass("overlay");
		    },
		    mouseleave:function () {
		       $(this).removeClass("overlay");
		    }
		},'.about');
		
		$('#btn-ssf-more').click(function(e) {
	    $('.about').toggleClass('overlay');
			e.preventDefault();
		});
	});
	</script>
<?php include 'partials/html-end.php'; ?>