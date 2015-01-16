<form class="form-horizontal" role="form" action="<?php echo site_url('users/update/'.$user['userData']->id)?>">
	
	<input type="hidden" name="userID" value="<?php echo $user['userData']->id;?>">

	<div class="form-group">
		<div class="col-md-12">
  			<input type="text" class="form-control" id="email" name="email" placeholder="<?php echo $this->lang->line('users_emailfield_placeholder')?>" value="<?php echo $user['userData']->email;?>">
		</div>
		</div>
		<div class="form-group">
		<div class="col-md-12">
  			<input type="password" class="form-control" id="password" name="password" placeholder="<?php echo $this->lang->line('users_emailfield_password')?>" value="">
		</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
	        	<label class="checkbox" for="checkbox1" style="padding-top: 0px;">
	       			<input type="checkbox" value="yes" <?php if( $user['is_admin'] == 'yes' ):?>checked<?php endif;?> id="" name="isAdmin" data-toggle="checkbox">
	       			<?php echo $this->lang->line('users_adminpermissions');?>
			</label>
	    	</div>
	</div>
		<div class="form-group">
		<div class="col-md-12">
  			<button type="button" class="btn btn-primary btn-embossed btn-block updateUserButton" data-userid="<?php echo $user['userData']->id;?>"><span class="fui-check"></span> <?php echo $this->lang->line('users_button_udpate')?></button>
		</div>
		</div>
</form>