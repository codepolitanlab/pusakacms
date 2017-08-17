<div class="row heading">
	<div class="col-md-6">
		<h1>Users</h1>
	</div>
	<div class="col-md-6 align-right">
		<div>
			<button class="btn btn-transparent" data-toggle="modal" data-target="#groupModal"><span class="fa fa-plus-circle"></span> Create Group</button>
			<a class="btn btn-md btn-transparent" href="{{ func.site_url }}panel/users/create_user"><span class="fa fa-plus-circle"></span> Add New User</a>
		</div>
	</div>
</div>

<ul class="nav nav-tabs">
	<li class="active"><a href="#users" role="tab" data-toggle="tab">Users</a></li>
	<li><a href="#groups" role="tab" data-toggle="tab">Groups</a></li>
</ul>

<div id="myTabContent" class="tab-content">

	<div class="tab-pane active" id="users">		
		
		<table class="table table-bordered" style="margin:0">
			<tr>
				<th><?php echo lang('index_fname_th');?></th>
				<th><?php echo lang('index_lname_th');?></th>
				<th><?php echo lang('index_email_th');?></th>
				<th><?php echo lang('index_groups_th');?></th>
				<th><?php echo lang('index_status_th');?></th>
				<th width="23%"></th>
			</tr>
			<?php foreach ($users as $user):?>
				<tr>
					<td><?php echo $user['first_name'];?></td>
					<td><?php echo $user['last_name'];?></td>
					<td><?php echo $user['email'];?></td>
					<td>
						<?php foreach ($user['groups'] as $group):?>
							<?php echo anchor("panel/users/edit_group/".$group['id'], $group['name']) ;?><br />
						<?php endforeach?>
					</td>
					<td><?php echo ($user['active']) ? lang('index_active_link') : lang('index_inactive_link');?></td>
					<td style="text-align:right">
						<?php if($this->session->userdata('id') != $user['id']): ?>
							<?php echo ($user['active']) ? anchor("users/auth/deactivate/".$user['id'], 'Deactivate', 'class="btn btn-xs btn-primary"') : anchor("users/auth/activate/". $user['id'], 'Activate', 'class="btn btn-xs btn-primary"'); ?>
						<?php endif; ?>
						<?php echo anchor("panel/users/edit_user/".$user['id'], 'Edit', 'class="btn edit btn-xs btn-primary"') ;?>
						<?php if($this->session->userdata('id') != $user['id']) echo anchor("panel/users/delete_user/".$user['id'], 'Delete', 'class="btn delete remove btn-xs btn-primary"') ;?>
					</td>
				</tr>
			<?php endforeach;?>
		</table>
	</div>

	<div class="tab-pane" id="groups">
		
		<table class="table table-bordered" style="margin:0">
			<tr>
				<th>Group Name</th>
				<th>Description</th>
				<th width="30%"></th>
			</tr>
			<?php foreach ($groups as $group):?>
				<tr>
					<td><?php echo $group['name'];?></td>
					<td><?php echo $group['description'];?></td>
					<td style="text-align:right">
						<?php if($group['name'] != 'admin'): ?>

						<a href="#" 
						   class="btn edit btn-xs btn-primary" 
						   data-group-id="<?php echo $group['id']; ?>" 
						   data-mode="edit" 
						   data-toggle="modal" 
						   data-target="#groupModal" 
						   data-name="<?php echo $group['name']; ?>" 
						   data-desc="<?php echo $group['description']; ?>">
							Edit
						</a>
						<?php echo anchor("panel/users/delete_group/".$group['id'], 'Delete', 'class="btn remove btn-xs btn-primary"') ;?>

						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach;?>
		</table>

	</div>
</div>

<!-- Group form Modal -->
<div class="modal fade" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form action="<?php echo site_url('panel/users/create_group'); ?>" class="form" id="group-form" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="groupModalLabel">New Group</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="area">Group Name</label>
						<input type="text" name="group_name" id="group_name" class="form-control">
					</div>
					<div class="form-group">
						<label for="area">Group Description</label>
						<input type="text" name="group_description" id="group_description" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" id="btn-submit-group-form" class="btn btn-primary">Create</button>
				</div>
			</form>
		</div>
	</div>
</div>