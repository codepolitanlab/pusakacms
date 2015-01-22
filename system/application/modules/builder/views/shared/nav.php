<nav class="mainnav navbar navbar-inverse navbar-embossed navbar-fixed-top" role="navigation" id="mainNav">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
			<span class="sr-only"><?php echo $this->lang->line('nav_toggle_navigation')?></span>
		</button>
		<a class="navbar-brand" href="<?php echo site_url()?>">
			<!--<img src="<?php echo base_url();?>images/logo.png" style="height: 30px; position: relative; top: -3px; margin-right: 5px;">-->
			<?php echo $this->lang->line('nav_name')?>
		</a>
	</div>
	<div class="collapse navbar-collapse" id="navbar-collapse-01">
		<ul class="nav navbar-nav">
			
			<?php if( isset($siteData) || ( isset($page) && $page == 'newPage' ) ):?>
		
				<?php if( isset($siteData) ):?>
				<li class="active">
					<a><span class="fui-home"></span> <span id="siteTitle"><?php echo $siteData['site']->sites_name?></span></a>
				</li>
				<?php endif;?>
				<?php if( isset($page) && $page == 'newPage' ):?>
				<li class="active">
					<a><span class="fui-home"></span> <span id="siteTitle"><?php echo $this->lang->line('newsite_default_title')?></span> </a>
				</li>
				<?php endif;?>
								
				<?php if( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '' ):?>
				
					<?php
						
						//find out where we came from :)
						
						$temp = explode("/", $_SERVER['HTTP_REFERER']);
						
						if( array_pop($temp) == 'users' ) {
						
							$t = 'nav_goback_users';
							$to = site_url('users');
						
						} else {
							
							$t = 'nav_goback_sites';
							$to = site_url('sites');
						
						}
						
					?>
				
					<li><a href="<?php echo $_SERVER['HTTP_REFERER']?>" id="backButton"><span class="fui-arrow-left"></span> <?php echo $this->lang->line( $t )?></a></li>
			
				<?php else:?>
				
					<li><a href="<?php echo site_url('sites')?>" id="backButton"><span class="fui-arrow-left"></span> <?php echo $this->lang->line('nav_goback_users')?></a></li>
				
				<?php endif;?>
			
			<?php else:?>
			
				<li <?php if( isset($page) && $page == "sites" ):?>class="active"<?php endif;?>><a href="<?php echo site_url('sites')?>"><span class="fui-windows"></span> <?php echo $this->lang->line('nav_sites')?></a></li>
      			<li <?php if( isset($page) && $page == "images" ):?>class="active"<?php endif;?>><a href="<?php echo site_url('assets/images')?>"><span class="fui-image"></span> <?php echo $this->lang->line('nav_imagelibrary')?></a></li>
      			<?php if( $this->ion_auth->is_admin() ):?>
      			<li <?php if( isset($page) && $page == "users" ):?>class="active"<?php endif;?>><a href="<?php echo site_url('users')?>"><span class="fui-user"></span> <?php echo $this->lang->line('nav_users')?></a></li>
      			<li <?php if( isset($page) && $page == "settings" ):?>class="active"<?php endif;?>><a href="<?php echo site_url('settings')?>"><span class="fui-gear"></span> <?php echo $this->lang->line('nav_settings')?></a></li>
      			<?php endif;?>
      		
      		<?php endif;?>
		</ul>
		<ul class="nav navbar-nav navbar-right" style="margin-right: 20px;">
			<li class="dropdown">
				<?php
					$u = $this->ion_auth->user()->row();
				?>
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi, <?php echo $u->first_name." ".$u->last_name;?> <b class="caret"></b></a>
				<span class="dropdown-arrow"></span>
			  	<ul class="dropdown-menu">
			    	<li><a href="#accountModal" data-toggle="modal"><span class="fui-cmd"></span> <?php echo $this->lang->line('nav_myaccount')?></a></li>
			    	<li class="divider"></li>
			    	<li><a href="<?php echo site_url('logout')?>"><span class="fui-exit"></span> <?php echo $this->lang->line('nav_logout')?></a></li>
			  	</ul>
			</li>			      
		</ul>	      
	</div><!-- /.navbar-collapse -->
</nav><!-- /navbar -->