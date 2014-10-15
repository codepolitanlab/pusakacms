<form action="#" class="panel-form">
<h1>Create new post</h1>
<?php echo $type; ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="title">Title <small>post title</small></label>
			<input type="text" class="form-control" name="title">
		</div>		
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="slug">Slug <small>post url will become {{ helpers.site_title }}</small></label>
			<input type="text" class="form-control" name="slug">
		</div>		
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="title">Layout <small>post layout file</small></label>
			<select class="form-control" name="layout" id="layout">
				<option value="auto">auto</option>
				<option value="full-width">full-width</option>
				<option value="sidebar-right">sidebar-right</option>
			</select>
		</div>		
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="slug">Format <small>content format</small></label>
			<select class="form-control" name="format" id="layout">
				<option value="md">markdown</option>
				<option value="textile">textile</option>
				<option value="html">HTML</option>
			</select>
		</div>		
	</div>
</div>

<div class="form-group">
<label for="content">Content</label>	
<textarea id="postdownMe" class="form-control" rows="10">
# This is the *first* editor.

Just plain **Markdown**, except that the input is sanitized:

<marquee>I'm the ghost from the past!</marquee>
</textarea>
</div>

<div class="form-group">
	<label for="meta-desc">Meta Description <small>optional</small></label>
	<textarea name="meta-desc" class="form-control" rows="3"></textarea>
</div>
<div class="form-group">
	<label for="meta-keyword">Meta Keyword <small>optional</small></label>
	<input type="meta-keyword" class="form-control">
</div>

</form>

<script type="text/javascript">
(function() {
	$("textarea#postdownMe").pagedownBootstrap();
	$('.wmd-preview').addClass('well').css('display', 'none');
})();
</script>