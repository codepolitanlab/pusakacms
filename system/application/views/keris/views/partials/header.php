<nav class="navbar navbar-default navbar-inverse" role="navigation">
	<div class="container">		
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="navbar-header">
					<a class="navbar-brand" href="<?php echo site_url(); ?>"><?php echo $this->config->item('site_title'); ?></a>
				</div>

				<?php
					$config = array(
						"ul_class" => "nav navbar-nav navbar-right",
						"current_class" => "active",
						"start" => "/",
						"depth" => 1
						);

					$this->fizl->initialize($config);
					echo $this->fizl->nav(null, 1);
				?>
			</div>
		</div>
	</div>
</nav>
