<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/cpform/Fields/CharField.php';

class NumberField extends CharField {

    public function rules($str){
        return ctype_digit($str) || (bool) preg_match('/^[0-9]+$/', $str);
    }
}