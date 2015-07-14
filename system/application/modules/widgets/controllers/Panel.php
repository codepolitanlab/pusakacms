<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends Admin_Controller {

	public $nav_db;

	var $nav_area_fields = array(
			array(
				'field'   => 'area-title',
				'label'   => 'Area Name',
				'rules'   => 'trim|required'
				)
			);

	var $link_fields = array(
			array(
				'field'   => 'link_title',
				'label'   => 'Link Title',
				'rules'   => 'trim|required'
				),
			array(
				'field'   => 'link_slug',
				'label'   => 'Link Slug',
				'rules'   => 'trim|required'
				),
			array(
				'field'   => 'link_url',
				'label'   => 'Link URL',
				'rules'   => 'trim|required'
				),
			array(
				'field'   => 'link_source',
				'label'   => 'Link Source',
				'rules'   => 'trim|required'
				),
			array(
				'field'   => 'link_area',
				'label'   => 'Navigation Area',
				'rules'   => 'trim|required'
				),
			array(
				'field'   => 'link_target',
				'label'   => 'Link Target',
				'rules'   => 'trim|required'
				)
			);

	function __construct(){
		parent::__construct();

		if(! $this->logged_in()) redirect('panel/login');

		$this->load->model('widgets/widgets_m');

		if(!is_readable(WIDGET_FOLDER) || !is_writable(WIDGET_FOLDER))
			show_error('Set folder '.WIDGET_FOLDER.' and its contents readable and writable first.');
	}

	/*********************************************
	 * NAVIGATION
	 **********************************************/

	function index()
	{
		// accomodate widgets
		$data['widgets']['core'] = $this->widgets_m->get_widgets();
		$data['widgets']['addon'] = $this->widgets_m->get_widgets('addon');

		$area_folders = directory_map(WIDGET_FOLDER, 2);

		foreach ($area_folders as $folder => $files) {
			if(count($files) > 0)
				$data['areas'][] = rtrim($folder, '/');
		}

		$this->template->view('index', $data);
	}

	function widget_list($area = false)
	{
		$files = array_filter(scandir(WIDGET_FOLDER.$area), function($file){
			return (strpos($file, '.json') !== FALSE);
		});

		$data['widgets'] = false;
		foreach ($files as $file) {
			// get widget data
			$widget_data = json_decode(file_get_contents(WIDGET_FOLDER.$area.'/'.$file), true);

			$widget_slug = strtolower(url_title($widget_data['title']));

			// override config form
			$form_config = array(
				'action' => site_url('panel/widgets/edit/'. $widget_slug.'/'. $area),
				'method' => 'POST'
				);

			// get widget form
			$data['widgets'][$widget_slug] = $this->widgets_m->load_widget_data($widget_data, $form_config);
		}

		$data['area'] = $area;

		return $this->load->view('widget_list', $data, true);
	}

	function add($widget_class = false)
	{
		$widget = $this->widgets_m->load_widget($widget_class);

		// validate
		if($widget->validate())
		{
			$data = $this->input->post();

			if($this->widgets_m->save_widget($widget_class, $data))
				$this->session->set_flashdata('success', 'Widget has been saved.');
			else
				$this->session->set_flashdata('error', 'Widget failed to save.');

		} else {
			$this->session->set_flashdata('error', validation_errors());
		}

		redirect(getenv('HTTP_REFERER'));
	}

	function edit($widget_name = false, $area = 'nonarea')
	{
		// get widget data
		$prev_data = json_decode(file_get_contents(WIDGET_FOLDER.$area.'/'.$widget_name.'.json'), true);

		// get widget class
		$widget = $this->widgets_m->load_widget('Widget_'.$prev_data['widget'], $prev_data);

		// validate
		if($widget->validate())
		{
			$data = $this->input->post();

			if($this->widgets_m->update_widget('Widget_'.$prev_data['widget'], $data, $prev_data))
				$this->session->set_flashdata('success', 'Widget has been edited.');
			else
				$this->session->set_flashdata('error', 'Widget failed to edit.');

		} else {
			$this->session->set_flashdata('error', validation_errors());
		}

		redirect(getenv('HTTP_REFERER'));
	}

	function delete($slug = false, $area = 'nonarea')
	{
		if(! $slug) show_404();

		if($this->widgets_m->delete_widget($slug, $area))
			$this->session->set_flashdata('success', 'Widget has been deleted.');
		else
			$this->session->set_flashdata('error', 'Widget failed to delete.');

		redirect(getenv('HTTP_REFERER'));
	}

}
