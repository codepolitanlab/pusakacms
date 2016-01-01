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
			<?php echo isset($message) ? '<div class="alert alert-danger">'. $message .'</div>' : ''; ?>
		</div>

		<form class="form-inline" role="form" action="<?php echo site_url('users/auth/login'); ?>" method="POST">
			<div class="form-group">
				<div class="input-group">
					<?php echo form_input($identity);?>
					<div class="input-group-addon"><i class="fa fa-user"></i></div>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<?php echo form_input($password);?>
					<div class="input-group-addon"><i class="fa fa-lock"></i></div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary btn-login">Login</button>
		</form>

		<div class="opt">	

			<div style="text-align:left; display:inline-block; width:50%">
				<?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
				<label for="remember">Remember me</label>
			</div>
		
			<div class="panel-login-form-forgot" style="display:inline-block; width:40%">
				<a href="<?php echo site_url('users/auth/forgot_password'); ?>"> Forgot your password?</a>
			</div>

		</div>
		
	</div>

	<?php get_partial('scripts'); ?>
</body>
</html>