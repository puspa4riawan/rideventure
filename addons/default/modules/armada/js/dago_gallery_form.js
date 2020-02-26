
//image preview
this.imagePreview = function(){	

	/* CONFIG */
		
		xOffset = 10;
		yOffset = 30;
		
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result
		
	/* END CONFIG */
	$("img.preview").live('mouseenter',function(e){
						this.t = this.title;
						this.title = "";	
						var c = (this.t != "") ? "<br/>" + this.t : "";
						$("body").append("<p id='preview'><img src='"+ $(this).attr('bigsrc') +"' alt='Image preview' />"+ c +"</p>");								 
						$("#preview")
							.css("top",(e.pageY - xOffset) + "px")
							.css("left",(e.pageX + yOffset) + "px")
							.fadeIn("fast");	
					})
					.live('mouseleave',function(e){
						this.title = this.t;	
						$("#preview").remove();
					});
	$("img.preview").live('mousemove',function(e){
		$("#preview")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};

//button delete hover
this.deleteButton = function()
{
	$('ul#tree1 li.item_subcollection>.subcollection,ul#tree1 li.item_category').live('mouseenter',function(e){
	
		if ($(e.target).hasClass('item_category'))
		{
			//console.log('mouse in category');
			//console.log($(e.target).find('> .btn_delete').first());
			$(e.target).find('> .btn_delete').first().show();
			$('li.item_subcollection>a.btn_delete').hide();
		}
		else
		{
			//console.log('mouse in subcollection');
			buttonDelete =$(this).children('a.btn_delete').show();
			$(buttonDelete).show();
		}
		
		
		
		//console.log($(this).find('> .btn_delete').first());
	}).live('mouseleave',function(e)
	{
		//$(this).find('> .btn_delete').first().hidden();
		//console.log($(this).find('> .btn_delete').first());
		//console.log('e target');
		//console.log(e.target);
		$(this).find('> .btn_delete').first().hide();
		//console.log('mouse leave')	
	});
}

this.expandCollapse = function()
{
	$('.subcollection').live('click',function(e)
	{
		if ($(e.target).hasClass('subcollection'))
		{
			//console.log($(this).parents('li:first').find('span:first'));
			$(this).parents('li:first').find('span:first').trigger('click');
		}
	});
}
		
var idImagePicture = false;
var statusConfirm = false;
var onAddImage = false;
var isThumbImage = false;
(function($) {
	$(function(){
		$('.btn_delete').live('click',function(e){
			if ($(this).parent().hasClass('subcollection'))
			{
				$(this).parents('li').remove();
			}
			else
			{
				$(this).parent('li').remove();
			}
			
		});
		imagePreview();
		deleteButton();
		expandCollapse();
	    /*$('img.preview').on('hover',
		function(){
			console.log('dasd6555');
		},function(){
			console.log('dasdd12345');
		});*/
		//console.debug('document di create',funcClose);
		 $(document).bind('cbox_closed',function()
		 { 
		 	if (idImagePicture)
		 	{ 
		 		console.log(isThumbImage);
		 		 if (isThumbImage)
		 		 {
		 		 	
			 		if (currentSubCollection)
			 		{
			 			$(currentSubCollection).val(idImagePicture);
			 			$(currentSubCollection).siblings('button.small_button').last().remove();
			 			if ($(currentSubCollection).siblings('img#img_thumb'))
			 			{
			 				$(currentSubCollection).siblings('img#img_thumb').remove();
			 				$(currentSubCollection).siblings('button#delete_img').remove();
			 				$(currentSubCollection).siblings('button#change_img').remove();
			 				
			 			}
			 			$(currentSubCollection).siblings('button.small_button').last().after('<img id="img_thumb" class="preview" src="'+SITE_URL+'files/thumb/'+idImagePicture+'/20/20" bigsrc="'+SITE_URL+'files/thumb/'+idImagePicture+'/200/200"/><button onclick="addImageThumb(\'subcollection\',this);return false;" id="change_img" class="btn blue small_button">Change</button><button id="delete_img" onclick="$(this).siblings(\'img#img_thumb\').remove();$(this).siblings(\'button#change_img\').removeClass(\'btn\').removeClass(\'blue\').html(\'Thumb Image\');$(this).siblings(\'input#subcollection_thumb_id\').val(\'\');$(this).remove();return false;" class=" btn blue small_button">Delete</button>');
			 			
			 			currentSubCollection =false;
			 		}else if (currentCategory)
			 		{
			 			$(currentCategory).val(idImagePicture);
			 			$(currentCategory).siblings('button.small_button').last().remove();
			 			if ($(currentCategory).siblings('img#img_thumb'))
			 			{
			 				$(currentCategory).siblings('img#img_thumb').remove();
			 				$(currentCategory).siblings('button#delete_img').remove();
			 				$(currentCategory).siblings('button#change_img').remove();
			 				
			 			}
			 			$(currentCategory).siblings('button.small_button').last().after('<img id="img_thumb" class="preview" src="'+SITE_URL+'files/thumb/'+idImagePicture+'/20/20" bigsrc="'+SITE_URL+'files/thumb/'+idImagePicture+'/200/200"/><button onclick="addImageThumb(\'category\',this);return false;" id="change_img" class="btn blue small_button">Change</button><button id="delete_img" onclick="$(this).siblings(\'img#img_thumb\').remove();$(this).siblings(\'button#change_img\').removeClass(\'btn\').removeClass(\'blue\').html(\'Thumb Image\');$(this).siblings(\'input#belong_to_thumb_id\').val(\'\');$(this).remove();return false;" class=" btn blue small_button">Delete</button>');
			 			currentCategory =false;
			 		}
			 		isThumbImage = false;
			 	}
			 	else
			 	{
			 		if (currentSubCollection)
			 		{
			 		$(currentSubCollection).val(idImagePicture);
			 		currentSubCollection =false;
			 		}else if (currentCategory)
			 		{
			 			$(currentCategory).val(idImagePicture);
			 			currentCategory =false;
			 		}
			 	}
		 		
		 		
		 		idImagePicture = false;
		 	}
		 	
		 });
		currentState = $('#default_collection_id').val();
	
		
		
		// generate a slug when the user types a title in
		max.generate_slug('input[name="title"]', 'input[name="slug"]');
				
		// needed so that Keywords can return empty JSON
		$.ajaxSetup({
			allowEmpty: true
		});

		$('#keywords').tagsInput({
			autocomplete_url:SITE_URL + ADMIN_URL +'/keywords/autocomplete'
		});
		
		// editor switcher
		$('select[name^=type]').live('change', function() {
			chunk = $(this).closest('li.editor');
			textarea = $('textarea', chunk);
			
			// Destroy existing WYSIWYG instance
			if (textarea.hasClass('wysiwyg-simple') || textarea.hasClass('wysiwyg-advanced')) 
			{
				textarea.removeClass('wysiwyg-simple');
				textarea.removeClass('wysiwyg-advanced');
					
				var instance = CKEDITOR.instances[textarea.attr('id')];
			    instance && instance.destroy();
			}
			
			
			// Set up the new instance
			textarea.addClass(this.value);
			
			max.init_ckeditor();
			
		});
		
		
		
		
		
		
		$('#menu-content-tab button[name="change_image"]').click(function(e)
		{
			
			/*if (typeof(CKEDITOR.dialog.addIframe) == 'function')
			{
				CKEDITOR.dialog.addIframe('pyroimage_dialog', 'Image', SITE_URL + 'admin/menu/image',800,500)
			}*/
			//console.log(CKEDITOR.dialog);
			//console.log('masuk');
			//alert('test');
			//e.preventDefault();
		});
		
	});
})(jQuery);