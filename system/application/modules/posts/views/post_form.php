<form action="<?php echo site_url('panel/posts/'.$type.'/'.$filename); ?>" class="panel-form" method="POST">
	<div class="row heading">
		<div class="col-md-6">
			<h1><a href="<?php echo site_url('panel/posts'); ?>">POSTS</a> &bull; <?php echo strtoupper($type); ?> POST</h1>
		</div>
		<div class="col-md-6 align-right">
			<button type="submit" name="btnSave" class="btn btn-info"><span class="fa fa-save"></span> Save</button>
			<button type="submit" name="btnSaveExit" value="1" class="btn btn-success"><span class="fa fa-save"></span> Save and exit</button>
		</div>
	</div>

	<!-- Tab panes -->
	<div class="row">
		<div class="col-md-8">
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
				<div class="col-md-12">
					<div class="form-group">
						<label for="content">Content</label>
						<textarea id="pagedownMe" class="form-control" name="content" rows="20"><?php echo set_value('content', validate_value($post, 'content')); ?></textarea>
					</div>
					<div class="form-group">
						<label for="intro">Introduction</label>	
						<textarea class="form-control" name="intro" id="intro" rows="4"><?php echo set_value('intro', validate_value($post, 'intro')); ?></textarea>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				<label for="title">Layout <small>page layout file</small></label>
				<select class="form-control" name="layout" id="layout">
					<option value="">Auto</option>
					<?php foreach ($layouts as $layout): ?>
						<option value="<?php echo substr($layout, 0, -4); ?>" <?php echo (substr($layout, 0, -4) == validate_value($post, 'layout')) ? "selected" : ''; ?>><?php echo $layout; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="labels">Labels <small>or categories</small></label>
				<input type="text" name="labels" id="labels" class="form-control" value="<?php echo set_value('labels', validate_value($post, 'labels')); ?>">
			</div>
			<div class="form-group">
				<label for="content">Featured Image</label>
				<input type="text" id="post_image" name="post_image" class="form-control" value="<?php echo set_value('post_image', validate_value($post, 'post_image')); ?>">
				<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal">Browse</button>
			</div>
			<div class="form-group">
				<label for="meta_description">Meta Description <small>optional</small></label>
				<textarea name="meta_description" class="form-control" rows="6"><?php echo set_value('meta_description', validate_value($post, 'meta_description')); ?></textarea>
			</div>
		</div>
	</div>

</form>

<div class="modal fade" id="myModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<iframe src="<?php echo site_url('panel/media/dialog', NULL, true); ?>/?type=1&field_id=post_image&relative_url=1" width="100%" height="600px" frameborder="0"></iframe>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->