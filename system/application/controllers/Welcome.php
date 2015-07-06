<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Admin_Controller {

	public function index()
	{
		echo "sipsip";
	}

	public function contact()
	{
		$contact_form = $this->cpformutil->load('Contact');
		$contact_form->init();

		if($_POST)
		{
			if($contact_form->is_valid())
			{
				echo "Form berhasil tervalidasi...";
				echo "<pre>";
				print_r($_POST);
				echo "</pre>";
			} else {
				echo "Form gagal tervalidasi....";
			}

		} else {
			$form_config = array(
				'action' => 'http://localhost/cpform/index.php/welcome/contact',
				'name' => 'contact-form',
				'id' => 'contact-form',
				'method' => 'POST',
			);

			$contact_form->config($form_config);
			$data['form'] = $contact_form->generate('paragraph');

			$this->template->view('contact', $data);
		}

	}
}
