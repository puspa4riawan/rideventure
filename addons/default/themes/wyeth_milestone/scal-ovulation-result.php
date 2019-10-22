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
			<h2 class="subtitle mb-2">Lihat Masa Subur Anda</h2>
			<p class="mb-4">10 hari menuju ovulasi berikutnya</p>
			<div class="legend">
				<span><i class="wy wy-d1" aria-hidden="true"></i> : Hari pertama siklus</span>
				<span><i class="wy wy-dOv" aria-hidden="true"></i> : Masa subur</span>
				<span><i class="wy wy-dFer" aria-hidden="true"></i> : Perkiraan ovulasi</span>
			</div>
		</div>
	</div>
	<div class="c-0 c-inner">
		<div class="row-0">
			<div class="scal-cal">
				<div class="calendar-wrapper">
					<div id="oCalendar"></div>		
				</div>
			</div>
			<div class="scal-result">
				<div class="row-0">
					<div class="due-date">
						<h4>Due Date</h4>
						<p>20 Juni 2017</p>
					</div>

					<div class="nav-social">
						<strong>Bagikan</strong>
						<a href="#" class="btn btn-facebook"><i class="fa-facebook" aria-hidden="true"></i><span class="sr-only">Facebook</span></a>
						<a href="#" class="btn btn-twitter"><i class="fa-twitter" aria-hidden="true"></i><span class="sr-only">Twitter</span></a>
						<div class="clearfix"></div>
					</div>
				</div>
				
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Masa subur berikutnya</th>
							<th scope="col">Ovulasi</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>06 Januari 2018 - 10 Januari 2018</td>
							<td>08 Januari 2018</td>
						</tr>
						<tr>
							<td>03 Februari 2018 - 07 Februari 2018</td>
							<td>05 Februari 2018</td>
						</tr>
						<tr>
							<td>03 Maret 2018 - 07 Maret 2018</td>
							<td>05 Maret 2018</td>
						</tr>
						<tr>
							<td>31 Maret 2018 - 04 April 2018</td>
							<td>02 April 2018</td>
						</tr>
						<tr>
							<td>28 April 2018 - 02 Mei 2018</td>
							<td>30 April 2018</td>
						</tr>
					</tbody>
				</table>
				<a href="" class="btn btn-primary btn-capital btn-lg">Hitung lagi <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>				
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