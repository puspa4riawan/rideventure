<?php include 'partials/html-head-start.php'; ?>
	<title>SSF Result</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-ssf.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent" class="p-ssf">
	<div class="progress pb">
		<!-- note: ubah aria-valuenow -->
	  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" aria-describedby="progress-txt">
			<div class="progress-txt"><span class="persen"></span><span class="hidden-xs-down"> Completed</span></div>		  	
	  </div>
	</div>

	<div class="ssfr-intro">
		<div class="container c-inner">
			<p>Hai <strong>Mam Jane</strong>, berikut adalah hasil deteksi kehebatan <strong>Ariel</strong> usia <strong>2 tahun 10 bulan.</strong></p>
			<p>Ingin mengulang kembali Smart Strength Finder Tool? Yuk, <a href="" class="btn btn-primary btn-capital btn-sm ">Klik  <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a> di sini</p>
		</div>
	</div>

	<div class="container c-inner mainPadding ssfr-main">
		<h2 class="subtitle">Hasil Smart Strength Finder</h2>
		
		<div class="smr-visual">
			<div class="smr-info">
				<ul class="nav nav-pills smr-tabs" role="tablist">
				  <li class="nav-item akal-nav">
				    <a class="nav-link active" data-toggle="tab" href="#number" role="tab">
				    	<img src="img/i-smart-number.png" alt="">
				    	Number Smart
				    </a>
				  </li>
				  <li class="nav-item fisik-nav">
				    <a class="nav-link" data-toggle="tab" href="#body" role="tab">
				    	<img src="img/i-smart-body.png" alt="">
				    	Body Smart
				    </a>
				  </li>
				 <li class="nav-item sosial-nav">
				    <a class="nav-link" data-toggle="tab" href="#self" role="tab">
				    	<img src="img/i-smart-self.png" alt="">
				    	Self Smart
				    </a>
				  </li>
				  <!--  <li class="nav-item akal-nav">
				    <a class="nav-link active" data-toggle="tab" href="#people" role="tab">
				    	<img src="img/i-smart-people.png" alt="">
				    	People Smart
				    </a>
				  </li>
				  <li class="nav-item fisik-nav">
				    <a class="nav-link" data-toggle="tab" href="#self" role="tab">
				    	<img src="img/i-smart-self.png" alt="">
				    	Self Smart
				    </a>
				  </li>
				  <li class="nav-item number-nav">
				    <a class="nav-link" data-toggle="tab" href="#number" role="tab">
				    	<img src="img/i-smart-number.png" alt="">
				    	Number Smart
				    </a>
				  </li>
				 <li class="nav-item word-nav">
				    <a class="nav-link" data-toggle="tab" href="#word" role="tab">
				    	<img src="img/i-smart-word.png" alt="">
				    	Word Smart
				    </a>
				  </li>
				  <li class="nav-item body-nav">
				    <a class="nav-link" data-toggle="tab" href="#body" role="tab">
				    	<img src="img/i-smart-body.png" alt="">
				    	Body Smart
				    </a>
				  </li>
				  <li class="nav-item picture-nav">
				    <a class="nav-link" data-toggle="tab" href="#picture" role="tab">
				    	<img src="img/i-smart-picture.png" alt="">
				    	Picture Smart
				    </a>
				  </li>
				  <li class="nav-item music-nav">
				    <a class="nav-link" data-toggle="tab" href="#music" role="tab">
				    	<img src="img/i-smart-music.png" alt="">
				    	Music Smart
				    </a>
				  </li>
				  <li class="nav-item nature-nav">
				    <a class="nav-link" data-toggle="tab" href="#nature" role="tab">
				    	<img src="img/i-smart-nature.png" alt="">
				    	Nature Smart
				    </a>
				  </li> -->
				</ul>

				<!-- Tab panes -->
				<div class="tab-content smr-tab-content">
				  <div class="tab-pane akal-tab active" id="number" role="tabpanel">
				  	<div class="smr-tab-img">
				  		<img src="img/smart-number-big.png" class="img-fluid" alt="">
				  	</div>
				  	<div class="smr-tab-txt">
					  	<h4 class="title">Number Smart</h4>
					  	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, quasi alias quo laborum tempora dolore saepe. Deserunt dolore laborum excepturi magni repellat. Corporis officia excepturi quo expedita architecto impedit tempora.</p>
					  	<p><strong>Kepintaran ini termasuk dalam sinergi kepintaran sosial</strong></p>			  		
				  	</div>
				  </div>
				  <div class="tab-pane fisik-tab" id="body" role="tabpanel">
				  	<div class="smr-tab-img">
				  		<img src="img/smart-number-big.png" class="img-fluid" alt="">
				  	</div>
				  	<div class="smr-tab-txt">
					  	<h4 class="title">Body Smart</h4>
					  	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, quasi alias quo laborum tempora dolore saepe. Deserunt dolore laborum excepturi magni repellat. Corporis officia excepturi quo expedita architecto impedit tempora.</p>
					  	<p><strong>Kepintaran ini termasuk dalam sinergi kepintaran sosial</strong></p>			  		
				  	</div>
				  </div>
				  <div class="tab-pane sosial-tab" id="self" role="tabpanel">
				  	<div class="smr-tab-img">
				  		<img src="img/smart-number-big.png" class="img-fluid" alt="">
				  	</div>
				  	<div class="smr-tab-txt">
					  	<h4 class="title">Self Smart</h4>
					  	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, quasi alias quo laborum tempora dolore saepe. Deserunt dolore laborum excepturi magni repellat. Corporis officia excepturi quo expedita architecto impedit tempora.</p>
					  	<p><strong>Kepintaran ini termasuk dalam sinergi kepintaran sosial</strong></p>			  		
				  	</div>
				  </div>
				  <!-- <div class="tab-pane active people-tab" id="people" role="tabpanel">
				  	<h4 class="title">People Smart</h4>
				  	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, quasi alias quo laborum tempora dolore saepe. Deserunt dolore laborum excepturi magni repellat. Corporis officia excepturi quo expedita architecto impedit tempora.</p>
				  </div>
				  <div class="tab-pane self-tab" id="self" role="tabpanel">
				  	<h4 class="title">Self Smart</h4>
				  	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, quasi alias quo laborum tempora dolore saepe. Deserunt dolore laborum excepturi magni repellat. Corporis officia excepturi quo expedita architecto impedit tempora.</p>
				  </div>
				  <div class="tab-pane number-tab" id="number" role="tabpanel">
				  	<h4 class="title">Number Smart</h4>
				  	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, quasi alias quo laborum tempora dolore saepe. Deserunt dolore laborum excepturi magni repellat. Corporis officia excepturi quo expedita architecto impedit tempora.</p>
				  </div>
				  <div class="tab-pane word-tab" id="word" role="tabpanel">
				  	<h4 class="title">Number Smart</h4>
				  	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, quasi alias quo laborum tempora dolore saepe. Deserunt dolore laborum excepturi magni repellat. Corporis officia excepturi quo expedita architecto impedit tempora.</p>
				  </div>
				  <div class="tab-pane body-tab" id="body" role="tabpanel">
				  	<h4 class="title">Number Smart</h4>
				  	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, quasi alias quo laborum tempora dolore saepe. Deserunt dolore laborum excepturi magni repellat. Corporis officia excepturi quo expedita architecto impedit tempora.</p>
				  </div>
				  <div class="tab-pane picture-tab" id="picture" role="tabpanel">
				  	<h4 class="title">Number Smart</h4>
				  	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, quasi alias quo laborum tempora dolore saepe. Deserunt dolore laborum excepturi magni repellat. Corporis officia excepturi quo expedita architecto impedit tempora.</p>
				  </div>
				  <div class="tab-pane music-tab" id="music" role="tabpanel">
				  	<h4 class="title">Number Smart</h4>
				  	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, quasi alias quo laborum tempora dolore saepe. Deserunt dolore laborum excepturi magni repellat. Corporis officia excepturi quo expedita architecto impedit tempora.</p>
				  </div>
				  <div class="tab-pane nature-tab" id="nature" role="tabpanel">
				  	<h4 class="title">Number Smart</h4>
				  	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, quasi alias quo laborum tempora dolore saepe. Deserunt dolore laborum excepturi magni repellat. Corporis officia excepturi quo expedita architecto impedit tempora.</p>
				  </div> -->
				</div>
			</div>
			<div class="smr-chart">
				<canvas class="sampleChart" width="500" height="500"></canvas>
			</div>
			<div class="nav-social">
				<p>Bagikan </p>
				<a href="#" class="btn btn-facebook"><i class="fa-facebook" aria-hidden="true"></i><span class="sr-only">Facebook</span></a>
				<a href="#" class="btn btn-twitter"><i class="fa-twitter" aria-hidden="true"></i><span class="sr-only">Twitter</span></a>
				<a href="#" class="btn btn-whatsapp"><i class="fa-whatsapp" aria-hidden="true"></i><span class="sr-only">Twitter</span></a>
			</div>
		</div>

		<div class="smr-recap row">
			<div class="col-12">
				<h2 class="subtitle">Tipe Kehebatan [nama anak]</h2>
				<p>Hasil deteksi kehebatan yang muncul untuk [nama anak] adalah [hasil]</p>
				<p>Yuk [Mam/Pap], kembangkan kehebatan si Kecil berdasarkan tahapan usia dan tipe kehebatannya untuk optimalkan proses belajarnya</p>
				<p class="small strong text-center mb-2">Download modul stimulasi kepintaran [nama anak]</p>
			</div>
			<div class="col smr-recap-btns mx-auto">
				<a href="" class="btn strong btn-smartness w-100 text-left btn-body"><i class="wy wy-smart wy-smart-body"></i>Body Smart</a>
				<a href="" class="btn strong btn-smartness w-100 text-left btn-music"><i class="wy wy-smart wy-smart-music"></i>Music Smart</a>
				<a href="" class="btn strong btn-smartness w-100 text-left btn-nature"><i class="wy wy-smart wy-smart-nature"></i>Nature Smart</a>
				<a href="" class="btn strong btn-smartness w-100 text-left btn-number"><i class="wy wy-smart wy-smart-number"></i>Number Smart</a>
				<a href="" class="btn strong btn-smartness w-100 text-left btn-people"><i class="wy wy-smart wy-smart-people"></i>People Smart</a>
				<a href="" class="btn strong btn-smartness w-100 text-left btn-picture"><i class="wy wy-smart wy-smart-picture"></i>Picture Smart</a>
				<a href="" class="btn strong btn-smartness w-100 text-left btn-self"><i class="wy wy-smart wy-smart-self"></i>Self Smart</a>
				<a href="" class="btn strong btn-smartness w-100 text-left btn-word"><i class="wy wy-smart wy-smart-word"></i> Smart</a>
			</div>
		</div>
	</div>

	<div class="container c-inner mainPadding ssfr-foot">
    <section class="related-atc atc-col">
      <div class="row">
        <div class="a-hero col-6 col-lg-3">
          <a href="">
            <div class="img">
              <img src="uploads/ch-5.jpg">
            </div>
            <div class="txt">
              <h3 class="a-title">Sinergisme Akal, Fisik, dan Sosial</h3>
            </div>
          </a>
        </div>
        <div class="a-hero col-6 col-lg-3">
          <a href="">
            <div class="img">
              <img src="uploads/ch-5.jpg">
            </div>
            <div class="txt">
              <h3 class="a-title">Pemantauan Sinergisme Akal, Fisik, dan Sosial</h3>
            </div>
          </a>
        </div>
        <div class="a-hero col-6 col-lg-3">
          <a href="">
            <div class="img">
              <img src="uploads/ch-5.jpg">
            </div>
            <div class="txt">
              <h3 class="a-title">Stimulasi Akal, Fisik, dan Sosial</h3>
            </div>
          </a>
        </div>
        <div class="a-hero col-6 col-lg-3">
          <a href="">
            <div class="img">
              <img src="uploads/ch-5.jpg">
            </div>
            <div class="txt">
              <h3 class="a-title">Tips Praktis Metode Stimulasi yang Tepat dan Benar</h3>
            </div>
          </a>
        </div>
      </div>
    </section>
	</div>
</main>

<?php include 'partials/mainFooter.php'; ?>


<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	<script>
	</script>
<?php include 'partials/html-end.php'; ?>
