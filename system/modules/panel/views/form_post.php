<form action="#" class="panel-form">
	<div class="row heading">
		<div class="col-md-6">
			<h1><a href="<?php echo site_url('panel/posts'); ?>">POSTS</a> &bull; <?php echo strtoupper($type); ?> POST</h1>
		</div>
		<div class="col-md-6 align-right">
			<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save changes</button>
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
						<label for="title">Title <small>post title</small></label>
						<input type="text" class="form-control" name="title" id="title">
					</div>		
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="slug">Slug</label>
						<input type="text" class="form-control" name="slug" id="slug">
					</div>		
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="title">Layout <small>post layout file</small></label>
						<select class="form-control" name="layout" id="layout">
							<?php foreach ($layouts as $layout): ?>
								<option value="<?php echo substr($layout, 0, -4); ?>" <?php echo ($layout=='default.php')?'selected':''; ?>><?php echo substr($layout, 0, -4); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="content">Content</label>	
				<textarea id="postdownMe" class="form-control" rows="20"></textarea>
			</div>
		</div>

		<div class="tab-pane" id="optional">
			<div class="form-group">
				<label for="meta-desc">Meta Description <small>optional</small></label>
				<textarea name="meta-desc" class="form-control" rows="3"></textarea>
			</div>
			<div class="form-group">
				<label for="meta-keyword">Meta Keyword <small>optional</small></label>
				<input type="meta-keyword" class="form-control">
			</div>
		</div>
	</div>

</form>

<script type="text/javascript">
	(function() {
		$("textarea#postdownMe").pagedownBootstrap();
		$('.wmd-preview').addClass('well').css('display', 'none');
	})();
</script>