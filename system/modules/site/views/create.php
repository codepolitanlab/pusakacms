<?php echo form_open(uri_string());?>

<div class="row heading">
	<div class="col-md-8">
		<h1><a href="{{ func.site_url uri="panel/site" }}">Site Management</a> &bull; Create Site</h1>
	</div>
	<div class="col-md-4 align-right">
		<div>
			<button type="submit" class="btn btn-md btn-success">Create Site</button>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-heading">
				User Admin
			</div>
			<div class="panel-body">
				<?php foreach($user_data as $user): ?>
				<div class="form-group">
					<label for="<?php echo $user['name']; ?>"><?php echo $user['title']; ?></label>
					<?php echo form_input($user);?>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel">
			<div class="panel-heading">
				Site Options
			</div>
			<div class="panel-body">
				<?php foreach($site_data as $site): ?>
				<div class="form-group">
					<label for="<?php echo $site['name']; ?>"><?php echo $site['title']; ?></label>
					<?php echo form_input($site);?>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

<?php echo form_hidden($csrf); ?>

<?php echo form_close();?>