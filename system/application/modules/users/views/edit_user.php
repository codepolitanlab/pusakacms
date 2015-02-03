<?php echo form_open(uri_string());?>

<div class="row heading">
	<div class="col-md-6">
		<h1><a href="{{ func.site_url uri="panel/users" }}">Users</a> &bull; Edit User</h1>
	</div>
	<div class="col-md-6 align-right">
		<div>
			<button type="submit" class="btn btn-md btn-success">Update User</a>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">

			<div class="form-group">
				<?php echo lang('create_user_fname_label', 'first_name');?> <br />
				<?php echo form_input($first_name);?>
			</div>

			<div class="form-group">
				<?php echo lang('create_user_lname_label', 'last_name');?> <br />
				<?php echo form_input($last_name);?>
			</div>

			<div class="form-group">
				<?php echo lang('create_user_company_label', 'company');?> <br />
				<?php echo form_input($company);?>
			</div>

			<div class="form-group">
				<?php echo lang('create_user_phone_label', 'phone');?> <br />
				<?php echo form_input($phone);?>
			</div>

		</div>

		<div class="col-md-6">

			<div class="form-group">
				<?php echo lang('create_user_email_label', 'email');?> <br />
				<?php echo form_input($email);?>
			</div>

			<div class="form-group">
				<?php echo lang('create_user_password_label', 'password');?> <br />
				<?php echo form_input($password);?>
			</div>

			<div class="form-group">
				<?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
				<?php echo form_input($password_confirm);?>
			</div>

			<?php if ($this->ion_auth->is_admin()): ?>

				<div class="form-group">
					
					<h3><?php echo lang('edit_user_groups_heading');?></h3>
					<?php foreach ($groups as $group):?>
						<label class="checkbox">
							<?php
							$gID=$group['id'];
							$checked = null;
							$item = null;
							foreach($currentGroups as $grp) {
								if ($gID == $grp['id']) {
									$checked= ' checked="checked"';
									break;
								}
							}
							?>
							<input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?> data-toggle="checkbox">
							<?php echo $group['name'];?>
						</label>
					<?php endforeach?>
				</div>

			<?php endif ?>

		</div>
	</div>

	<?php echo form_hidden('id', $user['id']);?>
	<?php echo form_hidden($csrf); ?>


	<?php echo form_close();?>