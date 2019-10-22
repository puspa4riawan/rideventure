<?php if($ages) { ?>
<div class="year-category" id="categories-years">
    <ul class="year" id="list-years">
        <?php foreach($ages as $val) { ?>
        <li class="click-years2">
            <input type="checkbox" class="ages-val" style="display: none;" name="ages" id="<?php echo $val->categories_id;?>" value="<?php echo $val->categories_id;?>" <?php if(isset($id_ages) && in_array($val->categories_id, $id_ages)) { echo 'checked="checked"';}?>>
            <a href="javascript:void(0);" class="link-years2 <?php if(isset($id_ages) && in_array($val->categories_id, $id_ages)) { echo 'active';}?>">
                <i class="baby-year">
                    <?php
                        echo '<img class="baby1" src="'.site_url($val->full_path).'">';
                        echo '<img class="baby2" src="'.site_url($val->img_hover_fullpath).'">';
                    ?>   
                </i>
                <div class="age">
                    <span class="age-num"><?php echo $val->ages_angka;?></span><br><span><?php echo $val->ages_title;?></span>
                </div>
            </a>
        </li>
        <?php } ?>
        <div class="clear"></div>
    </ul>
    <div class="clear"></div>
</div>
<?php } ?>

<?php if($cats) { ?>
<div class="article-category">
    <ul class="category-list" id="list-categories">
        <?php foreach($cats as $val) { ?>
        <li class="click-categories2" style="display: inline-block;">
            <input type="checkbox" class="cats-val" style="display: none;" name="cat" id="<?php echo $val->tags_id;?>" value="<?php echo $val->tags_id;?>" <?php if(isset($id_cats) && in_array($val->tags_id, $id_cats)) { echo 'checked="checked"';}?>>
            <a href="javascript:void(0);" class="link-categories2 <?php if(isset($id_cats) && in_array($val->tags_id, $id_cats)) { echo 'active';}?>">
                <div class="img-cat-wrap">
                    <i>
                        <!-- <a href="<?php //echo SITE_URL().'tips-and-tools-by-cat/'.$val->slug?>"> -->
                        <?php
                            echo '<img class="bulet1" src="'.site_url($val->full_path).'">';
                            echo '<img class="bulet2" src="'.site_url($val->img_hover_fullpath).'">';
                        ?> 
                    </i>
                </div>
                <span><?php echo $val->title; ?></span>
            </a>
        </li>
        <?php } ?>
    </ul>
</div>
<?php } ?>
<?php if($data_) { ?>
<ul class="article-list">
    <?php foreach($data_ as $val) { ?>
    <li>
        <div class="article-list-wrap">
            <div class="picture">
                <?php
                    $src='uploads/dummy.png';
                    if($val->full_path != '') {
                        if(file_exists($val->full_path)){
                            $src=$val->full_path;
                        }
                    }
                ?>
                <img class="article-pict" src="<?php echo site_url($src); ?>" alt="<?php echo $val->slug; ?>" title="<?php echo $val->slug; ?>">
                <img class="gelombang" src="{{ theme:image_url file="gelombang.png" }}">
                <img class="gelombang-mobile" src="{{ theme:image_url file="gelombang-mobile.png" }}">
                <div class="more-wrapper">
                    <div class="btn-read">
                        <a href="<?php echo SITE_URL().'tips-and-tools-detail/'.$val->slug;?>">read more</a>
                    </div>
                    <div class="comment-like">
                            <div class="comment-wrap">
                                <div class="article-comment">
                                    <div class="total">
                                        <p><span><?php echo $val->comment_count; ?></span> comment</p>
                                    </div>
                                    <i class="ico-comment"></i>
                                </div>
                            </div>
                            <div class="like-wrap">
                                <div class="article-like">
                                    <a href=""><i class="ico-like <?php echo ($data_usr) ? 'do-like' : 'do-login'; echo $val->is_liked==1 ? ' liked': '' ; ?>" id='<?php echo $val->article_id; ?>'></i></a>
                                    <div class="total">
                                        <p><span><?php echo $val->like_count; ?></span> like</p>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
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

<script type="text/javascript">
    /*set for click ages and categories */
    var _data_tag = [];
    var _data = [];

    $('.click-years2').click(function(){
        /* umur */
        id = $(this).val();
        $(this).find('.link-years2').toggleClass('active');
        checked = $(this).find('.link-years2').hasClass('active');
        $(this).find('input[type="checkbox"]').prop('checked', checked ? 'checked' : '');

        _data = [];
        $('ul#list-years li.click-years2').each(function(){
            _data.push({id:$(this).find('input[type="checkbox"]').attr('id') ,checked: $(this).find('input[type="checkbox"]').prop('checked')});
         });

        $.ajax({
          type: "POST",
          url: SITE_URL+'article/home/show_landing',
          data: $.extend({data:_data, data_cat:_data_tag},tokens),
          async: false,
          success: function(ret){

                $('ul.article-list').empty();
                $('ul.article-list').append(ret);
                $('.article-list-wrap').matchHeight();
            },
        });
    })

    $('.click-categories2').click(function(){
        id = $(this).val();
        $(this).find('.link-categories2').toggleClass('active');
        checked = $(this).find('.link-categories2').hasClass('active');
        $(this).find('input[type="checkbox"]').prop('checked', checked ? 'checked' : '');

        _data_tag = [];

        $('ul#list-categories li.click-categories2').each(function(){
            _data_tag.push({id:$(this).find('input[type="checkbox"]').attr('id') ,checked: $(this).find('input[type="checkbox"]').prop('checked')});
        });

        $.ajax({
          type: "POST",
          url: SITE_URL+'article/home/show_landing',
          data: $.extend({data:_data, data_cat:_data_tag},tokens),
          async: false,
          success: function(ret){

                $('ul.article-list').empty();
                $('ul.article-list').append(ret);
                $('.article-list-wrap').matchHeight();
            },
        });
    });

    $(document).on('click','.do-like',function(e){
        e.preventDefault();
        var article_id = this.id;
        $.ajax({
            type: "POST",
            url: SITE_URL+'article/home/do_like',
            data: $.extend({'article_id':article_id}, tokens),
            dataType: 'json',
            success: function(ret){
                $('i#'+article_id).parents('.article-like').find('.total p span').html(ret.likes_count);
                (ret.status=='liked') ? $('.ico-like#'+article_id).addClass('liked') : $('.ico-like#'+article_id).removeClass('liked');
            }
        });
    });

    $(document).on('click','.do-login',function(e){
        e.preventDefault();
        $('#popup-register').fadeIn();
    });
</script>
