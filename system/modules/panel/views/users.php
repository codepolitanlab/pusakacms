<form action="<?php echo site_url('panel/settings'); ?>" method="POST">
<div class="row heading">
	<div class="col-md-6">
		<h1>USERS</h1>
	</div>
	<div class="col-md-6 align-right">
		<a href="<?php echo site_url('panel/users/create'); ?>" class="btn btn-transparent"><span class="fa fa-user"></span> Add New User</a>
	</div>
</div>

<ul class="content-list nav">
	<?php foreach ($users as $user => $userdata): ?>
	<li>
		<div class="list-desc">
			<h3><a><?php echo $user; ?></a></h3>
			<div class="row">
				<div class="col-md-6 col-md-offset-6 align-right">			
					<div class="option">
						<a href="<?php echo site_url('panel/users/edit/'.$user); ?>" class="edit"><span class="fa fa-edit"></span> Edit</a>
						<a href="<?php echo site_url('panel/users/delete/'.$user); ?>" class="remove"><span class="fa fa-times"></span> Delete</a>
					</div>
				</div>
			</div>
		</div>
	</li>
	<?php endforeach; ?>
</ul>