<?php include 'partials/html-head-start.php'; ?>
	<title>Kumpulan popup</title>
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent">
	<div class="container c-inner py-6">
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puASI">
		  Popup ASI
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puLoginRegister">
		  Popup Login Register
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puLogin">
		  Popup Login
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puRegister">
		  Popup Register
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puThankYou">
		  Popup Thank You
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puSukses">
		  Popup Sukses
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puSC">
		  Popup Smart Consultation
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puLimitAnak">
		  Popup Limit Anak
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puGlobal">
		  Popup Global
		</button>

		<h2>Vaksin</h2>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puIntroVaksin">
		  Popup Intro Vaksin
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puBeforeUpdate">
		  Popup Before Update
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puCatatTanggal">
		  Popup tanggal + catatan vaksin
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puCatatTanggalOnly">
		  Popup tanggal vaksin
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puCatatanVaksin">
		  Popup Catatan Vaksin
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puJadwalImunisasi">
		  Popup Jadwal imunisasi
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puTanggalImunisasiUpdated">
		  Popup Tanggal imunisasi updated
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puAllowCalendar">
		  Popup allow calendar
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puEmailReminder">
		  Popup email calendar
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#puEmailReminderUpdated">
		  Popup email calendar sent
		</button>
	</div>
</main>
<?php include 'partials/puASI.php'; ?>
<?php include 'partials/puLoginRegister.php'; ?>
<?php include 'partials/puLogin.php'; ?>
<?php include 'partials/puRegister.php'; ?>
<?php include 'partials/puThankYou.php'; ?>
<?php include 'partials/puSukses.php'; ?>
<?php include 'partials/puSC.php'; ?>
<?php include 'partials/puLimitAnak.php'; ?>
<?php include 'partials/puGlobal.php'; ?>

<?php include 'partials/puIntroVaksin.php'; ?>
<?php include 'partials/puBeforeUpdate.php'; ?>
<?php include 'partials/puCatatTanggal.php'; ?>
<?php include 'partials/puCatatTanggalOnly.php'; ?>
<?php include 'partials/puCatatanVaksin.php'; ?>
<?php include 'partials/puJadwalImunisasi.php'; ?>
<?php include 'partials/puTanggalImunisasiUpdated.php'; ?>
<?php include 'partials/puAllowCalendar.php'; ?>
<?php include 'partials/puEmailReminder.php'; ?>
<?php include 'partials/puEmailReminderUpdated.php'; ?>
<!-- <?php include 'partials/.php'; ?> -->


<?php include 'partials/mainFooter.php'; ?>


<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	<script>
		$(document).ready(function(){
			// open popup ASI
			// $('#puASI').modal('show');
		});
	</script>
<?php include 'partials/html-end.php'; ?>