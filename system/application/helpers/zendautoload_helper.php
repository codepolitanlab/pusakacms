<?php

/**
 * Send Autoloader
 * 
 * Use zend autoloader to instance directly Zend in your classes
 * 
 * Before class definition:
 *		use Zend\Permissions\Acl;
 *		use Zend\Permissions\Acl\Role\GenericRole as Role;
 * 
 * Inside your class:
 *		$this->acl = new Acl\Acl();
 * 
 * Example:
 * 
 *		use Zend\Permissions\Acl;
 *		use Zend\Permissions\Acl\Role\GenericRole as Role;
 * 
 *		class MyController extends Core_Controller
 *		{
 *			public function loadAcl($userId)
 *			{
 *				$this->acl = new Acl\Acl();
 *				.
 *				.
 *				.
 *			}
 * 
 *		}
 *    
 */
if (!function_exists('zend_autoload'))
{
	function zend_autoload($class) {
		static $needle = 'Zend\\';
		static $length;
		if (!isset($length)) $length = strlen($needle);

		if (substr($class,0,$length) == $needle) {
			$fileName = COMMONPATH.'third_party/'.str_replace('\\','/',$class).'.php';
			if (file_exists($fileName))
				require_once($fileName);
		}
	}
	spl_autoload_register('zend_autoload');
}