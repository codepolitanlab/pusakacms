<?php
$links = array(
	'/' => '<span class="fa fa-dashboard fa-fw"></span><span class="nav-tooltip">Dashboard</span>',
	'content' => array(
		'#' => '<span class="fa fa-file-text-o fa-fw"></span><span class="nav-tooltip">Content</span>',
		'pages' => '<span class="fa fa-file fa-fw"></span><span class="nav-tooltip">Pages</span>',
		'posts' => '<span class="fa fa-file-text-o fa-fw"></span><span class="nav-tooltip">Articles</span>',
		'media' => '<span class="fa fa-picture-o fa-fw"></span><span class="nav-tooltip">Gallery</span>'
		),
	'navigation' => '<span class="fa fa-list fa-fw"></span><span class="nav-tooltip">Navigation</span>',
	'settings' => '<span class="fa fa-gears fa-fw"></span><span class="nav-tooltip">Settings</span>',
	'account' => array(
		'#' => '<span class="fa fa-user fa-fw"></span><span class="nav-tooltip">Account</span>',
		'logout' => '<span class="fa fa-lock fa-fw"></span><span class="nav-tooltip">Logout as '.$this->session->userdata(SITE_SLUG.'_username').'</span>'
		)
	);
?>

<ul class="nav navbar-nav">
	<!--<li>
		<a href="<?php echo site_url('/'); ?>" target="_blank">Pusaka</a>
	</li>-->
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