<div class="form-group">
	<label><?php echo $label;?></label>
	<?php if(isset($desc) && !empty($desc)): ?>
		<small><?php echo $desc; ?></small>
	<?php endif; ?>
	
	<?php 
	$options = array();
	foreach ($select_options as $opt) {
		$options[$opt['options_value']] = $opt['options_attr']['caption'];
	}
	?>

	<?php echo form_dropdown($name, $options, (isset($current_data[$name])?$current_data[$name]:''), $extra); ?>
</div>