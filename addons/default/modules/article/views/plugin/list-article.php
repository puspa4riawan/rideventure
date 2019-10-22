<?php if(count($data_) > 0) { ?>
<ul class="article-list">
    <?php foreach($data_ as $val) { ?>
    <li>
        <div class="article-list-wrap">
            <div class="picture">
                <?php if($val->filename != '') { ?>
                    <img class="article-pict" src="<?php echo $val->full_path; ?>" alt="<?php echo $val->slug; ?>" title="<?php echo $val->slug; ?>">
                <?php }else { ?>
                    <img class="article-pict" src="<?php echo SITE_URL().'/uploads/dummy.png'; ?>" alt="<?php echo $val->slug; ?>" title="<?php echo $val->slug; ?>">
                <?php } ?>    
                <img class="gelombang" src="{{ theme:image_url file="gelombang.png" }}">
                <img class="gelombang-mobile" src="{{ theme:image_url file="gelombang-mobile.png" }}">
                <div class="more-wrapper">
                    <div class="btn-read">
                        <a href="<?php echo SITE_URL().'tips-and-tools-detail/'.$val->slug;?>">read more</a>
                    </div>
                    <!-- <div class="comment-like">
                        <div class="comment-wrap">
                            <div class="article-comment">
                                <div class="total">
                                    <p><span>75</span> comment</p>
                                </div>
                                <i class="ico-comment"></i>
                            </div>
                        </div>
                        <div class="like-wrap">
                            <div class="article-like">
                                <i class="ico-like"></i>
                                <div class="total">
                                    <p><span>75</span> like</p>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div> -->
                </div>
            </div>                      
            <div class="article-info">
                <div class="article-info-wrap">
                    <h4 class="title">
                        <a href="<?php echo SITE_URL().'tips-and-tools-detail/'.$val->slug;?>"><?php echo word_limiter(($val->title), 6); ?></a>
                    </h4>
                    <p>
                        <?php echo word_limiter(($val->intro), 9); ?>
                    </p>
                    <div class="detail">
                        <a href="<?php echo SITE_URL().'tips-and-tools-detail/'.$val->slug;?>">read more</a>
                    </div>
                </div>
            </div>
            <a class="click-wholebox" href="<?php echo SITE_URL().'tips-and-tools-detail/'.$val->slug;?>"></a>
        </div>
    </li> 
    <?php } ?>            
    <div class="clear"></div>
</ul>
<div class="clear"></div>
<div class="link-wrapper">
    <a href="{{ url:site uri="tips-and-tools" }}">View all</a>
</div>
<?php } ?>