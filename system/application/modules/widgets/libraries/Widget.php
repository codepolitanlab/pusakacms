<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget extends CPForm {

    protected $cpform_exclude_prefix = array('cpform', 'widget');

    protected $widget_name;
    protected $widget_description;
    protected $widget_container_class = 'widget';

    protected $widget_data = array();
    protected $widget_area = 'nonarea';

    function __construct()
    {
        parent::__construct();

        // get children class name and file location
        $reflector = new ReflectionClass(get_class($this));
        $this->widget_path = dirname($reflector->getFileName()).DIRECTORY_SEPARATOR;
        $this->widget_slug = substr($reflector->getName(), strlen('Widget_'));

        // set data store location
        $this->widget_data_location = SITE_PATH.'content/widgets/'.$this->widget_area.'/'.$this->widget_slug.'.json';

        // set default fields
        $this->title = array(
            'fieldType' => 'TextField',
            'label' => 'Widget Title',
            'config' => array(
                'placeholder' => 'Your widget title',
                'id' => 'title',
                'class' => 'form-control'
            ),
            'rules' => 'required'
        );
        $this->show_title = array(
            'fieldType' => 'TextField',
            'label' => 'Show widget title',
            'config' => array(
                'value' => 'true',
                'id' => 'show_title',
                'class' => 'form-control'
            ),
            'rules' => 'required'
        );
        $this->area = array(
            'fieldType' => 'TextField',
            'label' => 'Widget Area',
            'config' => array(
                'value' => 'nonarea',
                'id' => 'area',
                'class' => 'form-control'
            ),
            'rules' => 'required'
        );
    }

    public function set_values($data)
    {
        if(isset($data['area']) && ! empty($data['area']))
            $this->widget_area = $data['area'];

        return write_file($this->widget_data_location, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function render($data = array())
    {
        // get value before render
        $this->widget_data = $data;

        // render widget view
        $output = '<div class="'.$this->widget_container_class.' '.$this->widget_slug.'">'."\n";
        $output .= $this->cpform_CI->template->load_view('view', $this->widget_data, TRUE, $this->widget_path)."\n";
        $output .= '</div>'."\n";

        return $output;
    }


}
