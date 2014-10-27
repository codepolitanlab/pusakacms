<?php
$links = array(
	'dashboard' => '<span class="fa fa-dashboard"></span><span class="nav-tooltip">Dashboard</span>',
	'content' => array(
		'#' => '<span class="fa fa-file-text-o"></span><span class="nav-tooltip">Content</span>',
		'pages' => '<span class="fa fa-file-text"></span> Pages',
		'posts' => '<span class="fa fa-book"></span> Posts',
		'media' => '<span class="fa fa-picture-o"></span> Media'
		),
	'structure' => array(
		'#' => '<span class="fa fa-newspaper-o"></span><span class="nav-tooltip">Structure</span>',
		'navigation' => '<span class="fa fa-list"></span> Navigation'
		),
	'settings' => array(
		'#' => '<span class="fa fa-gears"></span><span class="nav-tooltip">Settings</span>',
		'settings' => '<span class="fa fa-cog"></span> General',
		'users' => '<span class="fa fa-users"></span> Users'
		),
	'account' => array(
		'#' => '<span class="fa fa-user"></span><span class="nav-tooltip">Account</span>',
		'logout' => '<span class="fa fa-lock"></span> Logout as '.$this->session->userdata('username')
		)
	);
?>

<?php echo $this->pusaka->generate_nav($this->uri->segment(1), 3, "nav nav-pills nav-stacked", "list", "active"); ?>
<ul class="nav navbar-nav">
	<?php foreach ($links as $url => $link): ?>
		<?php if(is_array($link)): ?>
			<li <?php echo ($this->uri->segment(2) == $url)? 'class="dropdown active"' : 'class="dropdown"'; ?>>
				<?php foreach ($link as $url2 => $link2): ?>
					<?php if($url2 == '#'): ?>
						<a href="#" class="dropdown-toggle nav-tooltip" data-toggle="dropdown">
							<?php echo $link2; ?>
						</a>
						<ul class="dropdown-menu">
					<?php else: ?>
						<li>
							<a href="<?php echo site_url('panel/'.$url2); ?>"><?php echo $link2; ?></a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul></li>
		<?php else: ?>
			<li <?php echo ($this->uri->segment(2) == $url)? 'class="active"' : ''; ?>>
				<a href="<?php echo site_url('panel/'.$url); ?>" class="nav-tooltip" data-title="<?php echo $url; ?>"><?php echo $link; ?></a>
			</li>
		<?php endif; 
		endforeach; ?>
	</ul>