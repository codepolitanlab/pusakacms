<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Themes extends CPForm {

    protected $cpform_exclude_prefix = array('cpform', 'theme');

    // this is set by theme developer
    public $theme_name;
    public $theme_description;
    public $theme_author;
    public $theme_version;

    function __construct()
    {
        // get children class name and file location
        $reflector = new ReflectionClass(get_class($this));
        $this->theme_slug = substr($reflector->getName(), strlen('Theme_'));

        // set form config
        $this->cpform_config = array(
            'action' => site_url('panel/themes/save_config/'.get_class($this)),
            'method' => 'POST',
        );
        $this->cpform_additional = array(
            'submit_class' => 'btn btn-primary',
            'submit_value' => 'Submit'
        );

        // call parent constructor in the end
        parent::__construct();
    }

}
