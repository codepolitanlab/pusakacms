<?php echo form_open("panel/users/create_user");?>

<div class="row heading">
	<div class="col-md-6">
		<h1><a href="{{ func.site_url uri="panel/users" }}">Users</a> &bull; Create User</h1>
	</div>
	<div class="col-md-6 align-right">
		<div>
			<button type="submit" class="btn btn-md btn-success">Save User</a>
		</div>
	</div>
</div>

		<div class="row">
			<div class="col-md-6">

				<div class="form-group">
					<?php echo lang('create_user_fname_label', 'first_name');?>
					<?php echo form_input($first_name);?>
				</div>

				<div class="form-group">
					<?php echo lang('create_user_lname_label', 'last_name');?>
					<?php echo form_input($last_name);?>
				</div>

				<div class="form-group">
					<?php echo lang('create_user_company_label', 'company');?>
					<?php echo form_input($company);?>
				</div>

				<div class="form-group">
					<?php echo lang('create_user_phone_label', 'phone');?>
					<?php echo form_input($phone);?>
				</div>


			</div>

			<div class="col-md-6">
				
				<div class="form-group">
					<?php echo lang('create_user_email_label', 'email');?>
					<?php echo form_input($email);?>
				</div>

				<div class="form-group">
					<?php echo lang('create_user_password_label', 'password');?>
					<?php echo form_input($password);?>
				</div>

				<div class="form-group">
					<?php echo lang('create_user_password_confirm_label', 'password_confirm');?>
					<?php echo form_input($password_confirm);?>
				</div>

			</div>
		</div>


<?php echo form_close();?>
