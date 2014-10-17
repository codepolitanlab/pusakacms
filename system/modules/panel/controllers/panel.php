<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cms
 *
 * Simple tool for making simple sites.
 *
 * @package		Pusaka
 * @author		Toni Haryanto (@toharyan)
 * @copyright	Copyright (c) 2011-2012, Nyankod
 * @license		http://nyankod.com/license
 * @link		http://nyankod.com/pusakacms
 */

class Panel extends Admin_Controller {

	function index()
	{
		$this->template->view('dashboard');
	}

	function dashboard()
	{
		$this->index();
	}

	function pages()
	{
		$this->template->view('pages');
	}

	function posts()
	{
		
		$this->template->view('posts');
	}

	function navigation()
	{
		
		$this->template->view('navigation');
	}

	function media()
	{
		
		$this->template->view('media');
	}

	function settings($tab = 'general')
	{
		$this->template
			->set('tab', $tab)
			->view('settings');
	}

	function new_post()
	{

		$this->template->view('form_post', array('type'=>'edit'));
	}

	function edit_post()
	{

		$this->template->view('form_post', array('type'=>'edit'));
	}

	function new_page()
	{

		$this->template->view('form_page');
	}

	function edit_page()
	{

		$this->template->view('form_page');
	}

}