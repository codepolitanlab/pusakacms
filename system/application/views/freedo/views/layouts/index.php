<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>
	<?php get_partial('header'); ?>

	<div class="container">
		<div class="row jumbotron">
			<div class="col-md-10 col-md-offset-1">
				<h1>Jumbotron heading</h1>
				<p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
				<p><a class="btn btn-lg btn-success" href="#" role="button">Sign up today</a></p>
			</div>
		</div>

		<div class="row marketing">
			<div class="col-md-5 col-md-offset-1">
				<h4>Subheading</h4>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim iste recusandae sequi magnam temporibus maxime minus similique accusamus ullam? Tenetur eius natus, quibusdam! Laborum odit, autem aut odio eos nisi.Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

				<h4>Subheading</h4>
				<p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque atque qui, quod quae officiis enim cum delectus totam quas voluptate possimus, magnam! Repudiandae, repellat quisquam doloremque rem modi vero tenetur.</p>

			</div>

			<div class="col-lg-5">
				<h4>Subheading</h4>
				<p>Donec id elit non mi porta gravida at eget metus. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat nesciunt officiis, tempore laboriosam tenetur nisi consequatur, est quasi amet excepturi similique unde qui deleniti asperiores expedita alias veritatis earum fugit. Maecenas faucibus mollis interdum.</p>

				<h4>Subheading</h4>
				<p>Morbi leo risus, porta ac consectetur ac, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi porro aspernatur labore animi at quos facilis asperiores aliquam. Unde fugit totam voluptatem quos porro ea incidunt temporibus doloribus quae cum. vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>
			</div>
		</div>

		<div class="row">
			<?php
				echo $this->fizl->nav('guides');
			?>
		</div>
	</div>
	
	<?php get_partial('footer'); ?>
</body>
</html>