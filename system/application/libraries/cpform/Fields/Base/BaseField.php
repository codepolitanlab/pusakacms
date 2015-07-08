<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseField {

    protected $widget = '';
    protected $initial = '';
    protected $config = '';
    protected $name = '';
    protected $rules = '';

    public function __construct($name='', $label='', $config=[])
    {
        $this->name = $name;
        $this->label = $label;
        $this->config = $config;

    }
}
