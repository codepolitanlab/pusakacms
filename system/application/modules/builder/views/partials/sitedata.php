<form class="form-horizontal" role="form" id="siteSettingsForm">
	
		<input type="hidden" name="siteID" id="siteID" value="<?php echo $data['site']->sites_id;?>">

		<div id="siteSettingsWrapper" class="siteSettingsWrapper">
		        			
			<div class="optionPane">
				
				<h6><?php echo $this->lang->line('sitedata_sitedetails')?></h6>
				
				<div class="form-group">
					<label for="name" class="col-sm-3 control-label"><?php echo $this->lang->line('sitedata_label_name')?></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="siteSettings_siteName" name="siteSettings_siteName" placeholder="<?php echo $this->lang->line('sitedata_label_name')?>" value="<?php echo $data['site']->sites_name;?>">
					</div>
				</div>
				
			</div><!-- /.optionPane -->     				
			
			<div class="optionPane">
			
				<h6><?php echo $this->lang->line('sitedata_publishingdetails')?></h6>
			
				<div class="form-group">
					<label for="server" class="col-sm-3 control-label"><?php echo $this->lang->line('sitedata_label_publicurl')?></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="siteSettings_remoteUrl" name="siteSettings_remoteUrl" placeholder="<?php echo $this->lang->line('sitedata_label_publicurl_placeholder')?>" value="<?php echo $data['site']->remote_url;?>">
					</div>
				</div>
				<div class="form-group">
					<label for="server" class="col-sm-3 control-label"><?php echo $this->lang->line('sitedata_label_ftpserver')?></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="siteSettings_ftpServer" name="siteSettings_ftpServer" placeholder="<?php echo $this->lang->line('sitedata_label_ftpserver')?>" value="<?php echo $data['site']->ftp_server;?>">
					</div>
				</div>
				<div class="form-group">
					<label for="user" class="col-sm-3 control-label"><?php echo $this->lang->line('sitedata_label_ftpuser')?></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="siteSettings_ftpUser" name="siteSettings_ftpUser" placeholder="<?php echo $this->lang->line('sitedata_label_ftpuser')?>" value="<?php echo $data['site']->ftp_user;?>">
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-sm-3 control-label"><?php echo $this->lang->line('sitedata_label_ftppassword')?></label>
					<div class="col-sm-9">
						<input type="password" class="form-control" id="siteSettings_ftpPassword" name="siteSettings_ftpPassword" placeholder="<?php echo $this->lang->line('sitedata_label_ftppassword')?>" value="<?php echo $data['site']->ftp_password;?>">
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-sm-3 control-label"><?php echo $this->lang->line('sitedata_label_ftpport')?></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="siteSettings_ftpPort" name="siteSettings_ftpPort" placeholder="<?php echo $this->lang->line('sitedata_label_ftpport_placeholder')?>" value="<?php if( $data['site']->ftp_port != 0 ){echo $data['site']->ftp_port;}else{echo "21";}?>">
					</div>
				</div>
				<div class="form-group">
					<label for="path" class="col-sm-3 control-label"><?php echo $this->lang->line('sitedata_label_ftppath')?></label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="siteSettings_ftpPath" name="siteSettings_ftpPath" placeholder="<?php echo $this->lang->line('sitedata_label_ftppath')?>" value="<?php if( $data['site']->ftp_path != '' ){echo $data['site']->ftp_path;}else{echo "/";}?>">
					</div>
					<div class="col-sm-3">
						<button type="button" class="btn btn-info btn-embossed btn-block " id="siteSettingsBrowseFTPButton"><span class="fui-search"></span> <?php echo $this->lang->line('sitedata_button_browseserver')?></button>
					</div>
				</div>
				<div class="form-group ftpBrowse" id="ftpBrowse">
					<div class="col-sm-6 col-sm-offset-3">
						
						<div class="ftpList" id="ftpList">
						
							<div class="loaderFtp">
								<img src="<?php echo get_theme_image('loading.gif', false);?>" alt="Loading...">
								<?php echo $this->lang->line('sitedata_connectingtoftp')?>
							</div>
							
							<div id="ftpAlerts"></div>
						
							<div id="ftpListItems"></div>
						
						</div><!-- /.ftpList -->
						
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						<button type="button" class="btn btn-inverse btn-embossed btn-wide" id="siteSettingsTestFTP"><span class="fui-power"></span> <?php echo $this->lang->line('sitedata_button_testftpconnection')?></button>
						<span class="FTP_Connecting" style="display: none;"><?php echo $this->lang->line('sitedata_testingftpconnection')?></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9" id="ftpTestAlerts">
					
					</div>
				</div>
			
			</div><!-- ./optionPane -->
			
	
		</div><!-- /.siteSettingsWrapper -->
	
	</form>