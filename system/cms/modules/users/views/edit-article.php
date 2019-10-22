<div class="tab-pane <?php echo $page_active=='edit-article' ? 'active' : ''; ?>" id="edit-artikel" role="tabpanel">
	<?php if (!empty($edit_article)) { ?>
	<section>
		<div class="judul">
			<h3 class="page-subtitle">Edit Artikel</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid amet voluptas enim tempore quis, dicta voluptatibus quos officiis, porro fuga!</p>
		</div>
		<input type="hidden" name="ar_id" value="<?=$edit_article->article_id;?>" id="arid">
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Kategori</label>
			<div class="col-md-9">
				<select name="category_dashboard_edit" id="category-dashboard" class="selectpicker" data-style="btn-white round" data-width="100%" title="Kategori">
					<?php
					foreach($list_category as $key=>$cat) {
						if (in_array($cat['id'], explode(',',$edit_article->categories_id))) {
					?>
					<option selected="selected" value="<?=$cat['id'];?>" data-content="<span class='icon categories-dashboard' data-iconuri='<?=($cat['full_path']) ? base_url($cat['full_path']) : '';?>'></span><span class='text'><?=$cat['title'];?></span>"><?=$cat['title'];?></option>
					<?php } else { ?>
					<option value="<?=$cat['id'];?>" data-content="<span class='icon categories-dashboard' data-iconuri='<?=($cat['full_path']) ? base_url($cat['full_path']) : '';?>'></span><span class='text'><?=$cat['title'];?></span>"><?=$cat['title'];?></option>
					<?php }
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Subject</label>
			<div class="col-md-9">
				<input type="text" name="title_edit" onkeypress="return textAlphanumeric(event)" class="form-control" value="<?=$edit_article->title;?>" placeholder="Tulis judul artikel...">
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Intro</label>
			<div class="col-md-9">
				<textarea class="form-control" onkeypress="return textAlphanumeric(event)" name="intro_edit" rows="10" placeholder="Tulis intro artikel..."><?=$edit_article->intro;?></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Tulisan</label>
			<div class="col-md-9">
				<textarea class="form-control" id="description-edit-article" name="description_edit" rows="10" placeholder="Tulis isi artikel..."><?=$edit_article->description;?></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Tipe artikel</label>
			<div class="col-md-9">
				<select name="template_edit" id="atemplate-edit" class="selectpicker" data-style="btn-white round" data-width="100%" title="Konten artikel">
					<?php
					foreach ($ar_template as $key => $template) {
						if($edit_article->template==$key) {
					?>
					<option value="<?=$key;?>" selected="selected"><?=$template;?></option>
					<?php } else { ?>
					<option value="<?=$key;?>"><?=$template;?></option>
					<?php }
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Untuk anak usia</label>
			<div class="col-md-9">
				<select  name="kidsage_dashboard_edit" id="kidsage-dashboard" class="selectpicker" data-style="btn-white round" data-width="100%" title="Untuk anak usia">
					<?php
					foreach($list_kidsage as $key=>$kidsage) {
						if (in_array($kidsage['id'], explode(',',$edit_article->kidsage_id))) {
					?>
						<option selected="selected" value="<?=$kidsage['id'];?>" data-content="<span class='icon kidsages-dashboard' data-iconuri='<?=($kidsage['full_path']) ? base_url($kidsage['full_path']) : '';?>'></span><span class='text'><?=$kidsage['title'];?></span>"><?=$kidsage['title'];?></option>
					<?php } else { ?>
						<option value="<?=$kidsage['id'];?>" data-content="<span class='icon kidsages-dashboard' data-iconuri='<?=($kidsage['full_path']) ? base_url($kidsage['full_path']) : '';?>'></span><span class='text'><?=$kidsage['title'];?></span>"><?=$kidsage['title'];?></option>
					<?php }
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Meta Keyword</label>
			<div class="col-md-9">
				<textarea class="form-control" onkeypress="return textAlphanumeric(event)" name="meta_tag_edit" rows="10" placeholder=""><?=$edit_article->meta_keyword;?></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-md-3 col-form-label hidden-sm-down">Meta Description</label>
			<div class="col-md-9">
				<textarea class="form-control" onkeypress="return textAlphanumeric(event)" name="meta_description_edit" rows="10" placeholder=""><?=$edit_article->meta_desc;?></textarea>
			</div>
		</div>
	</section>
	<section id="article-edit-img">
		<div class="judul">
			<h3 class="page-subtitle">Gambar</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
		</div>
		<div class="artikel-images row">
			<?php foreach($edit_ar_imgs as $img) {?>
			<div class="item col-xs-6 col-md-3 dimg" id="dimg-<?=$img->imges_id;?>">
				<div class="fix-ratio" ratio="1:1">
					<img src="<?=base_url($img->full_path);?>" alt="">
					<div class="detail">
						<a href="javascript:void(0);" class="hapus-edit" data-fl="dimg" data-row="<?=$img->imges_id;?>" data-dir="<?=$img->path;?>" data-filenm="<?=$img->filename;?>" data-fled="<?=$img->imges_id;?>"><i class="fa fa-fw fa-times"></i></a>
						<div class="filename"><?=$img->filename;?></div>
						<input type="hidden" name="id_img_edit[<?=$img->imges_id;?>]" value="<?=$img->imges_id;?>">
						<input type="hidden" name="filename_img_edit[<?=$img->imges_id;?>]" value="<?=$img->filename;?>">
						<input type="hidden" name="path_img_edit[<?=$img->imges_id;?>]" value="<?=$img->path;?>">
						<input type="hidden" name="full_path_img_edit[<?=$img->imges_id;?>]" value="<?=$img->full_path;?>">
					</div>
				</div>
			</div>
			<?php } ?>

			<div class="tambah col-xs-6 col-md-3 add-edit-article-image">
				<label for="tambah-images" class="fix-ratio" ratio="1:1">
					<span id="upload-edit-img">+</span>
				</label>
			</div>
		</div>
		<form>
			<div class="form-group row">
				<label for="" class="col-md-5 col-form-label hidden-sm-down">Pilih gambar thumbnail</label>
				<div class="col-md-7">
					<select class="selectpicker" name="as_background_edit" data-style="btn-white round" data-width="100%" title="Pilih gambar thumbnail" id="set-edit-thumb">
						<?php foreach($edit_ar_imgs as $img) {?>
							<option value="<?=$img->imges_id;?>" <?=($img->as_background==1) ? 'selected="selected"':'';?>><?=$img->filename;?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</form>
	</section>
	<section id="article-edit-file">
		<div class="judul">
			<h3 class="page-subtitle d-inline-block">Attach file</h3>
			<span class="pull-right">
				<label for="browse-attach" class="btn btn-grey round" id="upload-edit-file">
				  Tambah File PDF
				</label>
			</span>
		</div>
		<div class="row attached-files">
			<?php foreach($edit_ar_files as $file) { $partfile_name=explode('.', $file->filename);?>
			<div class="item col-md-6 dfile" id="dfile-<?=$file->imges_id;?>">
				<a href="javascript:void(0);" class="hapus-edit" data-fl="dfile" data-row="<?=$file->imges_id;?>" data-dir="<?=$file->path;?>" data-filenm="<?=$file->filename;?>" data-fled="<?=$file->imges_id;?>"><i class="fa fa-fw fa-times" aria-hidden="true"><span class="sr-only">Hapus</span></i></a>
				<span class="detail" id="dtail-<?=$file->imges_id;?>">
					<a href="javascript:void(0);" class="rename-edit" data-row="<?=$file->imges_id;?>"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i><span class="sr-only">Edit</span></a>
					<input type="text" class="file-nm nm-file-edit" value="<?=($file->fname) ? $file->fname : $partfile_name[0];?>" id="file-nm-<?=$file->imges_id;?>" style="display:none;">
					<span class="filename" id="filename-edit-<?=$file->imges_id;?>"><?=($file->fname) ? $file->fname : $partfile_name[0];?></span>
					<span class="ext" id="ext-edit-<?=$file->imges_id;?>">.<?=$partfile_name[1];?></span>
				</span>
				<input type="hidden" name="id_file_edit[<?=$file->imges_id;?>]" value="<?=$file->imges_id;?>">
				<input type="hidden" name="fname_file_edit[<?=$file->imges_id;?>]" value="<?=$file->fname;?>" id="fname-<?=$file->imges_id;?>">
				<input type="hidden" name="filename_file_edit[<?=$file->imges_id;?>]" value="<?=$file->filename;?>">
				<input type="hidden" name="path_file_edit[<?=$file->imges_id;?>]" value="<?=$file->path;?>">
				<input type="hidden" name="full_path_file_edit[<?=$file->imges_id;?>]" value="<?=$file->full_path;?>">
			</div>
			<?php } ?>
			<div id="file-dash-edit"></div>
		</div>
	</section>
	<section>
		<div class="btns row">
			<div class="col-md-6 hidden-sm-down">
				<a href="#view-artikel" class="btn-link btn btn-grey round">Back</a>
			</div>
			<div class="col-md-6">
				<a href="javascript:void(0);" id="publish-edit-dashboard-article" class="btn btn-red btn-lg round w-100">Publish</a>
			</div>
		</div>
	</section>

	<script type="text/javascript">
	$(document).ready(function(){
		$('#description-edit-article').summernote({
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

	    $('body').on('change', '#atemplate-edit', function(ev) {
	        if(ev.currentTarget.value=='no-image') {
	            $('#article-edit-img').hide();
	        	$('#article-edit-file').hide();
	        } else {
	            /*if($('#atemplate-edit').val()=='downloadable') {
		            $('#article-edit-file').show();
		            $('#article-edit-img').hide();
		        } else {
		            $('#article-edit-img').show();
		            $('#article-edit-file').hide();
		        }*/
		        $('#article-edit-img').show();
	        	$('#article-edit-file').show();
	        }
	    });

	    $('body').on('click', '.hapus-edit', function(e) {
	    	dir 	= e.currentTarget.dataset.dir;
	    	row 	= e.currentTarget.dataset.row;
	    	filenm 	= e.currentTarget.dataset.filenm;
	    	fl 		= e.currentTarget.dataset.fl;
	    	fled 	= e.currentTarget.dataset.fled;
	    	$.ajax({
				url: SITE_URL+'delete-article-files-dashboard',
				type: 'post',
				data: $.extend(tokens,{
					   dir:dir,
					   row:row,
					   filenm:filenm,
					   fled:fled,
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

	    $('body').on('click', '#publish-edit-dashboard-article', function(e) {
	    	ar_id 						=$("input[name=ar_id]").val();
	    	title_edit 					=$("input[name=title_edit]").val();
	    	category_dashboard_edit 	=$("select[name=category_dashboard_edit]").val();
	    	kidsage_dashboard_edit 		=$("select[name=kidsage_dashboard_edit]").val();
	    	intro_edit 					=$("textarea[name=intro_edit]").val();
	    	meta_keyword_edit 			=$("textarea[name=meta_tag_edit]").val();
    		meta_description_edit 		=$("textarea[name=meta_description_edit]").val();
	    	description_edit 			=$("textarea[name=description_edit]").val();
	    	as_background_edit 			=$("select[name=as_background_edit]").val();
	    	template_edit 				=$("select[name=template_edit]").val();

	    	id_file_edit				=$("input[name^='id_file_edit']").serializeArray();
	    	fname_file_edit				=$("input[name^='fname_file_edit']").serializeArray();
	    	filename_file_edit			=$("input[name^='filename_file_edit']").serializeArray();
	    	path_file_edit 				=$("input[name^='path_file_edit']").serializeArray();
	    	full_path_file_edit 		=$("input[name^='full_path_file_edit']").serializeArray();
	    	id_img_edit					=$("input[name^='id_img_edit']").serializeArray();
	    	filename_img_edit			=$("input[name^='filename_img_edit']").serializeArray();
	    	path_img_edit 				=$("input[name^='path_img_edit']").serializeArray();
	    	full_path_img_edit			=$("input[name^='full_path_img_edit']").serializeArray();

	    	$.ajax({
				url: SITE_URL+'post-article-dashboard-edit',
				type: 'post',
				data: $.extend(tokens,{
					   ar_id:ar_id,
					   title_edit:title_edit,
					   category_dashboard_edit:category_dashboard_edit,
					   kidsage_dashboard_edit:kidsage_dashboard_edit,
					   intro_edit:intro_edit,
					    meta_keyword_edit:meta_keyword_edit,
				   		meta_description_edit:meta_description_edit,
					   description_edit:description_edit,
					   id_img_edit:id_img_edit,
					   filename_img_edit:filename_img_edit,
					   path_img_edit:path_img_edit,
					   full_path_img_edit:full_path_img_edit,
					   id_file_edit:id_file_edit,
					   fname_file_edit:fname_file_edit,
					   filename_file_edit:filename_file_edit,
					   path_file_edit:path_file_edit,
					   full_path_file_edit:full_path_file_edit,
					   as_background_edit:as_background_edit,
					   template_edit:template_edit,
				}),
				dataType: 'json',
				success: function(json) {
					tmlft();
					if(json['status']==true) {
						$('#ct-ar').html('');
						$('#ct-ar').html(json['ct_ar']);

						$('#set-edit-thumb').html('');
						$('.dimg').each(function(index, el) {
							$(this).remove();
						});
						$('.dfile').each(function(index, el) {
							$(this).remove();
						});
						$('option:selected').prop('selected', false)
						$('select').selectpicker('refresh');

						$('input[type=text], textarea, select').val('');
						$('#description-edit-article').summernote('reset');

						$('#puGlobal .modal-title').html('Sukses');
						$('#puGlobal .modal-body').html('Artikel '+json['ttl']+' berhasil diupdate, silahkan tunggu untuk proses validasi. Terima Kasih.');
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

	    $('body').on('click', '.rename-edit', function(e) {
	    	el_row_edit =  e.currentTarget.dataset.row;

	    	if($('#dtail-'+el_row_edit).hasClass('edit')==false) {
		    	$('#dtail-'+el_row_edit).addClass('edit');
		    	$('#file-nm-'+el_row_edit).show();
		    	$('#ext-edit-'+el_row_edit).hide();
		    	$('#filename-edit-'+el_row_edit).hide();
		    } else {
		    	$('#dtail-'+el_row_edit).removeClass('edit')
		    	$('#ext-edit-'+el_row_edit).show();
		    	$('#filename-edit-'+el_row_edit).show();
		    	$('#file-nm-'+el_row_edit).hide();
		    }

		    $('body').on('keyup', '.nm-file-edit', function(e) {
		    	fname = $(this).val();
		    	$('#filename-edit-'+el_row_edit).text(fname);
		    	$('#fname-'+el_row_edit).val(fname);
		    });
	    	e.preventDefault();
	    });
	});

	window.onload = function() {
		var arid_edit 		= $("input[name=ar_id]").val();;
		var btn_img_edit 	= document.getElementById('upload-edit-img');
		var btn_file_edit 	= document.getElementById('upload-edit-file');

		var uploader = new ss.SimpleUpload({
			button: btn_img_edit,
			url: SITE_URL+'submit-article-img-dashboard-edit',
			name: 'uploadfile',
			multipart: true,
			responseType: 'json',
			data:tokens,
			noParams: true,
			allowedExtensions: ['jpg', 'jpeg', 'png'],
		 	onComplete: function(filename, response) {
	        	if(response['success']==true) {
	        		$(response['html']).insertBefore('.add-edit-article-image');
	        		$('#set-edit-thumb').append(response['set_bg']).selectpicker('refresh');

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
			button: btn_file_edit,
			url: SITE_URL+'submit-article-file-dashboard-edit',
			name: 'uploadfile',
			multipart: true,
			responseType: 'json',
			data:tokens,
			noParams: true,
			allowedExtensions: ['pdf'],
		 	onComplete: function(filename, response) {
	        	if(response['success']==true) {
	        		$(response['html']).insertBefore('#file-dash-edit');
	        	}
		 	},
		  	endXHR: function(filename, response) {
	        	// console.log(filename);
	        	// console.log(response);
	      	},
		});

		if($('#atemplate-edit').val()=='no-image') {
	        $('#article-edit-img').hide();
	        $('#article-edit-file').hide();
	    } else {
	        /*if($('#atemplate-edit').val()=='downloadable') {
	            $('#article-edit-file').show();
	            $('#article-edit-img').hide();
	        } else {
	            $('#article-edit-img').show();
	            $('#article-edit-file').hide();
	        }*/
	        $('#article-edit-img').show();
	        $('#article-edit-file').show();
	    }
	};
	</script>
	<?php } ?>
</div>
