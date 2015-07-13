<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_hello extends Widget {


    function _set_config()
    {
        // any configuration set here
        $this->widget_name = 'Hello World';
        $this->widget_description = 'PusakaCMS widget sample';
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
