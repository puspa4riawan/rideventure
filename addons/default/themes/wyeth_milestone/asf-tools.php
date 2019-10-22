<?php include 'partials/html-head-start.php'; ?>
	<title>SSF Tools</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-ssf.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent" class="p-ssf p-asf">
	<div class="progress pb w-100 hidden-sm-down">
		<!-- note: ubah aria-valuenow -->
	  <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" aria-describedby="progress-txt">
			<div class="progress-txt"><span class="persen"></span><span class="hidden-xs-down"> Completed</span></div>		  	
	  </div>
	</div>

	<div id="ssf-tool" class="smr-step1">
		<div class="container c-inner">
			<div class="row">
				<div class="progress pb w-100 hidden-md-up">
					<!-- note: ubah aria-valuenow -->
				  <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" aria-describedby="progress-txt">
						<div class="progress-txt"><span class="persen"></span><span class="hidden-xs-down"> Completed</span></div>		  	
				  </div>
				</div>
				<div class="questions">
					<div class="head">
						<div class="icon">
							<img src="img/step1.png" alt="">
						</div>
						<div class="txt">
							<p class="sub">Step 1/8:</p>
							<h3 class="title">Pilihlah yang sesuai dengan Kepintaran si Kecil</h3>
						</div>
					</div>
					<div id="kuis" role="tablist" aria-multiselectable="true">
					  <div class="panel card active">
					    <div class="card-heading" role="tab" id="headingQ1">
					      <a data-toggle="collapse" data-parent="#kuis" href="#optionQ1" aria-expanded="true" aria-controls="optionQ1">
					        Si kecil sering menjadi pemimpin dalam setiap permainan
					      </a>
					    </div>
					    <div id="optionQ1" class="collapse show" role="tabpanel" aria-labelledby="headingQ1" data-parent="#kuis">
					    	<div class="card-block">
						      <label class="custom-control custom-radio">
									  <input id="radio1" name="radio" type="radio" class="custom-control-input">
									  <span class="custom-control-indicator"></span>
									  <span class="custom-control-description"><strong>YA</strong> <small>(Bisa/Pernah/Jarang/Sering)</small></span>
									</label>
									<label class="custom-control custom-radio">
									  <input id="radio2" name="radio" type="radio" class="custom-control-input">
									  <span class="custom-control-indicator"></span>
									  <span class="custom-control-description"><strong>TIDAK</strong> <small>(Tidak bisa/Tidak pernah/Tidak tahu)</small></span>
									</label>
					    	</div>
					    </div>
					  </div>
					  <div class="panel card">
					    <div class="card-heading" role="tab" id="headingQ2">
				        <a class="collapsed" data-toggle="collapse" data-parent="#kuis" href="#optionQ2" aria-expanded="false" aria-controls="optionQ2">
				          Collapsible Group Item #2
				        </a>
					    </div>
					    <div id="optionQ2" class="collapse" role="tabpanel" aria-labelledby="headingQ2" data-parent="#kuis">
					    	<div class="card-block">
						      <label class="custom-control custom-radio">
									  <input id="radio1" name="radio" type="radio" class="custom-control-input">
									  <span class="custom-control-indicator"></span>
									  <span class="custom-control-description"><strong>YA</strong> <small>(Bisa/Pernah/Jarang/Sering)</small></span>
									</label>
									<label class="custom-control custom-radio">
									  <input id="radio2" name="radio" type="radio" class="custom-control-input">
									  <span class="custom-control-indicator"></span>
									  <span class="custom-control-description"><strong>TIDAK</strong> <small>(Tidak bisa/Tidak pernah/Tidak tahu)</small></span>
									</label>
					    	</div>
					    </div>
					  </div>
					  <div class="panel card">
					    <div class="card-heading" role="tab" id="headingQ3">
				        <a class="collapsed" data-toggle="collapse" data-parent="#kuis" href="#optionQ3" aria-expanded="false" aria-controls="optionQ3">
				          Collapsible Group Item #3
				        </a>
					    </div>
					    <div id="optionQ3" class="collapse" role="tabpanel" aria-labelledby="headingQ3" data-parent="#kuis">
					    	<div class="card-block">
						      <label class="custom-control custom-radio">
									  <input id="radio1" name="radio" type="radio" class="custom-control-input">
									  <span class="custom-control-indicator"></span>
									  <span class="custom-control-description"><strong>YA</strong> <small>(Bisa/Pernah/Jarang/Sering)</small></span>
									</label>
									<label class="custom-control custom-radio">
									  <input id="radio2" name="radio" type="radio" class="custom-control-input">
									  <span class="custom-control-indicator"></span>
									  <span class="custom-control-description"><strong>TIDAK</strong> <small>(Tidak bisa/Tidak pernah/Tidak tahu)</small></span>
									</label>
					    	</div>
					    </div>
					  </div>
					  <div class="panel card">
					    <div class="card-heading" role="tab" id="headingQ4">
				        <a class="collapsed" data-toggle="collapse" data-parent="#kuis" href="#optionQ4" aria-expanded="false" aria-controls="optionQ4">
				          Collapsible Group Item #4
				        </a>
					    </div>
					    <div id="optionQ4" class="collapse" role="tabpanel" aria-labelledby="headingQ4" data-parent="#kuis">
					    	<div class="card-block">
						      <label class="custom-control custom-radio">
									  <input id="radio1" name="radio" type="radio" class="custom-control-input">
									  <span class="custom-control-indicator"></span>
									  <span class="custom-control-description"><strong>YA</strong> <small>(Bisa/Pernah/Jarang/Sering)</small></span>
									</label>
									<label class="custom-control custom-radio">
									  <input id="radio2" name="radio" type="radio" class="custom-control-input">
									  <span class="custom-control-indicator"></span>
									  <span class="custom-control-description"><strong>TIDAK</strong> <small>(Tidak bisa/Tidak pernah/Tidak tahu)</small></span>
									</label>
					    	</div>
					    </div>
					  </div>
					  <div class="panel card">
					    <div class="card-heading" role="tab" id="headingQ5">
				        <a class="collapsed" data-toggle="collapse" data-parent="#kuis" href="#optionQ5" aria-expanded="false" aria-controls="optionQ5">
				          Collapsible Group Item #5
				        </a>
					    </div>
					    <div id="optionQ5" class="collapse" role="tabpanel" aria-labelledby="headingQ5" data-parent="#kuis">
					    	<div class="card-block">
						      <label class="custom-control custom-radio">
									  <input id="radio1" name="radio" type="radio" class="custom-control-input">
									  <span class="custom-control-indicator"></span>
									  <span class="custom-control-description"><strong>YA</strong> <small>(Bisa/Pernah/Jarang/Sering)</small></span>
									</label>
									<label class="custom-control custom-radio">
									  <input id="radio2" name="radio" type="radio" class="custom-control-input">
									  <span class="custom-control-indicator"></span>
									  <span class="custom-control-description"><strong>TIDAK</strong> <small>(Tidak bisa/Tidak pernah/Tidak tahu)</small></span>
									</label>
					    	</div>
					    </div>
					  </div>
					</div>

					<div class="btns">
						<button class="btn btn-emas btn-capital d-block">Lanjutkan nanti <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
						<!-- kl udah isi semua, hapus .disabled -->
						<button class="btn btn-primary btn-capital d-block disabled">Lihat hasil <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
						<button class="btn btn-secondary btn-capital d-block"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Sebelumnya</button>
						<button class="btn btn-primary btn-capital d-block">Selanjutnya <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
						<button class="btn btn-primary btn-capital d-block w-100">Lihat hasil <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
					</div>


				</div>
				<div class="result">
					<div class="head">
						<p class="sub w-100 hidden-md-up">Profil</p>
						<div class="acc-img">
							<img src="img/anak-none.jpg" alt="">
						</div>
						<div class="txt">
							<p class="sub hidden-sm-down">Profil</p>
							<h3 class="title">Nama Anak</h3>
							<p class="age">Umur: 2 tahun 8 bulan</p>
						</div>
					</div>
					<div class="smr-chart">
						<canvas class="sampleChart" width="400" height="300"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<div class="ssf-foot">
		<div class="kiri bg-emas-gr">
			<h3 class="title">The Founder</h3>
			<div class="ssf-foot-img">
				<div>
					<div class="img">
						<img src="img/thomas.jpg" alt="" class="rounded-circle fix-ratio" ratio="1:1">
					</div>
					<div class="txt">
						<h4>Thomas Armstrong, Ph.D</h4>
						<p><strong>Executive Director of the American Institute for Learning and Human Development</strong></p>
						<p>Award Winning Author, Speaker, and Educator</p>
					</div>
				</div>
			</div>
			<div class="ssf-foot-txt">
				<p><strong>Smart Strength Finder merupakan hasil rancangan Thomas Armstrong, Ph.D.</strong></p>
				<p>Smart Strength Finder dibuat sebagai acuan untuk mengetahui kepintaran si Kecil. Hasil dari kuis ini bersifat tidak mutlak karena terdapat banyak faktor yang mempengaruhi. Tetap berikan dukungan terbaik untuk menstimulasi apa pun kepintaran si Kecil.</p>
			</div>
		</div>
		<div class="tengah">
			<h3 class="title">Sinergi Kepintaran</h3>
			<div class="ssf-foot-img"><img src="uploads/ssft-3.jpg" class="" alt=""></div>
			<div class="ssf-foot-txt">
				<div>
					<p>Sinergi kepintaran merupakan sebuah konsep yang mensinergikan seluruh kepintaran si Kecil yang meliputi akal, fisik, dan sosial.</p>
					<p>Sinergi kepintaran ini dapat dikembangan dengan memberikan asupan nutrisi yang tepat dan menstimulasi 8 jenis kepintaran yang dimiliki si Kecil.</p>
				</div>
			</div>
		</div>
		<div class="kanan">
			<h3 class="title">Periode Emas</h3>
			<div class="ssf-foot-img"><img src="uploads/fitpar-stimulation.jpg" class="" alt=""></div>
			<div class="ssf-foot-txt">
				<div>
					<p>Periode emas adalah periode kritis di mana otak si Kecil tumbuh dengan pesat yang terjadi hanya satu kali dalam kehidupannya. Penting bagi Mam dan Pap untuk memperhatikan nutrisi serta memberikan stimulasi yang tepat dalam periode emas tersebut. Berikan stimulasi secara konsisten dan sesuai dengan tahapan usia si <Kecil class=""></Kecil></p>
				</div>
			</div>
		</div>
	</div>


</main>

<?php include 'partials/mainFooter.php'; ?>


<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	<script>

	(function($){  
		$('#kuis')
			.on('show.bs.collapse', function (e) {
				$(e.target).parent('.panel').addClass('active');
			})
			.on('hide.bs.collapse', function (e) {
				$(e.target).parent('.panel').removeClass('active');
			});
	  $('#kuis input.custom-control-input').change(function() {
        var nextid = $(this).parents('.panel').next('.panel').find('.collapse').attr('id') ;
        $('#'+nextid).collapse('show');
        var thisid = $(this).parents('.collapse').attr('id') ;
        $('#'+thisid).collapse('hide');
        // $(this).parents('.panel').next('.panel').find('a[data-toggle="collapse"]').click();
    });
	})(jQuery);

	</script>
<?php include 'partials/html-end.php'; ?>
