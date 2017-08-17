<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/cpform/Fields/BaseField.php';

class TextField extends BaseField {

    public function render(){

        $this->widget = '<input type="text"';

        foreach ($this->config as $key => $value) {
            if($key == 'value')
                $attribute = $key.'="'.set_value($this->name, $value).'"';
            else
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
