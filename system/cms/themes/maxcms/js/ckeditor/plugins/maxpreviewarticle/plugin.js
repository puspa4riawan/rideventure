CKEDITOR.plugins.add('maxpreviewarticle', {
    init: function(editor) {
        CKEDITOR.dialog.add('maxpreviewarticle_dialog', function(api) {
            var dialogDefinition = {
                title: 'Parenting Club Article Helper',
                minWidth: 400,
                minHeight: 200,
                contents: [
                    {
                        id: 'tabPreview',
                        label: 'Preview',
                        title: 'Title',
                        expand: true,
                        padding: 10,
                        elements: [
                            {
                                type: 'select',
                                id: 'tool_id',
                                label: 'Select tool banner',
                                items: tools_items,
                                validate: CKEDITOR.dialog.validate.notEmpty('Field cannot be empty'),
                                onChange: function(api) {
                                    // this = CKEDITOR.ui.dialog.select
                                    // alert('Current value: '+this.getValue());
                                }
                            }
                        ]
                    }
                ],
                buttons: [CKEDITOR.dialog.okButton, CKEDITOR.dialog.cancelButton],
                onOk: function() {
                    // "this" is now a CKEDITOR.dialog object.
                    // Accessing dialog elements:
                    var dialog = this,
                        article_preview = editor.document.createElement('article_preview'),
                        slugObj = this.getContentElement('tabPreview', 'tool_id'),
                        result = '{{ article:tools_section_on_detail tool_title="'+slugObj.getValue()+'" tool_id="'+tools_items_id[slugObj.getValue()]+'" }}';

                    article_preview.setText(result);

                    // ID of textarea
                    // CKEDITOR.instances['body_text'].setData(result);
                    editor.insertElement(article_preview);
                }
            };

            return dialogDefinition;
        });
        editor.addCommand('maxpreviewarticle', {exec: maxpreviewarticle_onclick});
        editor.ui.addButton('maxpreviewarticle', {
            label: 'Parenting Club Article Helper',
            command: 'maxpreviewarticle',
            icon: this.path+'images/icon.png'
        });
    }
});

function maxpreviewarticle_onclick(e) {
    update_instance();
    CKEDITOR.currentInstance.openDialog('maxpreviewarticle_dialog')
}
