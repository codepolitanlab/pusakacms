<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends Admin_Controller {

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        echo THEME_PATH;
        // $widget = $this->cpformutil->load('Widget_hello', $widget_path);
        // echo $widget->render();
    }
}
