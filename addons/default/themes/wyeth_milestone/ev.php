<?php include 'partials/html-head-start.php'; ?>
	<title>E-Voucher</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-ev.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent">
	<div class="container c-inner mainPadding">
		<h2 class="subtitle">E-Voucher</h2>
		<p>Hanya dengan melakukan beberapa langkah sederhana, Anda berhak untuk mendapatkan E-Voucher dari beberapa mitra kami.</p>
		<div class="voucher-banner">
			<figure>
				<img src="img/ev.jpg">
			</figure>
			<div class="txt">
				<p>
					E-Voucher dari beberapa mitra kami yang dapat membantu si Kecil bertumbuh dan berkembang dan membuat Anda menghemat. Lorem ipsum dolor sit amet.
				</p>
				<a href="" class="btn btn-primary btn-capital">Lihat katalog <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>				
			</div>
		</div>


		<h2 class="subtitle">Cara Mendapatkan E-Voucher</h2>	
		<div class="ev-step">
			<div class="step">
				<div>
					<figure>
						<img src="img/ev-1.png">
					</figure>
					<div class="txt">
						Isi formulir yang terdapat di bawah ini, klik tombol "Daftar Sekarang".
					</div>
				</div>
			</div>
			<div class="step">
				<div>
					<figure>
						<img src="img/ev-2.png">
					</figure>
					<div class="txt">
						Kami mengirimkan email verifikasi ke email yang tertera di formulir.
					</div>
				</div>
			</div>
			<div class="step">
				<div>
					<figure>
						<img src="img/ev-3.png">
					</figure>
					<div class="txt">
						Verifikasi email yang Anda masukkan di formulir.
					</div>
				</div>
			</div>
			<div class="step">
				<div>
					<figure>
						<img src="img/ev-4.png">
					</figure>
					<div class="txt">
						E-Voucher akan dikirimkan ke email Anda di hari yang sama.
					</div>
				</div>
			</div>
		</div>


		<div class="join">
			<figure>
				<img src="img/ssf-img-stimulation.jpg">
			</figure>
			<div class="txt">
				<h3>Daftar sekarang!</h3>
				<p>Isi formulir berikut untuk menerima E-Voucher</p>
				<div class="form-group">
					<label><b>Email</b></label>
					<input type="text" class="form-control" name="">
				</div>
				<ul>
					<li>Dengan mendaftar, Anda setuju dengan <a href="">syarat dan ketentuan</a>.</li>
					<li>Valid bagi first time user.</li>
				</ul>
				<div class="form-group">
					<label class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input">
				    <span class="custom-control-indicator"></span>
				    <span class="custom-control-description">Ya, saya setuju</span>
					</label>
				</div>
				<div class="btns">
					<button class="btn btn-capital btn-primary" data-toggle="modal" data-target="#puEvoucher">daftar sekarang <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>

	</div>
</main>

<?php include 'partials/mainFooter.php'; ?>
<?php include 'partials/puEvoucher.php'; ?>

<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	<script>

	</script>
<?php include 'partials/html-end.php'; ?>