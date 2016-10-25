<div class="form-group">
	<label for="<?php echo $name; ?>"><?php echo $label;?></label> 
	<?php if(isset($desc) && !empty($desc)): ?>
		<small><?php echo $desc; ?></small>
	<?php endif; ?>
	
	<?php echo form_password($name, null, $extra); ?>
</div>