<div class="tab-pane <?= $page_active == 'edit-artikel' ? 'active' : ''; ?>" id="tulis-artikel" role="tabpanel">
    <?php if (!empty($edit_article)) { ?>
        <section class="inner">
            <div class="judul">
                <h3 class="page-subtitle mb-2">Edit Artikel</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid amet voluptas enim tempore quis, dicta voluptatibus quos officiis, porro fuga!</p>
            </div>
            <input type="hidden" name="ar_id" value="<?= $edit_article->article_id; ?>" id="arid">
            <div class="form-group row">
                <label for="" class="col-3 col-form-label hidden-md-down">Kategori</label>
                <div class="col-12 col-lg-9">
                    <select name="category_dashboard_edit" id="category-dashboard" class="bs-select" data-width="100%" title="Kategori">
                        <?php
                        foreach ($list_category as $key => $cat) {
                            if (in_array($cat['id'], explode(',', $edit_article->categories_id))) {
                        ?>
                                <option selected="selected" value="<?= $cat['id']; ?>"><?= $cat['title']; ?></option>
                        <?php
                            } else {
                        ?>
                                <option value="<?=$cat['id']; ?>"><?=$cat['title']; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-3 col-form-label hidden-md-down">Subject</label>
                <div class="col-12 col-lg-9">
                    <input type="text" name="title_edit" onkeypress="return textAlphanumeric(event)" class="form-control" value="<?= $edit_article->title; ?>" placeholder="Tulis judul artikel...">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-3 col-form-label hidden-md-down">Intro</label>
                <div class="col-12 col-lg-9">
                    <textarea class="form-control" name="intro_edit" onkeypress="return textAlphanumeric(event)" rows="10" placeholder="Tulis intro artikel..."><?= $edit_article->intro; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-3 col-form-label hidden-md-down">Tulisan</label>
                <div class="col-12 col-lg-9">
                    <textarea class="form-control" id="description-edit-article" name="description_edit" rows="10" placeholder="Tulis isi artikel..."><?= $edit_article->description; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-3 col-form-label hidden-md-down">Konten artikel</label>
                <div class="col-12 col-lg-9">
                    <select name="template_edit" id="atemplate-edit" class="bs-select" data-width="100%" title="Konten artikel">
                        <?php
                        foreach ($ar_template as $key => $template) {
                            if ($edit_article->content_format == $key) {
                        ?>
                                <option value="<?= $key; ?>" selected="selected"><?= $template; ?></option>
                        <?php
                            } else {
                        ?>
                                <option value="<?= $key; ?>"><?= $template; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-3 col-form-label hidden-md-down">Untuk anak usia</label>
                <div class="col-12 col-lg-9">
                    <select name="kidsage_dashboard_edit" id="kidsage-dashboard" class="bs-select" data-width="100%" title="Untuk anak usia">
                        <?php
                        foreach ($list_kidsage as $key => $kidsage) {
                            if (in_array($kidsage['id'], explode(',', $edit_article->kidsage_id))) {
                        ?>
                                <option selected="selected" value="<?= $kidsage['id']; ?>"><?= $kidsage['title']; ?></option>
                        <?php
                            } else {
                        ?>
                                <option value="<?= $kidsage['id']; ?>"><?= $kidsage['title']; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-3 col-form-label hidden-md-down">Meta Keyword</label>
                <div class="col-12 col-lg-9">
                    <textarea class="form-control" name="meta_keyword_edit" rows="10" placeholder="" onkeypress="return textAlphanumeric(event)"><?= $edit_article->meta_keyword; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-3 col-form-label hidden-md-down">Meta Description</label>
                <div class="col-12 col-lg-9">
                    <textarea class="form-control" name="meta_description_edit" rows="10" placeholder="" onkeypress="return textAlphanumeric(event)"><?= $edit_article->meta_desc; ?></textarea>
                </div>
            </div>
        </section>
        <section class="inner" id="article-img-edit">
            <div class="judul">
                <h3 class="page-subtitle">Gambar</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            </div>
            <div class="artikel-images">
                <div id="artikel-addimages-swiper">
                    <?php foreach ($edit_ar_imgs as $img) { ?>
                        <div class="item dimg" id="dimg-<?= $img->imges_id; ?>">
                            <div class="fix-ratio" ratio="1:1">
                                <img src="<?= base_url($img->full_path); ?>" alt="">
                                <div class="detail">
                                    <a href="javascript:void();" class="hapus hapus-edit" data-fl="dimg" data-row="<?= $img->imges_id; ?>" data-dir="<?= $img->path; ?>" data-filenm="<?= $img->filename; ?>" data-fled="<?= $img->imges_id; ?>"><i class="fa fa-fw fa-times"></i></a>
                                    <div class="filename"><?= $img->filename; ?></div>
                                    <input type="hidden" name="id_img_edit[<?= $img->imges_id; ?>]" value="<?= $img->imges_id; ?>">
                                    <input type="hidden" name="filename_img_edit[<?= $img->imges_id; ?>]" value="<?= $img->filename; ?>">
                                    <input type="hidden" name="path_img_edit[<?= $img->imges_id; ?>]" value="<?= $img->path; ?>">
                                    <input type="hidden" name="full_path_img_edit[<?= $img->imges_id; ?>]" value="<?= $img->full_path; ?>">
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="tambah add-edit-article-image">
                        <label for="tambah-images-edit" class="fix-ratio" ratio="1:1">
                            <span id="upload-edit-img">+</span>
                        </label>
                        <input id="tambah-images-edit" type="file" class="hidden-xs-up" />
                    </div>
                </div>
            </div>
            <form>
                <div class="form-group row">
                    <label for="" class="col-5 col-form-label hidden-md-down">Pilih gambar thumbnail</label>
                    <div class="col-12 col-md-7">
                        <select class="bs-select" name="as_background_edit" data-style="btn-white" data-width="100%" title="Pilih gambar thumbnail" id="set-edit-thumb">
						<?php foreach($edit_ar_imgs as $img) { ?>
							<option value="<?= $img->imges_id; ?>" <?= ($img->as_background == 1) ? 'selected="selected"' : ''; ?>><?= $img->filename; ?></option>
						<?php } ?>
					</select>
                    </div>
                </div>
            </form>
        </section>
        <section class="inner">
            <div id="article-file-edit">
                <div class="judul">
                    <h3 class="page-subtitle d-inline-block">Attach file</h3>
                    <span class="pull-right">
                        <a for="browse-attach" class="btn btn-primary btn-capital" id="upload-edit-file">
                            + Tambah File
                        </a>
                        <input id="browse-attach" type="file" class="hidden-xs-up" />
                    </span>
                </div>
                <div class="row attached-files">
                    <?php
                    foreach ($edit_ar_files as $file) {
                        $partfile_name = explode('.', $file->filename);
                    ?>
                        <div class="item col-12 col-lg-6 dfile" id="dfile-<?= $file->imges_id; ?>">
                            <a href="javascript:void();" class="hapus hapus-edit" data-fl="dfile" data-row="<?= $file->imges_id; ?>" data-dir="<?= $file->path; ?>" data-filenm="<?= $file->filename; ?>" data-fled="<?= $file->imges_id; ?>"><i class="fa fa-fw fa-times" aria-hidden="true"><span class="sr-only">Hapus</span></i></a>
                            <span class="detail" id="dtail-<?= $file->imges_id; ?>">
                                <a href="javascript:void();" class="rename-edit" data-row="<?= $file->imges_id; ?>"><i class="fa fa-fw fa-check" aria-hidden="true"></i><span class="sr-only">Edit</span></a>
                                <input type="text" class="file-nm nm-file-edit" value="<?= ($file->fname) ? $file->fname : $partfile_name[0]; ?>" id="file-nm-<?= $file->imges_id; ?>" style="display:none;">
                                <span class="filename" id="filename-edit-<?= $file->imges_id; ?>"><?= ($file->fname) ? $file->fname : $partfile_name[0]; ?></span>
                            </span>
                            <span class="ext" id="ext-edit-<?=$file->imges_id; ?>">.<?=$partfile_name[1]; ?></span>
                            <input type="hidden" name="id_file_edit[<?= $file->imges_id; ?>]" value="<?= $file->imges_id; ?>">
                            <input type="hidden" name="fname_file_edit[<?= $file->imges_id; ?>]" value="<?= $file->fname; ?>" id="fname-<?=$file->imges_id; ?>">
                            <input type="hidden" name="filename_file_edit[<?= $file->imges_id; ?>]" value="<?= $file->filename; ?>">
                            <input type="hidden" name="path_file_edit[<?= $file->imges_id; ?>]" value="<?= $file->path; ?>">
                            <input type="hidden" name="full_path_file_edit[<?= $file->imges_id; ?>]" value="<?= $file->full_path; ?>">
                        </div>
                    <?php
                        }
                    ?>
                    <div id="file-dash-edit"></div>
                </div>
            </div>
            <div id="article-youtube-edit">
                <div class="form-group row">
                    <label for="" class="col-3 col-form-label hidden-md-down">Youtube URL</label>
                    <div class="col-12 col-lg-9">
                        <?php
                        $_yt_value = $edit_ar_yt ? $edit_ar_yt[0]->filename : '';
                        $_yt_value_id = $edit_ar_yt ? $edit_ar_yt[0]->imges_id : '';
                        ?>
                        <input type="text" name="youtube_url_edit" class="form-control" value="<?= $_yt_value; ?>" placeholder="Masukkan youtube url...">
                        <input type="hidden" name="youtube_url_edit_id" value="<?= $_yt_value_id; ?>">
                        <?php if (!empty($_yt_value)) { ?>
                            <?php
                            $_ytid = explode('watch?v=', $_yt_value);
                            $_embed = 'https://www.youtube.com/embed/'.$_ytid[1].'?rel=0';
                            ?>
                            <br>
                            <iframe width="560" height="315" src="<?= $_embed; ?>" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div id="article-video-edit">
                <div class="judul">
                    <h3 class="page-subtitle d-inline-block">Attach video</h3>
                    <span class="pull-right">
                        <a for="browse-video" class="btn btn-primary btn-capital" id="upload-edit-video">
                            + Upload Video
                        </a>
                        <input id="browse-video" type="file" class="hidden-xs-up" />
                    </span>
                </div>
                <div class="row video-files">
                    <div id="video-dash-edit">
                        <?php foreach ($edit_ar_video as $file) { ?>
                            <div class="item swiper-slide dvid" id="dvid-<?= $file->imges_id; ?>">
                                <div class="fix-ratio" ratio="1:1">
                                    <video width="300px" height="200px" controls><source src="<?= $file->full_path; ?>" type="video/mp4"></video>
                                    <div class="detail">
                                        <a href="javascript:void();" class="hapus hapus-edit" data-fl="dvid" data-row="<?= $file->imges_id; ?>" data-dir="" data-filenm=""><i class="fa fa-fw fa-times"></i></a>
                                        <div class="filename"><?= $file->filename; ?></div>
                                        <input type="hidden" name="id_video_edit[<?= $file->imges_id; ?>]" value="<?= $file->imges_id; ?>">
                                        <input type="hidden" name="filename_video_edit[<?= $file->imges_id; ?>]" value="<?= $file->filename; ?>">
                                        <input type="hidden" name="path_video_edit[<?= $file->imges_id; ?>]" value="<?= $file->path; ?>">
                                        <input type="hidden" name="full_path_video_edit[<?= $file->imges_id; ?>]" value="<?= $file->full_path; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="btns row">
                <div class="col-6 hidden-sm-down">
                    <a href="javascript:void();" class="btn btn-warning" id="view-article-list-edit">Back</a>
                </div>
                <div class="col-12 col-md-6">
                    <a href="javascript:void();" class="btn btn-primary w-100 btn-capital" id="publish-edit-dashboard-article">Publish <i class="fa fa-arrow-circle-o-right ml-2" aria-hidden="true"></i></a>
                </div>
            </div>
        </section>
    <?php } ?>
</div>

<?php if (!empty($edit_article)) { ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('body').on('click', '#view-article-list-edit', function() {
                $('.article-list').click();
            });

            // if ($(window).width() && $('#artikel-addimages-swiper').length>0) {
            // 	var addArtikelImagesSwiper = new Swiper('#artikel-addimages-swiper', {
            // 		centeredSlides: true,
            // 		slidesPerView: 'auto'
            // 	});
            // 	//addArtikelImagesSwiper.resizeFix(true);
            // }

            $('#description-edit-article').summernote({
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

            $('body').on('change', '#atemplate-edit', function(ev) {
                if(ev.currentTarget.value=='banner' || ev.currentTarget.value=='carousel') {
                    $('#article-img-edit').show();
                    $('#article-file-edit').show();
                    $('#article-youtube-edit').hide();
                    $('#article-video-edit').hide();
                    fixRatio();
                } else if (ev.currentTarget.value=='youtube') {
                    $('#article-img-edit').hide();
                    $('#article-file-edit').hide();
                    $('#article-youtube-edit').show();
                    $('#article-video-edit').hide();
                } else if (ev.currentTarget.value=='video') {
                    $('#article-img-edit').hide();
                    $('#article-file-edit').hide();
                    $('#article-youtube-edit').hide();
                    $('#article-video-edit').show();
                } else {
                    /*if($('#atemplate_edit').val()=='downloadable') {
                        $('#article-file-edit').show();
                        $('#article-img-edit').hide();
                    } else {
                        $('#article-img-edit').show();
                        $('#article-file-edit').hide();
                    }*/
                    $('#article-img-edit').hide();
                    $('#article-file-edit').hide();
                    $('#article-youtube-edit').hide();
                    $('#article-video-edit').hide();
                }
            });

            $('body').on('click', '.hapus-edit', function(e) {
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
                youtube_url_edit 			=$("input[name=youtube_url_edit]").val();

                id_file_edit				=$("input[name^='id_file_edit']").serializeArray();
                fname_file_edit				=$("input[name^='fname_file_edit']").serializeArray();
                filename_file_edit			=$("input[name^='filename_file_edit']").serializeArray();
                path_file_edit 				=$("input[name^='path_file_edit']").serializeArray();
                full_path_file_edit 		=$("input[name^='full_path_file_edit']").serializeArray();
                id_img_edit					=$("input[name^='id_img_edit']").serializeArray();
                filename_img_edit			=$("input[name^='filename_img_edit']").serializeArray();
                path_img_edit 				=$("input[name^='path_img_edit']").serializeArray();
                full_path_img_edit			=$("input[name^='full_path_img_edit']").serializeArray();
                id_video_edit				=$("input[name^='id_video_edit']").serializeArray();
                filename_video_edit			=$("input[name^='filename_video_edit']").serializeArray();
			    path_video_edit 			=$("input[name^='path_video_edit']").serializeArray();
			    full_path_video_edit 		=$("input[name^='full_path_video_edit']").serializeArray();

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
                        template_edit:template_edit == '' ? 'none' : template_edit,
                        youtube_url_edit:youtube_url_edit,
                        id_video_edit:id_video_edit,
                        filename_video_edit:filename_video_edit,
                        path_video_edit:path_video_edit,
                        full_path_video_edit:full_path_video_edit,
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

                            $('.dvid').each(function(index, el) {
                                $(this).remove();
                            });

                            $('option:selected').prop('selected', false)
                            $('select').selectpicker('refresh');

                            $('input[type=text], textarea, select').val('');
                            $('#description-edit-article').summernote('reset');

                            // $('#puGlobal .img-responsive').hide();
                            $('#puGlobal .modal-title').html('Sukses');
                            $('#puGlobal .modal-body').html('Artikel '+json['ttl']+' berhasil diupdate, silahkan tunggu untuk proses validasi. Terima Kasih.');
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
            var arid_edit 	= $("input[name=ar_id]").val();
            var btn_img_edit 	= document.getElementById('upload-edit-img');
            var btn_file_edit 	= document.getElementById('upload-edit-file');
            var btn_video_edit 	= document.getElementById('upload-edit-video');

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

            var uploader_video = new ss.SimpleUpload({
                button: btn_video_edit,
                url: SITE_URL+'submit-article-video-dashboard-edit',
                name: 'uploadfile',
                multipart: true,
                responseType: 'json',
                data:tokens,
                noParams: true,
                allowedExtensions: ['mp4'],
                onComplete: function(filename, response) {
                    if(response['success']==true) {
                        $(response['html']).insertBefore('#video-dash-edit');
                        $('#upload-edit-video').hide();
                    }
                },
                endXHR: function(filename, response) {
                    // console.log(filename);
                    // console.log(response);
                },
            });

            if($('#atemplate-edit').val()=='banner' || $('#atemplate-edit').val()=='carousel') {
                $('#article-img-edit').show();
                $('#article-file-edit').show();
                $('#article-youtube-edit').hide();
                $('#article-video-edit').hide();
            } else if ($('#atemplate-edit').val()=='youtube') {
                $('#article-img-edit').hide();
                $('#article-file-edit').hide();
                $('#article-youtube-edit').show();
                $('#article-video-edit').hide();
            } else if ($('#atemplate-edit').val()=='video') {
                $('#article-img-edit').hide();
                $('#article-file-edit').hide();
                $('#article-youtube-edit').hide();
                $('#article-video-edit').show();
            } else {
                /*if($('#atemplate-edit').val()=='downloadable') {
                    $('#article-file-edit').show();
                    $('#article-img-edit').hide();
                } else {
                    $('#article-img-edit').show();
                    $('#article-file-edit').hide();
                }*/
                $('#article-img-edit').hide();
                $('#article-file-edit').hide();
                $('#article-youtube-edit').hide();
                $('#article-video-edit').hide();
            }

            if ($('.dvid').length) {
                $('#upload-edit-video').hide();
            }
        };
    </script>
<?php } ?>
