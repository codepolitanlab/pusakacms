<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<?php get_partial('book_metadata'); ?>
</head>
<body>
	<?php get_partial('book_navbar'); ?>

	<?php get_partial('book_header'); ?>

	<!-- Begin page content -->
	<div class="container paper">
		<?php echo $template['body']; ?>
	</div>

	<nav class="navbar-fixed-bottom">
		<ul class="pager">
			<li class="previous">
				<a href="#">
					<span class="prev-btn"><span class="glyphicon glyphicon-step-backward"></span> Prev</span>
					<span class="bab">Bab 1 : Kamu Sudah bisa Apa Aja?</span>
				</a>
			</li>
			<li class="next">
				<a href="#">
					<span class="bab">Bab 3 : Donlot dan Install</span>
					<span class="next-btn">Next <span class="glyphicon glyphicon-step-forward"></span></span>
				</a>
			</li>
		</ul>
	</nav>
	
	<!-- Classie - class helper functions by @desandro https://github.com/desandro/classie -->
	<script src="<?php echo get_theme_url() ?>assets/js/classie.js"></script>
	<script>
		var menuLeft = document.getElementById( 'spmenu-s1' ),
		menuRight = document.getElementById( 'spmenu-s2' ),
		showLeftPush = document.getElementById( 'showLeftPush' ),
		body = document.body;

		showLeftPush.onclick = function() {
			classie.toggle( this, 'active' );
			classie.toggle( body, 'spmenu-toright' );
			classie.toggle( menuLeft, 'spmenu-open' );
			disableOther( 'showLeftPush' );
		};
	</script>
</body>
</html>