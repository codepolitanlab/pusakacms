<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>

	<!-- MAIN WRAPPER -->
	<div class="main-wrapper" data-spy="scroll" data-target=".collapse">


		<nav class="navbar navbar-fixed-top" role="navigation">
		  	<div class="container">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			      	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
			      	</button>
			      	<a class="navbar-brand" href="#"><?php echo site_config('site_name'); ?></a>
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      	<ul class="nav navbar-nav navbar-right">
				        <li><a href="#">Home</a></li>
				        <li><a href="#">Blog</a></li>
				        <li><a href="#">Contact</a></li>
			      	</ul>
			    </div><!-- /.navbar-collapse -->
		  	</div><!-- /.container-fluid -->
		</nav>


		<!-- HEADER -->
		<header class="home-header">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-6">
						<div class="jumbo-lead">

							<h1 class="margin-lg-bottom">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt</h1>

							<a href="#" class="btn btn-default btn-lg">Download</a>

						</div>
					</div>
				</div>
			</div>
		</header>
		<!-- END: HEADER -->


		<!-- MAIN CONTENT -->
		<div class="home-content">
			<div class="container">
				<?php echo $template['body']; ?>
			</div>
		</div>
		<!-- END: MAIN CONTENT -->



		<footer class="home-footer text-center">
			<div class="container">
				Copyright &copy; Nyankod. Powered by PusakaCMS. All rights reserved. 
			</div>
		</div>


	</div>
	<!-- END: MAIN WRAPPER -->


	<!-- JavaScript -->
	<script src="<?php echo get_theme_url() ?>/assets/js/jquery.min.js"></script>
	<script src="<?php echo get_theme_url() ?>/assets/js/bootstrap.min.js"></script>
	<script src="<?php echo get_theme_url() ?>/assets/js/classie.js"></script>
	<script src="<?php echo get_theme_url() ?>/assets/js/script.js"></script>
</body>
</html>