<div class="row heading">
	<div class="col-md-6">
		<h1>NAVIGATION</h1>
	</div>
	<div class="col-md-6 align-right">
		<div><button class="btn btn-transparent" data-toggle="modal" data-target="#myModal">+ Create new area</button></div>
	</div>
</div>
<br>
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title">header</h3>
			</div>
			<div class="col-md-6 align-right">
				<a href="#" class="btn btn-xs btn-info">+ Add link</a>
			</div>
		</div>
	</div>
	<table class="table">
		<tr>
			<td>Docs</td>
			<td><a href="#" target="_blank">{{ helpers.site_url }}docs</a></td>
			<td class="align-right">
				<div class="option">
					<a href="#" class="edit"><span class="fa fa-edit"></span> Edit</a>
					<a href="#" class="remove"><span class="fa fa-times"></span> Delete</a>
				</div>
			</td>
		</tr>
		<tr>
			<td>Blog</td>
			<td><a href="#" target="_blank">{{ helpers.site_url }}blog</a></td>
			<td class="align-right">
				<div class="option">
					<a href="#" class="edit"><span class="fa fa-edit"></span> Edit</a>
					<a href="#" class="remove"><span class="fa fa-times"></span> Delete</a>
				</div>
			</td>
		</tr>
		<tr>
			<td>Contact</td>
			<td><a href="#" target="_blank">{{ helpers.site_url }}contact</a></td>
			<td class="align-right">
				<div class="option">
					<a href="#" class="edit"><span class="fa fa-edit"></span> Edit</a>
					<a href="#" class="remove"><span class="fa fa-times"></span> Delete</a>
				</div>
			</td>
		</tr>
	</table>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title">footer</h3>
			</div>
			<div class="col-md-6 align-right">
				<a href="#" class="btn btn-xs btn-info">+ Add link</a>
			</div>
		</div>
	</div>
	<table class="table">
		<tr>
			<td>Docs</td>
			<td><a href="#" target="_blank">{{ helpers.site_url }}docs</a></td>
			<td class="align-right">
				<div class="option">
					<a href="#" class="edit"><span class="fa fa-edit"></span> Edit</a>
					<a href="#" class="remove"><span class="fa fa-times"></span> Delete</a>
				</div>
			</td>
		</tr>
		<tr>
			<td>Blog</td>
			<td><a href="#" target="_blank">{{ helpers.site_url }}blog</a></td>
			<td class="align-right">
				<div class="option">
					<a href="#" class="edit"><span class="fa fa-edit"></span> Edit</a>
					<a href="#" class="remove"><span class="fa fa-times"></span> Delete</a>
				</div>
			</td>
		</tr>
		<tr>
			<td>Contact</td>
			<td><a href="#" target="_blank">{{ helpers.site_url }}contact</a></td>
			<td class="align-right">
				<div class="option">
					<a href="#" class="edit"><span class="fa fa-edit"></span> Edit</a>
					<a href="#" class="remove"><span class="fa fa-times"></span> Delete</a>
				</div>
			</td>
		</tr>
	</table>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form action="<?php echo site_url('panel/navigation/add'); ?>" class="form">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Create New Navigation Area</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="area">Navigation Area Name</label>
					<input type="text" name="area-title" class="form-control title">
				</div>
				<div class="form-group">
					<label for="area">Navigation Area Slug</label>
					<input type="text" name="area-slug" class="form-control slug">
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