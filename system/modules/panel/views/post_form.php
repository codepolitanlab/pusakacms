<form action="<?php echo site_url('panel/posts/'.$type.'?post='.$url); ?>" class="panel-form" method="POST">
	<div class="row heading">
		<div class="col-md-6">
			<h1><a href="<?php echo site_url('panel/posts'); ?>">POSTS</a> &bull; <?php echo strtoupper($type); ?> POST</h1>
		</div>
		<div class="col-md-6 align-right">
			<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save changes</button>
		</div>
	</div>
	<ul class="nav nav-tabs" role="tablist">
		<li class="active"><a href="#maintab" role="tab" data-toggle="tab">Main</a></li>
		<li><a href="#optionaltab" role="tab" data-toggle="tab">Optional</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="maintab">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="title">Title <small>post title</small></label>
						<input type="text" class="form-control title" name="title" value="<?php echo set_value('title', validate_value($post, 'title')); ?>">
					</div>		
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="slug">Slug</label>
						<input type="text" class="form-control slug" name="slug" value="<?php echo set_value('slug', validate_value($post, 'slug')); ?>">
					</div>		
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="title">Layout <small>page layout file</small></label>
						<select class="form-control" name="layout" id="layout">
							<option value="">Auto</option>
							<?php foreach ($layouts as $layout): ?>
								<option value="<?php echo substr($layout, 0, -4); ?>" <?php echo (substr($layout, 0, -4) == validate_value($post, 'layout')) ? "selected" : ''; ?>><?php echo $layout; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="labels">Labels <small>or categories</small></label>
						<input type="text" name="labels" id="labels" class="form-control" value="<?php echo set_value('labels', validate_value($post, 'labels')); ?>">
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="content">Content</label>
				<textarea id="pagedownMe" class="form-control" name="content" rows="20"><?php echo set_value('content', validate_value($post, 'content')); ?></textarea>
			</div>
		</div>

		<div class="tab-pane" id="optionaltab">
			<div class="form-group">
				<label for="intro">Introduction</label>	
				<textarea class="form-control" name="intro" id="intro" rows="6"><?php echo set_value('intro', validate_value($post, 'intro')); ?></textarea>
			</div>
			<div class="form-group">
				<label for="meta-desc">Meta Description <small>optional</small></label>
				<textarea name="meta-desc" class="form-control" rows="3"><?php echo set_value('meta-desc', validate_value($post, 'meta-desc')); ?></textarea>
			</div>
			<div class="form-group">
				<label for="meta-keyword">Meta Keyword <small>optional</small></label>
				<input type="meta-keyword" class="form-control" name="meta-keyword" id="meta-keyword" value="<?php echo set_value('meta-keyword', validate_value($post, 'meta-post')); ?>">
			</div>
		</div>
	</div>

</form>