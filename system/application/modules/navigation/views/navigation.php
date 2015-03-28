<div class="row heading">
	<div class="col-md-6">
		<h1>NAVIGATION</h1>
	</div>
	<div class="col-md-6 align-right">
		<div><button class="btn btn-transparent" data-toggle="modal" data-target="#areaModal"><i class="fa fa-plus fa-fw"></i> Create new area</button></div>
	</div>
</div>
<br>

<?php if($areas): ?>
	<?php foreach ($areas as $area_slug => $area_content): ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6"><?php echo $area_slug; ?></div>
					<div class="col-md-6 align-right">
						<a href="#" data-toggle="modal" data-target="#linkModal" data-area="<?php echo $area_slug; ?>" class="btn btn-xs btn-primary"><span class="fa fa-link"></span> Add link</a>
						<a href="#" data-toggle="modal" data-target="#areaModal" class="btn btn-xs btn-info" data-title="<?php echo $area_slug; ?>" data-slug="<?php echo $area_slug; ?>" data-mode="edit" title="Edit Area"><span class="fa fa-pencil"></span></a>
						<a href="<?php echo site_url('panel/navigation/delete_area/'.$area_slug); ?>" class="btn btn-xs btn-danger remove" title="Delete Area"><span class="fa fa-times"></span></a>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<?php if($area_content): ?>
					<div class="dd" id="<?php echo $area_slug; ?>">
						<ol class="dd-list">
							<?php echo Modules::run('navigation/panel/navigation_list', $area_slug, $area_content, true); ?>
						</ol>
					</div>
				<?php else: ?>
					<p class="align-center">No link yet.</p>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>

<!-- Area form Modal -->
<div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form action="<?php echo site_url('panel/navigation/create_area'); ?>" class="form" id="area-form" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="areaModalLabel">New Navigation Area</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="area">Navigation Area Name</label>
						<input type="text" name="area-title" id="area-title" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" id="btn-submit-area-form" class="btn btn-primary">Create</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- link form Modal -->
<div class="modal fade" id="linkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?php echo site_url('panel/navigation/create_link'); ?>" id="link-form" class="form" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="linkModalLabel">Add new link</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="area">Link title</label>
								<input type="text" name="link_title" id="link_title" class="form-control title">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="area">Link slug</label>
								<input type="text" name="link_slug" id="link_slug" class="form-control slug">
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="area">Link URL</label>
								<select name="link_source" id="link_source" class="form-control">
									<option value="http://">http://</option>
									<option value="https://">https://</option>
									<option value="uri">URI</option>
								</select>
							</div>
						</div>
						<div class="col-md-9">
							<div class="form-group">
								<label for="">&nbsp;</label>
								<input type="text" name="link_url" id="link_url" class="form-control">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="area">Navigation Area</label>
								<select name="link_area" id="link_area" class="form-control">
									<?php foreach ($areas as $area_title => $area_content): ?>
										<option value="<?php echo $area_title; ?>"><?php echo $area_title; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<!-- <div class="form-group">
								<label for="area">Link Parent</label>
								<select name="link_parent" id="link_parent" class="form-control"></select>
							</div> -->
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="area">Link Target</label>
								<select name="link_target" id="link_target" class="form-control">
									<option value="_self">_self</option>
									<option value="_blank">_blank</option>
									<option value="_parent">_parent</option>
									<option value="_top">_top</option>
								</select>
							</div>
						</div>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" id="btn-submit-link-form" class="btn btn-primary">Add Link</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(function(){
		<?php if($areas): $group = 0; foreach ($areas as $area_slug => $area_content): ?>
		$('#<?php echo $area_slug; ?>').nestable({group: <?php echo $group; ?>}).on('change', updateSort);
		<?php $group++; endforeach; endif; ?>
	})

	// callback to update arrange navigation
	var updateSort = function(e)
	{
		var list   = e.length ? e : $(e.target);
		var area = list.attr('id');
		
		//clear timeout
		$('.alert').fadeOut(100);
		clearTimeout(timeout);

		if (window.JSON) {
			var newmap = window.JSON.stringify(list.nestable('serialize'));
			$.post(base_url+'panel/navigation/sort/'+area, {newmap : newmap})
			.done(function(data){
				var res = JSON.parse(data);
				$('#alert-'+res.status).children('span').html(res.message);
				$('#alert-'+res.status).fadeIn(300);
				timeout = setTimeout(function(){
					$('.alert').fadeOut(300);
				}, 5000)
			});
		} else {
			output.val('JSON browser support required for this demo.');
		}
	};
</script>