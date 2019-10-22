<section class="title">
	<?php if ($this->method == 'create'): ?>
		<h4><?php echo lang('pages:create_title') ?></h4>
	<?php else: ?>
		<h4><?php echo sprintf(lang('pages:edit_title'), $page->title) ?></h4>
	<?php endif ?>
</section>

<section class="item">
	<div class="content">

		<?php $parent = ($parent_id) ? '&parent='.$parent_id : null ?>
	
		<?php echo form_open_multipart(uri_string().'?page_type='.$this->input->get('page_type').$parent, 'id="page-form" data-mode="'.$this->method.'"') ?>
		<?php echo form_hidden('parent_id', empty($page->parent_id) ? 0 : $page->parent_id) ?>
	
		<div class="tabs">
	
			<ul class="tab-menu">
				<li><a href="#page-details"><span><?php echo lang('pages:details_label') ?></span></a></li>
				<?php if ($stream_fields): ?><li><a href="#page-content"><span><?php if ($page_type->content_label): echo lang_label($page_type->content_label); else: echo lang('pages:content_label'); endif ?></span></a></li><?php endif ?>
				<li><a href="#page-tabcontent"><span><?php echo lang('pages:tabcontent_content') ?></span></a></li>
				<li><a href="#page-meta"><span><?php echo lang('pages:meta_label') ?></span></a></li>
				<li><a href="#page-design"><span><?php echo lang('pages:css_label') ?></span></a></li>
				<li><a href="#page-script"><span><?php echo lang('pages:script_label') ?></span></a></li>
				<li><a href="#page-options"><span><?php echo lang('pages:options_label') ?></span></a></li>
			</ul>
	
			<div class="form_inputs" id="page-details">
	
				<fieldset>
			
				<ul>
					
					<li>
						<label for="title"><?php if ($page_type->title_label): echo lang_label($page_type->title_label); else: echo lang('global:title'); endif ?> <span>*</span></label>
						<div class="input"><?php echo form_input('title', $page->title, 'id="title" maxlength="60"') ?></div>
					</li>
					
					<li>
						<label for="slug"><?php echo lang('global:slug') ?>  <span>*</span></label>
						
						<div class="input">
						<?php if ( ! empty($page->parent_id)): ?>
							<?php echo site_url($parent_page->uri) ?>/
						<?php else: ?>
							<?php echo site_url() . (config_item('index_page') ? '/' : '') ?>
						<?php endif ?>
	
						<?php if ($this->method == 'edit'): ?>
							<?php echo form_hidden('old_slug', $page->slug) ?>
						<?php endif ?>
	
						<?php if (in_array($page->slug, array('home', '404'))): ?>
							<?php echo form_hidden('slug', $page->slug) ?>
							<?php echo form_input('', $page->slug, 'id="slug" size="20" disabled="disabled"') ?>
						<?php else: ?>
							<?php echo form_input('slug', $page->slug, 'id="slug" size="20" class="'.($this->method == 'edit' ? ' disabled' : '').'"') ?>
						<?php endif ?>
	
						<?php echo config_item('url_suffix') ?>
						
						</div>
					</li>
					
					<li>
						<label for="category_id"><?php echo lang('pages:status_label') ?></label>
						<div class="input"><?php echo form_dropdown('status', array('draft'=>lang('pages:draft_label'), 'live'=>lang('pages:live_label')), $page->status, 'id="category_id"') ?></div>
					</li>

					<li>
						<label for="show_ontab">Show on page tab</label>
						<div class="input"><?php echo form_dropdown('show_ontab', array(0=>'No', 1=>'Show'), $page->show_ontab, 'id="show_ontab"') ?></div>
					</li>
					
					
				</ul>
	
				</fieldset>
	
			</div>
	
			<?php if ($stream_fields): ?>
			
			<!-- Content tab -->
			<div class="form_inputs" id="page-content">
		
				<fieldset>
	
				<ul>
					
					<?php foreach ($stream_fields as $field) echo $this->load->view('admin/partials/streams/form_single_display', array('field' => $field), true) ?>
					
				</ul>
	
				</fieldset>
			
			</div>
	
			<?php endif ?>

			<!-- Tab content data -->
			<div class="form_inputs" id="page-tabcontent">
			
				<fieldset>
					<?php
					$fdata_row = 0;
					if (!empty($tabcontent['content'])) {
						foreach ($tabcontent['content'] as $tabcontent_item) {
					?>
					<fieldset class="tabcontent-fieldset" id="tabcontent-<?=$fdata_row;?>">
						<ul>
							<input type="hidden" name="tabcontent_id[<?=$fdata_row;?>]" value="<?=$tabcontent_item['id'];?>" />
							<li>
								<label for="order"><?php echo lang('pages:tabcontent_item_title') ?></label>
								<div class="input"><?php echo form_input('item_title['.$fdata_row.']', $tabcontent_item['item_title'], 'id="item-title'.$fdata_row.'" maxlength="200"') ?></div>
							</li>
							<li>
								<label for="order"><?php echo lang('pages:tabcontent_item_content') ?></label>
								<?php echo form_textarea(array('name' => 'item_content['.$fdata_row.']', 'value' => $tabcontent_item['item_content'], 'rows' => 5, 'id="item-content'.$fdata_row.'"')) ?>
							</li>
							<li>
	                            <label for="map_desc"><?php echo lang('pages:tabcontent_contnet') ?></label> 
	                            <div class="input scrollbox" id="content<?=$fdata_row;?>" data-count="0">
	                            	<?php if (isset($tabcontent_item['content']) and is_array($tabcontent_item['content'])) { ?>
	                            	<ul class="tabcontent-data">
	                            		<?php 
	                            		$item = 0;
	                            		foreach ($tabcontent_item['content'] as $content) { ?>
	                            		<li class="tabcontent-item">
	                            			<input type="checkbox" class="content-item content-item<?=$fdata_row;?>" data-item-row="<?=$fdata_row;?>" name="content_id[<?=$fdata_row;?>][<?=$item;?>]" value="<?=$content['qa_id'];?>" <?php echo ($content['checked']==1) ? 'checked':'';?>>&nbsp;&nbsp;
	                            			<label><?=$content['question'];?></label>
	                            		</li>
	                            		<?php $item++; } ?>
	                            	</ul>
	                            	<?php } ?>
	                            </div>
	                        </li>
							<li>
								<label for="order"><?php echo lang('pages:tabcontent_order') ?></label>
								<div class="input"><?php echo form_input('order['.$fdata_row.']', $tabcontent_item['order'], 'id="order'.$fdata_row.'" maxlength="60"') ?></div>
							</li>
						</ul>
						<a href="javascript:void(0);" title="Delete Content" class="btn orange delete-content" id="delete-content<?=$fdata_row;?>" data-row="<?=$fdata_row;?>" data-metaid="<?=$tabcontent_item['id'];?>" >Delete Content</a>
					</fieldset>				
					<?php
						$fdata_row++;
						}
					}
					?>
					<a href="javascript:void(0);" title="Edit" class="btn green" id="add-content" data-row="<?=$fdata_row;?>">Add Content</a>
				</fieldset>
	
			</div>
	
			<!-- Meta data tab -->
			<div class="form_inputs" id="page-meta">
			
				<fieldset>
			
				<ul>
					<li>
						<label for="meta_title"><?php echo lang('pages:meta_title_label') ?></label>
						<div class="input"><input type="text" id="meta_title" name="meta_title" maxlength="255" value="<?php echo $page->meta_title ?>" /></div>
					</li>
									
					<?php if ( ! module_enabled('keywords')): ?>
						<?php echo form_hidden('keywords'); ?>
					<?php else: ?>
						<li>
							<label for="meta_keywords"><?php echo lang('pages:meta_keywords_label') ?></label>
							<div class="input"><input type="text" id="meta_keywords" name="meta_keywords" maxlength="255" value="<?php echo $page->meta_keywords ?>" /></div>
						</li>
					<?php endif; ?>
						<li>
							<label for="meta_robots_no_index"><?php echo lang('pages:meta_robots_no_index_label') ?></label>
							<div class="input"><?php echo form_checkbox('meta_robots_no_index', true, $page->meta_robots_no_index == true, 'id="meta_robots_no_index"') ?></div>
						</li>

						<li>
							<label for="meta_robots_no_follow"><?php echo lang('pages:meta_robots_no_follow_label') ?></label>
							<div class="input"><?php echo form_checkbox('meta_robots_no_follow', true, $page->meta_robots_no_follow == true, 'id="meta_robots_no_follow"') ?></div>
						</li>
					<li>
						<label for="meta_description"><?php echo lang('pages:meta_desc_label') ?></label>
						<?php echo form_textarea(array('name' => 'meta_description', 'value' => $page->meta_description, 'rows' => 5)) ?>
					</li>
				</ul>
				
				</fieldset>
	
			</div>
	
			<!-- Design tab -->
			<div class="form_inputs" id="page-design">
	
				<fieldset>
				
				<ul>
					<li>
						<label for="css"><?php echo lang('pages:css_label') ?></label><br />
						<div>
							<?php echo form_textarea('css', $page->css, 'class="css_editor"') ?>
						</div>
					</li>
				</ul>
				
				</fieldset>
				
			</div>
	
			<!-- Script tab -->
			<div class="form_inputs" id="page-script">
	
				<fieldset>
	
				<ul>
					<li class="<?php echo alternator('', 'even') ?>">
						<label for="js"><?php echo lang('pages:js_label') ?></label><br />
						<div>
							<?php echo form_textarea('js', $page->js, 'class="js_editor"') ?>
						</div>
					</li>
				</ul>
	
				</fieldset>
	
			</div>
	
			<!-- Options tab -->
			<div class="form_inputs" id="page-options">
	
				<fieldset>
	
				<ul>
					<li>
						<label for="restricted_to[]"><?php echo lang('pages:access_label') ?></label>
						<div class="input"><?php echo form_multiselect('restricted_to[]', array(0 => lang('global:select-any')) + $group_options, $page->restricted_to, 'size="'.(($count = count($group_options)) > 1 ? $count : 2).'"') ?></div>
					</li>
									
					<?php if ( ! module_enabled('comments')): ?>
						<?php echo form_hidden('comments_enabled'); ?>
					<?php else: ?>
						<li>
							<label for="comments_enabled"><?php echo lang('pages:comments_enabled_label') ?></label>
							<div class="input"><?php echo form_checkbox('comments_enabled', true, $page->comments_enabled == true, 'id="comments_enabled"') ?></div>
						</li>
					<?php endif; ?>
									
					<li>
						<label for="rss_enabled"><?php echo lang('pages:rss_enabled_label') ?></label>
						<div class="input"><?php echo form_checkbox('rss_enabled', true, $page->rss_enabled == true, 'id="rss_enabled"') ?></div>
					</li>
									
					<li>
						<label for="is_home"><?php echo lang('pages:is_home_label') ?></label>
						<div class="input"><?php echo form_checkbox('is_home', true, $page->is_home == true, 'id="is_home"') ?></div>
					</li>
	
					<li>
						<label for="strict_uri"><?php echo lang('pages:strict_uri_label') ?></label>
						<div class="input"><?php echo form_checkbox('strict_uri', 1, $page->strict_uri == true, 'id="strict_uri"') ?></div>
					</li>
				</ul>
	
				</fieldset>
	
			</div>
	
		</div>

		<input type="hidden" name="row_edit_id" value="<?php if ($this->method != 'create'): echo $page->entry_id; endif; ?>" />
	
		<div class="buttons align-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )) ?>
		</div>
	
		<?php echo form_close() ?>
	</div>
</section>


<script type="text/javascript">
var label_order = "<?php echo lang('pages:tabcontent_order') ?>";
var label_contentqa = "<?php echo lang('pages:tabcontent_contentqa') ?>";
var label_item_title = "<?php echo lang('pages:tabcontent_item_title') ?>";
var label_item_content = "<?php echo lang('pages:tabcontent_item_content') ?>";
var uri = '<?=ADMIN_URL."/pages/tabcontent_data";?>';
var uri_delete = '<?=ADMIN_URL."/pages/delete_meta";?>';
var qa_list = <?=json_encode($qa_list, JSON_FORCE_OBJECT);?>;
var htmlqa = '';

$(document).ready(function(){
	// console.log('ready');
	$('body').on('click', '#add-content', function(e) {
	// $('#add-content').click(function(e) {
		row=parseInt($('#add-content').attr('data-row'));
		html='';
		prev = '<?=base_url('uploads/default/files/no-available-image.png');?>';
		item_content_list ='';
		item = 0;

		item_content_list += '<ul>';
		$.each(qa_list, function( key, value ) {
	        item_content_list += '<li class="tabcontent-item">';
			item_content_list += '<input type="checkbox" class="content-item content-'+row+' data-item-row="'+row+'" name="content_id['+row+']['+item+']" value="'+value.qa_id+'">&nbsp;&nbsp;';
			item_content_list += '<label>'+value.question+'</label>';
			item_content_list += '</li>';
			item++;
	    });
		item_content_list += '</ul>';
		
		// if (row<5) {
			html += '<fieldset class="tabcontent-fieldset" id="tabcontent-'+row+'">'+
					'<ul>'+
						'<input type="hidden" name="tabcontent_id['+row+']" value="" />'+
						'<li class="editor"> '+
                            '<label for="map_desc">'+label_item_title+'</label> '+
                            '<div class="input">'+
                                '<input type="text" name="item_title['+row+']" maxlength="200" id="item-title'+row+'" class="item-title">'+
                            '</div>'+
                        '</li>'+
                        '<li class="editor"> '+
                            '<label for="map_desc">'+label_item_content+'</label> '+
                            '<div class="input">'+
                                '<textarea name="item_content['+row+']" cols="40" rows="10" class="wysiwyg-advanced" id="item-content'+row+'"></textarea>'+
                            '</div>'+
                        '</li>'+
                        '<li class="editor"> '+
                            '<label for="map_desc">'+label_contentqa+'</label> '+
                            '<div class="input scrollbox" id="content'+row+'" data-count="0">'+
                            item_content_list+
                            '</div>'+
                        '</li>'+
                        '<li class="editor"> '+
                            '<label for="map_desc">'+label_order+'</label> '+
                            '<div class="input">'+
                                '<input type="text" name="order['+row+']" maxlength="100" id="order'+row+'" class="order">'+
                            '</div>'+
                        '</li>'+
					'</ul>'+
					'<a href="javascript:void(0);" title="Delete Content" class="btn orange delete-content" id="delete-content'+row+'" data-row="'+row+'">Delete Content</a>'+
				'</fieldset>';
				$( html ).insertBefore( $('#add-content') );
				row=row+1;
				$('#add-content').attr('data-row',row);
		// } else {
			// return false;
		// }
	});

	$('body').on('click', '.delete-content', function(e) {
		id_meta = $(this).attr('data-metaid');
		id_el = $(this).attr('data-row');
		
		if (id_meta != undefined) {
			if (confirm('Are you sure you want to delete this?')) {
				$.ajax({
					url: uri_delete,
					type: 'post',
					data: $.extend(tokens,{
						   id_meta:id_meta,
					}),
					dataType: 'json',
					success: function(json) {
						if(json['status']==true) {
							$('#tabcontent-'+id_el).remove();
						}
					}
				});
			}
		} else {
			$('#tabcontent-'+id_el).remove();
		}		
	});

	$('body').on('keyup', '.item-id', function(e) {
		section_id = $('#'+e.currentTarget.id).val();
		new_id = convertToSlug(section_id);
		$('#'+e.currentTarget.id).val(new_id);
	});
});

</script>