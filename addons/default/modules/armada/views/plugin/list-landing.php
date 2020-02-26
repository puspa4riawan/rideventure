<?php if(count($ages) > 0) { ?>
<div class="year-category">
    <ul class="year">
        <?php foreach($ages as $val) { ?>
        <li class="click-chk">
            <input type="checkbox" class="ages-val" style="display: none;" name="ages" id="<?php echo $val->categories_id;?>" value="<?php echo $val->categories_id;?>">
            <a href="javascript:void(0);" class="single-year">
                <i class="baby-year">
                    <!-- <a href="<?php //echo SITE_URL().'tips-and-tools-by-ages/'.$val->slug?>"> -->
                    <?php 
                        if($val->filename != '') {

                            $src = base_url($val->full_path);
                        }else {

                            $src = base_url('upload/dummy.png');
                        }  
                    ?>
                    <img class="baby1" src="<?php echo $src;?>" alt="<?php echo $val->slug;?>" title="<?php echo $val->slug;?>">

                    <?php 
                        if($val->img_hover != '') {

                            $src2 = base_url($val->img_hover_fullpath);
                        }else {

                            $src2 = base_url('upload/dummy.png');
                        }  
                    ?>
                    <img class="baby2" src="<?php echo $src2; ?>" alt="<?php echo $val->slug;?>" title="<?php echo $val->slug;?>">
                    <!-- </a> -->
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

<?php if(count($cats) > 0) { ?>
<div class="article-category">
    <ul class="category-list">
        <?php foreach($cats as $val) { ?>
        <li class="click-cats" style="display: inline-block;">
            <input type="checkbox" class="cats-val" style="display: none;" name="cat" id="<?php echo $val->tags_id;?>" value="<?php echo $val->tags_id;?>">
            <a href="javascript:void(0);" class="single-cat">
                <div class="img-cat-wrap">
                    <i>
                        <!-- <a href="<?php //echo SITE_URL().'tips-and-tools-by-cat/'.$val->slug?>"> -->
                        <?php 
                            if($val->filename != '') {

                                $src = base_url($val->full_path);
                            }else {

                                $src = base_url('upload/dummy.png');
                            }  
                        ?>
                        <img class="bulet1" src="<?php echo $src;?>" alt="<?php echo $val->slug;?>" title="<?php echo $val->slug;?>">

                        <?php 
                            if($val->img_hover != '') {

                                $src2 = base_url($val->img_hover_fullpath);
                            }else {

                                $src2 = base_url('upload/dummy.png');
                            }  
                        ?>
                        <img class="bulet2" src="<?php echo $src2; ?>" alt="<?php echo $val->slug;?>" title="<?php echo $val->slug;?>">
                        <!-- </a> -->
                    </i>
                </div>
                <span><?php echo $val->title; ?></span>
            </a>
        </li>
        <?php } ?>
    </ul>
</div>
<?php } ?>

<script type="text/javascript">
    
    var _data_tag = [];
    var _data = [];

    $('.click-chk').click(function(){
        /* umur */
        id = $(this).val();
        $(this).find('.single-year').toggleClass('active');
        checked = $(this).find('.single-year').hasClass('active');
        $(this).find('input[type="checkbox"]').prop('checked', checked ? 'checked' : '');
        
        _data = [];
        //_test = {}
        $('ul.year li').each(function(){
            _data.push({id:$(this).find('input[type="checkbox"]').attr('id') ,checked: $(this).find('input[type="checkbox"]').prop('checked')});
            //_data[$(this).find('input[type="checkbox"]').attr('id')] = $(this).find('input[type="checkbox"]').prop('checked');
        })

       
        console.log(_data)
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

    $('.click-cats').click(function(){
        id = $(this).val();
        $(this).find('.single-cat').toggleClass('active');
        checked = $(this).find('.single-cat').hasClass('active');
        $(this).find('input[type="checkbox"]').prop('checked', checked ? 'checked' : '');
        
        _data_tag = [];
        //_test = {}
        $('ul.category-list li').each(function(){
            _data_tag.push({id:$(this).find('input[type="checkbox"]').attr('id') ,checked: $(this).find('input[type="checkbox"]').prop('checked')});
            //_data[$(this).find('input[type="checkbox"]').attr('id')] = $(this).find('input[type="checkbox"]').prop('checked');
        })
        //console.log(_data)
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
</script>