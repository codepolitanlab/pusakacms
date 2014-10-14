<nav class="navbar navbar-default navbar-inverse" role="navigation">
	<div class="container">		
		<div class="row">
			<div class="col-md-12">
				<div class="navbar-header">
					<a class="navbar-brand" href="<?php echo site_url(); ?>"><?php echo $this->config->item('site_name'); ?></a>
				</div>

				<?php echo $this->pusaka->generate_nav(null, 1, "nav navbar-nav navbar-right", null, "active"); ?>
			</div>
		</div>
	</div>
</nav>
