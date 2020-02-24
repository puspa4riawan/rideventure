var CKEDITOR = window.parent.CKEDITOR;
var img_float;
function insertImage(file, alt, location, path)
{
	/*if(replace_html)
	{
		replace_html.remove();
	}*/
	var img_width = document.getElementById('insert_width').value;
		img_width = ! isNaN(img_width) ? img_width : 0;

	if (location == 'local') {//
		//path = '{{ url:site }}files/' + (img_width > 0 ? 'thumb/' + file + '/' + img_width : 'large/' + file);
		path = window.parent.SITE_URL+'files/' + (img_width > 0 ? 'thumb/' + file + '/' + img_width : 'large/' + file);
	}
	
	// don't display a width="0" tag
	var width_tag	= (img_width > 0 ? 'width="'+img_width+'"' : '');
	/*var img_float 	= $('input[name=insert_float]:checked').val();
	var float_tag 	= (img_float !== 'none' ? 'style="float:'+img_float+'"' : '');
	
	window.parent.instance.insertHtml('<img class="pyro-image alignment-'+img_float+'" '+width_tag+' '+float_tag+' src="'+path+'" alt="' + alt + '" />');*/
   	btnChange = '<div id="button_image_wrap" style="float:right;padding-right:40%;" ><button class="btn blue"onclick="$.colorbox({href:SITE_URL + \'admin/instructor/image/index/\',height:500,width:800,iframe:true,inline:true});return false;">Change</button><button class="btn blue" onclick="$(\'#trainer_image\').val(\'\'); $(this).parents(\'.wrap_large_image\').replaceWith(window.tmpFileUpload); return false;">Delete</button></div><input type="hidden" id="trainer_image" name="trainer_image" value="'+file+'">';
	  if (window.parent.jQuery('.form_inputs li label[for="image"]').parent().children().last().attr('class') == 'input')
	  {
	  	window.parent.tmpFileUpload = window.parent.jQuery('.form_inputs li label[for="image"]').parent().children().last();
	  }
   window.parent.jQuery('.form_inputs li label[for="image"]').parent().children().last().replaceWith('<div class="wrap_large_image"><img class="pyro-image" '+width_tag+'  src="'+path+'" alt="' + alt + '" />'+btnChange+'</div>');
   window.parent.jQuery.colorbox.close();
}

function insertImageBanner(file, alt, location, path)
{
	/*if(replace_html)
	{
		replace_html.remove();
	}*/
	var img_width = document.getElementById('insert_width').value;
		img_width = ! isNaN(img_width) ? img_width : 0;

	if (location == 'local') {//
		//path = '{{ url:site }}files/' + (img_width > 0 ? 'thumb/' + file + '/' + img_width : 'large/' + file);
		path = window.parent.SITE_URL+'files/' + (img_width > 0 ? 'thumb/' + file + '/' + img_width : 'large/' + file);
	}
	
	// don't display a width="0" tag
	var width_tag	= (img_width > 0 ? 'width="'+img_width+'"' : '');
	/*var img_float 	= $('input[name=insert_float]:checked').val();
	var float_tag 	= (img_float !== 'none' ? 'style="float:'+img_float+'"' : '');
	
	window.parent.instance.insertHtml('<img class="pyro-image alignment-'+img_float+'" '+width_tag+' '+float_tag+' src="'+path+'" alt="' + alt + '" />');*/
   	btnChange = '<div id="button_image_wrap" style="float:right;padding-right:40%;" ><button class="btn blue"onclick="$.colorbox({href:SITE_URL + \'admin/instructor/image/index/banner_image\',height:500,width:800,iframe:true,inline:true});return false;">Change</button><button class="btn blue" onclick="$(\'#banner_image\').val(\'\'); $(this).parents(\'.wrap_large_image\').replaceWith(window.tmpFileUploadBanner); return false;">Delete</button></div><input type="hidden" id="banner_image" name="banner_image" value="'+file+'">';
	  if (window.parent.jQuery('.form_inputs li label[for="banner_image"]').parent().children().last().attr('class') == 'input')
	  {
	  	window.parent.tmpFileUploadBanner = window.parent.jQuery('.form_inputs li label[for="banner_image"]').parent().children().last();
	  }
   window.parent.jQuery('.form_inputs li label[for="banner_image"]').parent().children().last().replaceWith('<div class="wrap_large_image"><img class="pyro-image" '+width_tag+'  src="'+path+'" alt="' + alt + '" />'+btnChange+'</div>');
   window.parent.jQuery.colorbox.close();
}

function insertFile(id, title, location, path)
{
	if (location == 'local') {
		var path = '{{ url:site }}files/download/' + id;
	}

	if(replace_html)
	{
		replace_html.remove();
	}
	window.parent.instance.insertHtml('<a class="pyro-file" href="'+path+'">' + title + '</a>');
    windowClose();
}

// By default, insert (which will also replace)
var replace_html = null;

$(function()
{ 
	function detectFile()
	{
		// Get whatever is selected
		selection = window.parent.instance.getSelection();

		// A Tag has been fuly selected
		if(selection.getSelectedElement())
		{
			element = jQuery( selection.getSelectedElement().$ );
		}

		// If the cursor is anywhere in the textbox
		else(selection.getRanges()[ 0 ])
		{
			// Find the range of the selection
			range = selection.getRanges()[ 0 ];
			range.shrink( CKEDITOR.SHRINK_TEXT );

			// Have they clicked inside an <img> tag?
			maybe_element = range.getCommonAncestor().getAscendant( 'img', true );

			if(!maybe_element) return false;
			else element = jQuery(maybe_element.$);

			// Save this HTML to be replaced up update
			replace_html = maybe_element;
		}

		if( ! element.hasClass('pyro-image')) return false;

		$('#current_document').load(SITE_URL + 'admin/wysiwyg/files/ajax_get_file', {
			doc_id: element.attr('href').match(/\/download\/([0-9]+)/)[1]
		});

		return true;
	}

	//detectFile() || $('#current_document h2').hide();
	
    //tooltip
	$('#images-container img').hover( function() {
	    $(this).attr('title', 'Click to insert image');
	});
	
    
    /**
     * left files navigation handler
     *  - handles loading of different folders
     *  - manipulates dom classes etc
     */
    $('#files-nav li a').live('click', function(e) {
        
        e.preventDefault();
        
        var href_val = $(this).attr('href');
        
        //remove existing 'current' classes
        $('#files-nav li').removeClass('current');
        
        //add class to click anchor parent
        $(this).parent('li').addClass('current');
		
		//remove any notifications
		$( 'div.notification' ).fadeOut('fast');
        
		if ($(this).attr('title') != 'upload')
		{
			$('#files_right_pane').load(href_val + ' #files-wrapper', function() {
				$(this).children().fadeIn('slow');
			});
		}
		else
		{
			var box = $('#upload-box');
			if (box.is( ":visible" ))
			{
				// Hide - slide up.
				box.fadeOut( 200 );
			}
			else
			{
				// Show - slide down.
				box.fadeIn( 200 );
				 
			}
		}
    });
	
	$( '#upload-box span.close, #upload-box a.cancel' ).on('click', function(e) {
		e.preventDefault();
		  $('#files-nav li').removeClass('current');
        $('#files-nav li').first().addClass('current');
		$( '#upload-box' ).fadeOut( 200, function() {
			$(this).find('input[type=text], input[type=file]').val('');
		});
		
	});
    
    $('select[name=parent_id]').live('change', function() {
        var folder_id = $(this).val();
		var controller = $(this).attr('title');
        var href_val = SITE_URL + 'admin/wysiwyg/' + controller + '/index/' + folder_id;
        $('#files_right_pane').load(href_val + ' #files-wrapper', function() {
			$(this).children().fadeIn('slow');
			var class_exists = $('#folder-id-' + folder_id).html();
			$( 'div.notification' ).fadeOut('fast');
			if(class_exists !== null)
			{
				$('#files-nav li').removeClass('current');
				$('li#folder-id-'+folder_id).addClass('current'); 
			}
			  
        });
    })
    
    //slider
   
    $('#slider').livequery(function() {
		$(this).fadeIn('slow');
		$(this).slider({
			value: 0,
			min: 0,
			max: 1000,
			step: 1,
			slide: function( event, ui ) {
				if (ui.value > 0) {
					$('#insert_width').val(ui.value);
				} else {
					$('#insert_width').val( $('#insert_width').attr('data-name') );
				}
			}
		});

		$('#insert_width').val( $('#insert_width').attr('data-name') );
    });
    
	$('#radio-group').livequery(function(){
		$(this).children('.set').buttonset();
		$(this).fadeIn('slow');
	});

	$( '#files_right_pane' ).livequery(function() {
		$(this).children().fadeIn('slow');
		$('#upload-box').hide();
	});
	
	// Add the close link to all alert boxes
	$('.alert').livequery(function(){
		$(this).prepend('<a href="#" class="close">x</a>');
	});

	// Close the notifications when the close link is clicked
	$('a.close').live('click', function(e){
		e.preventDefault();
		$(this).fadeTo(200, 0); // This is a hack so that the close link fades out in IE
		$(this).parent().fadeTo(200, 0);
		$(this).parent().slideUp(400, function(){
			$(window).trigger('notification-closed');
			$(this).remove();
		});
	});
	
	//baru
	$('input[name="userfile"]').live('change',function(e)
	{
		$('#upload-box input[name="name"]').val($(this).val().substr(0,$(this).val().indexOf('.',-1)));
		console.debug('nilai name',$('#upload-box input[name="name"]').val());
	});
	/*$('a[title="upload"]').click(function(e){
		e.preventDefault();
		console.log($.colorbox.element());
		$.colorbox.element().find('#upload-box').show();
	});*/
	
});