<div class="container c-inner">
	<div class="row">
		<div class="dash-aside">
            <div class="user-info">
                <div class="img">
                    <?php if ($profile->photo_profile) {
                        if (file_exists($profile->photo_profile)) {
                            $prof_pic = site_url($profile->photo_profile);
                        } else {
                            $prof_pic = '{{ theme:image_url file=\'anak-none.jpg\' }}';
                        }
                    } else {
                        $prof_pic = '{{ theme:image_url file=\'anak-none.jpg\' }}';
                    } ?>
                    <img src="<?= $prof_pic; ?>" alt="">
                </div>
                <div class="txt">
                    <h2 class="page-subtitle"><?= ucwords($profile->display_name); ?></h2>
                    <p class="user-status"><?= $profile->gender == 'f' ? 'Mam' : 'Pap'; ?> with <?= count($child); ?> kids</p>
                    <p class="user-membership">Member since <?= format_date(strtotime($profile->created), 'F d, Y'); ?></p>
                    <?php if ($users_article && count((array) $users_article) > 0) { ?>
                        <p class="user-badge"><i class="i blogger"></i>Verified Contributor</p>
                    <?php } ?>
                </div>
            </div>
            <nav class="nav flex-column nav-pills" id="tabPages" role="tablist" aria-orientation="vertical">
                <a class="nav-link <?= $page_active == 'profile' ? 'active' : ''; ?>" data-toggle="pill" href="#view-profile" role="tab" aria-controls="view-profile" aria-selected="<?= $page_active == 'profile' ? 'true' : 'false'; ?>">View Profile</a>
                <a class="nav-link <?= $page_active == 'artikel' ? 'active' : ''; ?>" data-toggle="pill" href="#artikel" role="tab" aria-controls="artikel" aria-selected="<?= $page_active == 'artikel' ? 'true' : 'false'; ?>">Daftar Artikel <span class="tag"><?= count((array) $users_article); ?></span></a>
            </nav>
        </div>

		<div class="dash-main">
			<div class="tab-content">
				<?php $this->load->view('users/partials/dash-view-profile'); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#mainContent').addClass('profile-dashboard');
    });
</script>
<script type="text/javascript">
	var segment1 = '<?= $this->uri->segment(1); ?>';
	var segment2 = '<?= $this->uri->segment(2); ?>';
	$(document).ready(function() {
		$('.dash-aside .nav-link, .btn-link').on('click', function(e) {
            var page = $(this).attr('href').replace(/\#/g, '');

            if (page == 'view-profile') {
                page = 'profile';
            }

            page = segment1+'/'+segment2+'/'+page;

			$('.tab-pane').removeClass('active');
			$('#'+page).addClass('active');

			history.pushState({}, '', SITE_URL+page);
			setTimeout(function() {
				$(window).resize();
    		}, 200);
		});
	});
</script>
