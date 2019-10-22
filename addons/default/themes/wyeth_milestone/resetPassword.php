<?php include 'partials/html-head-start.php'; ?>
	<title>Reset Password</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent" class="p-forgotPass">
	<div class="container c-inner mainPadding">
		<div class="row">
			<div class="col-12 col-md-6 mx-auto">
				<form action="">
					<div class="form-group">
						<label for=""><strong>Password</strong></label>
						<input type="password" class="form-control">
					</div>
					<div class="form-group mb-4">
						<label for=""><strong>Repeat Password	</strong></label>
						<input type="password" class="form-control">
					</div>
					<div class="form-group">
						<button class="btn btn-primary btn-lg btn-capital">Reset Password <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
					</div>
				</form>
				
			</div>
		</div>
	</div>
</main>

<?php include 'partials/mainFooter.php'; ?>


<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	<script>

	</script>
<?php include 'partials/html-end.php'; ?>