<form action="<?php echo site_url('panel/pages/'.$type.'/'.$url); ?>" method="POST" data-page="<?php echo $url; ?>" data-mode="<?php echo $type; ?>" class="panel-form">
	<div class="row heading">
		<div class="col-md-6">
			<h1><a href="<?php echo site_url('panel/pages'); ?>">PAGES</a> &bull; <?php echo strtoupper($type); ?> PAGE</h1>
		</div>
		<div class="col-md-6 align-right">
			<button type="submit" name="btnSave" class="btn btn-save btn-info"><span class="fa fa-save"></span> Save</button>
			<button type="submit" name="btnSaveExit" value="1" class="btn btn-save btn-success"><span class="fa fa-save"></span> Save and exit</button>
		</div>
	</div>
	<ul class="nav nav-tabs" role="tablist">
		<li class="active"><a href="#main" role="tab" data-toggle="tab">Main</a></li>
		<li><a href="#optional" role="tab" data-toggle="tab">Optional</a></li>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="main">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="title">Title <small>page title</small></label>
						<input type="text" class="form-control title" name="title" id="title" value="<?php echo set_value('title', validate_value($page, 'title')); ?>">
					</div>		
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="slug">Slug <small>page url</small></label>
						<input type="text" class="form-control slug" name="slug" id="slug" value="<?php echo set_value('slug', validate_value($page, 'slug')); ?>">
					</div>		
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="slug">Parent <small>Parent page</small></label>
						<select class="form-control" name="parent" id="parent">
							<option value="">—</option>
							<?php foreach ($pagelinks as $pagelink => $caption): ?>
								<option value="<?php echo $pagelink; ?>" <?php echo ($pagelink==$parent || $pagelink==validate_value($page, 'parent'))? "selected":''; ?>><?php echo $caption; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="title">Layout <small>page layout file</small></label>
						<select class="form-control" name="layout" id="layout">
							<option value="">Auto</option>
							<?php foreach ($layouts as $layout): ?>
								<option value="<?php echo substr($layout, 0, -4); ?>" <?php echo (substr($layout, 0, -4) == validate_value($page, 'layout')) ? "selected" : ''; ?>><?php echo $layout; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="content">Content</label>	
				<textarea id="pagedownMe" name="content" class="form-control cm-textarea" rows="40"><?php echo set_value('content', validate_value($page, 'content')); ?></textarea>
			</div>
		</div>

		<div class="tab-pane" id="optional">
			<div class="form-group">
				<label for="role">Role <small>role who can access this page separated by comma, leave blank for no restriction</small></label>
				<input name="role" id="role" class="form-control" placeholder="i.e. admin, user" value="<?php echo set_value('role', validate_value($page, 'role')); ?>">
			</div>
			<div class="form-group">
				<label for="meta_description">Meta Description <small>optional</small></label>
				<textarea name="meta_description" id="meta_description" class="form-control" rows="3"><?php echo set_value('meta_description', validate_value($page, 'meta_description')); ?></textarea>
			</div>
			<div class="form-group">
				<label for="meta_keywords">Meta Keyword <small>optional</small></label>
				<input name="meta_keywords" id="meta_keywords" class="form-control" value="<?php echo set_value('meta_keywords', validate_value($page, 'meta_keywords')); ?>">
			</div>
		</div>
	</div>

</form>