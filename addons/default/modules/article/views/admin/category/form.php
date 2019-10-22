<section class="title">
<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('categories:add') ?></h4>
<?php else: ?>
	<h4><?php echo sprintf(lang('categories:update'), $data_->title) ?></h4>
<?php endif ?>
</section>

<section class="item">
    <div class="content">
        <h1 id="h1"></h1>
        <?php
            $gallery_section = $this->uri->segment(3);
            echo form_open_multipart()
        ?>
        <div class="tabs">
	       <div class="form_inputs" id="dago_gallery-content-tab">
	   	        <fieldset>
			        <ul>
        				<li>
        					<label for="title"><?php echo lang('categories:label_title') ?> <span>*</span></label>
        					<div class="input">
        						<input type="text" id="title" name="title" size="80" value="<?php echo set_value('title', isset($data_->title) ? $data_->title : ''); ?>" />
        					</div>
        				</li>
        				<li>
        					<label for="slug">Slug <span>*</span></label>
        					<div class="input">
        						<input type="text" id="slug" name="slug" size="80" value="<?php echo set_value('slug', isset($data_->slug) ? $data_->slug : ''); ?>" readonly/>
        					</div>
        				</li>
                        <li>
                            <label for="kidsage_id"><?php echo lang('kidsage:title') ?></label>
                            <br />
                            <div class="input">
                                <select multiple="multiple" name="kidsage_id[]">
                                    <?php
                                        if(count($list_kidsage) > 0 ){
                                            foreach($list_kidsage as $key => $value){
                                                $selected = '';

                                                $data_->kidsage_id = trim($data_->kidsage_id, ",");
                                                if(strpos($data_->kidsage_id, ",")){
                                                    $selected_kidsage = explode(",", $data_->kidsage_id);
                                                    foreach ($selected_kidsage as $key_tag => $value_tag) {

                                                        if($value_tag == $value['id']){

                                                            $selected = 'selected="selected"';
                                                        }
                                                    }
                                                } else{
                                                    if($data_->kidsage_id == $value['id']){

                                                        $selected = 'selected="selected"';
                                                    }
                                                }
                                                echo '<option value="'.$value['id'].'" '.$selected.'>'.$value['title'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label for="status"><?php echo lang('categories:icon'); ?> <span>*</span></label>
                            <div class="input picture-sel">
                            <?php
                                $prev = base_url('uploads/default/files/no-available-image.png');
                                if($data_->filename!=''){
                                    $prev = base_url($data_->full_path);
                                }
                                echo '<input type="file" name="icon" class="icon" /><br />';
                                echo '<img class="preview-icon" src="'.$prev.'" width="250px"><br />';
                                echo '<img class="cek-icon" src="" style="display:none;"><br />';
                            ?>
                            </div>
                        </li>
                        <li>
        					<label for="status"><?php echo lang('general:status_label') ?></label>
        					<div class="input"><?php echo form_dropdown('status', array('draft' => lang('general:draft_label'), 'live' => lang('general:live_label')), $data_->status) ?></div>
        				</li>
                        <li class="editor">
                            <label for="meta_keyword"><?php echo lang('general:meta_keyword') ?> </label><br>
                            <div class="edit-content">
                                <?php echo form_textarea(array('id' => 'meta_keyword', 'name' => 'meta_keyword', 'rows' => 3, 'value' => isset($data_->meta_keyword) ? $data_->meta_keyword : '','class' => '')); ?>
                            </div><br />
                        </li>
                        <li class="editor">
                            <label for="meta_desc"><?php echo lang('general:meta_desc') ?> </label><br>
                            <div class="edit-content">
                                <?php echo form_textarea(array('id' => 'meta_desc', 'name' => 'meta_desc', 'rows' => 5, 'value' => isset($data_->meta_desc) ? $data_->meta_desc : '','class' => '')); ?>
                            </div><br />
                        </li>
                        <li>
                            <label for="order"><?php echo lang('kidsage:order') ?></label>
                           <div class="input">
                                <input type="text" id="order" name="order" size="12" value="<?php echo set_value('order', isset($data_->order) ? $data_->order : ''); ?>" />
                            </div>
                        </li>
			        </ul>
		        </fieldset>
	       </div>
        </div>
        <div class="buttons">
	       <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))) ?>
        </div>

        <?php echo form_close() ?>

    </div>
</section>
<script type="text/javascript">
$(document).ready(function(){
   $('body').on('change', '.icon', function(){
        var idx = $( ".icon" ).index( $(this) );
        var img_preview = $(this).val();
        readURL(this, idx, '.preview-icon', '.cek-icon', 'icon');
    });
});

function readURL(input, idx, preview_t, cek_t, thumb) {
        var $prev = $(preview_t).eq(idx);
        var $cek = $(cek_t).eq(idx);
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            var img = '';
            reader.onload = function (e) {
                //$prev.attr('src', e.target.result);
                $cek.attr('src', e.target.result);

                $cek.unbind("load");
                $cek.bind("load", function () {
                    // Get image sizes
                    var w_img = this.width;
                    var h_img = this.height;

                    //$prev.attr('src', e.target.result);
                    //$prev.show();

                    // var max_w = 600;
                    // var max_h = 220;
                    // if(thumb=='bgimage' || thumb=='ctimage'){
                    //  max_w = 1200;
                    //  max_h = 1200;
                    // }

                    // if((w_img <= max_w) && (h_img <= max_h)){
                        $prev.attr('src', e.target.result);
                        $prev.show();
                    // }else{
                        // $('.'+thumb+'-pic').eq(idx).val('');
                        // alert('Image tidak valid !! \n\n Format Valid :\n - Width = '+max_w+'\n - Height = '+max_h);
                    // }

                });
            }

            reader.readAsDataURL(input.files[0]);

        } else {
            $prev.hide(); // this hides it when the input is cleared
        }
    }
</script>