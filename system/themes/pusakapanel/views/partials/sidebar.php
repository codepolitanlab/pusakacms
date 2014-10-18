<?php
$links = array(
	'dashboard' => '<span class="fa fa-dashboard"></span><br>Dashboard',
	'pages' => array(
		'#' => '<span class="fa fa-file-text-o"></span><br>Pages',
		'pages' => 'All pages',
		'new_page' => 'Create new'
		),
	'posts'  => array(
		'#' => '<span class="fa fa-book"></span><br>Posts',
		'pages' => 'All posts',
		'new_post' => 'Create new'
		),
	'media' => '<span class="fa fa-picture-o"></span><br>Media',
	'navigation' => '<span class="fa fa-list"></span><br>Navigation',
	'settings' => array(
		'#' => '<span class="fa fa-gears"></span><br>Settings',
		'settings' => 'General',
		'auth' => 'Authentication'
		),
	);
	?>

	<div class="sidebar">
		<?php echo $this->pusaka->generate_nav($this->uri->segment(1), 3, "nav nav-pills nav-stacked", "list", "active"); ?>
		<ul class="nav nav-pills nav-stacked">
			<?php foreach ($links as $url => $link): ?>
				<?php if(is_array($link)): ?>
					<li <?php echo ($this->uri->segment(2) == $url)? 'class="active"' : ''; ?>>
					<?php foreach ($link as $url2 => $link2): ?>
						<?php if($url2 == '#'): ?>
							<a href="<?php echo site_url('panel/'.$url); ?>"><?php echo $link2; ?></a><ul class="">
						<?php else: ?>
							<li <?php echo ($this->uri->segment(2) == $url)? 'class="active"' : ''; ?>>
								<a href="<?php echo site_url('panel/'.$url2); ?>"><?php echo $link2; ?></a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
					</ul></li>
				<?php else: ?>
				<li <?php echo ($this->uri->segment(2) == $url)? 'class="active"' : ''; ?>>
					<a href="<?php echo site_url('panel/'.$url); ?>"><?php echo $link; ?></a>
				</li>
			<?php endif; 
				endforeach; ?>
		</ul>
	</div>