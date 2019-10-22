<div class="tab-pane <?= $page_active == 'tulis-artikel' ? 'active' : ''; ?>" id="tulis-artikel" role="tabpanel">
	<section class="inner">
		<div class="judul">
			<h3 class="page-subtitle mb-2">Tulis Artikel</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid amet voluptas enim tempore quis, dicta voluptatibus quos officiis, porro fuga!</p>
		</div>
		<div class="form-group row">
			<label for="" class="col-3 col-form-label hidden-md-down">Kategori</label>
			<div class="col-12 col-lg-9">
				<select name="category_dashboard" id="category-dashboard" class="bs-select" data-width="100%" title="Kategori">
					<?php foreach ($list_category as $key => $cat) { ?>
						<option value="<?= $cat['id']; ?>"><?= $cat['title']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-3 col-form-label hidden-md-down">Subject</label>
			<div class="col-12 col-lg-9">
				<input type="text" name="title" onkeypress="return textAlphanumeric(event)" class="form-control" placeholder="Tulis judul artikel...">
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-3 col-form-label hidden-md-down">Intro</label>
			<div class="col-12 col-lg-9">
				<textarea class="form-control" name="intro" onkeypress="return textAlphanumeric(event)" rows="10" placeholder="Tulis intro artikel..."></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-3 col-form-label hidden-md-down">Tulisan</label>
			<div class="col-12 col-lg-9">
				<textarea class="form-control" id="description-article" name="description" rows="10" placeholder="Tulis isi artikel..."></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-3 col-form-label hidden-md-down">Konten artikel</label>
			<div class="col-12 col-lg-9">
				<select name="template" id="atemplate" class="bs-select" data-width="100%" title="Konten artikel">
					<?php foreach ($ar_template as $key => $template) { ?>
						<option value="<?= $key; ?>"><?= $template; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-3 col-form-label hidden-md-down">Untuk anak usia</label>
			<div class="col-12 col-lg-9">
				<select name="kidsage_dashboard" id="kidsage-dashboard" class="bs-select" data-width="100%" title="Untuk anak usia">
					<?php foreach ($list_kidsage as $key=>$kidsage) { ?>
						<option value="<?= $kidsage['id']; ?>"><?= $kidsage['title']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-3 col-form-label hidden-md-down">Meta Keyword</label>
			<div class="col-12 col-lg-9">
				<textarea class="form-control" name="meta_keyword" rows="10" placeholder="" onkeypress="return textAlphanumeric(event)"></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label for="" class="col-3 col-form-label hidden-md-down">Meta Description</label>
			<div class="col-12 col-lg-9">
				<textarea class="form-control" name="meta_description" rows="10" placeholder="" onkeypress="return textAlphanumeric(event)"></textarea>
			</div>
		</div>
	</section>
	<section class="inner" id="article-img">
		<div class="judul">
			<h3 class="page-subtitle">Gambar</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
		</div>
		<div class="artikel-images">
			<div id="artikel-addimages-swiper">
				<div class="tambah add-article-image">
					<label for="tambah-images" class="fix-ratio" ratio="1:1">
						<span id="upload-img">+</span>
					</label>
					<input id="tambah-images" type="file" class="hidden-xs-up" />
				</div>
			</div>
		</div>
		<form>
			<div class="form-group row">
				<label for="" class="col-5 col-form-label hidden-md-down">Pilih gambar thumbnail</label>
				<div class="col-12 col-md-7">
					<select class="bs-select" name="as_background" data-style="btn-white" data-width="100%" title="Pilih gambar thumbnail" id="set-thumb">
					</select>
				</div>
			</div>
		</form>
	</section>
	<section class="inner">
		<div id="article-file">
			<div class="judul">
				<h3 class="page-subtitle d-inline-block">Attach file</h3>
				<span class="pull-right">
					<a for="browse-attach" class="btn btn-primary btn-capital" id="upload-file">
						+ Tambah File
					</a>
					<input id="browse-attach" type="file" class="hidden-xs-up" />
				</span>
			</div>
			<div class="row attached-files">
				<div id="file-dash"></div>
			</div>
		</div>
		<div id="article-youtube">
			<div class="form-group row">
				<label for="" class="col-3 col-form-label hidden-md-down">Youtube URL</label>
				<div class="col-12 col-lg-9">
					<input type="text" name="youtube_url" class="form-control" placeholder="Masukkan youtube url...">
				</div>
			</div>
		</div>
		<div id="article-video">
			<div class="judul">
				<h3 class="page-subtitle d-inline-block">Attach video</h3>
				<span class="pull-right">
					<a for="browse-video" class="btn btn-primary btn-capital" id="upload-video">
						+ Upload Video
					</a>
					<input id="browse-video" type="file" class="hidden-xs-up" />
				</span>
			</div>
			<div class="row video-files">
				<div id="video-dash"></div>
			</div>
		</div>
		<div class="btns row">
			<div class="col-6 hidden-sm-down">
				<a href="javascript:void();" class="btn btn-emas btn-capital" id="view-article-list">Back <i class="fa fa-arrow-circle-o-right ml-2" aria-hidden="true"></i></a>
			</div>
			<div class="col-12 col-md-6">
				<a href="javascript:void();" class="btn btn-primary w-100 btn-capital" id="publish-dashboard-article">Publish <i class="fa fa-arrow-circle-o-right ml-2" aria-hidden="true"></i></a>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('body').on('click', '#view-article-list', function() {
			$('.article-list').click();
		});

		// if ($(window).width() && $('#artikel-addimages-swiper').length>0) {
		// 	var addArtikelImagesSwiper = new Swiper('#artikel-addimages-swiper', {
		// 		centeredSlides: true,
		// 		slidesPerView: 'auto'
		// 	});
		// 	//addArtikelImagesSwiper.resizeFix(true);
		// }

		$('#description-article').summernote({
			height: '200px',
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
			if(ev.currentTarget.value=='banner' || ev.currentTarget.value=='carousel') {
				$('#article-img').show();
				$('#article-file').show();
				$('#article-youtube').hide();
				$('#article-video').hide();
				fixRatio();
			} else if (ev.currentTarget.value=='youtube') {
				$('#article-img').hide();
				$('#article-file').hide();
				$('#article-youtube').show();
				$('#article-video').hide();
			} else if (ev.currentTarget.value=='video') {
				$('#article-img').hide();
				$('#article-file').hide();
				$('#article-youtube').hide();
				$('#article-video').show();
			} else {
				/*if($('#atemplate').val()=='downloadable') {
					$('#article-file').show();
					$('#article-img').hide();
				} else {
					$('#article-img').show();
					$('#article-file').hide();
				}*/
				$('#article-img').hide();
				$('#article-file').hide();
				$('#article-youtube').hide();
				$('#article-video').hide();
			}
		});

		$('body').on('click', '.hapus-create', function(e) {
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

						if (fl == 'dvid') {
							$('#upload-edit-video').show();
						}
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
			youtube_url 			=$("input[name=youtube_url]").val();

			fname_file					=$("input[name^='fname_file']").serializeArray();
			filename_file				=$("input[name^='filename_file']").serializeArray();
			path_file 					=$("input[name^='path_file']").serializeArray();
			full_path_file 				=$("input[name^='full_path_file']").serializeArray();
			filename_img				=$("input[name^='filename_img']").serializeArray();
			path_img 					=$("input[name^='path_img']").serializeArray();
			full_path_img 				=$("input[name^='full_path_img']").serializeArray();
			filename_video				=$("input[name^='filename_video']").serializeArray();
			path_video 					=$("input[name^='path_video']").serializeArray();
			full_path_video 			=$("input[name^='full_path_video']").serializeArray();

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
					template:template == '' ? 'none' : template,
					youtube_url:youtube_url,
					filename_video:filename_video,
					path_video:path_video,
					full_path_video:full_path_video,
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

						$('.dvid').each(function(index, el) {
							$(this).remove();
						});

						$('option:selected').prop('selected', false)
						$('select').selectpicker('refresh');

						$('input[type=text], textarea, select').val('');
						$('#description-article').summernote('reset');

						// $('#puGlobal .img-responsive').hide();
						$('#puGlobal .modal-title').html('Terima kasih sudah berbagi cerita!');
						$('#puGlobal .modal-body').html('Artikel Anda telah diterima. Namun, kami akan melakukan proses moderasi terlebih dulu sebelum memuat artikel tersebut.');
						$('#puGlobal').modal();
					} else {
						err = json['ttl'] != '' ? 'Artikel dengan judul '+json['ttl']+' sudah ada. Terima Kasih.' : json['msg'];
						// $('#puGlobal .img-responsive').hide();
						$('#puGlobal .modal-title').html('Gagal');
						$('#puGlobal .modal-body').html(err);
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
		var btn_video 	= document.getElementById('upload-video');

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

		var uploader_video = new ss.SimpleUpload({
			button: btn_video,
			url: SITE_URL+'submit-article-video-dashboard',
			name: 'uploadfile',
			multipart: true,
			responseType: 'json',
			data:tokens,
			noParams: true,
			allowedExtensions: ['mp4'],
			onComplete: function(filename, response) {
				if(response['success']==true) {
					$(response['html']).insertBefore('#video-dash');
					$('#upload-edit-video').hide();
				}
			},
			endXHR: function(filename, response) {
				// console.log(filename);
				// console.log(response);
			},
		});

		if($('#atemplate').val()=='banner' || $('#atemplate').val()=='carousel') {
			$('#article-img').show();
			$('#article-file').show();
			$('#article-youtube').hide();
			$('#article-video').hide();
		} else if ($('#atemplate').val()=='youtube') {
			$('#article-img').hide();
			$('#article-file').hide();
			$('#article-youtube').show();
			$('#article-video').hide();
		} else if ($('#atemplate').val()=='video') {
			$('#article-img').hide();
			$('#article-file').hide();
			$('#article-youtube').hide();
			$('#article-video').show();
		} else {
			/*if($('#atemplate').val()=='downloadable') {
				$('#article-file').show();
				$('#article-img').hide();
			} else {
				$('#article-img').show();
				$('#article-file').hide();
			}*/
			$('#article-img').hide();
			$('#article-file').hide();
			$('#article-youtube').hide();
			$('#article-video').hide();
		}
	};
</script>
