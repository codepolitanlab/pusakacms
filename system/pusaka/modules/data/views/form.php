<form action="<?php echo ($type == 'add') ? $add_url : $edit_url . '/' . $current_data['id'];?>" method="post">

	<input type="hidden" name="id" value="<?php echo (isset($current_data['id'])) ? $current_data['id'] : '';?>">

	<?php
	foreach ($structure as $field)
		if (isset($field['input_type']))
			$this->load->view('fieldtype/admin/'.$field['input_type'], $field);
	?>

	<button class="btn btn-default"type="submit"><?php echo $button_name;?></button><br/>
</form>

