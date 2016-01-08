<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autocrud {


	public function __construct()
	{
		$this->load->model('crud/autocrud_m');
	}

	public function __call($method, $arguments)
	{
		if (!method_exists( $this->autocrud_m, $method) )
		{
			throw new Exception('Undefined method Autocrud::' . $method . '() called');
		}

		return call_user_func_array( array($this->autocrud_m, $method), $arguments);
	}

	public function __get($var)
	{
		return get_instance()->$var;
	}

}