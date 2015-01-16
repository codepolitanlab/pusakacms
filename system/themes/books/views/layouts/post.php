<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>

	<header class="blog-detail-header">
		<div class="blog-nav">
			<div class="nav-left">
				<a href="<?php echo site_url('blog'); ?>" class="btn btn-border-grey"><span class="fa fa-long-arrow-left"></span> Back</a>
			</div>
			<div class="nav-right">
				<a href="<?php echo site_url(); ?>" class="blog-detail-logo-btn"><?php echo site_config('site_name'); ?></a>
			</div>
		</div>
	</header>


	<div class="blog-content blog-detail">
		<div class="container">		
			<div class="row">
				<div class="col-md-10 col-md-offset-1">

					<article class="the-content">
						<h1><?php echo $post['title']; ?></h1>

						<span class="date"><?php echo date("d F Y", strtotime($post['date'])); ?></span>
						<?php if(isset($post['labels'])): ?>
							<span class="cat">
								<?php foreach ($post['labels'] as $post_label): ?>
									<span><?php echo anchor(POST_TERM.'/label/'.$post_label, $post_label); ?></span>
								<?php endforeach; ?>
							</span>
						<?php endif; ?>

						<div class="content">
							<?php echo $post['content']; ?>
						</div>
					</article>


					<?php if( $this->config->item('disqus_shortname') != null ): ?>
						<article>
							<div id="disqus_thread"></div>
							<script type="text/javascript">
								/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
		        				var disqus_shortname = '<?php echo $this->config->item("disqus_shortname"); ?>'; // required: replace example with your forum shortname

						        /* * * DON'T EDIT BELOW THIS LINE * * */
						        (function() {
						        	var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
						        	dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
						        	(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
						        })();
						    </script>
						    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
						    <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
						</article>
					<?php endif; ?>

				</div>
			
			</div>
		</div>
	</div>


	<?php get_partial('footer'); ?>
</body>
</html>