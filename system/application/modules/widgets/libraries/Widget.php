<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget extends CPForm {

    protected $cpform_exclude_prefix = array('cpform', 'widget');

    // this is set by widget developer
    public $widget_name;
    public $widget_description;
    public $widget_container_class = 'widget';

    public $widget_data = array();
    protected $widget_area = 'nonarea';
    protected $widget_view_path = '';

    function __construct()
    {
        // get children class name and file location
        $reflector = new ReflectionClass(get_class($this));
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

        // call parent constructor in the end
        parent::__construct();
    }

    // these two method init() and process() are set by widget developer
    protected function _process($data = array())
    {
        // get value before render
        $this->widget_data = $data;
    }

    public function save_data($data)
    {
        if(isset($data['area']) && ! empty($data['area']))
            $this->widget_area = $data['area'];

        return write_file($this->widget_data_location, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function render($data = array())
    {
        // call process() method first to prepare data
        $this->_process($data);

        // accomodate view paths
        $view_paths = array(
            $this->cpform_CI->template->get_theme_path().'views/widgets/'.$this->widget_slug.DIRECTORY_SEPARATOR,
            ADDON_FOLDER.'widgets/'.$this->widget_slug.DIRECTORY_SEPARATOR,
            APPPATH.'widgets/'.$this->widget_slug.DIRECTORY_SEPARATOR
        );
        foreach ($view_paths as $path) {
            if(file_exists($path.'view.php'))
                $this->widget_view_path = $path;
        }

        // set output and the container
        $output = '<div class="'.$this->widget_container_class.' '.$this->widget_slug.'">'."\n";
        $output .= $this->cpform_CI->template->load_view('view', $this->widget_data, TRUE, $this->widget_view_path)."\n";
        $output .= '</div>'."\n";

        return $output;
    }

}
