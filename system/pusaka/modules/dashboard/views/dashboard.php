<div class="row heading">
	<div class="col-md-10">
		<h1 class="dash-title">Welcome, <?php echo $this->session->userdata(SITE_SLUG.'_username'); ?>!</h1>
	</div>
	<div class="col-md-2">
		<div><a href="<?php echo site_url(); ?>" class="btn btn-transparent" target="_blank"><i class="fa fa-long-arrow-right fa-fw"></i> Kunjungi Web</a></div>
	</div>
</div>

<div class="panel-dashboard">

	<div class="row">
		<!--<div class="col-md-4">
			<div class="panel-stat red">
				<div class="stat-title">Visitors Yesterday</div>
				<div class="stat-body">
					<span class="number">7.865</span>
				</div>
			</div>
			<div class="panel-stat dark">
				<div class="stat-title">Visitors This Month</div>
				<div class="stat-body">
					<span class="number">89.096</span>
				</div>
			</div>
		</div>-->
		<div class="col-md-12">
			<div class="panel-button-wrapper">
				<div class="row">
					<div class="col-sm-2 col-xs-6">
						<a href="{{ func.site_url }}panel/posts/create" class="btn btn-block btn-dashboard">
							<div class="btn-icon"><span class="fa fa-pencil"></span></div>
							<div class="btn-label">New Post</div>
						</a>
					</div>
					<div class="col-sm-2 col-xs-6">
						<a href="{{ func.site_url }}panel/pages/create" class="btn btn-block btn-dashboard">
							<div class="btn-icon"><span class="fa fa-file-text"></span></div>
							<div class="btn-label">New page</div>
						</a>
					</div>
					<!-- <div class="col-sm-2 col-xs-6">
						<a href="{{ func.site_url }}panel/media" class="btn btn-block btn-dashboard">
							<div class="btn-icon"><span class="fa fa-image"></span></div>
							<div class="btn-label">Media</div>
						</a>
					</div> -->
					<div class="col-sm-2 col-xs-6">
						<a href="{{ func.site_url }}panel/navigation" class="btn btn-block btn-dashboard">
							<div class="btn-icon"><span class="fa fa-list"></span></div>
							<div class="btn-label">Navigation</div>
						</a>
					</div>
					<div class="col-sm-2 col-xs-6">
						<a href="{{ func.site_url }}panel/users" class="btn btn-block btn-dashboard">
							<div class="btn-icon"><span class="fa fa-group"></span></div>
							<div class="btn-label">Users</div>
						</a>
					</div>
					<div class="col-sm-2 col-xs-6">
						<a href="{{ func.site_url }}panel/settings" class="btn btn-block btn-dashboard">
							<div class="btn-icon"><span class="fa fa-cog"></span></div>
							<div class="btn-label">Settings</div>
						</a>
					</div>
					<div class="col-sm-2 col-xs-6">
						<a href="{{ func.site_url }}panel/export" class="btn btn-block btn-dashboard">
							<div class="btn-icon"><span class="fa fa-html5"></span></div>
							<div class="btn-label">Export to HTML</div>
						</a>
					</div>
				</div>
			</div>

			<!--<div class="panel-home-contact">
				<div class="panel-stat white">
					<div class="stat-title">Contact</div>
					<div class="stat-body">
						Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
					</div>
				</div>
			</div>-->
		</div>
	</div>
</div>