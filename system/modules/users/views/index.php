<div class="row heading">
	<div class="col-md-6">
		<h1>Users</h1>
	</div>
	<div class="col-md-6 align-right">
		<div>
			<a class="btn btn-md btn-transparent" href="{{ func.site_url }}panel/users/create_group"><span class="fa fa-plus-circle"></span> Create Group</a>
			<a class="btn btn-md btn-transparent" href="{{ func.site_url }}panel/users/create_user"><span class="fa fa-plus-circle"></span> Add New User</a>
		</div>
	</div>
</div>

<div id="infoMessage"><?php echo $message;?></div>

<div class="panel panel-default">
	<div class="panel-body">

		<table class="table table-bordered" style="margin:0">
			<tr>
				<th><?php echo lang('index_fname_th');?></th>
				<th><?php echo lang('index_lname_th');?></th>
				<th><?php echo lang('index_email_th');?></th>
				<th><?php echo lang('index_groups_th');?></th>
				<th><?php echo lang('index_status_th');?></th>
				<th><?php echo lang('index_action_th');?></th>
			</tr>
			<?php foreach ($users as $user):?>
				<tr>
					<td><?php echo $user->first_name;?></td>
					<td><?php echo $user->last_name;?></td>
					<td><?php echo $user->email;?></td>
					<td>
						<?php foreach ($user->groups as $group):?>
							<?php echo anchor("panel/users/edit_group/".$group->id, $group->name) ;?><br />
						<?php endforeach?>
					</td>
					<td><?php echo ($user->active) ? anchor("users/auth/deactivate/".$user->id, lang('index_active_link')) : anchor("users/auth/activate/". $user->id, lang('index_inactive_link'));?></td>
					<td><?php echo anchor("panel/users/edit_user/".$user->id, 'Edit') ;?></td>
				</tr>
			<?php endforeach;?>
		</table>

	</div>
</div>