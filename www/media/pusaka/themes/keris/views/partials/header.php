<nav class="navbar navbar-default navbar-inverse" role="navigation">
	<div class="container">		
		<div class="row">
			<div class="col-md-12">
				<div class="navbar-header">
					<a class="navbar-brand" href="<?php echo site_url(); ?>"><?php echo $this->config->item('site_name'); ?></a>
				</div>

				<ul class="nav navbar-nav navbar-right">
					<?php echo generate_nav('header', array('has_children_li_class'=>'dropdown')); ?>
				</ul>
			</div>
		</div>
	</div>
</nav>
