<?php include 'partials/html-head-start.php'; ?>
	<title>Vaksin Tutorial</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-vaksin.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent">
  <section class="bg-cream mainMargin-b">
    <div class="container c-inner pt-4">
      <a href="vaksin-riwayat-imunisasi.php" class="btn btn-link btn-capital btn-icon-right pl-0"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Kalender imunisasi</a>
      <hr>
    </div>

    <div class="container c-inner mainPadding">
      <div class="vaksin-section-subtitle text-emas3 text-center pb-5">
        <h2 class="text-inherit">Tutorial Kalender Imunisasi</h2>
      </div>

      <div class="row">
        <div class="col-12 col-sm-8 col-md-4 mx-auto">
          <div class="vaksin-tutorial-card">
            <i class="wy i-vaksin i-kalender-spuit" aria-hidden="true"></i>
            <div class="vaksin-tutorial-card-text">
              <h4 class="h6">Tutorial Kalender Imunisasi</h4>
              <a href="vaksin-tut-kalender-01.php" class="btn btn-primary btn-capital btn-icon-right w-100">Lihat <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
            </div>
          </div>          
        </div>

        <div class="col-12 col-sm-8 col-md-4 mx-auto">
          <div class="vaksin-tutorial-card">
            <i class="wy i-vaksin i-kalender-jam" aria-hidden="true"></i>
            <div class="vaksin-tutorial-card-text">
              <h4 class="h6">Tutorial Kalender Reminder</h4>
              <a href="vaksin-tut-reminder-kalender-01.php" class="btn btn-primary btn-capital btn-icon-right w-100">Lihat <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-8 col-md-4 mx-auto">
          <div class="vaksin-tutorial-card">
            <i class="wy i-vaksin i-envelope" aria-hidden="true"></i>
            <div class="vaksin-tutorial-card-text">
              <h4 class="h6">Tutorial Reminder Email</h4>
              <a href="vaksin-tut-reminder-email-01.php" class="btn btn-primary btn-capital btn-icon-right w-100">Lihat <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
            </div>
          </div>
        </div>
      </div>

    </div>

  </section>
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