<?php if(count($data_) > 0) { ?>
<div class="year-category">
    <ul class="year">
        <?php foreach($data_ as $val) { ?>
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