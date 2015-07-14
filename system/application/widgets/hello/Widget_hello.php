<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_hello extends Widget {


    function _set_config()
    {
        // any configuration set here
        $this->widget_name = 'Hello World';
        $this->widget_description = 'PusakaCMS widget sample';
        $this->widget_container_class = 'widget';

        // set form config
        $this->cpform_config = array(
            'action' => site_url('panel/widgets/add/'.get_class($this)),
            'method' => 'POST',
        );
        $this->cpform_additional = array(
            'submit_class' => 'btn btn-primary',
            'submit_value' => 'Submit'
        );
    }

    function _set_fields()
    {
        // any other fields set here
        $this->message = array(
            'fieldType' => 'TextField',
            'label' => 'Hello Message',
            'config' => array(
                'placeholder' => 'your welcome message',
                'id' => 'message',
                'class' => 'form-control'
            )
        );
    }

    function _process($data = array())
    {
        // any data processing set here

        // don't forget to store to widget_data property
        $this->widget_data = $data;
    }

}
