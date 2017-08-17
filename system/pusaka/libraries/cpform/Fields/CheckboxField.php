<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/cpform/Fields/BaseField.php';

class CheckboxField extends BaseField {

    public function render(){

        $attribute = '';
        $the_value = isset($this->config['value']) ? $this->config['value'] : '';
        foreach ($this->config as $key => $value) {
            $attribute .= ' '.$key.'="'.$value.'" ';
        }

        $data = array();
        foreach ($this->options as $val => $label) {
            if(is_string($the_value)) $the_value = explode(',', $the_value);
            $checked = in_array($val, $the_value);
            $this->widget .= '<div class="checkbox">';
            $this->widget .= form_checkbox($this->name, $val, $checked, $attribute).' <span class="checkbox-label">'.$label.'</span> ';
            $this->widget .= '</div>';
        }

        return $this->widget;
    }

    public function rules($str){
    	return ctype_alpha($str) || (bool) preg_match('/^[a-zA-Z ]+$/', $str);
    }
}
