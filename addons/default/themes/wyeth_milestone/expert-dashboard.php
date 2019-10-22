<?php include 'partials/html-head-start.php'; ?>
<title>User Profile</title>
<!-- separate page style -->
<link rel="stylesheet" href="css/p-db.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent" class="profile-dashboard expert-dashboard">
	<div class="container c-outer">
		<div class="row">
			<div class="dash-aside">
					<div class="user-info">
						<div class="img">
							<img src="uploads/doctor-2.jpg" alt="">
						</div>
						<div class="txt">
							<h2 class="expert-name">Victoria Djajadi, MNutrDiet, APD </h2>
							<p>By <span class="text-emas">Nutrition Expert</span></p>
						</div>
					</div>
					<nav class="nav flex-column nav-pills" id="tabPages" role="tablist" aria-orientation="vertical">
				    <a class="nav-link" id="dash-expert-tab" data-toggle="pill" href="#dash-expert" role="tab" aria-controls="dash-expert" aria-selected="true">My Conslusion<span class="tag">2</span></a>
				    <a class="nav-link active" id="view-profile-tab" data-toggle="pill" href="#view-profile" role="tab" aria-controls="view-profile" aria-selected="false">My Profile</a>
				    <a class="nav-link" id="settings-tab" data-toggle="pill" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
					</nav>
			</div>
			<div class="dash-main">
				<div class="tab-content">
					<?php include 'partials/dash-expert.php'; ?>
					<?php include 'partials/dash-view-profile.php'; ?>
					<?php include 'partials/dash-settings.php'; ?>
				</div>
			</div>
		</div>
	</div>
</main>
<?php include 'partials/mainFooter.php'; ?>


<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	
	<script type="text/javascript">
		$(document).ready(function(){

		})
	</script>
<?php include 'partials/html-end.php'; ?>