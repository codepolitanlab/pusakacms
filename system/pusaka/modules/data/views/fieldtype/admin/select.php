<?php echo $name;?><br/>
<select class="form-control" name="<?php echo $field;?>">
	<option value="">-- <?php echo $name;?> Options --</option>
	
	<?php
	foreach ($select_options as $options => $options_item)
	{
	?>
	<option value="<?php echo $options_item['options_value'];?>" <?php echo ($type == 'edit' && $options_item['options_value'] == $current_data[$field]) ? 'selected="selected"' : '';?>><?php echo $options_item['options_label'];?></option>
	<?php
	}
	?>
</select>
<br/>