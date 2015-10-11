<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_html extends Widget {


    function _set_config()
    {
        // any configuration set here
        $this->widget_name = 'HTML Block';
        $this->widget_description = 'Add HTML block';
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
        $this->html = array(
            'fieldType' => 'TextareaField',
            'label' => 'HTML code',
            'config' => array(
                'placeholder' => 'place HTML block code here',
                'id' => 'html',
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
