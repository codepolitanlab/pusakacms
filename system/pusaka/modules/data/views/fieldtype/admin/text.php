<?php echo $name;?><br/>
<input class="form-control col-xs-3" type="text" name="<?php echo $field;?>" value="<?php echo (isset($current_data[$field])) ? $current_data[$field] : $this->form_validation->set_value($field);?>" <?php echo (isset($disable_update)) ? 'disabled="disabled"' : '';?>>
<br/><br/>