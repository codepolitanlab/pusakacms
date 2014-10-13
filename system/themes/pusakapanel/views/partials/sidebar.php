<?php
$links = array(
	'dashboard' => 'Dashboard',
	'pages' => 'Pages',
	'posts' => 'Posts',
	'media' => 'Media',
	'menus' => 'Menus',
	'settings' => 'Settings',
	);
	?>

	<div class="sidebar">
		<?php echo $this->pusaka->generate_nav($this->uri->segment(1), 3, "nav nav-pills nav-stacked", "list", "active"); ?>
		<ul class="nav nav-pills nav-stacked">
			<?php foreach ($links as $url => $link): ?>
				<li <?php echo ($this->uri->segment(2) == $url)? 'class="active"' : ''; ?>>
					<a href="<?php echo site_url('panel/'.$url); ?>"><?php echo $link; ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>