<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    // ---------------------------------------------------------------------
    // Bug fixing, see
    // http://www.mahbubblog.com/php/form-validation-callbacks-in-hmvc-in-codeigniter/
    // ---------------------------------------------------------------------

    public function run($module = '', $group = '') {

        (is_object($module)) AND $this->CI = &$module;
        return parent::run($group);
    }

}
