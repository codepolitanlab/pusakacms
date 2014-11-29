<!-- NAVBAR -->
<nav class="navbar" role="navigation">
	<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			   <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				    <span class="sr-only">Toggle navigation</span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
			   </button>
			   <a class="navbar-brand" href="<?php echo site_url(); ?>"><?php echo site_config('site_name'); ?></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			   <ul class="nav navbar-nav navbar-right">
			   		<?php echo generate_nav('header', array('has_children_li_class'=>'dropdown')); ?>
			   </ul>
			</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<!-- END: NAVBAR -->