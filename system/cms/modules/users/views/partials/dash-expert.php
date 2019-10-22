<div class="tab-pane <?= $page_active == 'dash-expert' ? 'active' : ''; ?>" id="dash-expert" role="tabpanel">
    <div class="filter" id="expert-filters-holder" style="display: none;">
        <?php if ($this->current_user->group == 'super_expert') { ?>
            <select class="bs-select" id="filter_expert_doctor">
                <option value="">Pilih Dokter</option>
                <?php foreach ($doctor_data_all as $doctor) { ?>
                    <?php if ($doctor->status == 'publish') { ?>
                        <option value="<?= $doctor->doctor_id; ?>"><?= $doctor->doctor_nickname; ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        <?php } ?>
        <select class="bs-select" id="filter_expert_sort">
            <option value="latest">Terbaru</option>
            <option value="oldest">Terlama</option>
        </select>
        <select class="bs-select" id="filter_expert_read">
            <?php
            $selected_read = '';
            $total_load_data_count = $asks_data_count;
            $expert_type = $expert_type == 'super_expert' ? 'sp' : 'reg';

            if (isset($ask_params['status']) && $ask_params['status'] == 'unpublish') {
                $selected_read = 'selected';
                $total_load_data_count = $asks_data_count_unread;
            }
            ?>
            <option value="">Semua</option>
            <option value="unread" <?= $selected_read; ?>>Belum dijawab</option>
            <option value="read">Sudah dijawab</option>
        </select>
    </div>
    <br>
    <div id="asks-data-holder">
        <?php foreach ($asks_data as $key => $ask) { ?>
            <?php
            $url = site_url('smart-consultation/'.$ask->speciality_slug.'/'.$ask->ask_slug);
            $wa = 'whatsapp://send?text='.$ask->ask_subject.' '.$url;
            ?>
            <div class="atc">
                <div class="a-info">
                    <h3 class="a-title"><?= $ask->ask_subject; ?></h3>
                    <p class="a-author">By: <strong><?= $ask->display_name; ?></strong></p>
                    <div class="nav-social">
                        <span>Bagikan </span>
                        <a href="javascript:void();" class="btn btn-facebook share-to-fb" data-url="<?= $url; ?>" data-title="<?= $ask->ask_subject; ?>" data-description="<?= $ask->ask_value; ?>" data-image="<?= site_url($ask->doctor_image); ?>"><i class="fa-facebook" aria-hidden="true"></i><span class="sr-only">Facebook</span></a>
                        <a href="javascript:void();" class="btn btn-twitter share-to-tw" data-url="<?= $url; ?>" data-description="<?= $ask->ask_value; ?>"><i class="fa-twitter" aria-hidden="true"></i><span class="sr-only">Twitter</span></a>
                        <a href="<?= $wa; ?>" class="btn btn-whatsapp"><i class="fa-whatsapp" aria-hidden="true"></i><span class="sr-only">Twitter</span></a>
                    </div>
                </div>
                <div class="a-content">
                    <strong>Detail: </strong> <?= $ask->ask_value; ?>
                </div>
                <?php if(!empty($ask->ask_child)) { ?>
                <div class="a-content">
                    <strong><a href="javascript:void(0);" class="expert-vaccine-setkid" data-askuser="<?=$ask->user_id;?>" data-askchild="<?=$ask->ask_child;?>">Lihat riwayat vaksin</a></strong>
                </div>
                <?php } ?>
                <div class="a-content">
                    <?php if ($ask->answer_status == 'publish') { ?>
                        <div id="answer-ask-<?= $ask->ask_id; ?>"><strong>Jawaban: </strong> <?= !empty($ask->answer_value) ? $ask->answer_value : ''; ?></div>
                        <a href="javascript:void();" class="edit-answer-sc edit-answer-sc-<?= $ask->ask_id; ?>" data-id="<?= $ask->ask_id; ?>" data-answer="<?= !empty($ask->answer_value) ? strip_tags($ask->answer_value) : ''; ?>">Edit</a> |
                        <a href="javascript:void();" class="new-answer-sc new-answer-sc-<?= $ask->ask_id; ?>" data-id="<?= $ask->ask_id; ?>" data-answer="">New</a>
                    <?php } ?>
                </div>
                <div class="expert-answer">
                    <div class="form-group" style="display: none;">
                        <input type="text" id="subject-ask-<?= $ask->ask_id; ?>" class="form-control" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <textarea id="comment-ask-<?= $ask->ask_id; ?>" rows="4" class="form-control" placeholder="Write your comments..."></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-link btn-capital submit-ask-comment btn-ask-comment-<?= $ask->ask_id; ?>" data-id="<?= $ask->ask_id; ?>" data-type="create">Submit the answer <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
                    </div>
                </div>

                <div class="comments">
                    <h4 class="page-subtitle mb-2">Komentar</h4>
                    <div class="comment hasReplies replies-for-<?= $ask->ask_id; ?>">
                    <?php if ($ask->comments) { ?>
                        <?php foreach ($ask->comments as $key => $comment) { ?>
                            <?php if (isset($comment['ask_id']) && $comment['ask_id'] == $ask->ask_id) { ?>
                                <?php $comment_counts = array_key_exists('child', $comment) ? count($comment['child']) : 0; ?>
                                <div class="com">
                                    <div class="com-wrap">
                                        <div class="profile">
                                            <div class="ava">
                                                <img src="<?= $comment['photo_profile']; ?>" alt="">
                                            </div>
                                            <div class="name"><strong>By: </strong> <?= trim($comment['first_name'].' '.$comment['last_name']); ?></div>
                                        </div>
                                        <h5 class="com-subject"><strong>Subject: </strong> <?= $comment['subject']; ?></h5>
                                        <div class="com-isi">
                                            <strong>Comment: </strong><p><?= $comment['comments']; ?></p>
                                        </div>
                                        <div class="com-info"><?= $comment_counts; ?> Replies <button class="btn btn-link reply-comment-sc reply-comment-sc-<?= $comment['comments_id']; ?>" data-id="<?= $comment['comments_id']; ?>" data-type="reply">Reply</button></div>
                                        <div class="com-form">
                                            <div class="form-group form-reply-ask-<?= $comment['comments_id']; ?>" style="display: none;">
                                                <input type="text" id="subject-ask-<?= $comment['comments_id']; ?>" class="form-control" placeholder="Subject">
                                            </div>
                                            <div class="form-group form-reply-ask-<?= $comment['comments_id']; ?>" style="display: none;">
                                                <textarea id="comment-ask-<?= $comment['comments_id']; ?>" rows="4" class="form-control" placeholder="Write your comments..."></textarea>
                                            </div>
                                            <div class="form-group form-reply-ask-<?= $comment['comments_id']; ?>" style="display: none;">
                                                <button class="btn btn-link btn-capital submit-ask-reply" data-id="<?= $comment['comments_id']; ?>" data-type="create" data-askid="<?= $ask->ask_id; ?>" data-parent="<?= $comment['comments_id']; ?>" data-replyto="<?= $comment['user_id']; ?>">Submit the comment <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="replies child-replies-for-<?= $comment['comments_id']; ?>">
                                <?php if (array_key_exists('child', $comment)) { ?>
                                    <?php foreach ($comment['child'] as $key => $child) { ?>
                                        <div class="com">
                                            <div class="com-wrap">
                                                <div class="profile">
                                                    <div class="ava">
                                                        <img src="<?= $child['photo_profile']; ?>" alt="">
                                                    </div>
                                                    <div class="name"><strong>By: </strong> <?= trim($child['first_name'].' '.$child['last_name']); ?></div>
                                                </div>
                                                <h5 class="com-subject"><strong>Subject: </strong> <?= $child['subject']; ?></h5>
                                                <div class="com-isi">
                                                    <strong>Comment: </strong><p><?= $child['comments']; ?></p>
                                                </div>
                                                <div class="com-info"><button class="btn btn-link reply-child-comment-sc reply-child-comment-sc-<?= $child['comments_id']; ?>" data-id="<?= $child['comments_id']; ?>" data-type="reply">Reply</button></div>
                                                <div class="com-form">
                                                    <div class="form-group form-reply-child-ask-<?= $child['comments_id']; ?>" style="display: none;">
                                                        <input type="text" id="child-subject-ask-<?= $child['comments_id']; ?>" class="form-control" placeholder="Subject">
                                                    </div>
                                                    <div class="form-group form-reply-child-ask-<?= $child['comments_id']; ?>" style="display: none;">
                                                        <textarea id="child-comment-ask-<?= $child['comments_id']; ?>" rows="4" class="form-control" placeholder="Write your comments..."></textarea>
                                                    </div>
                                                    <div class="form-group form-reply-child-ask-<?= $child['comments_id']; ?>" style="display: none;">
                                                        <button class="btn btn-link btn-capital submit-ask-child-reply" data-id="<?= $child['comments_id']; ?>" data-type="create" data-askid="<?= $ask->ask_id; ?>" data-parent="<?= $comment['comments_id']; ?>" data-replyto="<?= $child['user_id']; ?>">Submit the comment <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="loader" style="display: none;">
        <div class="load">
            <i class="fa" aria-hidden="true"></i>
            <span>Loading...</span>
        </div>
    </div>

    <?php if ($total_load_data_count > 5) { ?>
        <div class="form-group btns">
            <button class="btn btn-primary btn-capital btn-lg" id="load-more-asks">Muat Lagi <i class="fa fa-arrow-circle-o-right ml-2" aria-hidden="true"></i></button>
        </div>
    <?php } ?>
</div>

<div>
    <input type="hidden" id="current_page" value="2">
    <input type="hidden" id="total_data" value="<?= $total_load_data_count; ?>">
    <input type="hidden" id="total_data_unread" value="<?= $asks_data_count_unread; ?>">
</div>

<script type="text/javascript">
    $(document).ready(function() {
        <?php if ($asks_data) { ?>
            $(document).on('click', '.submit-ask-comment', function(e) {
                e.preventDefault();

                var ask_id = $(this).data('id'),
                    submit = {
                        ask_id: ask_id,
                        comment: $('#comment-ask-'+ask_id).val(),
                        unread: $('#total_data_unread').val(),
                        type: $(this).data('type'),
                        expert_type: '<?= $expert_type; ?>'
                    };

                $.post(SITE_URL+'submit-ask-comment', $.extend(tokens, submit), function(result) {
                    if (result.status) {
                        if (result.unread > 0) {
                            $('#total_data_unread').val(result.unread);
                            $('.expert-dash-notif').html(result.unread);
                        } else {
                            $('#total_data_unread').val(0);
                            $('.expert-dash-notif').html(result.unread).hide();
                        }

                        if (submit.type == 'update') {
                            $('#answer-ask-'+ask_id).html('<strong>Jawaban: </strong>&nbsp'+result.answer_value_preview);
                            $('.edit-answer-sc-'+ask_id).attr('data-answer', result.answer_value_dataattr);
                        } else {
                            //
                        }

                        $('#puSukses .modal-body p').html(result.message);
                        $('#puSukses').modal();
                    }
                });
            });

            $('#expert-filters-holder').show();
        <?php } ?>

        $(document).on('click', '#load-more-asks', function(e) {
            e.preventDefault();

            var submit = {
                page: $('#current_page').val(),
                total: $('#total_data').val(),
                sort: $('#filter_expert_sort').val(),
                read: $('#filter_expert_read').val(),
                doctor: $('#filter_expert_doctor').length ? $('#filter_expert_doctor').val() : ''
            };

            load_more_asks_expert(submit);
        });

        $('#filter_expert_doctor').on('change', function(e) {
            e.preventDefault();

            var submit = {
                page: 1,
                total: $('#total_data').val(),
                sort: $('#filter_expert_sort').val(),
                read: $('#filter_expert_read').val(),
                doctor: $(this).val()
            };

            load_more_asks_expert(submit);
        });

        $('#filter_expert_sort').on('change', function(e) {
            e.preventDefault();

            var submit = {
                page: 1,
                total: $('#total_data').val(),
                sort: $(this).val(),
                read: $('#filter_expert_read').val(),
                doctor: $('#filter_expert_doctor').length ? $('#filter_expert_doctor').val() : ''
            };

            load_more_asks_expert(submit);
        });

        $('#filter_expert_read').on('change', function(e) {
            e.preventDefault();

            var submit = {
                page: 1,
                total: $('#total_data').val(),
                sort: $('#filter_expert_sort').val(),
                read: $(this).val(),
                doctor: $('#filter_expert_doctor').length ? $('#filter_expert_doctor').val() : ''
            };

            load_more_asks_expert(submit);
        });

        $(document).on('click', '.edit-answer-sc', function(e) {
            e.preventDefault();

            var ask_id = $(this).data('id'),
                ask_answer = $(this).data('answer');

            $('#subject-ask-'+ask_id).parent().hide();
            $('#comment-ask-'+ask_id).val(ask_answer);
            $('.btn-ask-comment-'+ask_id).attr('data-type', 'update');
        });

        $(document).on('click', '.new-answer-sc', function(e) {
            e.preventDefault();

            var ask_id = $(this).data('id');

            $('#subject-ask-'+ask_id).parent().show();
            $('#comment-ask-'+ask_id).val('');
            $('.btn-ask-comment-'+ask_id).attr('data-type', 'create');
        });

        $(document).on('click', '.reply-comment-sc', function(e) {
            e.preventDefault();

            var ask_id = $(this).data('id')
                type = $(this).attr('data-type'),
                attr = type == 'reply' ? 'hide' : 'reply',
                text = type == 'reply' ? 'Hide' : 'Reply';

            $('.reply-comment-sc-'+ask_id).attr('data-type', attr).html(text);

            if (type == 'reply') {
                $('.form-reply-ask-'+ask_id).show();
            } else {
                $('.form-reply-ask-'+ask_id).hide();
            }
        });

        $(document).on('click', '.reply-child-comment-sc', function(e) {
            e.preventDefault();

            var ask_id = $(this).data('id')
                type = $(this).attr('data-type'),
                attr = type == 'reply' ? 'hide' : 'reply',
                text = type == 'reply' ? 'Hide' : 'Reply';

            $('.reply-child-comment-sc-'+ask_id).attr('data-type', attr).html(text);

            if (type == 'reply') {
                $('.form-reply-child-ask-'+ask_id).show();
            } else {
                $('.form-reply-child-ask-'+ask_id).hide();
            }
        });

        $(document).on('click', '.submit-ask-reply', function(e) {
            e.preventDefault();

            var parent = $(this).data('parent'),
                id = $(this).data('id'),
                submit = {
                    ask_id: $(this).data('askid'),
                    parent: parent,
                    reply: $(this).data('replyto'),
                    ask_subject: $('#subject-ask-'+id).val(),
                    ask_body: $('#comment-ask-'+id).val(),
                    source: 'expert',
                    expert_type: '<?= $expert_type; ?>'
                };

            $.post(SITE_URL+'smart-consultation/post-ask-comment', $.extend(tokens, submit), function(result) {
                var json = JSON.parse(result);

                if (json.status) {
                    var html =  '<div class="com">'+
                                    '<div class="com-wrap">'+
                                        '<div class="profile">'+
                                            '<div class="ava">'+
                                                '<img src="'+json.content.photo_profile+'" alt="">'+
                                            '</div>'+
                                            '<div class="name"><strong>By: </strong> '+json.content.first_name+' '+json.content.last_name+'</div>'+
                                        '</div>'+
                                        '<h5 class="com-subject"><strong>Subject: </strong> '+json.content.subject+'</h5>'+
                                        '<div class="com-isi">'+
                                            '<strong>Comment: </strong><p>'+json.content.comments+'</p>'+
                                        '</div>'+
                                        '<div class="com-info"><button class="btn btn-link reply-comment-sc reply-comment-sc-'+json.content.comments_id+'" data-id="'+json.content.comments_id+'" data-type="reply">Reply</button></div>'+
                                        '<div class="com-form">'+
                                            '<div class="form-group form-reply-ask-'+json.content.comments_id+'" style="display: none;">'+
                                                '<input type="text" id="subject-ask-'+json.content.comments_id+'" class="form-control" placeholder="Subject">'+
                                            '</div>'+
                                            '<div class="form-group form-reply-ask-'+json.content.comments_id+'" style="display: none;">'+
                                                '<textarea id="comment-ask-'+json.content.comments_id+'" rows="4" class="form-control" placeholder="Write your comments..."></textarea>'+
                                            '</div>'+
                                            '<div class="form-group form-reply-ask-'+json.content.comments_id+'" style="display: none;">'+
                                                '<button class="btn btn-link btn-capital submit-ask-reply" data-id="'+json.content.comments_id+'" data-type="create" data-askid="'+submit.ask_id+'" data-parent="'+submit.parent+'" data-replyto="'+json.content.user_id+'">Submit the comment <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';

                    $('.child-replies-for-'+submit.parent).append(html);
                }
            });
        });

        $(document).on('click', '.submit-ask-child-reply', function(e) {
            e.preventDefault();

            var parent = $(this).data('parent'),
                id = $(this).data('id'),
                submit = {
                    ask_id: $(this).data('askid'),
                    parent: parent,
                    reply: $(this).data('replyto'),
                    ask_subject: $('#child-subject-ask-'+id).val(),
                    ask_body: $('#child-comment-ask-'+id).val(),
                    source: 'expert',
                    expert_type: '<?= $expert_type; ?>'
                };

            $.post(SITE_URL+'smart-consultation/post-ask-comment', $.extend(tokens, submit), function(result) {
                var json = JSON.parse(result);

                if (json.status) {
                    var html =  '<div class="com">'+
                                    '<div class="com-wrap">'+
                                        '<div class="profile">'+
                                            '<div class="ava">'+
                                                '<img src="'+json.content.photo_profile+'" alt="">'+
                                            '</div>'+
                                            '<div class="name"><strong>By: </strong> '+json.content.first_name+' '+json.content.last_name+'</div>'+
                                        '</div>'+
                                        '<h5 class="com-subject"><strong>Subject: </strong> '+json.content.subject+'</h5>'+
                                        '<div class="com-isi">'+
                                            '<strong>Comment: </strong><p>'+json.content.comments+'</p>'+
                                        '</div>'+
                                        '<div class="com-info"><button class="btn btn-link reply-child-comment-sc reply-child-comment-sc-'+json.content.comments_id+'" data-id="'+json.content.comments_id+'" data-type="reply">Reply</button></div>'+
                                        '<div class="com-form">'+
                                            '<div class="form-group form-reply-child-ask-'+json.content.comments_id+'" style="display: none;">'+
                                                '<input type="text" id="child-subject-ask-'+json.content.comments_id+'" class="form-control" placeholder="Subject">'+
                                            '</div>'+
                                            '<div class="form-group form-reply-child-ask-'+json.content.comments_id+'" style="display: none;">'+
                                                '<textarea id="child-comment-ask-'+json.content.comments_id+'" rows="4" class="form-control" placeholder="Write your comments..."></textarea>'+
                                            '</div>'+
                                            '<div class="form-group form-reply-child-ask-'+json.content.comments_id+'" style="display: none;">'+
                                                '<button class="btn btn-link btn-capital submit-ask-child-reply" data-id="'+json.content.comments_id+'" data-type="create" data-askid="'+submit.ask_id+'" data-parent="'+submit.parent+'" data-replyto="'+json.content.user_id+'">Submit the comment <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';

                    $('.child-replies-for-'+submit.parent).append(html);
                }
            });
        });

        $('body').on('click', '.expert-vaccine-setkid', function (e) {
            _askuser = e.currentTarget.dataset.askuser;
            _askchild = e.currentTarget.dataset.askchild;
            $.ajax({
                type: "POST",
                url: SITE_URL+'vaksin-tools/setkidexpert',
                data: $.extend({
                    askuser: _askuser,
                    askchild: _askchild,
                }, tokens),
                dataType: 'json',
                success: function(res){
                    // window.location.href = res.url;
                    win = window.open(res.url, '_blank');
                    win.focus();
                },
            });
            e.preventDefault();
        });
    });

    function load_more_asks_expert(submit) {
        var html = ''
            current_page = submit.page;

        $.ajax({
            type: 'POST',
            url: SITE_URL+'load-more-asks',
            dataType: 'json',
            data: $.extend(tokens, submit),
            beforeSend: function() {
                $('.loader').show();
            },
            success: function(result) {
                tmlft();

                if (result.status) {
                    $('#current_page').val(result.page);
                    $('#total_data').val(result.total);

                    for (var i = 0; i < result.data.length; i++) {
                        var url = SITE_URL+'smart-consultation/'+result.data[i].speciality_slug+'/'+result.data[i].ask_slug;
                        var wa = 'whatsapp://send?text='+result.data[i].ask_subject+' '+url;
                        var desc = result.data[i].answer_value ? result.data[i].answer_value : '';
                        var img = SITE_URL+result.data[i].doctor_image;
                        var type = result.data[i].answer_status == 'unpublish' ? 'create' : 'update';

                        html += '<div class="atc">'+
                                    '<div class="a-info">'+
                                        '<h3 class="a-title">'+result.data[i].ask_subject+'</h3>'+
                                        '<p class="a-author">By: <strong>'+result.data[i].display_name+'</strong></p>'+
                                        '<div class="nav-social">'+
                                            '<span>Bagikan </span>'+
                                            '<a href="javascript:void();" class="btn btn-facebook share-to-fb" data-url="'+url+'" data-title="'+result.data[i].ask_subject+'" data-description="'+result.data[i].ask_value+'" data-image="'+img+'"><i class="fa-facebook" aria-hidden="true"></i><span class="sr-only">Facebook</span></a>&nbsp;'+
                                            '<a href="javascript:void();" class="btn btn-twitter share-to-tw" data-url="'+url+'" data-description="'+result.data[i].ask_value+'"><i class="fa-twitter" aria-hidden="true"></i><span class="sr-only">Twitter</span></a>&nbsp;'+
                                            '<a href="'+wa+'" class="btn btn-whatsapp"><i class="fa-whatsapp" aria-hidden="true"></i><span class="sr-only">Twitter</span></a>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="a-content"><strong>Detail: </strong> '+result.data[i].ask_value+'</div>'+
                                    '<div class="a-content">';

                            if (result.data[i].answer_status == 'publish') {
                                html += '<div id="answer-ask-'+result.data[i].ask_id+'"><strong>Jawaban: </strong> '+desc+'</div>'+
                                        '<a href="javascript:void();" class="edit-answer-sc edit-answer-sc-'+result.data[i].ask_id+'" data-id="'+result.data[i].ask_id+'" data-answer="'+desc+'">Edit</a> | '+
                                        '<a href="javascript:void();" class="new-answer-sc new-answer-sc-'+result.data[i].ask_id+'" data-id="'+result.data[i].ask_id+'" data-answer="">New</a>';
                            }

                        html +=     '</div>'+
                                    '<div class="expert-answer">'+
                                        '<div class="form-group" style="display: none;">'+
                                            '<input type="text" id="subject-ask-'+result.data[i].ask_id+'" class="form-control" placeholder="Subject">'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<textarea id="comment-ask-'+result.data[i].ask_id+'" rows="4" class="form-control" placeholder="Write your comments..."></textarea>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<button class="btn btn-link btn-capital submit-ask-comment" data-id="'+result.data[i].ask_id+'" data-type="'+type+'">Submit the comment <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="comments">'+
                                        '<h4 class="page-subtitle mb-2">Komentar</h4>'+
                                        '<div class="comment hasReplies replies-for-'+result.data[i].ask_id+'">';

                        if (typeof result.data[i].comments != 'undefined') {
                            for (var j = 0; j < result.data[i].comments; i++) {
                                var comment = result.data[i].comments[j];
                                var comment_counts = comment.child ? comment.child.length : 0;

                                if (comment.ask_id && comment.ask_id == result.data[i].ask_id) {
                                html += '<div class="com">'+
                                            '<div class="com-wrap">'+
                                                '<div class="profile">'+
                                                    '<div class="ava">'+
                                                        '<img src="'+comment.photo_profile+'" alt="">'+
                                                    '</div>'+
                                                    '<div class="name"><strong>By: </strong> '+comment.first_name+' '+comment.last_name+'</div>'+
                                                '</div>'+
                                                '<h5 class="com-subject"><strong>Subject: </strong> '+comment.subject+'</h5>'+
                                                '<div class="com-isi">'+
                                                    '<strong>Comment: </strong><p>'+comment.comments+'</p>'+
                                                '</div>'+
                                                '<div class="com-info">'+comment_counts+' Replies <button class="btn btn-link reply-comment-sc reply-comment-sc-'+comment.comments_id+'" data-id="'+comment.comments_id+'" data-type="reply">Reply</button></div>'+
                                                '<div class="com-form">'+
                                                    '<div class="form-group form-reply-ask-'+comment.comments_id+'" style="display: none;">'+
                                                        '<input type="text" id="subject-ask-'+comment.comments_id+'" class="form-control" placeholder="Subject">'+
                                                    '</div>'+
                                                    '<div class="form-group form-reply-ask-'+comment.comments_id+'" style="display: none;">'+
                                                        '<textarea id="comment-ask-'+comment.comments_id+'" rows="4" class="form-control" placeholder="Write your comments..."></textarea>'+
                                                    '</div>'+
                                                    '<div class="form-group form-reply-ask-'+comment.comments_id+'" style="display: none;">'+
                                                        '<button class="btn btn-link btn-capital submit-ask-reply" data-id="'+comment.comments_id+'" data-type="create" data-askid="'+result.data[i].ask_id+'" data-parent="'+comment.comments_id+'" data-replyto="'+comment.user_id+'">Submit the comment <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="replies child-replies-for-'+comment.comments_id+'">';

                                    if (comment_counts > 0) {
                                        for (var k = 0; k < comment_counts; i++) {
                                            var child = comment.child[k];

                                            html += '<div class="com">'+
                                                        '<div class="com-wrap">'+
                                                            '<div class="profile">'+
                                                                '<div class="ava">'+
                                                                    '<img src="'+child.photo_profile+'" alt="">'+
                                                                '</div>'+
                                                                '<div class="name"><strong>By: </strong> '+child.first_name+' '+child.last_name+'</div>'+
                                                            '</div>'+
                                                            '<h5 class="com-subject"><strong>Subject: </strong> '+child.subject+'</h5>'+
                                                            '<div class="com-isi">'+
                                                                '<strong>Comment: </strong><p>'+child.comments+'</p>'+
                                                            '</div>'+
                                                            '<div class="com-info"><button class="btn btn-link reply-child-comment-sc reply-child-comment-sc-'+child.comments_id+'" data-id="'+child.comments_id+'" data-type="reply">Reply</button></div>'+
                                                            '<div class="com-form">'+
                                                                '<div class="form-group form-reply-child-ask-'+child.comments_id+'" style="display: none;">'+
                                                                    '<input type="text" id="child-subject-ask-'+child.comments_id+'" class="form-control" placeholder="Subject">'+
                                                                '</div>'+
                                                                '<div class="form-group form-reply-child-ask-'+child.comments_id+'" style="display: none;">'+
                                                                    '<textarea id="child-comment-ask-'+child.comments_id+'" rows="4" class="form-control" placeholder="Write your comments..."></textarea>'+
                                                                '</div>'+
                                                                '<div class="form-group form-reply-child-ask-'+child.comments_id+'" style="display: none;">'+
                                                                    '<button class="btn btn-link btn-capital submit-ask-child-reply" data-id="'+child.comments_id+'" data-type="create" data-askid="'+result.data[i].ask_id+'" data-parent="'+comment.comments_id+'" data-replyto="'+child.user_id+'">Submit the comment <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button>'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>';
                                        }
                                    }

                                    html += '</div>';
                                }
                            }
                        }

                        html += '</div>'+
                            '</div>'+
                        '</div>';
                    }

                    if (current_page == 1) {
                        $('#asks-data-holder').html(html);
                    } else {
                        $('#asks-data-holder').append(html);
                    }

                    if (result.total == 0) {
                        $('#load-more-asks').hide();
                    }
                }
            },
            complete: function() {
                $('.loader').hide();
            }
        });
    }
</script>
