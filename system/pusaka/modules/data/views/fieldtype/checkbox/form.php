<div class="form-group">
	<label for="<?php echo $name; ?>"><?php echo $label;?></label> 
	<?php if(isset($desc) && !empty($desc)): ?>
		<small><?php echo $desc; ?></small>
	<?php endif; ?>

	<?php $val = isset($current_data[$name]) ? (is_array($current_data[$name]) ? $current_data[$name] : explode(',', $current_data[$name])) : array(); ?>

	<?php foreach ($select_options as $key => $caption): ?>
		<div class="checkbox">
			<?php echo form_checkbox($name.($multiple?'[]':''), $key, in_array($key, $val), $extra); echo $caption; ?>
		</div>
	<?php endforeach ?>
</div>