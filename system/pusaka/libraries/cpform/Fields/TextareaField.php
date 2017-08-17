<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/cpform/Fields/BaseField.php';

class TextareaField extends BaseField {

    public function render(){

        $this->widget = '<textarea';

        // get value
        $the_value = isset($this->config['value']) ? $this->config['value'] : '';
        unset($this->config['value']);

        foreach ($this->config as $key => $value) {
            $attribute = $key.'="'.$value.'"';

            $this->widget .= ' '.$attribute.' ';
        }

        $this->widget .= ' name="'.$this->name.'" rows="4">';
        $this->widget .= $the_value.'</textarea>';

        return $this->widget;
    }

    public function rules($str){
    	return ctype_alpha($str) || (bool) preg_match('/^[a-zA-Z ]+$/', $str);
    }
}
