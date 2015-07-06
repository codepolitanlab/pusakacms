<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	/**
	* Index Page for this controller.
	*
	* Maps to the following URL
	* 		http://example.com/index.php/welcome
	*	- or -
	* 		http://example.com/index.php/welcome/index
	*	- or -
	* Since this controller is set as the default controller in
	* config/routes.php, it's displayed at http://example.com/
	*
	* So any other public methods not prefixed with an underscore will
	* map to /index.php/welcome/<method_name>
	* @see http://codeigniter.com/user_guide/general/urls.html
	*/
	public function index()
	{
		echo "sipsip";
	}

	public function contact()
	{
		$this->load->library('cpform/CPFormUtil');
		$contact_form = $this->cpformutil->load('Contact');
		$contact_form->init();

		if ($_POST) {

			if ($contact_form->is_valid()){
				echo "Form berhasil tervalidasi...";
				echo "<pre>";
				print_r($_POST);
				echo "</pre>";
			}
			else {
				echo "Form gagal tervalidasi....";
			}

		}

		else {

			$contact_form->config([
				'action' => 'http://localhost/cpform/index.php/welcome/contact',
				'name' => 'contact-form',
				'id' => 'contact-form',
				'method' => 'POST',
				]);

				$form = $contact_form->generate('paragraph');
				echo $form;
			}

		}
	}
