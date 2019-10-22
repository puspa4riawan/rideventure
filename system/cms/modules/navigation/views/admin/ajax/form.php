<style type="text/css">
ul#article-list {
	width: 300px;
	max-height: 300px;
	overflow-y: scroll;
	background: #cecece;
	position: absolute;
	z-index: 99;
	display: none;
}
ul#article-list li {
	width: 100%;
	margin: 0px;
	list-style: none;
	padding: 0px !important;
}
ul#article-list li a{
	padding: 3px;
	margin: 2px;
	display: block;
	background: #aeaeae !important;
	border: none;
	color: #000;
}	
</style>

<div id="details-container">
	<?php if ($this->method == 'create'): ?>
		<div class="hidden" id="title-value-<?php echo $link->navigation_group_id ?>">
			<?php echo lang('nav:link_create_title');?>
		</div>
	<?php else: ?>
		<div class="hidden" id="title-value-<?php echo $link->navigation_group_id ?>">
			<?php echo sprintf(lang('nav:link_edit_title'), $link->title);?>
		</div>
	<?php endif ?>
	
	<?php echo form_open(uri_string(), 'id="nav-' . $this->method . '" class="form_inputs"') ?>
	
		<ul>
<?php if ($this->method == 'edit'): ?>
			<?php echo form_hidden('link_id', $link->id) ?>
<?php endif ?>

			<?php echo form_hidden('current_group_id', $link->navigation_group_id) ?>
			
			<li class="<?php echo alternator('', 'even') ?>">
				<label for="title"><?php echo lang('global:title');?> <span>*</span></label>
				<?php echo form_input('title', $link->title, 'maxlength="50" class="text"') ?>
			</li>
			
			<?php if ($this->method == 'edit'): ?>
				<li class="<?php echo alternator('', 'even') ?>">
					<label for="navigation_group_id"><?php echo lang('nav:group_label');?></label>
					<?php echo form_dropdown('navigation_group_id', $groups_select, $link->navigation_group_id) ?>
				</li>
			<?php else: ?>
				<?php echo form_hidden('navigation_group_id', $link->navigation_group_id) ?>
			<?php endif ?>
	
			<li class="<?php echo alternator('', 'even') ?>">
				<label for="link_type"><?php echo lang('nav:type_label');?></label>
				<span class="spacer-right">
					<?php echo form_radio('link_type', 'url', $link->link_type == 'url') ?> <?php echo lang('nav:url_label');?>
					<?php echo form_radio('link_type', 'uri', $link->link_type == 'uri') ?> <?php echo lang('nav:uri_label');?>
					<?php echo form_radio('link_type', 'page', $link->link_type == 'page') ?> <?php echo lang('nav:page_label');?>
					<?php echo form_radio('link_type', 'divider', $link->link_type == 'divider') ?> Divider label
					<?php echo form_radio('link_type', 'tools', $link->link_type == 'tools') ?> Tools
					<?php echo form_radio('link_type', 'milestone', $link->link_type == 'milestone') ?> Milestone
					<?php echo form_radio('link_type', 'milestonelist', $link->link_type == 'milestonelist') ?> Milestone list
					<?php echo form_radio('link_type', 'article', $link->link_type == 'article') ?> Article
				</span>
			</li>

			<li class="<?php echo alternator('', 'even') ?>">
	
				<p style="<?php echo ! empty($link->link_type) ? 'display:none' : '' ?>">
					<?php echo lang('nav:link_type_desc') ?>
				</p>
	
				<div id="navigation-url" style="<?php echo @$link->link_type == 'url' ? '' : 'display:none' ?>">
					<label class="label" for="url"><?php echo lang('nav:url_label');?></label>
					<input type="text" id="url" name="url" value="<?php echo empty($link->url) ? 'http://' : $link->url ?>" />
				</div>
	
				<div id="navigation-uri" style="<?php echo @$link->link_type == 'uri' ? '' : 'display:none' ?>">
					<label class="label" for="uri"><?php echo lang('nav:uri_label');?></label>
					<input type="text" id="uri" name="uri" value="<?php echo $link->uri ?>" />
				</div>
	
				<div id="navigation-page" style="<?php echo @$link->link_type == 'page' ? '' : 'display:none' ?>">
					<label class="label" for="page_id"><?php echo lang('nav:page_label');?></label>
					<select name="page_id">
						<option value=""><?php echo lang('global:select-pick');?></option>
						<?php echo $tree_select ?>
					</select>
				</div>

				<div id="navigation-tools" style="<?php echo @$link->link_type == 'tools' ? '' : 'display:none' ?>">
					<label class="label" for="tools_name">Tools</label>
					<select name="uri_tools">
						<option value="">Tools</option>
						<?php foreach ($tools_select as $key => $tool) { ?>
						<option value="<?=$key;?>" <?=($link->uri==$key) ? 'selected="selected' : '';?> ><?=$tool['label'];?></option>
						<?php } ?>
					</select>
				</div>

				<div id="navigation-divider" style="<?php echo @$link->link_type == 'divider' ? '' : 'display:none' ?>">
					<input type="hidden" id="divider" name="url_divider" value="<?php echo $link->url ?>" />
				</div>

				<div id="navigation-article" style="<?php echo @$link->link_type == 'article' ? '' : 'display:none' ?>">
					<label class="label" for="article">Article</label>
					<input type="text" id="article_title" name="article_title" value="<?php echo $link->article_title ?>" />
					<input type="hidden" id="article" name="uri_article" value="<?php echo $link->uri ?>" />
					<ul class="article-list" id="article-list">
					</ul>
				</div>

				<div id="navigation-milestone" style="<?php echo @$link->link_type == 'milestone' ? '' : 'display:none' ?>">
					<label class="label" for="milestone_name">Milestone</label>
					<select name="uri_milestone">
						<option value="">Milestone</option>
						<?php foreach ($milestone_select as $key => $mlstn) { ?>
						<option value="<?=$key;?>" <?=($link->uri==$key) ? 'selected="selected' : '';?> ><?=$mlstn;?></option>
						<?php } ?>
					</select>
				</div>

				<div id="navigation-milestonelist" style="<?php echo @$link->link_type == 'milestonelist' ? '' : 'display:none' ?>">
					<label class="label" for="milestonelist_name">Milestone list</label>
					<select name="uri_milestonelist">
						<option value="">Milestone</option>
						<?php foreach ($milestonelist_select as $key => $mlstnlst) { ?>
						<option value="<?=$key;?>" <?=($link->uri==$key) ? 'selected="selected' : '';?> ><?=$mlstnlst;?></option>
						<?php } ?>
					</select>
				</div>
			</li>

			<li class="<?php echo alternator('', 'even') ?>">
				<label for="target"><?php echo lang('nav:target_label') ?></label>
				<?php echo form_dropdown('target', array(''=> lang('nav:link_target_self'), '_blank' => lang('nav:link_target_blank')), $link->target) ?>
			</li>

			<li class="<?php echo alternator('even', '') ?>">
				<label for="restricted_to[]"><?php echo lang('nav:restricted_to');?></label>
				<?php echo form_multiselect('restricted_to[]', array(0 => lang('global:select-any')) + $group_options, (strpos($link->restricted_to, ",") ? explode(",", $link->restricted_to) : $link->restricted_to), 'size="'.(($count = count($group_options)) > 1 ? $count : 2).'"') ?>
			</li>
	
			<li class="<?php echo alternator('', 'even') ?>">
				<label for="class"><?php echo lang('nav:class_label') ?></label>
				<?php echo form_input('class', $link->class) ?>
			</li>
		</ul>
	
		<div class="buttons float-left padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
		</div>
	
	<?php echo form_close() ?>
</div>
