<div class="modal fade accountModal" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	
	<div class="modal-dialog">
    	
    	<div class="modal-content">
      		
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $this->lang->line('modal_close')?></span></button>
        		<h4 class="modal-title" id="myModalLabel"> <?php echo $this->lang->line('account_myaccount')?></h4>
      		</div>
      		      	
      		<div class="modal-body padding-top-40">
      			
      			<ul class="nav nav-tabs nav-append-content">
					<li class="active"><a href="#myAccount"><span class="fui-user"></span> <?php echo $this->lang->line('account_tab_account')?></a></li>
				</ul> <!-- /tabs -->
      	
				<div class="tab-content">
				
					<?php
					
						$user = $this->ion_auth->user()->row();
					
					?>
				
					<div class="tab-pane active" id="myAccount">
													
						<form class="form-horizontal" role="form" id="account_details" >
						
							<div class="loader" style="display: none;">
								<img src="<?php echo get_theme_image('loading.gif', false);?>" alt="Loading...">
							</div>
							
							<div class="alerts"></div>
						
							<input type="hidden" name="userID" value="<?php echo $user->id;?>">
							<div class="form-group">
								<label for="name" class="col-md-3 control-label"><?php echo $this->lang->line('account_label_first_name')?></label>
								<div class="col-md-9">
						  			<input type="text" class="form-control" id="firstname" name="firstname" placeholder="<?php echo $this->lang->line('account_label_first_name')?>" value="<?php echo $user->first_name;?>">
								</div>
							</div>
							<div class="form-group">
								<label for="name" class="col-md-3 control-label"><?php echo $this->lang->line('account_label_last_name')?></label>
								<div class="col-md-9">
										<input type="text" class="form-control" id="lastname" name="lastname" placeholder="<?php echo $this->lang->line('account_label_last_name')?>" value="<?php echo $user->last_name;?>">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-3 col-md-9">
									<button type="button" class="btn btn-primary btn-embossed btn-block" id="accountDetailsSubmit"><span class="fui-check"></span> <?php echo $this->lang->line('account_button_updatedetails')?></button>
								</div>
							</div>
						</form>
					
						<hr class="dashed">
						
						<form class="form-horizontal" role="form" id="account_login">
						
							<div class="loader" style="display: none;">
								<img src="<?php echo get_theme_image('loading.gif', false);?>" alt="Loading...">
							</div>
							
							<div class="alerts"></div>
						
							<input type="hidden" name="userID" value="<?php echo $user->id;?>">
							<div class="form-group">
								<label for="username" class="col-md-3 control-label"><?php echo $this->lang->line('account_label_username')?></label>
								<div class="col-md-9">
						  			<input type="text" class="form-control" id="email" name="email" placeholder="<?php echo $this->lang->line('account_label_username')?>" value="<?php echo $user->email;?>">
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-md-3 control-label"><?php echo $this->lang->line('account_label_password')?></label>
								<div class="col-md-9">
						  			<input type="password" class="form-control" id="password" name="password" placeholder="<?php echo $this->lang->line('account_label_password')?>" value="">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-3 col-md-9">
									<button type="button" class="btn btn-primary btn-embossed btn-block" id="accountLoginSubmit"><span class="fui-check"></span> <?php echo $this->lang->line('account_button_updatedetails')?></button>
								</div>
							</div>
						</form>
						
					</div>
      	
				</div> <!-- /tab-content -->
      				        	
      		</div><!-- /.modal-body -->
      			      		
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fui-cross"></span> <?php echo $this->lang->line('modal_cancelclose')?></button>
      		</div>
      		
    	</div><!-- /.modal-content -->
    	
  	</div><!-- /.modal-dialog -->
  		  	
</div><!-- /.modal -->