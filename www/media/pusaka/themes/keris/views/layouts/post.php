<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_partial('metadata'); ?>
</head>
<body>
	<?php get_partial('header_blog'); ?>

	<div class="container">		
		<div class="row">
			<div class="col-md-10 col-md-offset-1">

				<div class="content-wrapper">

					<article class="the-content">
						<h1><?php echo $post['title']; ?></h1>

						<span class="date"><i class="glyphicon glyphicon-calendar"></i> <?php echo date("d F Y", strtotime($post['date'])); ?></span>
						<?php if(isset($post['labels'])): ?>
						<span class="cat">
							<i class="glyphicon glyphicon-tags"></i>
							<?php foreach ($post['labels'] as $label): ?>
								<span><?php echo anchor(POST_TERM.'/label/'.$label, $label); ?></span>
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
			<!--<div class="col-md-3">
				<?php /* get_partial('post_sidebar'); */ ?>
			</div>-->
		</div>
	</div>

	<?php get_partial('footer'); ?>
</body>
</html>