<div class="tab-pane <?php echo $page_active=='tulis-article' ? 'active' : ''; ?>" id="tulis-artikel" role="tabpanel">
	<section>
		<div class="judul">
			<h3 class="page-subtitle">Tulis Artikel</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid amet voluptas enim tempore quis, dicta voluptatibus quos officiis, porro fuga!</p>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Kategori</label>
			<div class="col-md-9">
				<select name="category_dashboard" id="category-dashboard" class="selectpicker" data-style="btn-white round" data-width="100%" title="Kategori">
					<?php foreach($list_category as $key=>$cat) {?>
					<option value="<?=$cat['id'];?>" data-content="<span class='icon categories-dashboard' data-iconuri='<?=($cat['full_path']) ? base_url($cat['full_path']) : '';?>'></span><span class='text'><?=$cat['title'];?></span>"><?=$cat['title'];?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Subject</label>
			<div class="col-md-9">
				<input type="text" name="title" onkeypress="return textAlphanumeric(event)" class="form-control" placeholder="Tulis judul artikel...">
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Intro</label>
			<div class="col-md-9">
				<textarea class="form-control" onkeypress="return textAlphanumeric(event)" name="intro" rows="10" placeholder="Tulis intro artikel..."></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Tulisan</label>
			<div class="col-md-9">
				<textarea class="form-control" id="description-article" name="description" rows="10" placeholder="Tulis isi artikel..."></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Tipe artikel</label>
			<div class="col-md-9">
				<select name="template" id="atemplate" class="selectpicker" data-style="btn-white round" data-width="100%" title="Konten artikel">
					<?php foreach ($ar_template as $key => $template) { ?>
					<option value="<?=$key;?>"><?=$template;?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Untuk anak usia</label>
			<div class="col-md-9">
				<select  name="kidsage_dashboard" id="kidsage-dashboard" class="selectpicker" data-style="btn-white round" data-width="100%" title="Untuk anak usia">
					<?php foreach($list_kidsage as $key=>$kidsage) {?>
					<option value="<?=$kidsage['id'];?>" data-content="<span class='icon kidsages-dashboard' data-iconuri='<?=($kidsage['full_path']) ? base_url($kidsage['full_path']) : '';?>'></span><span class='text'><?=$kidsage['title'];?></span>"><?=$kidsage['title'];?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Meta Keyword</label>
			<div class="col-md-9">
				<textarea class="form-control" onkeypress="return textAlphanumeric(event)" name="meta_keyword" rows="10" placeholder=""></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Meta Description</label>
			<div class="col-md-9">
				<textarea class="form-control" onkeypress="return textAlphanumeric(event)" name="meta_description" rows="10" placeholder=""></textarea>
			</div>
		</div>
	</section>
	<section id="article-img">
		<div class="judul">
			<h3 class="page-subtitle">Gambar</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
		</div>
		<div class="artikel-images row">

			<div class="tambah col-xs-6 col-md-3 add-article-image">
				<label for="tambah-images" class="fix-ratio" ratio="1:1">
					<span id="upload-img">+</span>
				</label>
			</div>
		</div>
		<form>
			<div class="form-group row">
				<label for="" class="col-md-5 col-form-label hidden-sm-down">Pilih gambar thumbnail</label>
				<div class="col-md-7">
					<select class="selectpicker" name="as_background" data-style="btn-white round" data-width="100%" title="Pilih gambar thumbnail" id="set-thumb">
					</select>
				</div>
			</div>
		</form>
	</section>
	<section id="article-file">
		<div class="judul">
			<h3 class="page-subtitle d-inline-block">Attach file</h3>
			<span class="pull-right">
				<label for="browse-attach" class="btn btn-grey round" id="upload-file">
				  Tambah File PDF
				</label>
			</span>
		</div>
		<div class="row attached-files">
			<div id="file-dash"></div>
		</div>
	</section>
	<section>
		<div class="btns row">
			<div class="col-md-6 hidden-sm-down">
				<a href="#view-artikel" class="btn-link btn btn-grey round">Back</a>
			</div>
			<div class="col-md-6">
				<a href="javascript:void(0);" id="publish-dashboard-article" class="btn btn-red btn-lg round w-100">Publish</a>
			</div>
		</div>
	</section>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#description-article').summernote({
		toolbar: [
		    ['style', ['style','bold', 'italic', 'underline', 'clear']],
		    ['para', ['ul', 'ol']],
		    ['misc', ['codeview','undo','redo']],
		],
		popover: {
			image: [],
			link: [],
			air: []
		}
	});

    $('body').on('change', '#atemplate', function(ev) {
        if(ev.currentTarget.value=='no-image') {
            $('#article-img').hide();
        	$('#article-file').hide();
        } else {
            /*if($('#atemplate').val()=='downloadable') {
	            $('#article-file').show();
	            $('#article-img').hide();
	        } else {
	            $('#article-img').show();
	            $('#article-file').hide();
	        }*/
	        $('#article-img').show();
        	$('#article-file').show();
        }
    });

    $('body').on('click', '.hapus', function(e) {
    	dir 	= e.currentTarget.dataset.dir;
    	row 	= e.currentTarget.dataset.row;
    	filenm 	= e.currentTarget.dataset.filenm;
    	fl 		= e.currentTarget.dataset.fl;
    	$.ajax({
			url: SITE_URL+'delete-article-files-dashboard',
			type: 'post',
			data: $.extend(tokens,{
				   dir:dir,
				   row:row,
				   filenm:filenm,
			}),
			dataType: 'json',
			success: function(json) {
				tmlft();
				if(json['status']==true) {
					$('#'+fl+'-'+row).remove();
				}
			}
		});
    	e.preventDefault();
    });

    $('body').on('click', '#publish-dashboard-article', function(e) {
    	title 					=$("input[name=title]").val();
    	category_dashboard 		=$("select[name=category_dashboard]").val();
    	kidsage_dashboard 		=$("select[name=kidsage_dashboard]").val();
    	intro 					=$("textarea[name=intro]").val();
    	meta_keyword 			=$("textarea[name=meta_keyword]").val();
    	meta_description 		=$("textarea[name=meta_description]").val();
    	description 			=$("textarea[name=description]").val();
    	as_background 			=$("select[name=as_background]").val();
    	template 				=$("select[name=template]").val();

    	fname_file					=$("input[name^='fname_file']").serializeArray();
    	filename_file				=$("input[name^='filename_file']").serializeArray();
    	path_file 					=$("input[name^='path_file']").serializeArray();
    	full_path_file 				=$("input[name^='full_path_file']").serializeArray();
    	filename_img				=$("input[name^='filename_img']").serializeArray();
    	path_img 					=$("input[name^='path_img']").serializeArray();
    	full_path_img 				=$("input[name^='full_path_img']").serializeArray();

    	$.ajax({
			url: SITE_URL+'post-article-dashboard',
			type: 'post',
			data: $.extend(tokens,{
				   title:title,
				   category_dashboard:category_dashboard,
				   kidsage_dashboard:kidsage_dashboard,
				   intro:intro,
				   meta_keyword:meta_keyword,
				   meta_description:meta_description,
				   description:description,
				   filename_img:filename_img,
				   path_img:path_img,
				   full_path_img:full_path_img,
				   fname_file:fname_file,
				   filename_file:filename_file,
				   path_file:path_file,
				   full_path_file:full_path_file,
				   as_background:as_background,
				   template:template,
			}),
			dataType: 'json',
			success: function(json) {
				tmlft();
				if(json['status']==true) {
					$('#ct-ar').html('');
					$('#ct-ar').html(json['ct_ar']);

					$('#set-thumb').html('');
					$('.dimg').each(function(index, el) {
						$(this).remove();
					});
					$('.dfile').each(function(index, el) {
						$(this).remove();
					});
					$('option:selected').prop('selected', false)
					$('select').selectpicker('refresh');

					$('input[type=text], textarea, select').val('');
					$('#description-article').summernote('reset');

					$('#puGlobal .modal-title').html('Terima kasih sudah berbagi cerita!');
					$('#puGlobal .modal-body').html('Artikel Anda telah diterima. Namun, kami akan melakukan proses moderasi terlebih dulu sebelum memuat artikel tersebut.');
					$('#puGlobal').modal();
				} else {
					$('#puGlobal .modal-title').html('Gagal');
					$('#puGlobal .modal-body').html('Artikel dengan judul '+json['ttl']+' sudah ada. Terima Kasih.');
					$('#puGlobal').modal();
				}
			}
		});
    	e.preventDefault();
    });

    $('body').on('click', '.rename', function(e) {
    	el_row_edit =  e.currentTarget.dataset.row;

    	if($('#dtail-'+el_row_edit).hasClass('edit')==false) {
	    	$('#dtail-'+el_row_edit).addClass('edit');
	    	$('#file-nm-'+el_row_edit).show();
	    	$('#ext-'+el_row_edit).hide();
	    	$('#filename-'+el_row_edit).hide();
	    } else {
	    	$('#dtail-'+el_row_edit).removeClass('edit')
	    	$('#ext-'+el_row_edit).show();
	    	$('#filename-'+el_row_edit).show();
	    	$('#file-nm-'+el_row_edit).hide();
	    }

	    $('body').on('keyup', '.nm-file', function(e) {
	    	fname = $(this).val();
	    	$('#filename-'+el_row_edit).text(fname);
	    	$('#fname-'+el_row_edit).val(fname);
	    });
    	e.preventDefault();
    });
});

window.onload = function() {
	var btn_img 	= document.getElementById('upload-img');
	var btn_file 	= document.getElementById('upload-file');

	var uploader = new ss.SimpleUpload({
		button: btn_img,
		url: SITE_URL+'submit-article-img-dashboard',
		name: 'uploadfile',
		multipart: true,
		responseType: 'json',
		data:tokens,
		noParams: true,
		allowedExtensions: ['jpg', 'jpeg', 'png'],
	 	onComplete: function(filename, response) {
        	if(response['success']==true) {
        		$(response['html']).insertBefore('.add-article-image');
        		$('#set-thumb').append(response['set_bg']).selectpicker('refresh');

        		setTimeout(function(){
					fixRatio();
				},250);
        	}
	 	},
	  	endXHR: function(filename, response) {
        	// console.log(filename);
        	// console.log(response);
      	},
	});

	var uploader_file = new ss.SimpleUpload({
		button: btn_file,
		url: SITE_URL+'submit-article-file-dashboard',
		name: 'uploadfile',
		multipart: true,
		responseType: 'json',
		data:tokens,
		noParams: true,
		allowedExtensions: ['pdf'],
	 	onComplete: function(filename, response) {
        	if(response['success']==true) {
        		$(response['html']).insertBefore('#file-dash');
        	}
	 	},
	  	endXHR: function(filename, response) {
        	// console.log(filename);
        	// console.log(response);
      	},
	});

	if($('#atemplate').val()=='no-image') {
        $('#article-img').hide();
        $('#article-file').hide();
    } else {
        /*if($('#atemplate').val()=='downloadable') {
            $('#article-file').show();
            $('#article-img').hide();
        } else {
            $('#article-img').show();
            $('#article-file').hide();
        }*/
        $('#article-img').show();
        $('#article-file').show();
    }
};
</script>
