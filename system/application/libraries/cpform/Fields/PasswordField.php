<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/cpform/Fields/BaseField.php';

class PasswordField extends BaseField {

    public function render(){

        $this->widget = '<input type="password"';

        foreach ($this->config as $key => $value) {
            $attribute = $key.'="'.$value.'"';
            $this->widget .= ' '.$attribute.' ';
        }

        $this->widget .= ' name="'.$this->name.'" ';
        $this->widget .= ' />';

        return $this->widget;
    }

    public function rules($str){
    	return ctype_alpha($str) || (bool) preg_match('/^[a-zA-Z ]+$/', $str);
    }
}
