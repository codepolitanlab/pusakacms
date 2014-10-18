<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body style="background-color:#8ec63f;">
	<div class="row wrapper">
		<div class="col-md-4 col-md-offset-4">
			<a target="_blank" href="<?php echo site_url(); ?>" style="display:block; text-align:center;margin-top:100px; margin-bottom:20px;">
				<img src="<?php echo get_theme_image('kujang_logo.png', false); ?>" height="200px">
			</a>
			<div class="content">
				<div class="notif">
					<?php echo $this->session->flashdata('error')? '<div class="alert alert-danger">'. $this->session->flashdata('error') .'</div>' : ''; ?>
				</div>

				<form action="<?php echo site_url('panel/login'); ?>" method="POST">
					<div class="form-group">
						<input type="text" name="username" class="form-control" placeholder="Your username">
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" placeholder="Your password">
					</div>
					<input type="submit" class="btn btn-primary btn-block" value="Login">
				</form>
			</div>
		</div>
	</div>
</body>
</html>