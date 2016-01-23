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

    public function __construct($name='', $attr=array(), $value = '')
    {
        $this->name = isset($attr['name']) ? $attr['name'] : $name;
        $this->label = isset($attr['label']) ? $attr['label'] : $name;
        if(isset($attr['initial'])) $this->initial = $attr['initial'];
        if(isset($attr['config'])) $this->config = $attr['config'];
        if(isset($attr['options'])) $this->options = $attr['options'];
        if(isset($attr['rules'])) $this->rules = $attr['rules'];
        if(!empty($value)) $this->config['value'] = $value;
    }
}
