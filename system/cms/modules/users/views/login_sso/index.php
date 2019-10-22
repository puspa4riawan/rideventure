
<?php include_once('partials/header.php') ?>
<?php include_once('partials/nav.php') ?>

<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<p>&nbsp;</p>
			<?php if (!$isLoggedIn): ?>
				<h4>You are currently Not Logged-In</h4>
				<?php if (isset($_SESSION['error'])): ?>
					<p class="alert alert-danger"><?php echo $_SESSION['error'] ?></p>
				<?php endif; ?>
			<?php else: ?>
				<?php if (isset($_SESSION['user'])): ?>
					<?php include_once('partials/profile.php') ?>
				<?php elseif (isset($_SESSION['error'])): ?>
					<p class="alert alert-danger"><?php echo $_SESSION['error'] ?></p>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php include_once('partials/footer.php') ?>
