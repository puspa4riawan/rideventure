<section class="l-article section-content section-theme">
    <div class="l-section article-container">
        <div class="l-section-shrink">
            <div class="safebox">

                <div class="c-panel section-heading">
                    <div class="c-heading">
                        <img 
                            alt="Artikel" 
                            class="figure-assets svg" 
                            src="{{ theme:image_url file='upload/placeholder/figure-section-heading-article-placeholder.png' }}" 
                            data-original="{{ theme:image_url file='upload/figure/figure-section-heading-article.svg' }}" 
                        />
                    </div>
                </div> <!-- .section-heading -->

                <div class="c-panel section-entry c-card-thumbnail-group">
                    <div class="l-section-shrink">
                        <div class="safebox c-card-thumbnail">
                    <?php
                        if($article_slug){
                            foreach ($article_slug as $article) {
                                
                    ?>
                            <!-- SINGLE THUMBNAIL -->
                            <div class="c-card color-cyan">
                                <div class="bounds">
                                    <div class="c-card-content">
                                        <div class="c-card-image-thumbnail">
                                            <img 
                                                alt="6 Cara Membuat Si Kecil Mendapat Manfaat Minum Air Putih" 
                                                class="figure-assets lazy" 
                                                src="<?= site_url($article->full_path); ?>" 
                                                data-original="<?= site_url($article->full_path); ?>" 
                                                data-src-original="<?= site_url($article->full_path); ?> 320w, 
                                                <?= site_url($article->full_path); ?> 640w, 
                                                <?= site_url($article->full_path); ?> 960w, 
                                                <?= site_url($article->full_path); ?> 1280w, 
                                                <?= site_url($article->full_path); ?> 1600w" 
                                            />
                                            <div class="c-card-icon-category">
                                                <img 
                                                    alt="Kategori Air" 
                                                    class="figure-assets lazy" 
                                                    src="{{ theme:image_url file='upload/icon/water-icon-cyan-320w.png' }}" 
                                                    data-original="{{ theme:image_url file='upload/icon/water-icon-cyan-320w.png' }}" 
                                                    data-src-original="{{ theme:image_url file='upload/icon/water-icon-cyan-320w.png' }} 320w, 
                                                    {{ theme:image_url file='upload/icon/water-icon-cyan-640w.png' }} 640w, 
                                                    {{ theme:image_url file='upload/icon/water-icon-cyan-960w.png' }} 960w, 
                                                    {{ theme:image_url file='upload/icon/water-icon-cyan-1280w.png' }} 1280w" 
                                                />
                                            </div> <!-- .c-card-icon-category -->
                                            <div class="c-card-brand-label">
                                                <img 
                                                    alt="Brand Label" 
                                                    class="figure-assets lazy" 
                                                    src="{{ theme:image_url file='upload/placeholder/figure-thumbnail-logo-label-placeholder.png' }}" 
                                                    data-original="{{ theme:image_url file='upload/figure/figure-thumbnail-logo-label-320w.png' }}" 
                                                    data-src-original="{{ theme:image_url file='upload/figure/figure-thumbnail-logo-label-320w.png' }} 320w, 
                                                    {{ theme:image_url file='upload/figure/figure-thumbnail-logo-label-640w.png' }} 640w, 
                                                    {{ theme:image_url file='upload/figure/figure-thumbnail-logo-label-960w.png' }} 960w" 
                                                />
                                            </div> <!-- .c-card-brand-label -->
                                        </div> <!-- .c-card-image-thumbnail -->
                                        <div class="c-card-entry">
                                            <h4><?= $article->title?></h4>
                                            <a href="<?= $article->altr_url ?>" class="o-button o-button-arrow color-cyan">
                                                <img 
                                                    alt="Baca Artikel" 
                                                    class="figure-assets svg" 
                                                    src="{{ theme:image_url file='upload/placeholder/figure-button-arrow-placeholder.png' }}" 
                                                    data-original="{{ theme:image_url file='upload/figure/figure-button-arrow.svg' }}" 
                                                />
                                            </a>
                                        </div> <!-- .c-card-entry -->
                                    </div> <!-- .c-card-content-->

                                    <div class="thumbnail-shadow-bg">
                                        <img 
                                            alt="thumbnail shadow" 
                                            class="figure-assets lazy" 
                                            src="{{ theme:image_url file='upload/placeholder/figure-thumbnail-shadow-placeholder.png' }}" 
                                            data-original="{{ theme:image_url file='upload/figure/figure-thumbnail-shadow-320w.png' }}" 
                                            data-src-original="{{ theme:image_url file='upload/figure/figure-thumbnail-shadow-320w.png' }} 320w, 
                                            {{ theme:image_url file='upload/figure/figure-thumbnail-shadow-640w.png' }} 640w"
                                        />
                                    </div> <!-- .section-shadow-bg -->
                                    
                                </div> <!-- .bounds -->
                            </div> <!-- .c-card -->
                            <!-- END SINGLE THUMBNAIL -->

                    <?php }} ?>                                       

                        </div> <!-- .c-card-thumbnail -->
                    </div> <!-- .l-section-shrink -->
                </div> <!-- .section-entry -->

            </div> <!-- .safebox -->
        </div> <!-- .l-section-shrink -->
    </div> <!-- .article-container -->

    <div class="section-shadow-bg">
    <img 
            alt="section shadow" 
            class="figure-assets lazy" 
            src="{{ theme:image_url file='upload/placeholder/figure-shadow-placeholder.png' }}" 
            data-original="{{ theme:image_url file='upload/figure/figure-shadow-320w.png' }}" 
            data-src-original="{{ theme:image_url file='upload/figure/figure-shadow-320w.png' }} 320w, 
            {{ theme:image_url file='upload/figure/figure-shadow-640w.png' }} 640w, 
            {{ theme:image_url file='upload/figure/figure-shadow-960w.png' }} 960w,
            {{ theme:image_url file='upload/figure/figure-shadow-1440w.png' }} 1440w"
        />
    </div> <!-- .section-shadow-bg -->
    
</section> <!-- .l-article -->

<section class="l-article section-content section-theme reverse bg-pattern">
    <div class="l-section article-container">
        <div class="l-section-shrink">
            <div class="safebox">

                <div class="c-panel section-heading">
                    <div class="c-heading">
                        <img 
                            alt="Resep Untuk Si Kecil" 
                            class="figure-assets svg" 
                            src="{{ theme:image_url file='upload/placeholder/figure-section-heading-recipe-placeholder.png' }}" 
                            data-original="{{ theme:image_url file='upload/figure/figure-section-heading-recipe.svg' }}" 
                        />
                    </div>
                </div> <!-- .section-heading -->

                <div class="c-panel section-entry c-card-thumbnail-group">
                    <div class="l-section-shrink">
                        <div class="safebox c-card-thumbnail">
                    <?php
                        if($recipe_slug){
                            foreach ($recipe_slug as $recipe) {

                    ?>
                            <!-- SINGLE THUMBNAIL -->
                            <div class="c-card">
                                <div class="bounds">
                                    <div class="c-card-content">
                                        <div class="c-card-image-thumbnail">
                                            <img 
                                                alt="<?= $recipe->title ?>" 
                                                class="figure-assets lazy" 
                                                src="<?= site_url($recipe->full_path); ?>" 
                                                data-original="<?= site_url($recipe->full_path); ?>" 
                                                data-src-original="<?= site_url($recipe->full_path); ?> 320w, 
                                                <?= site_url($recipe->full_path); ?> 640w, 
                                                <?= site_url($recipe->full_path); ?> 960w, 
                                                <?= site_url($recipe->full_path); ?> 1280w, 
                                                <?= site_url($recipe->full_path); ?> 1600w" 
                                            />
                                            <div class="c-card-brand-label">
                                                <img 
                                                    alt="Brand Label" 
                                                    class="figure-assets lazy" 
                                                    src="{{ theme:image_url file='upload/placeholder/figure-thumbnail-logo-label-placeholder.png' }}" 
                                                    data-original="{{ theme:image_url file='upload/figure/figure-thumbnail-logo-label-320w.png' }}" 
                                                    data-src-original="{{ theme:image_url file='upload/figure/figure-thumbnail-logo-label-320w.png' }} 320w, 
                                                    {{ theme:image_url file='upload/figure/figure-thumbnail-logo-label-640w.png' }} 640w, 
                                                    {{ theme:image_url file='upload/figure/figure-thumbnail-logo-label-960w.png' }} 960w" 
                                                />
                                            </div> <!-- .c-card-brand-label -->
                                        </div> <!-- .c-card-image-thumbnail -->
                                        <div class="c-card-entry">
                                            <h4><?= $recipe->title ?></h4>
                                            <a href="<?= $recipe->altr_url ?>" class="o-button o-button-arrow">
                                                <img 
                                                    alt="Baca Artikel" 
                                                    class="figure-assets svg" 
                                                    src="{{ theme:image_url file='upload/placeholder/figure-button-arrow-placeholder.png' }}" 
                                                    data-original="{{ theme:image_url file='upload/figure/figure-button-arrow.svg' }}" 
                                                />
                                            </a>
                                        </div> <!-- .c-card-entry -->
                                    </div> <!-- .c-card-content-->

                                    <div class="thumbnail-shadow-bg">
                                        <img 
                                            alt="thumbnail shadow" 
                                            class="figure-assets lazy" 
                                            src="{{ theme:image_url file='upload/placeholder/figure-thumbnail-shadow-placeholder.png' }}" 
                                            data-original="{{ theme:image_url file='upload/figure/figure-thumbnail-shadow-320w.png' }}" 
                                            data-src-original="{{ theme:image_url file='upload/figure/figure-thumbnail-shadow-320w.png' }} 320w, 
                                            {{ theme:image_url file='upload/figure/figure-thumbnail-shadow-640w.png' }} 640w"
                                        />
                                    </div> <!-- .section-shadow-bg -->
                                    
                                </div> <!-- .bounds -->
                            </div> <!-- .c-card -->
                            <!-- END SINGLE THUMBNAIL -->

                    <?php }} ?>                                     

                        </div> <!-- .c-card-thumbnail -->
                    </div> <!-- .l-section-shrink -->
                </div> <!-- .section-entry -->

            </div> <!-- .safebox -->
        </div> <!-- .l-section-shrink -->
    </div> <!-- .article-container -->

    <div class="section-shadow-bg">
        <img 
            alt="section shadow" 
            class="figure-assets lazy" 
            src="{{ theme:image_url file='upload/placeholder/figure-shadow-placeholder.png' }}" 
            data-original="{{ theme:image_url file='upload/figure/figure-shadow-320w.png' }}" 
            data-src-original="{{ theme:image_url file='upload/figure/figure-shadow-320w.png' }} 320w, 
            {{ theme:image_url file='upload/figure/figure-shadow-640w.png' }} 640w, 
            {{ theme:image_url file='upload/figure/figure-shadow-960w.png' }} 960w,
            {{ theme:image_url file='upload/figure/figure-shadow-1440w.png' }} 1440w"
        />
    </div> <!-- .section-shadow-bg -->
    
</section> <!-- .l-article -->