<?php defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('render_area'))
{
    function render_area($area = 'nonarea')
    {
        if(! file_exists(WIDGET_FOLDER.$area) || ! file_exists(WIDGET_FOLDER.$area.DIRECTORY_SEPARATOR.'index.json'))
            return false;

        $files = json_decode(file_get_contents(WIDGET_FOLDER.$area.DIRECTORY_SEPARATOR.'index.json'), true);

        $output = '';
        foreach ($files as $file) {
            $output .= render_instance($file, $area);
        }

        return $output;
    }
}

if ( ! function_exists('render_instance'))
{
    function render_instance($slug = false, $area = 'nonarea')
    {
        // check if widget data exist
        if(! file_exists(WIDGET_FOLDER.$area.'/'.$slug.'.json'))
            return false;

        // get the data
        $data = json_decode(file_get_contents(WIDGET_FOLDER.$area.'/'.$slug.'.json'), true);

        $CI = &get_instance();
        // accomodate widget paths
        $widget_path = array(
            WWW_FOLDER . $CI->template->get_theme_path($CI->config->item('theme')). 'views/widgets' . DIRECTORY_SEPARATOR,
            ADDON_FOLDER.'widgets'.DIRECTORY_SEPARATOR,
            APPPATH.'widgets'.DIRECTORY_SEPARATOR
        );

        // check if widget exist
        $location = false;
        foreach ($widget_path as $path) {
            if(file_exists($path.$data['widget'].DIRECTORY_SEPARATOR.'Widget_'.$data['widget'].'.php')) {
                $location = $path.$data['widget'];
                break;
            }
        }

        // if widget exist
        if($location){
            // load widget
            $widget = $CI->cpformutil->load('Widget_'.$data['widget'], $location);

            // render widget
            return $widget->render($data);
        }

        return false;
    }
}
