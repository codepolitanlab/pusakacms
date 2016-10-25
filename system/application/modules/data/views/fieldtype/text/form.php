<div class="form-group">
	<label for="<?php echo $name; ?>"><?php echo $label;?></label> 
	<?php if(isset($desc) && !empty($desc)): ?>
		<small><?php echo $desc; ?></small>
	<?php endif; ?>

	<?php 
		$val = (isset($current_data[$name])) ? html_escape($current_data[$name]) : $this->form_validation->set_value($name);
		echo form_input($name, $val, $extra); 
	?>
</div>