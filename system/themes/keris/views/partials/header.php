<nav class="navbar navbar-default navbar-inverse" role="navigation">
	<div class="container">		
		<div class="row">
			<div class="col-md-7">
				<h1><a href="<?php echo site_url(); ?>"><?php echo site_config('site_name'); ?></a></h1>
			</div>
			<div class="col-md-5">
				<div class="navbar-right">
					<?php echo $this->pusaka->generate_nav(null, 1, "nav nav-pills", null, "active"); ?>
				</div>
			</div>
		</div>
	</div>
</nav>