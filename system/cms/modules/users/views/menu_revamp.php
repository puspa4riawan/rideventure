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
            <?php if ($expert) { ?>
                <h2 class="expert-name"><?= ucwords($this->current_user->first_name); ?></h2>
                <?php if ($doctor_data) { ?>
                    <p>By <span class="text-emas"><?= $doctor_data->speciality_title; ?> Expert</span></p>
                <?php } ?>
            <?php } else { ?>
                <h2 class="page-subtitle"><?= ucwords($this->current_user->first_name); ?></h2>
            <?php } ?>
            <?php if ($this->current_user->group_id==2) { ?>
                <p class="user-status"><?= $this->current_user->gender == 'f' ? 'Mam' : 'Pap'; ?> with <?= count($child); ?> kids</p>
                <p class="user-membership">Member since <?= format_date(strtotime($profile->created), 'F d, Y'); ?></p>
            <?php } ?>
            <?php if ($this->current_user->group_id==3) { ?>
                <p class="user-badge"><i class="i blogger"></i>Verified Contributor</p>
            <?php } ?>
        </div>
    </div>
    <nav class="nav flex-column nav-pills" id="tabPages" role="tablist" aria-orientation="vertical">
        <?php if ($this->current_user->group_id == 3) { ?>
            <a class="nav-link article-list <?= $page_active == 'view-artikel' ? 'active' : ''; ?>" data-toggle="pill" href="#view-artikel" role="tab" aria-controls="view-artikel" aria-selected="<?= $page_active == 'view-artikel' ? 'true' : 'false'; ?>">Daftar Artikel <span class="tag"><?= count((array) $users_article); ?></span></a>
            <a class="nav-link new-article <?= $page_active == 'tulis-artikel' ? 'active' : ''; ?>" data-toggle="pill" href="#tulis-artikel" role="tab" aria-controls="tulis-artikel" aria-selected="<?= $page_active == 'tulis-artikel' ? 'true' : 'false'; ?>">Tulis Artikel</a>
            <a class="nav-link <?= $page_active == 'my-activity' ? 'active' : ''; ?>" data-toggle="pill" href="#my-activity" role="tab" aria-controls="my-activity" aria-selected="<?= $page_active == 'my-activity' ? 'true' : 'false'; ?>">My activity <span class="tag"><?= $activity_count; ?></span></a>
        <?php } ?>
        <?php if ($this->current_user->group_id == 2) { ?>
            <a class="nav-link <?= $page_active == 'my-activity' ? 'active' : ''; ?>" data-toggle="pill" href="#my-activity" role="tab" aria-controls="my-activity" aria-selected="<?= $page_active == 'my-activity' ? 'true' : 'false'; ?>">My activity <span class="tag"><?= $activity_count; ?></span></a>
        <?php } ?>
        <?php if ($this->current_user->group_id == 5 || $this->current_user->group_id == 6) { ?>
            <a class="nav-link <?= $page_active == 'dash-expert' ? 'active' : ''; ?>" id="dash-expert-tab" data-toggle="pill" href="#dash-expert" role="tab" aria-controls="dash-expert" aria-selected="<?= $page_active == 'dash-expert' ? 'true' : 'false'; ?>">My Consultation<span class="tag"><?= (int) $asks_data_count + (int) $ask_limit; ?></span></a>
        <?php } ?>
        <a class="nav-link <?= $page_active == 'edit-profile' ? 'active' : ''; ?>" data-toggle="pill" href="#edit-profile" role="tab" aria-controls="edit-profile" aria-selected="<?= $page_active == 'edit-profile' ? 'true' : 'false'; ?>">Edit Profile</a>
        <a class="nav-link <?= $page_active == 'settings' ? 'active' : ''; ?>" data-toggle="pill" href="#settings" role="tab" aria-controls="settings" aria-selected="<?= $page_active == 'settings' ? 'true' : 'false'; ?>">Settings</a>
    </nav>
</div>
