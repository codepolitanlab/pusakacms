<nav class="navbar navbar-default navbar-inverse" role="navigation">
	<div class="container">		
		<div class="row">
			<div class="col-md-12">
				<div class="navbar-header">
					<a class="navbar-brand" href="<?php echo site_url(); ?>"><?php echo $this->config->item('site_title'); ?></a>
				</div>

				<?php
					$config = array(
						"ul_class" => "nav navbar-nav navbar-right",
						"current_class" => "active"
						);

					$this->pusaka->initialize($config);
					echo $this->pusaka->nav(null, 1);
				?>
			</div>
		</div>
	</div>
</nav>
