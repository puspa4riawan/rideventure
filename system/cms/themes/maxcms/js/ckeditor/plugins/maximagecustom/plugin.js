(function(siteUrl, baseUrl)
{

function maximagecustom_onclick(e)
{
    update_instance();
    // run when max button is clicked]
    CKEDITOR.currentInstance.openDialog('maximagecustom_dialog');
}


CKEDITOR.plugins.add('maximagecustom',
{    
    init : function(editor)
    {
		CKEDITOR.dialog.add( 'maximagecustom_dialog', function( api )
		{
			// CKEDITOR.dialog.definition
			var dialogDefinition =
			{
				title : 'Image Upload',
				minWidth : 390,
				minHeight : 130,
				contents : [
					{
						id : 'tab1',
						label : 'Label',
						title : 'Title',
						expand : true,
						padding : 0,
						elements :
						[		
							{
								type: 'text',
								id: 'customImageTitle',
								label: 'Image title',								
								validate: function() {
									if ( !this.getValue()) {
										//api.openMsgDialog( 'title value is required' );
										alert( 'title value is required' );
										return false;
									}
								}
							},
							{
								type : 'html',
								html : '<br><label>Select file from your computer</label><div><input type="file" name="custom_image" id="customImage" accept="image/*" style="margin-top:0"></div>'
							},
							/* {
								type: 'file',
								id: 'customImageFile',
								label: 'Select file from your computer',
								validate: function() {
									console.log($(this)[0].files);
									return false;
									var val = $(this)[0].files[0];									
									if ( !val) {
										//api.openMsgDialog( 'title value is required' );
										alert( 'image value is required' );
										return false;
									}
								}								
							}, */						
							/* {
								type : 'html',
								html : '<label>Title</label><div><input type="text" name="custom_title" id="customTitle"></div>'
							}, */																						
						]
					}
				],
				buttons : [ CKEDITOR.dialog.okButton, CKEDITOR.dialog.cancelButton ],
				onOk : function() {
					var inputCustom = this.getContentElement( 'tab1', 'customImageTitle' );					
					var file = $('input[name="custom_image"]')[0].files[0];					
					var formData = new FormData();    					
					formData.append('csrf_hash_name', tokens.csrf_hash_name);
					formData.append('title', inputCustom.getValue());
					formData.append("userfile", file);

					$.ajax({
						url: ADMIN_URL + '/article/upload_custom',
						type: 'POST',
						data: formData,
						contentType: false,
						processData:false,
						dataType: 'json',
						beforeSend: function(){     							
						},
						complete: function(){							
						},
						success: function(result, status, xhr){    
							console.log(result);
							if(!result.status){
								alert(result.message);
								return false;
							}else{								
								console.log(result.result.element);
								editor.insertHtml(result.result.element);
							}
						},
						error: function(xhr, ajaxOptions, thrownError){
						var spesificError = '';
						try{
							spesificError = xhr.responseJSON.errors[0].message;  
						}catch(e){
							console.log("Error Exception: ",e);
						}                   
							alert('Error upload image. ' + thrownError + ': ' + spesificError);						
							return false;
						}
					});					
				}
			};

			return dialogDefinition;
		} );
        editor.addCommand('maximagecustom', {exec:maximagecustom_onclick});
        editor.ui.addButton('maximagecustom',{ label:'Upload images from library', command:'maximagecustom', icon:this.path+'images/icon.png' });
		
	},
});

})(SITE_URL,BASE_URL);