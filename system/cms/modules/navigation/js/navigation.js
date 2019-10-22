(function($) {

	$(function() {

		// generate a slug for new navigation groups
		max.generate_slug('input[name="title"]', 'input[name="abbrev"]');

		var open_sections = $.cookie('nav_groups');
		
		if (open_sections) {
			$('section[rel="'+open_sections+'"] .item').slideDown(200).removeClass('collapsed');
		} else {
			// show the first box with js to get around page jump
			$('.box .item:first').slideDown(200).removeClass('collapsed');			
		}
		
		// show and hide the sections
		$('.box .title').click(function(){
			window.scrollTo(0, 0);
			if ($(this).next('section.item').hasClass('collapsed')) {
				$('.box .item').slideUp(200).addClass('collapsed');
				$.cookie('nav_groups', $(this).parents('.box').attr('rel'), { expires: 1, path: window.location.pathname });
				$(this).next('section.collapsed').slideDown(200).removeClass('collapsed');
			}
		});

		// load edit via ajax
		$('a.ajax').live('click', function(){
			// make sure we load it into the right one
			var id = $(this).attr('rel');
			if ($(this).hasClass('add')) {
				// if we're creating a new one remove the selected icon from link in the tree
				$('.group-'+ id +' #link-list a').removeClass('selected');
			}
			// Load the form
			$('div#link-details.group-'+ id +'').load($(this).attr('href'), '', function(){
				$('div#link-details.group-'+ id +'').fadeIn();
				// display the create/edit title in the header
				var title = $('#title-value-'+id).html();
				$('section.box .title h4.group-title-'+id).html(title);
				
				// Update Chosen
				max.chosen();
			});
			return false;
		});

		// submit create form via ajax
		$('#nav-create button:submit').live('click', function(e){
			e.preventDefault();
			$.post(SITE_URL + ADMIN_URL + '/navigation/create', $('#nav-create').serialize(), function(message){

				// if message is simply "success" then it's a go. Refresh!
				if (message == 'success') {
					window.location.href = window.location
				}
				else {
					$('.notification').remove();
					$('div#content-body').prepend(message);
					// Fade in the notifications
					$(".notification").fadeIn("slow");
				}
			});
		});

		// submit edit form via ajax
		$('#nav-edit button:submit').live('click', function(e){
			e.preventDefault();
			$.post(SITE_URL + ADMIN_URL + '/navigation/edit/' + $('input[name="link_id"]').val(), $('#nav-edit').serialize(), function(message){

				// if message is simply "success" then it's a go. Refresh!
				if (message == 'success') {
					window.location.href = window.location
				}
				else {
					$('.notification').remove();
					$('div#content-body').prepend(message);
					// Fade in the notifications
					$(".notification").fadeIn("slow");
				}
			});

		});

		// Pick a rule type, show the correct field
		$('input[name="link_type"]').live('change', function(){
			$(this).parents('ul').find('#navigation-' + $(this).val())

			// Show only the selected type
			.show().siblings().hide()

			// Reset values when switched
			.find('input:not([value="http://"]), select').val('');

		// Trigger default checked
		}).filter(':checked').change();

		// show link details
		$('#link-list li a').livequery('click', function()
		{
			var id = $(this).attr('rel');
			link_id = $(this).attr('alt');
			$('.group-'+ id +' #link-list a').removeClass('selected');
			$(this).addClass('selected');

			// Load the details box in
			$('div#link-details.group-'+ id +'').load(SITE_URL + ADMIN_URL + '/navigation/ajax_link_details/' + link_id, '', function(){
				$('div#link-details.group-'+ id +'').fadeIn();
			});
			// Remove the title from the form pane.
			$('section.box .title h4.group-title-'+id).html('');

			return false;
		});
		
		$('.box:visible ul.sortable').livequery(function(){
			$item_list		= $(this);
			$url			= ADMIN_URL+'/navigation/order';
			$cookie			= 'open_links';
			$data_callback	= function(event, ui) {
				// Grab the group id so we can update the right links
				return { 'group' : ui.item.parents('section.box').attr('rel') };
			}
			// $post_callback is available but not needed here
			
			// Get sortified
			max.sort_tree($item_list, $url, $cookie, $data_callback);
		});

		$('body').on('keyup', '#article_title', function(event) {
			$('#article-list').hide();
			_articletitle 	=  $(this).val();
			_uriarticle 	= SITE_URL+ADMIN_URL+'/navigation/getarticle';

			$.ajax({
				url: _uriarticle,
				type: 'post',
				data: $.extend(tokens,{
					   title_article:_articletitle,
				}),
				dataType: 'json',
				success: function(json) {
					tmlft();
					if(json['status']==true) {
						_html = '';
						$.each(json['article'], function (index, value) {
							_html += '<li class="article-data" id="article-data">'+
										'<a href="javascript:void(0);" class="article-item" data-articleid="smart-stories/'+index+'" data-articletitle="'+value+'">'+value+'</a>'+
									'</li>';
						});

						$('#article-list').empty();
						$('#article-list').append(_html);
						$('#article-list').show();
					} else {
						$('#article-list').empty();
						$('#article-list').append('No data found!');
						$('#article-list').show();
					}
				}
			});
			event.preventDefault();
		});

		$('body').on('click', '.article-item', function(event) {
			_articleid = $(this).attr('data-articleid');
			_articletitle = $(this).attr('data-articletitle');
			$('#article').val(_articleid);
			$('#article_title').val(_articletitle);
			$('input[name="title"]').val(_articletitle);
			$('#article-list').hide();
			event.preventDefault();
		});

	});

})(jQuery);
