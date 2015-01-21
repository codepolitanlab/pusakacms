<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
	function run($group = '')
	{
		$obj = new $this->CI->router->class();
		
		(is_object($obj)) AND $this->CI =& $obj;
		
		return parent::run($group);
	}
}
/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */