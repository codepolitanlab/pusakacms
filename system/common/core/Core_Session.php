<?php

include_once 'Core_Storage.php';

class Core_Session {
	private $sess_cookie_name			= 'codeigniter';
	private $sess_expiration			= 86400;
	private $sess_expire_on_close		= FALSE;
	private $sess_storagetype			= 'Session';
	private $sess_time_to_update		= 600;
	private $cookie_domain				= '';
	private $cookie_path				= '/';
	private $time_reference				= 'time';
	private $userdata					= array();
	public  $flashdata_key				= 'flash';
	private $CI;
	private $now;

	public function __construct($params = array())
	{ 
		// Set the super object to a local variable for use throughout the class
		$this->CI =& get_instance();

		// Set all the session preferences, which can either be set
		// manually via the $params array above or via the config file
		foreach (array('sess_cookie_name','sess_expiration', 'sess_time_to_update', 'sess_expire_on_close', 'sess_storagetype', 'time_reference', 'sess_expire_on_close','cookie_domain','cookie_path') as $key)
		{
			$this->$key = (isset($params[$key])) ? $params[$key] : $this->CI->config->item($key);
		}

		// Set the "now" time.  Can either be GMT or server time, based on the
		// config prefs.  We use this to set the "last activity" time
		$this->now = $this->_get_time();

		// Set the session length. If the session expiration is
		// set to zero we'll set the expiration two years from now.
		if ($this->sess_expiration == 0)
		{
			$this->sess_expiration = (60*60*24*365*2);
			ini_set('session.cookie_lifetime',$this->sess_expiration);
		}

		if ($this->sess_expire_on_close == TRUE)
			$this->sess_expiration = 0;

		ini_set('session.cookie_lifetime',$this->sess_expiration);
		if ($this->cookie_domain != '')
			ini_set('session.cookie_domain',$this->cookie_domain);
		if ($this->cookie_path != '/')
			ini_set('session.cookie_path',$this->cookie_path);
		
		Core_Storage::init($this->sess_cookie_name)->setPersistence(TRUE)->setStorageLifeTime($this->sess_expiration)->setStorageType($this->sess_storagetype)->restoreNameSpace(TRUE);

		$this->sess_update();

		log_message('debug', "Session routines successfully run");
	}
	
	/**
	 * Fetch a specific item from the session array
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function userdata($item)
	{
		return Core_Storage::getKey('UserData',$item);
	}

	/**
	 * Fetch a specific item from the session array
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	
	function sessiondataTTL()
	{
		return Core_Storage::getTTL('SessionData');
	}

	/**
	 * Fetch a specific item from the session array
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function userdataTTL($item = null)
	{
		return Core_Storage::getTTL('UserData',$item);
	}

	/**
	 * Fetch all userdata
	 *
	 * @access	public
	 * @return	array
	 */
	function all_userdata()
	{
		return Core_Storage::get('UserData');
	}
	
	/**
	 * Fetch all debugdata
	 *
	 * @access	public
	 * @return	array
	 */
	function all_debugdata()
	{
		return Core_Storage::get('DebugData');
	}

	/**
	 * Add or change data in the "userdata" array
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @return	void
	 */
	function set_userdata($newdata = array(), $newval = '', $ttl=0, $destVar = 'UserData')
	{
		$userData = Core_Storage::get($destVar);
		if (is_string($newdata))
		{
			$newdata = array($newdata => $newval);
		}

		if (count($newdata) > 0)
		{
			foreach ($newdata as $key => $val)
			{
				$userData[$key] = $val;
			}
		}

		Core_Storage::set($destVar,$userData,$ttl);
	}
	
	/**
	 * Delete a session variable from the "userdata" array
	 *
	 * @access	array
	 * @return	void
	 */
	function unset_userdata($newdata = array(),$destVar = 'UserData')
	{
		$userData = Core_Storage::get($destVar);
		if (is_string($newdata))
		{
			$newdata = array($newdata => '');
		}

		if (count($newdata) > 0)
		{
			foreach ($newdata as $key => $val)
			{
				unset($userData[$key]);
			}
		}
		Core_Storage::set($destVar,$userData);

	}
	
	/**
	 * Add or change flashdata, only available
	 * until the next request
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @return	void
	 */
	function set_flashdata($newdata = array(), $newval = '')
	{
		// Save old values only for new values set
		if (is_string($newdata))
		{
			$newdata = array($newdata => '');
		}

		if (count($newdata) > 0)
		{
			foreach ($newdata as $key)
			{
				$flashData = Core_Storage::getFlashKey('FlashData:new',$key);
				if ($flashData)
					Core_Storage::setKey('FlashData:old',$key,$flashData);
			}
		}		
		$this->set_userdata($newdata, $newval, 0, 'FlashData:new');
	}

	/**
	 * Fetch a specific flashdata item from the session array
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function flashdata($key)
	{
		$flashData = Core_Storage::getFlashKey('FlashData:new',$key);
		return $flashData;
	}

	/**
	 * Keeps existing flashdata available to next request.
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function keep_flashdata($key)
	{
		// 'old' flashdata gets removed.  Here we mark all
		// flashdata as 'new' to preserve it from _flashdata_sweep()
		// Note the function will return FALSE if the $key
		// provided cannot be found
		$old_flashData = Core_Storage::getFlashKey('FlashData:old',$key);
		$this->set_flashdata(array($key => $old_flashData));
	}


	/**
	 * Get the "now" time
	 *
	 * @access	private
	 * @return	string
	 */
	private function _get_time()
	{
		if (strtolower($this->time_reference) == 'gmt')
		{
			$now = time();
			$time = mktime(gmdate("H", $now), gmdate("i", $now), gmdate("s", $now), gmdate("m", $now), gmdate("d", $now), gmdate("Y", $now));
		}
		else
		{
			$time = time();
		}

		return $time;
	}

	/**
	 * 
	 */
	public function sess_create(){}
	/**
	 * Sess Destroy
	 * 
	 * Clear all storage data relative to user and flash data
	 */
	public function sess_destroy()
	{
		Core_Storage::clear('UserData');
		Core_Storage::clear('FlasData:new');
		Core_Storage::clear('FlasData:old');
	}
	
	/**
	 * Sess write, not used 
	 */
	public function sess_write(){}
	
	/**
	 * Sess read, not used
	 */
	public function sess_read(){}

	/**
	 * Cookie monster, not used
	 * @param type $param
	 */
	public function cookie_monster($param){}
	
	/**
	 * Update an existing session
	 *
	 * @access	public
	 * @return	void
	 */
	public function sess_update()
	{
		$sessiondata = $this->get_session();

		// We only update the session every five minutes by default
		if ($this->sess_time_to_update==0 || ($sessiondata['last_activity'] + $this->sess_time_to_update) >= $this->now)
		{
			return;
		}
		
		session_regenerate_id();

		$sessionData = array('session_id' => session_id(),'ip_address' => $this->CI->input->ip_address(),'user_agent' => substr($this->CI->input->user_agent(), 0, 120),'last_activity' => $this->now);
		$this->set_session($sessionData);
		
	}
	
	/**
	 * Get current session data
	 * 
	 * @return array
	 */
	protected function get_session()
	{
		return Core_Storage::get('SessionData');
	}

	/**
	 * Set current session data
	 * 
	 * @param array $sessionData
	 * @param integer $ttl
	 */
	protected function set_session($sessionData,$ttl=0)
	{
		Core_Storage::set('SessionData',$sessionData,$ttl);
	}
	
	/**
	 * Get all storage data
	 * 
	 * @return array
	 * 
	 */
	public function _getAllVars()
	{
		return Core_Storage::getInternalVars();
	}
	
	/**
	 * Set debug data
	 * 
	 * @param array $newdata
	 * @param array $newval
	 */
	public function set_debugdata($newdata = array(), $newval = '')
	{
		$flashData = Core_Storage::getFlash('DebugData:new');
		Core_Storage::set('DebugData:old',$flashData);
		$this->set_userdata($newdata, $newval, 0, 'DebugData:new');
	}
	/**
	 * Fetch a specific debugdata item from the session array
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function get_debugdata($key)
	{
		$debugData = Core_Storage::get('DebugData:new',$key);
		return $debugData;
	}
}