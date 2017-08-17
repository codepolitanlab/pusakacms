<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/cpform/Fields/BaseField.php';

class DropdownField extends BaseField {

    public function render(){

        $attribute = array();

        foreach ($this->config as $key => $value) {
            $attribute[$key] = $value;
        }

        if( (is_array($this->rules) && ! isset($this->rules['required'])) ||
            (is_string($this->rules) && strpos($this->rules, 'required') === false) )
            array_unshift($this->options, '-- '. $this->config['placeholder'] .' --');

        $this->widget = form_dropdown($this->name, $this->options, $this->initial, $attribute);

        return $this->widget;
    }

    public function rules($str){
    	return ctype_alpha($str) || (bool) preg_match('/^[a-zA-Z ]+$/', $str);
    }
}
