<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body class="panel-bg-login">

	<div class="panel-login-header text-center">
		<a target="_blank" href="<?php echo site_url(); ?>">
			<img src="<?php echo get_theme_image('kujang_logo.png', false); ?>" height="200px">
		</a>
	</div>

	
	
	<div class="panel-login-form text-center">
		
		<div class="form-text">Login Admin</div>

		<div class="notif">
			<?php echo $this->session->flashdata('error')? '<div class="alert alert-danger">'. $this->session->flashdata('error') .'</div>' : ''; ?>
		</div>

		<form class="form-inline" role="form" action="<?php echo site_url('panel/auth/login'); ?>" method="POST">
			<div class="form-group">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Username" name="username" autocomplete="off">
					<div class="input-group-addon"><i class="fa fa-user"></i></div>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off">
					<div class="input-group-addon"><i class="fa fa-lock"></i></div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary btn-login">Login</button>
		</form>

		<div class="panel-login-form-forgot">
			<a href="#"> Forgot your password?</a>
		</div>
		
	</div>

	<?php get_partial('scripts'); ?>
</body>
</html>