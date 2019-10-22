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
		<h2 class="subtitle mb-2">Smart Ovulation Calendar</h2>
		<p class="mb-4">Sedang merencanakan kehamilan? Fitur ini akan memudahkan Anda menghitung masa ovulasi dan masa subur dengan beberapa langkah sederhana</p>

		<div class="row-0">
			<div class="scal-form">
				<div class="form-group">
					<label for="datepicker">Hari pertama siklus menstruasi yang lalu</label>
					<div class="bg-emas-gr">
						<input type="text" class="form-control" id="datepicker" readonly placeholder="Pilih tanggal">
					</div>
				</div>
				<div class="form-group">
					<label for="input-siklus">Rata-rata lama siklus</label>
					<div class="row">
						<div class="siklus-form">
							<div class="group">
								<button class="siklus-minus i cl-prev"></button>
								<input type="number" placeholder="0" id="input-siklus" value="28" class="form-control">
								<button class="siklus-plus i cl-next"></button>
							</div>
						</div>
						<div class="txt">
							* From the first day of your period to the first day of your next period. <br>
							Range: 22 - 44; Default: 28 <br>
							Leave 28 if unsure
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-12">
							<button class="btn btn-primary btn-capital w-100">Cari Tanggal Ovulasi <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div id="datepicker-container"></div>
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