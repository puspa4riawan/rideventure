<?php if(count($data_) > 0) { ?>
<div class="article-category">
    <ul class="category-list">
        <?php foreach($data_ as $val) { ?>
        <li>
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

<script type="text/javascript">
    $('.single-cat').click(function(){
        
         $(this).find('.single-cat').toggleClass('active');
        // $.ajax({
        //   type: "POST",
        //   url: SITE_URL+'article/home/load_more_home',
        //   data: $.extend(tokens,{last_id:last_id}),
        //   success: function(ret){
                
        //         $('#article-wrap').append(ret)
        //         //$('#article-wrap').append($(ret)).masonry('appended', $(ret), true);
                
        //         var tes = parseInt(last_id) + 8;
        //         last_id = tes;
                
        //     },
        // });
    })
</script>
<?php } ?>