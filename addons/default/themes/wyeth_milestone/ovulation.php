<?php include 'partials/html-head-start.php'; ?>
	<title>Ovulation Calendar</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/fullcalendar.min.css"/>
	<link rel="stylesheet" href="css/p-ovulation.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent" class="ovulation-page">
	<i class="i mom hidden-md-up"></i>
	<i class="i cloud-7 hidden-md-up"></i>
	<div class="container c-inner">
		<div class="row">
			<div class="input col-12 col-md-6">
				<h2 class="h1">Pregnancy Due Date Calculator</h2>
				<p>10 hari menuju ovulasi berikutnya (20/09/2017)</p>
				<p><b>Hari Pertama Siklus Menstruasi yang Lalu</b></p>
				<div class="legend">
					<span><i class="i x-1"></i> : Hari pertama siklus</span>
					<span><i class="i ht-b1"></i> : Masa ovulasi</span>
					<span><i class="i ht-f1"></i> : Masa subur</span>
				</div>
				<div class="inner">
					<input type="text" placeholder="dd / mm / yyyy" id="datepicker">
				</div>
				<div class="siklus">
					<div class="left-side">
						<a href="javascript:void(0)" class="siklus-minus i cl-prev"></a>
						<input type="text" placeholder="0" id="input-siklus">
						<a href="javascript:void(0)" class="siklus-plus i cl-next"></a>
					</div>
					<div class="right-side">
						<p>
							* From the first day of your period
							to the first day of your next period.
							Range: 22 - 44; Default: 28
							Leave 28 if unsure
						</p>
					</div>
					<div class="clearfix"></div>
				</div>
				<button class="btn btn-primary btn-capital">CARI TANGGAL OVULASI <i class="i circle-arrow"></i></button>
				<div id="datepicker-container"></div>
				<div class="calendar-wrapper">
					<div id="oCalendar"></div>		
				</div>			
			</div>
			<div class="col-12 col-md-6">
				<div class="row">
					<div class="col-7">
						<p class="a-cate">Due Date</p>
						<h2>June 17th 2018</h2>
					</div>	
					<div class="col-5">
						<div class="nav-social">
							<p class="a-cate">Bagikan</p>
							<a href="#" class="btn btn-facebook"><i class="fa-facebook" aria-hidden="true"></i><span class="sr-only">Facebook</span></a>
							<a href="#" class="btn btn-twitter"><i class="fa-twitter" aria-hidden="true"></i><span class="sr-only">Twitter</span></a>
							<div class="clear"></div>
						</div>
					</div>
					<div class="col-7">
						<p class="a-cate">Another Fertile Day!</p>
						<p>14/12/2017-14/12/2017</p>
						<p>14/12/2017-14/12/2017</p>
						<p>14/12/2017-14/12/2017</p>
					</div>
					<div class="col-5">
						<p class="a-cate">Due Date</p>
						<p>14/12/2017</p>
						<p>14/12/2017</p>
						<p>14/12/2017</p>
					</div>
					<div class="col-12">
						<button class="btn btn-primary btn-capital">HITUNG LAGI <i class="i circle-arrow"></i></button>
					</div>
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
		$(document).ready(function() {
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

					// areas where "Meeting" must be dropped
					/*{
						id: 'availableForMeeting',
						start: '2017-11-11T10:00:00',
						end: '2017-11-11T16:00:00',
						rendering: 'background'
					},
					{
						id: 'availableForMeeting',
						start: '2017-11-13T10:00:00',
						end: '2017-11-13T16:00:00',
						rendering: 'background'
					},

					// red areas where no events can be dropped
					{
						start: '2017-11-24',
						end: '2017-11-28',
						overlap: false,
						rendering: 'background',
						color: '#ff9f89'
					},
					{
						start: '2017-11-06',
						end: '2017-11-08',
						overlap: false,
						rendering: 'background',
						color: '#ff9f89'
					}*/
				]
			});
			/*var picker = new Pikaday(
		    {
		        field: document.getElementById('datepicker'),
		        firstDay: 1,
		        minDate: new Date(2000, 0, 1),
		        maxDate: new Date(2020, 12, 31),
		        yearRange: [2000, 2020],
		        bound: false,
		        container: document.getElementById('datepicker-container'),
		    });*/
		    $('#datepicker').datepicker({
		    	container: $('#datepicker-container'),
		    	autoclose: true,
		    	format: 'dd / mm / yyyy'
		    });
		});
	</script>
<?php include 'partials/html-end.php'; ?>