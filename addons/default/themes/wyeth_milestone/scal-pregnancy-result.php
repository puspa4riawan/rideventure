<?php include 'partials/html-head-start.php'; ?>
	<title>Smart Ovulation Calendar</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/fullcalendar.min.css"/>
	<link rel="stylesheet" href="css/p-scal.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent" class="scal-page">
	<div class="container c-inner">
		<div class="intro">
			<h2 class="subtitle">
				<small>Perkiraan tanggal kelahiran si Kecil adalah:</small>
				22 Desember 2017
			</h2>
			<p>Ini adalah minggu ke-3 kehamilan Anda.</p>
			<p>Masih 262 hari lagi menjelang kelahiran si Kecil!</p>
		</div>

	</div>
	<div class="c-0 c-inner">
		<div class="row-0 scal-pregnancy">
			<div class="scal-cal">
				<div class="calendar-wrapper">
					<div id="oCalendar"></div>		
				</div>
				<h4>Perkiraan waktu melahirkan Anda antara:</h4>
				<p>15 September - 29 Desember 2017</p>
				<div class="btns">
					<a href="" class="btn btn-primary btn-capital btn-lg">Hitung lagi <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>				
				</div>
				<div class="nav-social hidden-md-up">
					<strong>Bagikan</strong>
					<a href="#" class="btn btn-facebook"><i class="fa-facebook" aria-hidden="true"></i><span class="sr-only">Facebook</span></a>
					<a href="#" class="btn btn-twitter"><i class="fa-twitter" aria-hidden="true"></i><span class="sr-only">Twitter</span></a>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="scal-result">
				<h3>Tahap Kehamilan</h3>

				<h4>14 April 2018</h4>
				<p><a href="">Trisemester pertama kehamilan</a></p>

				<h4>14 April 2018</h4>
				<p><a href="">Trisemester pertama kehamilan</a></p>

				<h4>14 April 2018</h4>
				<p><a href="">Trisemester pertama kehamilan</a></p>


				<div class="nav-social hidden-sm-down">
					<strong>Bagikan</strong>
					<a href="#" class="btn btn-facebook"><i class="fa-facebook" aria-hidden="true"></i><span class="sr-only">Facebook</span></a>
					<a href="#" class="btn btn-twitter"><i class="fa-twitter" aria-hidden="true"></i><span class="sr-only">Twitter</span></a>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		
	</div>
</main>

<?php include 'partials/footerAbout.php'; ?>
<?php include 'partials/mainFooter.php'; ?>


<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	<script src='js/fullcalendar.min.js'></script>
	<script>
			$('.siklus-minus').on('click', function(){
				$('#input-siklus').val(parseInt($('#input-siklus').val())-1);
				if($('#input-siklus').val()<0) $('#input-siklus').val('0');
			})
			$('.siklus-plus').on('click', function(){
				$('#input-siklus').val(parseInt($('#input-siklus').val())+1);
			})
			$('#input-siklus').on('keyup', function(){
				newval = $(this).val().replace(/[^0-9.]/g, "");
    			$(this).val(newval);
			})
			$('#oCalendar').fullCalendar({
				header: {
					left: 'prev',
					center: 'title',
					right: 'next'
				},
				defaultDate: '2017-11-12',
				height: 450,
				events: [
					{
						title: '3',
						start: '2017-11-03',
						constraint: 'startingDay',
						className: 'sDay'
					},
					{
						title: '13',
						start: '2017-11-13',
						constraint: 'ovulationDay', // defined below
						className: 'oDay'
					},
					{
						title: '18',
						start: '2017-11-18',
						constraint: 'fertilizationDay', // defined below
						className: 'fDay'
					}
				]
			});
			$('#datepicker').datepicker({
	    	container: $('#datepicker-container'),
	    	autoclose: true,
	    	format: 'dd / mm / yyyy',
	    	endDate: "today",
		    maxViewMode: 0,
		    language: "id",
	    });
	    $('#datepicker').datepicker()
		    .on('show', function(e) {
		      $('#datepicker-container').addClass('isCal');
		    })
		    .on('hide', function(e){
		      $('#datepicker-container').removeClass('isCal');
		    })
		    ;

	</script>
<?php include 'partials/html-end.php'; ?>