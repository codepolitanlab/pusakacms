<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseField {

    public $name = '';
    protected $widget = '';
    protected $initial = '';
    protected $config = array();
    protected $rules = '';
    protected $rule_messages = array();
    protected $options = array();

    public function __construct($name='', $value=array())
    {
        $this->name = isset($value['name']) ? $value['name'] : $name;
        $this->label = isset($value['label']) ? $value['label'] : $name;
        if(isset($value['initial'])) $this->initial = $value['initial'];
        if(isset($value['config'])) $this->config = $value['config'];
        if(isset($value['options'])) $this->options = $value['options'];
        if(isset($value['rules'])) $this->rules = $value['rules'];
    }
}
