<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_navigations extends Widget {


    function _set_config()
    {
        // any configuration set here
        $this->widget_name = 'Navigations';
        $this->widget_description = 'Add Navigations area to widget';
        $this->widget_container_class = 'widget';

        // set additional config
        $this->cpform_additional = array(
            'submit_class' => 'btn btn-primary',
            'submit_value' => 'Submit'
        );
    }

    function _set_fields()
    {
        $areas = directory_map(NAV_FOLDER);
        $nav_area = array();
        foreach ($areas as $key => $value) {
            if(strpos($value, '.json') !== false)
                $nav_area[str_replace(".json", "", $value)] = ucfirst(str_replace(".json", "", $value));
        }
        // print_r($areas);

        $this->nav_area = array(
            'fieldType' => 'DropdownField',
            'label' => 'Navigation Area',
            'config' => array(
                'placeholder' => 'place nav_area block code here',
                'id' => 'nav_area',
                'class' => 'form-control'
            ),
            'rules' => 'required',
            'options' => $nav_area
        );
    }

    function _process($data = array())
    {
        // any data processing set here
        $data['navs'] = get_nav($data['nav_area']);

        // don't forget to store to widget_data property
        $this->widget_data = $data;
    }

}
