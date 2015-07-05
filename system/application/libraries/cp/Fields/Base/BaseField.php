<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseField {

    protected $widget = '';
    protected $initial = '';
    protected $config = '';
    protected $name = '';

    public function __construct($name='', $initial='', $config=[])
    {
        $this->name = $name;
        $this->initial = $initial;
        $this->config = $config;

    }
}