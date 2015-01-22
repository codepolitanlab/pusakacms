<form action="<?php echo site_url('panel/users/'.$type.'/'.(isset($username)?$username:'')); ?>" class="panel-form" method="POST">
	<div class="row heading">
		<div class="col-md-6">
			<h1><a href="<?php echo site_url('panel/users'); ?>">USERS</a> &bull; <?php echo strtoupper($type); ?> USER</h1>
		</div>
		<div class="col-md-6 align-right">
			<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save changes</button>
		</div>
	</div>


	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="title">Username</label>
				<input type="text" class="form-control" name="username" value="<?php echo set_value('username', isset($user['username']) ? $user['username'] : ''); ?>">
			</div>		
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="slug">Password</label>
				<input type="password" class="form-control" name="password">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="title">Confirm Password</label>
				<input type="password" class="form-control" name="passconf">
			</div>		
		</div>
	</div>

</div>

</form>