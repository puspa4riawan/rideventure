<section class="title">
<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('destinations:add') ?></h4>
<?php else: ?>
	<h4><?php echo sprintf(lang('destinations:update'), $data_->title) ?></h4>
<?php endif ?>
</section>

<section class="item">
    <div class="content">
        <h1 id="h1"></h1>
        <?php
            $gallery_section = $this->uri->segment(3);
            echo form_open_multipart()
        ?>

        <div class="form_inputs" id="article-main-tab">
   	        <fieldset>
		        <ul>
                    
    				<li>
    					<label for="title"><?php echo lang('destinations:label_title') ?> <span>*</span></label>
    					<div class="input">
    						<input type="text" id="title" name="title" size="80" value="<?php echo set_value('title', isset($data_->title) ? $data_->title : ''); ?>" />
                            <br>
                            <?php if($this->method=='edit') { ?>
                                <a href="javascript:void(0);" title="Set title as slug" class="btn green" id="set-title-slug" >Set title as slug</a>
                            <?php } ?>
    					</div>
    				</li>
    				<li>
    					<label for="slug">Slug <span>*</span></label>
    					<div class="input">
    						<input type="text" id="slug" name="slug" size="80" value="<?php echo set_value('slug', isset($data_->slug) ? $data_->slug : ''); ?>"/>
    					</div>
    				</li>
                    
                    
                    <li class="editor">
                        <label for="description"><?php echo lang('general:desc_label') ?> </label><br>
                        <div class="edit-content">
                            <?php echo form_textarea(array('id' => 'description', 'name' => 'description', 'rows' => 30, 'value' => isset($data_->description) ? $data_->description : '','class' => 'wysiwyg-advanced')); ?>
                        </div><br />
                    </li>
                    
                    <li class="editor" id="thumb">
                        <label for="map_desc" class="labelf">Thumbnail</label>
                        <div class="edit-content">
                            <?php
                                $prev = base_url('uploads/default/files/no-available-image.png');
                                if($data_->full_path != ''){
                                    $prev = base_url($data_->path.'/'.$data_->filename);
                                }
                                echo '<input type="file" name="thumb" class="thumb" id="thumb"/><br />';
                                echo '<img class="preview-thumb" src="'.$prev.'" width="250" id="preview-thumb"><br />';
                                echo '<img class="cek-thumb" src="" style="display:none;" id="cek-thumb"><br />';
                            ?>
                        </div>
                    </li>
                    
                    
                    
                    <li class="editor">
                        <label for="meta_title">Meta Title </label><br>
                        <div class="edit-content">
                            <?php echo form_textarea(array('id' => 'meta_title', 'name' => 'meta_title', 'rows' => 3, 'value' => isset($data_->meta_title) ? $data_->meta_title : '','class' => '')); ?>
                        </div><br />
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
                        <label for="status"><?php echo lang('general:status_label') ?></label>
                        <div class="input"><?php echo form_dropdown('status', array('draft' => lang('general:draft_label'), 'live' => lang('general:live_label')), $data_->status) ?></div>
                    </li>
                   
		        </ul>
	        </fieldset>
        </div>

        <div class="buttons">
	       <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))) ?>
        </div>

        <?php echo form_close() ?>
    </div>
</section>
<script type="text/javascript">
var uri_delete_info = '<?=ADMIN_URL."/article/delete_arinfo";?>';
var current_method = '<?=$this->method;?>';
var slugarticle = function(str) {
    str = str.replace(/^\s+|\s+$/g, '');
    str = str.toLowerCase();

    var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
    var to   = "aaaaaeeeeeiiiiooooouuuunc------";
    for (var i=0, l=from.length ; i<l ; i++) {
    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '')
    .replace(/\s+/g, '-')
    .replace(/-+/g, '-');

    return str;
};

$(document).ready(function(){
    // generate a slug when the user types a title in
    if (current_method=='create') {
        max.generate_slug('input[name="title"]', 'input[name="slug"]');
    }

    $('body').on('click', '#set-title-slug', function(e) {
        $('#slug').val(slugarticle($('#title').val()));
    });

    $('body').on('change', '#atemplate', function(ev) {
        if(ev.currentTarget.value=='no-image') {
            $('#info-image').hide();
            // $('#info-file').hide();
            // $('#bg-color').show();
        } else {
            /*if($('#atemplate').val()=='downloadable') {
                $('#file-span').text("File");
                $('.labelf').text("File");
                $('.arfilenm').show();
            } else {
                $('#file-span').text("Image");
                $('.labelf').text("Image");
                $('.arfilenm').hide();
            }*/
            $('#info-image').show();
            // $('#info-file').show();
            // $('#bg-color').hide();
        }
    });

    $('body').on('change', '#content_format', function(ev) {
        switch (ev.currentTarget.value) {
            case 'carousel':
                $('#info-image').show();
                $('#info-video').hide();
                $('.default-info-img').show();
                $('.not-default').show();
                break;
            case 'banner':
                $('#info-image').show();
                $('#info-video').hide();
                $('.default-info-img').show();
                $('.not-default').hide();
                break;
            case 'youtube':
                $('#info-image').hide();
                $('#info-video').show();
                $('#article-youtube-fieldset').show();
                $('#article-video-fieldset').hide();
                break;
            case 'video':
                $('#info-image').hide();
                $('#info-video').show();
                $('#article-youtube-fieldset').hide();
                $('#article-video-fieldset').show();
                break;
            default:
                $('#info-image').hide();
                $('#info-video').hide();
                $('.default-info-img').show();
                $('.not-default').show();
                break;
        }
    });

    $('body').on('change', '.as_background', function(e) {
        if (e.currentTarget.value=='1') {
            $('.as_background').val('0');
            $('.as_background option').removeAttr('selected');
            $('.as_background option').prop('selected', false );
            $(this).val('1');
        }
    });

    $('#add-img-info').click(function(e) {
        row=parseInt($('#add-img-info').attr('data-row'));
        html='';
        prev = '<?=base_url('uploads/default/files/no-available-image.png');?>';
        /*if($('#atemplate').val()=='downloadable') {
            labelf = 'Files';
        } else {
            labelf = 'Image';
        }*/
        labelf = 'Image';

        if ($('#content_format').val() == 'banner' && row > 0) {
            alert('Banner type can only upload one image');
            return false;
        }

        html += '<fieldset class="info-img-fieldset" id="info-img-'+row+'">'+
                '<ul>'+
                    '<input type="hidden" name="article_img_id['+row+']" value="" />'+
                    '<input type="hidden" name="article_img_path['+row+']" value="" />'+
                    /*'<li class="editor arfilenm"> '+
                        '<label for="map_desc">'+labelf+'</label> '+
                        '<div class="edit-content">'+
                                '<input type="text" name="fname['+row+']" class="arfnm" id="arfnm'+row+'">'+
                        '</div>'+
                    '</li>'+*/
                    '<li class="editor"> '+
                        '<label for="map_desc" class="labelf">'+labelf+'</label> '+
                        '<div class="edit-content">'+
                                '<input type="file" name="arimg['+row+']" class="arimg" /><br />'+
                                '<img class="preview-arimg" src="'+prev+'" width="250" id="preview-arimg'+row+'"><br />'+
                                '<img class="cek-arimg" src="" style="display:none;" id="cek-arimg'+row+'"><br />'+
                        '</div>'+
                    '</li>'+
                    '<select name="as_background['+row+']" id="as_background'+row+'" class="as_background">'+
                        '<option value="0">No</option>'+
                        '<option value="1">Yes</option>'+
                    '</select>'+
                '</ul>'+
                '<a href="javascript:void(0);" title="Delete Row" class="btn orange delete-info-img" id="delete-info-img'+row+'" data-row="'+row+'">Delete Row</a>'+
            '</fieldset>';
        $( html ).insertBefore( $('#add-img-info') );
        row=row+1;
        $('#add-img-info').attr('data-row',row);

        /*if($('#atemplate').val()=='downloadable') {
            $('.arfilenm').show();
        } else {
            $('.arfilenm').hide();
        }*/
    });

    $('#add-file-info').click(function(e) {
        row=parseInt($('#add-file-info').attr('data-row'));
        html='';
        labelf = 'File';

        html += '<fieldset class="info-file-fieldset" id="info-file-'+row+'">'+
                '<ul>'+
                    '<input type="hidden" name="article_file_id['+row+']" value="" />'+
                    '<input type="hidden" name="article_file_path['+row+']" value="" />'+
                    '<li class="editor arfilenm"> '+
                        '<label for="map_desc">'+labelf+'</label> '+
                        '<div class="edit-content">'+
                                '<input type="text" name="fname['+row+']" class="arfnm" id="arfnm'+row+'">'+
                        '</div>'+
                    '</li>'+
                    '<li class="editor"> '+
                        '<label for="map_desc" class="labelf">'+labelf+'</label> '+
                        '<div class="edit-content">'+
                                '<input type="file" name="arfile['+row+']" class="arfile" /><br />'+
                        '</div>'+
                    '</li>'+
                '</ul>'+
                '<a href="javascript:void(0);" title="Delete Row" class="btn orange delete-info-file" id="delete-info-file'+row+'" data-row="'+row+'">Delete Row</a>'+
            '</fieldset>';
        $( html ).insertBefore( $('#add-file-info') );
        row=row+1;
        $('#add-file-info').attr('data-row',row);

        /*if($('#atemplate').val()=='downloadable') {
            $('.arfilenm').show();
        } else {
            $('.arfilenm').hide();
        }*/
    });

    $('body').on('change', '.thumb', function(e){
        var idx = $( ".thumb" ).index( $(this) );
        var img_preview = $(this).val();
        readURL(this, idx, '.preview-thumb', '.cek-thumb');
    });

    $('body').on('change', '.arimg', function(e){
        var idx = $( ".arimg" ).index( $(this) );
        var img_preview = $(this).val();
        readURL(this, idx, '.preview-arimg', '.cek-arimg');
    });

    $('body').on('click', '.delete-info-file', function(e) {
        id_article = $(this).attr('data-articleid');
        id_data = $(this).attr('data-infoid');
        id_el = $(this).attr('data-row');

        if (id_data != undefined) {
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: uri_delete_info,
                    type: 'post',
                    data: $.extend(tokens,{
                           id_article:id_article,
                           id_data:id_data,
                    }),
                    dataType: 'json',
                    success: function(json) {
                        if (json['status']==true) {
                            $('#info-file-'+id_el).remove();
                            $('#add-img-info').attr('data-row', id_el);
                        }
                    }
                });
            }
        } else {
            $('#info-file-'+id_el).remove();
            $('#add-img-info').attr('data-row', id_el);
        }

    });

    $('body').on('click', '.delete-info-img', function(e) {
        id_article = $(this).attr('data-articleid');
        id_data = $(this).attr('data-infoid');
        id_el = $(this).attr('data-row');

        if (id_data != undefined) {
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: uri_delete_info,
                    type: 'post',
                    data: $.extend(tokens,{
                           id_article:id_article,
                           id_data:id_data,
                    }),
                    dataType: 'json',
                    success: function(json) {
                        if (json['status']==true) {
                            $('#info-img-'+id_el).remove();
                            $('#add-img-info').attr('data-row', id_el);
                        }
                    }
                });
            }
        } else {
            $('#info-img-'+id_el).remove();
            $('#add-img-info').attr('data-row', id_el);
        }

    });

    $('#input-tags').selectize({
        persist: false,
        createOnBlur: true,
        create: true
    });
});

$(window).load(function() {
    if($('#atemplate').val()=='no-image') {
        $('#info-image').hide();
        // $('#info-file').hide();
        // $('#bg-color').show();
    } else {
        /*if($('#atemplate').val()=='downloadable') {
            $('#file-span').text("File");
            $('.labelf').text("File");
            $('.arfilenm').show();
        } else {
            $('#file-span').text("Image");
            $('.labelf').text("Image");
            $('.arfilenm').hide();
        }*/
        $('#info-image').show();
        // $('#info-file').show();
        // $('#bg-color').hide();
    }

    switch ($('#content_format').val()) {
        case 'carousel':
            $('#info-image').show();
            $('#info-video').hide();
            $('.default-info-img').show();
            $('.not-default').show();
            break;
        case 'banner':
            $('#info-image').show();
            $('#info-video').hide();
            $('.default-info-img').show();
            $('.not-default').hide();
            break;
        case 'youtube':
            $('#info-image').hide();
            $('#info-video').show();
            $('#article-youtube-fieldset').show();
            $('#article-video-fieldset').hide();
            break;
        case 'video':
            $('#info-image').hide();
            $('#info-video').show();
            $('#article-youtube-fieldset').hide();
            $('#article-video-fieldset').show();
            break;
        default:
            $('#info-image').hide();
            $('#info-video').hide();
            $('.default-info-img').show();
            $('.not-default').show();
            break;
    }
});

function readURL(input, idx, preview_t, cek_t) {
    var $prev = $(preview_t).eq(idx);
    var $cek = $(cek_t).eq(idx);
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        var img = '';
        reader.onload = function (e) {
            $cek.attr('src', e.target.result);

            $cek.unbind("load");
            $cek.bind("load", function () {
                var w_img = this.width;
                var h_img = this.height;

                var max_w = 1200;
                var max_h = 1200;

                if((w_img <= max_w) && (h_img <= max_h)){
                    id=$($prev).attr('id');
                    console.log(id);
                    $('#'+id).attr('src', e.target.result);
                    $('#'+id).show();
                }else{
                    $('.image').eq(idx).val('');
                    alert('Invalid !! \n\n Image format :\n - Width = '+max_w+'\n - Height = '+max_h);
                }

            });
        }

        reader.readAsDataURL(input.files[0]);

    } else {
        $prev.hide();
    }
}
</script>

<script type="text/javascript">
    

    $('#description').ckeditor({
        toolbar: [
            ['Maximize'],
            //['maximages', 'maxfiles'],
            //['Image'],
            ['maximagecustom'],
            ['Cut','Copy','Paste','PasteFromWord'],
            ['Undo','Redo','-','Find','Replace'],
            ['Link','Unlink'],
            ['Table','HorizontalRule','SpecialChar'],
            ['Bold','Italic','StrikeThrough'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl'],
            ['Format', 'FontSize', 'Subscript','Superscript', 'NumberedList','BulletedList','Outdent','Indent','Blockquote'],
            ['ShowBlocks', 'RemoveFormat', 'Source'],
            ['maxpreviewarticle']
        ],
        //removeDialogTabs: 'image:Upload',
        extraPlugins: 'maximages,maxfiles,maxpreviewarticle,maximagecustom',
        width: '99%',
        height: 400,
        dialog_backgroundCoverColor: '#000',
        removePlugins: 'elementspath',
        filebrowserBrowseUrl: SITE_URL + 'system/cms/themes/maxcms/js/ckeditor/plugins' + '/kcfinder/browse.php?opener=ckeditor&type=files',
        filebrowserImageBrowseUrl: SITE_URL + 'system/cms/themes/maxcms/js/ckeditor/plugins' + '/kcfinder/browse.php?opener=ckeditor&type=images',
        filebrowserFlashBrowseUrl: SITE_URL + 'system/cms/themes/maxcms/js/ckeditor/plugins' + '/kcfinder/browse.php?opener=ckeditor&type=flash',
    });

    
    var featuredWrapperElement = $('#featuredWrapper');
    var featuredOrderWrapperElement = $('#khOrderWrapper');
    var featuredElement = $('#featured_kecil_hebat');
    var featuredOrderElement = $('#featured_kecil_hebat_order');

    $('#kecilhebat_section_id').change(function(e){        
        featuredElement.val('no');
        featuredOrderElement.val('');
        var value = $(this).val();
        if(value){
            featuredWrapperElement.show();
        }else{
            featuredWrapperElement.hide();
            featuredOrderWrapperElement.hide();
        }
    });

    $('#featured_kecil_hebat').change(function(e){
        var val = $(this).val();
        featuredOrderElement.val('');
        if(val == 'yes'){
            featuredOrderWrapperElement.show();
        }else{
            featuredOrderWrapperElement.hide();
        }
    });
        
</script>
