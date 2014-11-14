<div class="row heading">
	<div class="col-md-6">
		<h1>NAVIGATION</h1>
	</div>
	<div class="col-md-6 align-right">
		<div><button class="btn btn-transparent" data-toggle="modal" data-target="#areaModal">+ Create new area</button></div>
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
						<a href="#" data-toggle="modal" data-target="#linkModal" data-area="<?php echo $area_slug; ?>" class="btn btn-xs btn-primary" data-slug="<?php echo $area_slug; ?>"><span class="fa fa-link"></span> Add link</a>
						<a href="#" data-toggle="modal" data-target="#areaModal" class="btn btn-xs btn-info" data-title="<?php echo $area_slug; ?>" data-slug="<?php echo $area_slug; ?>" data-mode="edit" title="Edit Area"><span class="fa fa-pencil"></span></a>
						<a href="<?php echo site_url('panel/navigation/delete_area/'.$area_slug); ?>" class="btn btn-xs btn-danger remove" title="Delete Area"><span class="fa fa-times"></span></a>
					</div>
				</div>
			</div>
			<?php if($area_content): ?>
				<ul class="navlist">
					<?php foreach ($area_content as $link): ?>
						<li>
							<div><span class="fa fa-align-justify" style="color:#aaa;line-height:27px;"></span></div>
							<div><?php echo $link['title']; ?></div>
							<div><a href="<?php echo ($link['source'] == 'uri') ? site_url($link['url']) : $link['source'].$link['url']; ?>" target="_blank"><?php echo $link['url']; ?></a></div>
							<div class="align-right pull-right">
								<div class="option">
									<a href="#" class="edit" data-mode="edit" data-toggle="modal" data-target="#linkModal" data-area="<?php echo $area_slug; ?>" data-title="<?php echo $link['title']; ?>" data-source="<?php echo $link['source']; ?>" data-url="<?php echo $link['url']; ?>" data-linktarget="<?php echo $link['target']; ?>"><span class="fa fa-edit"></span> Edit</a>
									<a href="<?php echo site_url('panel/navigation/delete_link/'.$area_slug.'/'.urlencode($link['title'])); ?>" class="remove"><span class="fa fa-times"></span> Delete</a>
								</div>
							</div>
						</li>
					<?php endforeach; ?>
				</table>
			<?php else: ?>
				<p class="align-center">No link yet.</p>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
<?php endif; ?>

<!-- Area form Modal -->
<div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form action="<?php echo site_url('panel/navigation/add_area'); ?>" class="form" id="area-form" method="POST">
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
			<form action="<?php echo site_url('panel/navigation/add_link'); ?>" id="link-form" class="form" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="linkModalLabel">Add new link</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label for="area">Link title</label>
								<input type="text" name="link_title" id="link_title" class="form-control">
							</div>
							<div class="form-group">
								<label for="area">Link URL</label>
								<div class="row">
									<div class="col-md-5">
										<select name="link_source" id="link_source" class="form-control">
											<option value="http://">http://</option>
											<option value="https://">https://</option>
											<option value="uri">URI</option>
										</select>
									</div>
									<div class="col-md-7">
										<input type="text" name="link_url" id="link_url" class="form-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="area">Navigation Area</label>
								<select name="link_area" id="link_area" class="form-control">
									<?php foreach ($areas as $area_title => $area_content): ?>
									<option value="<?php echo $area_title; ?>"><?php echo $area_title; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
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
		// nav area modals
		$('#areaModal').on('show.bs.modal', function (e) {
			var title = $(e.relatedTarget).data('title');
			var slug = $(e.relatedTarget).data('slug');
			var mode = $(e.relatedTarget).data('mode');
			$('#area-title').val(title);
			$('#area-slug').val(slug);
			if(mode == 'edit'){
				$('#area-form').attr('action', base_url + 'panel/navigation/edit_area/'+slug);
				$('#btn-submit-area-form').html('Edit');
				$('#areaModalLabel').html('Edit Navigation Area');
			} else {
				$('#area-form').attr('action', base_url + 'panel/navigation/add_area');
				$('#btn-submit-area-form').html('Create');
				$('#areaModalLabel').html('New Navigation Area');				
			}
		});

		// nav link modals
		$('#linkModal').on('show.bs.modal', function (e) {
			var mode = $(e.relatedTarget).data('mode');
			var link_area = $(e.relatedTarget).data('area');
			var link_title = $(e.relatedTarget).data('title');
			var link_source = $(e.relatedTarget).data('source');
			var link_url = $(e.relatedTarget).data('url');
			var link_target = $(e.relatedTarget).data('linktarget');
			$('#link_area').val(link_area);
			$('#link_title').val(link_title);
			$('#link_source').val(link_source);
			$('#link_url').val(link_url);
			$('#link_target').val(link_target);
			if(mode == 'edit'){
				$('#link-form').attr('action', base_url + 'panel/navigation/edit_link/' + link_area + '/' + link_title);
				$('#btn-submit-link-form').html('Edit');
				$('#linkModalLabel').html('Edit Link');
			} else {
				$('#area-form').attr('action', base_url + 'panel/navigation/add_link');
				$('#btn-submit-area-form').html('Create');
				$('#linkModalLabel').html('Add New Link');				
			}
		}) 
	})
</script>