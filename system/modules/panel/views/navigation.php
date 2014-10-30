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
			<div class="col-md-6"><?php echo $area_content['title']; ?></div>
			<div class="col-md-6 align-right">
				<a href="#" data-toggle="modal" data-target="#areaModal" class="btn btn-xs btn-info" data-title="<?php echo $area_content['title']; ?>" data-slug="<?php echo $area_slug; ?>" data-mode="edit"><span class="fa fa-edit"></span> Edit Area</a>
				<a href="#" data-toggle="modal" data-target="#linkModal" class="btn btn-xs btn-primary" data-slug="<?php echo $area_slug; ?>"><span class="fa fa-plus-circle"></span> Add link</a>
			</div>
		</div>
	</div>
	<?php if($area_content['links']): ?>
	<table class="table">
		<?php foreach ($area_content['links'] as $link): ?>
		<tr>
			<td>Docs</td>
			<td><a href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>"><?php echo $link['url']; ?></a></td>
			<td class="align-right">
				<div class="option">
					<a href="#" class="edit"><span class="fa fa-edit"></span> Edit</a>
					<a href="#" class="remove"><span class="fa fa-times"></span> Delete</a>
				</div>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
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
					<h4 class="modal-title" id="myModalLabel">Create New Navigation Area</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="area">Navigation Area Name</label>
						<input type="text" name="area-title" id="area-title" class="form-control title">
					</div>
					<div class="form-group">
						<label for="area">Navigation Area Slug</label>
						<input type="text" name="area-slug" id="area-slug" class="form-control slug">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Create</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- link form Modal -->
<div class="modal fade" id="linkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?php echo site_url('panel/navigation/add_link'); ?>" class="form" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Add new link</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="area">Link title</label>
								<input type="text" name="link-title" class="form-control">
							</div>
							<div class="form-group">
								<label for="area">Link URL</label>
								<input type="text" name="link-url" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="area">Navigation Area</label>
								<select name="link-area" id="link-area" class="form-control">
									<option value="header">Header</option>
									<option value="sidebar">Sidebar</option>
								</select>
							</div>
							<div class="form-group">
								<label for="area">Link Target</label>
								<select name="link-target" class="form-control">
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
					<button type="submit" class="btn btn-primary">Add Link</button>
				</div>
			</form>
		</div>
	</div>
</div>