<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_labels extends Widget {


    function _set_config()
    {
        // any configuration set here
        $this->widget_name = 'Post Labels';
        $this->widget_description = 'Show available post labels';
        $this->widget_container_class = 'widget';

        // set additional config
        $this->cpform_additional = array(
            'submit_class' => 'btn btn-primary',
            'submit_value' => 'Submit'
        );
    }

    function _process($data = array())
    {
        $labels = get_labels();
        foreach ($labels as  $url => $label) {
            $data['labels'][] = array( 'label' => $label, 'url' => $url);
        }

        // don't forget to store to widget_data property
        $this->widget_data = $data;
    }

}
