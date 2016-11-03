<header class="blog-header">
	<div class="blog-nav">
		<div class="nav-left">
			<a href="<?php echo site_url(); ?>" class="btn btn-border"><span class="fa fa-home"></span></a>
		</div>
		<div class="nav-right">
			<a href="<?php echo site_url('blog'); ?>" class="btn btn-border">Blog</a>
		</div>
	</div>

	<h1><a href="<?php echo site_url(); ?>"><?php echo $page['title']; ?></a></h1>
</header>


<div class="blog-content blog-detail">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">

				<article class="the-content">
					<?php echo $page['content']; ?>
				</article>

			</div>

		</div>
	</div>
</div>