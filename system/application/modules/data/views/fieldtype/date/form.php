<div class="form-group">
	<label for="<?php echo $name; ?>"><?php echo $label;?></label> 
	<?php if(isset($desc) && !empty($desc)): ?>
		<small><?php echo $desc; ?></small>
	<?php endif; ?>

	<?php 
		$val = (isset($current_data[$name])) ? html_escape($current_data[$name]) : $this->form_validation->set_value($name);
		$attr = '';
		if(is_array($extra))
			foreach ($extra as $key => $value)
				$attr .= $key .'="'. $value .'" ';
		else
			$attr = $extra;
	?>
	<input type="text" name="<?php echo $name;?>" value="<?php echo (isset($current_data[$name])) ? $current_data[$name] : $this->form_validation->set_value($name);?>" <?php echo (isset($disable_update)) ? 'disabled="disabled"' : '';?> <?php echo $attr; ?> id="<?php echo $name;?>">
</div>

<script type="text/javascript">
	$('#<?php echo $name;?>').datepick();
</script>