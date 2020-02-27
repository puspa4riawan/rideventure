<div class="ms bg-prahamil">
    <div class="container c-inner">
        <h2 class="subtitle"><i class="i mi prahamil"></i>Prakehamilan</h2>

        {{ article:render_milestone_tools milestone="<?= $milestone['prakehamilan']; ?>" type="desktop" }}

        <?php
        $main = array();
        $_id = 0;
        ?>
        <div class="row">
            <?php if (isset($articles['prakehamilan'])) { ?>
                <div class="col-12 col-lg-8">
                    <div class="a-hero">
                        <?php
                        if (isset($articles_main['prakehamilan'][0])) {
                            $main = $articles_main['prakehamilan'][0];
                            $_id = $main->article_id;

                            $_img_desktop = $main->full_path;
                            $_img_mobile = !empty($main->filename_mobile)
                                ? $main->path.'/'.$main->filename_mobile
                                : $main->full_path;

                            if (empty($_img_mobile) && $main->images) {
                                if (isset($main->images[0])) {
                                    $_img_mobile = $main->images[0]->full_path;
                                }
                            }

                            if (empty($_img_desktop) && $main->images) {
                                if (isset($main->images[0])) {
                                    $_img_desktop = $main->images[0]->full_path;
                                }
                            }
                        }
                        ?>
                        <?php if ($main) { ?>
                            <a href="<?= site_url('smart-stories/'.$main->slug); ?>">
                                <div class="img">
                                    <img src="<?= site_url($_img_mobile); ?>" alt="" class="hidden-md-up">
                                    <img src="<?= site_url($_img_desktop); ?>" alt="" class="hidden-sm-down">
                                </div>
                                <div class="txt">
                                    <h3 class="a-title"><?= $main->title; ?></h3>
                                    <i class="i circle-arrow-3"></i>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-12 col-lg-4 col-first">
                    {{ article:render_milestone_tools milestone="<?= $milestone['prakehamilan']; ?>" type="mobile" }}

                    <div class="a-list">
                        <?php $_counter = 0; ?>
                        <?php foreach ($articles['prakehamilan'] as $article) { ?>
                            <?php
                            $_img_mobile = !empty($article->filename_mobile)
                                ? $article->path.'/'.$article->filename_mobile
                                : $article->full_path;

                            if (empty($_img_mobile) && $article->images) {
                                if (isset($article->images[0])) {
                                    $_img_mobile = $article->images[0]->full_path;
                                }
                            }
                            ?>
                            <?php if ($article->article_id != $_id && $_counter < 3) { ?>
                                <?php if ($article->featured == 1) { ?>
                                    <a href="<?= site_url('smart-stories/'.$article->slug); ?>" class="atc">
                                        <div class="img">
                                            <img src="<?= site_url($_img_mobile); ?>" alt="">
                                        </div>
                                        <div class="txt">
                                            <div>
                                                <h4 class="a-title"><?= $article->title; ?></h4>
                                                <div class="meta-bar">
                                                    <span class="a-cate"><?= $article->milestone['data']; ?></span>
                                                    <span class="a-time"><?= calculate_article_time($article->created, $timezone); ?></span>
                                                </div>
                                            </div>
                                            <i class="i arrow-2"></i>
                                        </div>
                                    </a>
                                    <?php $_counter++; ?>
                                <?php } else { ?>
                                    <a href="<?= site_url('smart-stories/'.$article->slug); ?>" class="atc">
                                        <div class="img">
                                            <img src="<?= site_url($_img_mobile); ?>" alt="">
                                        </div>
                                        <div class="txt">
                                            <div>
                                                <h4 class="a-title"><?= $article->title; ?></h4>
                                                <div class="meta-bar">
                                                    <span class="a-cate"><?= $article->milestone['data']; ?></span>
                                                    <span class="a-time"><?= calculate_article_time($article->created, $timezone); ?></span>
                                                </div>
                                            </div>
                                            <i class="i arrow-2"></i>
                                        </div>
                                    </a>
                                    <?php $_counter++; ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <a href="<?= site_url('prakehamilan'); ?>" class="btn-more">Selengkapnya <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="ms bg-hamil">
    <div class="container c-inner">
        <h2 class="subtitle"><i class="i mi hamil"></i>Kehamilan</h2>

        {{ article:render_milestone_tools milestone="<?= $milestone['kehamilan']; ?>" type="desktop" }}

        <div class="row">
            <?php if (isset($articles['kehamilan'])) { ?>
                <div class="col-12 col-lg-8">
                    <div class="a-hero">
                        <?php
                        if (isset($articles_main['kehamilan'][0])) {
                            $main = $articles_main['kehamilan'][0];
                            $_id = $main->article_id;

                            $_img_desktop = $main->full_path;
                            $_img_mobile = !empty($main->filename_mobile)
                                ? $main->path.'/'.$main->filename_mobile
                                : $main->full_path;

                            if (empty($_img_mobile) && $main->images) {
                                if (isset($main->images[0])) {
                                    $_img_mobile = $main->images[0]->full_path;
                                }
                            }

                            if (empty($_img_desktop) && $main->images) {
                                if (isset($main->images[0])) {
                                    $_img_desktop = $main->images[0]->full_path;
                                }
                            }
                        }
                        ?>
                        <?php if ($main) { ?>
                            <a href="<?= site_url('smart-stories/'.$main->slug); ?>">
                                <div class="img">
                                    <img src="<?= site_url($_img_mobile); ?>" alt="" class="hidden-md-up">
                                    <img src="<?= site_url($_img_desktop); ?>" alt="" class="hidden-sm-down">
                                </div>
                                <div class="txt">
                                    <h3 class="a-title"><?= $main->title; ?></h3>
                                    <i class="i circle-arrow-3"></i>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    {{ article:render_milestone_tools milestone="<?= $milestone['kehamilan']; ?>" type="mobile" }}

                    <div class="a-list">
                        <?php $_counter = 0; ?>
                        <?php foreach ($articles['kehamilan'] as $article) { ?>
                            <?php
                            $_img_mobile = !empty($article->filename_mobile)
                                ? $article->path.'/'.$article->filename_mobile
                                : $article->full_path;

                            if (empty($_img_mobile) && $article->images) {
                                if (isset($article->images[0])) {
                                    $_img_mobile = $article->images[0]->full_path;
                                }
                            }
                            ?>
                            <?php if ($article->article_id != $_id && $_counter < 3) { ?>
                                <?php if ($article->featured == 1) { ?>
                                    <a href="<?= site_url('smart-stories/'.$article->slug); ?>" class="atc">
                                        <div class="img">
                                            <img src="<?= site_url($_img_mobile); ?>" alt="">
                                        </div>
                                        <div class="txt">
                                            <div>
                                                <h4 class="a-title"><?= $article->title; ?></h4>
                                                <div class="meta-bar">
                                                    <span class="a-cate"><?= $article->milestone['data']; ?></span>
                                                    <span class="a-time"><?= calculate_article_time($article->created, $timezone); ?></span>
                                                </div>
                                            </div>
                                            <i class="i arrow-2"></i>
                                        </div>
                                    </a>
                                    <?php $_counter++; ?>
                                <?php } else { ?>
                                    <a href="<?= site_url('smart-stories/'.$article->slug); ?>" class="atc">
                                        <div class="img">
                                            <img src="<?= site_url($_img_mobile); ?>" alt="">
                                        </div>
                                        <div class="txt">
                                            <div>
                                                <h4 class="a-title"><?= $article->title; ?></h4>
                                                <div class="meta-bar">
                                                    <span class="a-cate"><?= $article->milestone['data']; ?></span>
                                                    <span class="a-time"><?= calculate_article_time($article->created, $timezone); ?></span>
                                                </div>
                                            </div>
                                            <i class="i arrow-2"></i>
                                        </div>
                                    </a>
                                    <?php $_counter++; ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <a href="<?= site_url('kehamilan'); ?>" class="btn-more">Selengkapnya <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="ms bg-bayi">
    <div class="container c-inner">
        <h2 class="subtitle"><i class="i mi bayi"></i>Bayi</h2>

        {{ article:render_milestone_tools milestone="<?= $milestone['bayi']; ?>" type="desktop" }}

        <div class="row">
            <?php if (isset($articles['bayi'])) { ?>
                <div class="col-12 col-lg-8">
                    <div class="a-hero">
                        <?php
                        if (isset($articles_main['bayi'][0])) {
                            $main = $articles_main['bayi'][0];
                            $_id = $main->article_id;

                            $_img_desktop = $main->full_path;
                            $_img_mobile = !empty($main->filename_mobile)
                                ? $main->path.'/'.$main->filename_mobile
                                : $main->full_path;

                            if (empty($_img_mobile) && $main->images) {
                                if (isset($main->images[0])) {
                                    $_img_mobile = $main->images[0]->full_path;
                                }
                            }

                            if (empty($_img_desktop) && $main->images) {
                                if (isset($main->images[0])) {
                                    $_img_desktop = $main->images[0]->full_path;
                                }
                            }
                        }
                        ?>
                        <?php if ($main) { ?>
                            <a href="<?= site_url('smart-stories/'.$main->slug); ?>">
                                <div class="img">
                                    <img src="<?= site_url($_img_mobile); ?>" alt="" class="hidden-md-up">
                                    <img src="<?= site_url($_img_desktop); ?>" alt="" class="hidden-sm-down">
                                </div>
                                <div class="txt">
                                    <h3 class="a-title"><?= $main->title; ?></h3>
                                    <i class="i circle-arrow-3"></i>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    {{ article:render_milestone_tools milestone="<?= $milestone['bayi']; ?>" type="mobile" }}

                    <div class="a-list">
                        <?php $_counter = 0; ?>
                        <?php foreach ($articles['bayi'] as $article) { ?>
                            <?php
                            $_img_mobile = !empty($article->filename_mobile)
                                ? $article->path.'/'.$article->filename_mobile
                                : $article->full_path;

                            if (empty($_img_mobile) && $article->images) {
                                if (isset($article->images[0])) {
                                    $_img_mobile = $article->images[0]->full_path;
                                }
                            }
                            ?>
                            <?php if ($article->article_id != $_id && $_counter < 3) { ?>
                                <?php if ($article->featured == 1) { ?>
                                    <a href="<?= site_url('smart-stories/'.$article->slug); ?>" class="atc">
                                        <div class="img">
                                            <img src="<?= site_url($_img_mobile); ?>" alt="">
                                        </div>
                                        <div class="txt">
                                            <div>
                                                <h4 class="a-title"><?= $article->title; ?></h4>
                                                <div class="meta-bar">
                                                    <span class="a-cate"><?= $article->milestone['data']; ?></span>
                                                    <span class="a-time"><?= calculate_article_time($article->created, $timezone); ?></span>
                                                </div>
                                            </div>
                                            <i class="i arrow-2"></i>
                                        </div>
                                    </a>
                                    <?php $_counter++; ?>
                                <?php } else { ?>
                                    <a href="<?= site_url('smart-stories/'.$article->slug); ?>" class="atc">
                                        <div class="img">
                                            <img src="<?= site_url($_img_mobile); ?>" alt="">
                                        </div>
                                        <div class="txt">
                                            <div>
                                                <h4 class="a-title"><?= $article->title; ?></h4>
                                                <div class="meta-bar">
                                                    <span class="a-cate"><?= $article->milestone['data']; ?></span>
                                                    <span class="a-time"><?= calculate_article_time($article->created, $timezone); ?></span>
                                                </div>
                                            </div>
                                            <i class="i arrow-2"></i>
                                        </div>
                                    </a>
                                    <?php $_counter++; ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <a href="<?= site_url('bayi'); ?>" class="btn-more">Selengkapnya <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="ms bg-anak">
    <div class="container c-inner">
        <h2 class="subtitle"><i class="i mi anak"></i>Anak</h2>

        {{ article:render_milestone_tools milestone="<?= $milestone['anak']; ?>" type="desktop" }}

        <div class="row">
            <?php if (isset($articles['anak'])) { ?>
                <div class="col-12 col-lg-8">
                    <div class="a-hero">
                        <?php
                        if (isset($articles_main['anak'][0])) {
                            $main = $articles_main['anak'][0];
                            $_id = $main->article_id;

                            $_img_desktop = $main->full_path;
                            $_img_mobile = !empty($main->filename_mobile)
                                ? $main->path.'/'.$main->filename_mobile
                                : $main->full_path;

                            if (empty($_img_mobile) && $main->images) {
                                if (isset($main->images[0])) {
                                    $_img_mobile = $main->images[0]->full_path;
                                }
                            }

                            if (empty($_img_desktop) && $main->images) {
                                if (isset($main->images[0])) {
                                    $_img_desktop = $main->images[0]->full_path;
                                }
                            }
                        }
                        ?>
                        <?php if ($main) { ?>
                            <a href="<?= site_url('smart-stories/'.$main->slug); ?>">
                                <div class="img">
                                    <img src="<?= site_url($_img_mobile); ?>" alt="" class="hidden-md-up">
                                    <img src="<?= site_url($_img_desktop); ?>" alt="" class="hidden-sm-down">
                                </div>
                                <div class="txt">
                                    <h3 class="a-title"><?= $main->title; ?></h3>
                                    <i class="i circle-arrow-3"></i>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    {{ article:render_milestone_tools milestone="<?= $milestone['anak']; ?>" type="mobile" }}

                    <div class="a-list">
                        <?php $_counter = 0; ?>
                        <?php foreach ($articles['anak'] as $article) { ?>
                            <?php
                            $_img_mobile = !empty($article->filename_mobile)
                                ? $article->path.'/'.$article->filename_mobile
                                : $article->full_path;

                            if (empty($_img_mobile) && $article->images) {
                                if (isset($article->images[0])) {
                                    $_img_mobile = $article->images[0]->full_path;
                                }
                            }
                            ?>
                            <?php if ($article->article_id != $_id && $_counter < 3) { ?>
                                <?php if ($article->featured == 1) { ?>
                                    <a href="<?= site_url('smart-stories/'.$article->slug); ?>" class="atc">
                                        <div class="img">
                                            <img src="<?= site_url($_img_mobile); ?>" alt="">
                                        </div>
                                        <div class="txt">
                                            <div>
                                                <h4 class="a-title"><?= $article->title; ?></h4>
                                                <div class="meta-bar">
                                                    <span class="a-cate"><?= $article->milestone['data']; ?></span>
                                                    <span class="a-time"><?= calculate_article_time($article->created, $timezone); ?></span>
                                                </div>
                                            </div>
                                            <i class="i arrow-2"></i>
                                        </div>
                                    </a>
                                    <?php $_counter++; ?>
                                <?php } else { ?>
                                    <a href="<?= site_url('smart-stories/'.$article->slug); ?>" class="atc">
                                        <div class="img">
                                            <img src="<?= site_url($_img_mobile); ?>" alt="">
                                        </div>
                                        <div class="txt">
                                            <div>
                                                <h4 class="a-title"><?= $article->title; ?></h4>
                                                <div class="meta-bar">
                                                    <span class="a-cate"><?= $article->milestone['data']; ?></span>
                                                    <span class="a-time"><?= calculate_article_time($article->created, $timezone); ?></span>
                                                </div>
                                            </div>
                                            <i class="i arrow-2"></i>
                                        </div>
                                    </a>
                                    <?php $_counter++; ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <a href="<?= site_url('anak'); ?>" class="btn-more">Selengkapnya <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
