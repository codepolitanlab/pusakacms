<?php echo form_open("panel/users/create_group");?>

<div class="row heading">
	<div class="col-md-6">
		<h1><a href="{{ func.site_url uri="panel/users" }}">Users</a> &bull; Create Group</h1>
	</div>
	<div class="col-md-6 align-right">
		<div>
			<button type="submit" class="btn btn-md btn-success">Save Group</button>
		</div>
	</div>
</div>


<div class="form-group">
	<?php echo lang('create_group_name_label', 'group_name');?>
	<?php echo form_input($group_name);?>
</div>

<div class="form-group">
	<?php echo lang('create_group_desc_label', 'description');?>
	<?php echo form_input($group_description);?>
</div>

<?php echo form_close();?>