<?php foreach( $users as $user ):?>

	<div class="user" data-name="<?php echo $user['userData']->first_name?> <?php echo $user['userData']->last_name;?>">
	
		<div class="topPart clearfix">
											
			<img src="<?php echo get_theme_image('dude.png', false);?>" class="pic">
										
			<div class="details">
			
				<h4><?php echo $user['userData']->first_name?> <?php echo $user['userData']->last_name;?></h4>
				
				<p>
					<span class="fui-mail"></span> <a href=""><?php echo $user['userData']->email;?></a>
				</p>
			
			</div><!-- /.details -->
		
		</div><!-- /.topPart -->
		
		<div class="bottom">
		
			<div class="loader" style="display: none;">
				<img src="<?php echo get_theme_image('loading.gif', false);?>" alt="Loading...">
			</div>
			
			<div class="alerts"></div>
								
			<ul class="nav nav-tabs nav-append-content">
				<li class="active"><a href="#<?php echo $user['userData']->id;?>_account"><span class="fui-user"></span> <?php echo $this->lang->line('users_tab_account')?></a></li>
				<li><a href="#<?php echo $user['userData']->id;?>_sites"><span class="fui-window"></span> <?php echo $this->lang->line('users_tab_sites')?> (<span class="text-primary"><?php echo count($user['sites'])?></span>)</a></li>
			</ul><!-- /tabs -->
		
			<div class="tab-content clearfix">
			
				<div class="tab-pane clearfix" id="<?php echo $user['userData']->id;?>_sites">
					
					<div class="userSites">
						
						<?php if( count($user['sites']) == 0 ):?>
						<!-- Alert Info -->
						<div class="alert alert-info">
							<button type="button" class="close fui-cross" data-dismiss="alert"></button>
						  	<?php echo $this->lang->line('users_nosites')?>
						</div>
						<?php endif;?>
						
						<?php foreach( $user['sites'] as $site ):?>
						<div class="userSite site">
						
							<div class="window">
							
								<div class="top">
								
									<div class="buttons clearfix">
										<span class="left red"></span>
									 	<span class="left yellow"></span>
										<span class="left green"></span>
									</div>
									
									<b><?php echo $site['siteData']->sites_name;?></b>
									
								</div><!-- /.top -->
								
								<div class="viewport">
									
									<?php if( $site['lastFrame'] != '' ):?>
										<iframe src="<?php echo site_url('sites/getframe/'.$site['lastFrame']->frames_id)?>" frameborder="0" scrolling="0" data-height="<?php echo $site['lastFrame']->frames_height?>" data-siteid="<?php echo $site['siteData']->sites_id?>"></iframe>
									<?php else:?>
										<a href="<?php echo site_url('sites/'.$site['siteData']->sites_id)?>" class="placeHolder">
											<span><?php echo $this->lang->line('sites_empty_placeholder')?></span>
										</a>
									<?php endif;?>
								
								</div><!-- /.viewport -->
																			
							</div><!-- /.window -->
							
							<div class="siteButtons clearfix">
								<a href="<?php echo site_url('sites/'.$site['siteData']->sites_id)?>" class="btn btn-primary btn-sm btn-embossed"><span class="fui-new"></span> <?php echo $this->lang->line('users_button_edit')?></a>
								<a href="#" class="btn btn-info btn-sm btn-embossed siteSettingsModalButton" data-siteid="<?php echo $site['siteData']->sites_id?>"><span class="fui-gear"></span> <?php echo $this->lang->line('users_button_settings')?></a>
								<a href="#deleteSiteModal" class="btn btn-danger btn-sm btn-embossed deleteSiteButton" data-siteid="<?php echo $site['siteData']->sites_id?>"><span class="fui-trash"></span> <?php echo $this->lang->line('users_button_delete')?></a>
							</div>
						
						</div><!-- /.userSite -->
						<?php endforeach;?>
																									
					</div><!-- /.userSites -->
					
				</div><!-- /.tab-pane -->
		
				<div class="tab-pane active" id="<?php echo $user['userData']->id;?>_account">
				
					<?php $this->load->view('partials/userdetailsform', array('user'=>$user));?>
					
					<hr class="dashed">
					
					<div class="actions clearfix">
						<a href="#" class="btn btn-info btn-embossed btn-block passwordReset" data-userid="<?php echo $user['userData']->id;?>"><span class="fui-mail"></span> <?php echo $this->lang->line('users_button_sendpasswordreset')?></a>
						<a href="<?php echo site_url('users/delete/'.$user['userData']->id)?>" class="btn btn-danger btn-embossed btn-block deleteUserButton"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('users_button_deleteaccount')?></a>
					</div><!-- /.actions -->
				
				</div><!-- /.tab-pane -->
				
			</div> <!-- /tab-content -->
		
		</div><!-- /.bottom -->
	
	</div><!-- /.user -->
	
<?php endforeach;?>