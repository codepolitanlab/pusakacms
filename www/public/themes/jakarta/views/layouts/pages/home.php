<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>

	<!-- MAIN WRAPPER -->
	<div class="main-wrapper" data-spy="scroll" data-target=".collapse">


		<?php 
		/* Show navbar */
		get_partial('navbar'); 
		?>


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



		<!-- FOOTER -->
		<footer class="home-footer text-center">
			<div class="container">
				Copyright &copy; Nyankod. Powered by PusakaCMS. All rights reserved. 
			</div>
		</div>
		<!-- END: FOOTER -->


	</div>
	<!-- END: MAIN WRAPPER -->


	<!-- JavaScript -->
	<script src="<?php echo vendor_url('jquery', 'jquery-1.7.2.min.js') ?>"></script>
	<script src="<?php echo vendor_url('bootstrap', '3.2.0/js/bootstrap.min.js') ?>"></script>

</body>
</html>