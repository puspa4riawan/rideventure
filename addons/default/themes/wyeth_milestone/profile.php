<?php include 'partials/html-head-start.php'; ?>
<title>User Profile</title>
<!-- separate page style -->
<link rel="stylesheet" href="css/p-db.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent" class="profile-dashboard">
	<div class="container c-inner">
		<div class="row">
			<div class="dash-aside">
					<div class="user-info">
						<div class="img">
							<img src="img/anak-none.jpg" alt="">
						</div>
						<div class="txt">
							<h2 class="page-subtitle">Jessica</h2>
							<p class="user-status">Mam with 2 kids</p>
							<p class="user-membership">Member since August 12, 2016</p>
							<p class="user-badge"><i class="i blogger"></i>Verified Contributor</p>
						</div>
					</div>
					<nav class="nav flex-column nav-pills" id="tabPages" role="tablist" aria-orientation="vertical">
				    <a class="nav-link active" id="view-profile-tab" data-toggle="pill" href="#view-profile" role="tab" aria-controls="view-profile" aria-selected="true">View Profile</a>
				    <a class="nav-link" id="view-artikel-tab" data-toggle="pill" href="#view-artikel" role="tab" aria-controls="view-artikel" aria-selected="false">Daftar Artikel <span class="tag">3</span></a>
				    <a class="nav-link" id="tulis-artikel-tab" data-toggle="pill" href="#tulis-artikel" role="tab" aria-controls="tulis-artikel" aria-selected="false">Tulis Artikel</a>
				    <a class="nav-link" id="activity-tab" data-toggle="pill" href="#activity" role="tab" aria-controls="activity" aria-selected="false">My activity <span class="tag">5</span></a>
				    <a class="nav-link" id="edit-profile-tab" data-toggle="pill" href="#edit-profile" role="tab" aria-controls="edit-profile" aria-selected="false">Edit Profile</a>
				    <a class="nav-link" id="settings-tab" data-toggle="pill" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
					</nav>
			</div>
			<div class="dash-main">
				<div class="tab-content">
					<?php include 'partials/dash-view-profile.php'; ?>
					<?php include 'partials/dash-view-artikel.php'; ?>
					<?php include 'partials/dash-tulis-artikel.php'; ?>
					<?php include 'partials/dash-activity.php'; ?>
					<?php include 'partials/dash-edit-profile.php'; ?>
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
			/*$('[data-toggle="pill"]').on('shown.bs.tab', function (e) {
				if ($(window).width() && $('#artikel-addimages-swiper').length>0) {
					var addArtikelImagesSwiper = new Swiper('#artikel-addimages-swiper', {
						centeredSlides: true,
						slidesPerView: 'auto'
					});
			  		addArtikelImagesSwiper.resizeFix(true);
			  	}
				fixRatio();
			});*/
		})
	</script>
<?php include 'partials/html-end.php'; ?>