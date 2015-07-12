<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_hello extends Widget {

    function __construct()
    {
        parent::__construct();
    }

    protected $widget_name = 'Hello World';
    protected $widget_description = 'PusakaCMS widget sample';

}
