<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_latest_posts extends Widget {


    function _set_config()
    {
        // any configuration set here
        $this->widget_name = 'Latest Posts';
        $this->widget_description = 'Show latest blog posts';
        $this->widget_container_class = 'widget';

        // set additional config
        $this->cpform_additional = array(
            'submit_class' => 'btn btn-primary',
            'submit_value' => 'Submit'
        );
    }

    function _set_fields()
    {
        // any other fields set here
        $this->label = array(
            'fieldType' => 'TextField',
            'label' => 'Post Label',
            'config' => array(
                'placeholder' => 'separate by comma, leave blank to show all',
                'id' => 'label',
                'class' => 'form-control'
            )
        );
        $this->num_posts = array(
            'fieldType' => 'TextField',
            'label' => 'Number of Posts',
            'config' => array(
                'value' => '5',
                'id' => 'num_posts',
                'class' => 'form-control'
            )
        );
    }

    function _process($data = array())
    {
        $entries = get_posts($data['label'], 1, $data['num_posts'], 'desc', true);

        $data['latest_posts'] = $entries['entries'];

        // don't forget to store to widget_data property
        $this->widget_data = $data;
    }

}
