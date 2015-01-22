<?php
/**
 * Core_Storage
 *
 
 // NOTICE OF LICENSE

 // MIT LICENSE
 
 // Copyright (c) 2013 Xavier Pérez 

 // Permission is hereby granted, free of charge, to any person obtaining a copy
 // of this software and associated documentation files (the "Software"), to deal
 // in the Software without restriction, including without limitation the rights
 // to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 // copies of the Software, and to permit persons to whom the Software is
 // furnished to do so, subject to the following conditions:

 // The above copyright notice and this permission notice shall be included in
 // all copies or substantial portions of the Software.

 // THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 // IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 // FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 // AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 // LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 // OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 // THE SOFTWARE. 

*/

/**
 * @category   Core_Storage
 * @package    Core_Storage
 * @copyright  Copyright (c) 2013 Xavier Perez 
 * @license    http://www.opensource.org/licenses/mit-license.html
 * @author     Xavier Perez 
 * @version    2.0.12
 */

/**
 * Class Core_Storage
 *
 * Store and retrieve data 
 * @package     Core_Storage
 * 
 */
class Core_Storage
{
	/**
	* Global store of all namespaces and vars
	* @var array
	*/	
    private static $vars    = array();
	/**
	* Instance of each namespace
	* @var array
	*/	
    private static $instance = array();
	/**
	* Default namespace
	* @var string
	*/	
    private static $defaultnamespace = "DEFAULT";
    /**
	* Current namespace used
	* @var string
	*/	
    private static $namespace = "";
	/**
	* Basename for session namespaces
	* The name of the main SESSION element to save all namespaces and vars
	* @var string
	*/	
    private static $sessionname = 'CORESTORAGESES';
	/**
	* Global persistence
	* Enable or disable global persistence, by default, disabled
	* @var string
	*/	
    private static $gpersistent = FALSE;
	/**
	* Local persistence settings
	* Array to save specified settings for local persistence
	* @var array
	*/	
    private static $lpersistent = array();
	/**
	* Storage type
	* Where to save and retrieve namespaces, Files or Session
	* @var array
	*/	
    private static $storagetype = "Session";
	/**
	* Storage dir
	* Directory to save files
	* @var array
	*/	
    private static $storagedir  = "/tmp";
	/**
	* Memcache server
	* Memcache server IP
	* @var string
	*/	
    private static $memcacheserver  = "127.0.0.1";
	/**
	* Memcache port
	* Memcache port
	* @var string
	*/	
    private static $memcacheport  = "11211";
	/**
	* Storage dir
	* Directory to save files
	* @var array
	*/	
    private static $storagelifetime = 86400;
    
    /**
    * Constructor, if there are global persistence, load data from store
    * 
    * Allows to restore namespace from SESSION automatically
    * 
    */
    public function __construct()
    {
		if (session_id()=='') 
			session_start();
    } 
    
    /**
    * Destructor, if there are persistence, save data in store
    * 
    * Allows to backup namespace automatically
    * 
    */
    public static function myDestruct()
    {
    	$purgeFiles=FALSE;
    	foreach (self::$vars as $key => $val)
    	{
    		if (self::$gpersistent === TRUE || (isset(self::$lpersistent[$key]) && self::$lpersistent[$key] === TRUE))
			{
				self::$namespace = $key;
    			self::backupNameSpace();
    			$purgeFiles = TRUE;
			}
    	}
    	self::$vars = array();
    	if ($purgeFiles && self::$storagetype == "Files")
    	{
    		$dir = opendir(self::$storagedir);
			while ($file = readdir($dir)) 
			{
				if ($file != '.' && $file != '..')
				{
//					echo "$file ".filectime(self::$storagedir."/".$file)."-".(time()-self::$storagelifetime)."<br>";
					if (filectime(self::$storagedir."/".$file) < (time() - self::$storagelifetime)) 
					{
//						echo "DELETING $file <br>";
						self::recursiveRMDir(self::$storagedir."/".$file);
					}
				}
			}
			closedir($dir);    
    	}    	
    } 
    
    /**
	* Load current pointer to given namespace
	*
	* @param  string  Namespace name
	*/
    public static function init($nameSpace="",$className="")
    {
		if (session_id()=='') 
			session_start();
    	register_shutdown_function(array(__CLASS__,'myDestruct'));
    	// Set default is not specified
    	if ($nameSpace == "")
    		$nameSpace = self::$defaultnamespace;

    	// Assign current namespace used
		self::$namespace = $nameSpace;
    	
		// Check exists current instance
		if (!isset(self::$instance[self::$namespace]))
			self::$instance[self::$namespace] = NULL;

		// Create new instance or return current
    	if (self::$instance[self::$namespace] == NULL)
			self::$instance[self::$namespace] = new self();

		if ($className != "")
			return self::getClass($className);
		else
			return self::$instance[self::$namespace];
    }
    
    /**
	* Change persistent default
	*
	* @param  boolean Enable / disable persistence
	* @param  boolean Affects global persistence 
	*/
    public static function setPersistence($enable,$global=FALSE)
    {
    	if ($enable === TRUE OR $enable === FALSE)
    	{
	   		self::$lpersistent[self::$namespace] = $enable;
    		if ($global === TRUE)
    			self::$gpersistent = $enable;
    	}
    	if (isset(self::$instance[self::$namespace]))
    		return self::$instance[self::$namespace];
    	else
    		return NULL;
    }
    
    /**
	* Change session Name 
	* 
	* Call it before any other command
	* 
	* @param  boolean Enable / disable persistence
	* @param  boolean Affects global persistence 
	*/
    public static function setSessionName($name)
    {
    	self::$sessionname = $name;
    	return self::$instance[self::$namespace];
    } 
    
    /**
	* Save persistence to session (TRUE) / or destroy namespace (FALSE)
	*
	* @param  boolean Backup (TRUE) or Delete backup (FALSE)
	*/
	public static function backupNameSpace($enable=TRUE)
    {
    	if ($enable === TRUE)
		{
			if (self::$storagetype == "Session")
				$_SESSION[self::$sessionname][self::$namespace] = serialize((self::$vars[self::$namespace]));

			if (self::$storagetype == "Memcache")
			{
				$_instance = new Memcache;
				$_instance->connect(self::$memcacheserver,self::$memcacheport);
				foreach (self::$vars as $key => $val)
				{
					$_instance->set(session_id().$key, serialize(self::$vars[$key]), MEMCACHE_COMPRESSED, 86400);
					$_SESSION[self::$sessionname][$key] = true;
				}
			}

			if (self::$storagetype == "Files")
			{
				$dir = self::$storagedir."/".substr(session_id(),0,4)."/".substr(session_id(),4,4)."/".session_id();
				if (!is_dir($dir))
					@mkdir($dir,0777,true);
				$filepath = $dir."/".rtrim(base64_encode(self::$namespace),"=");
				if ( $fp = fopen($filepath, 'wb'))
				{				
					if (flock($fp, LOCK_EX))
					{				
						fwrite($fp,gzdeflate(serialize(self::$vars[self::$namespace])));
						flock($fp, LOCK_UN);
					}
					fclose($file); 
				}
				
				// In php 5.3.1 can be enabled to be refreshed
				//@touch(self::$storagedir);				
			}
			self::$lpersistent[self::$namespace] = $enable;
		}
		if ($enable === FALSE && isset ($_SESSION[self::$sessionname][self::$namespace]))
		{ 
			if (self::$storagetype == "Session")
				unset($_SESSION[self::$sessionname][self::$namespace]);
			self::$lpersistent[self::$namespace] = $enable;
		}
    }
    
    /**
	* Get persistent data from current storage
	*
	* @param  boolean All namespaces (TRUE) on only current namespace (FALSE)
	*/
    public static function restoreNameSpace($all=FALSE)
    {
    	if ($all === FALSE)
    	{
			if (self::$storagetype == "Session")
			{
	    		if (isset($_SESSION[self::$sessionname][self::$namespace]))
	    		{
	    			self::$vars[self::$namespace] = (unserialize($_SESSION[self::$sessionname][self::$namespace]));
	    		}
	    		unset($_SESSION[self::$sessionname][self::$namespace]);
			}

			if (self::$storagetype == "Memcache")
			{ 
					$_instance = new Memcache;
					$_instance->connect(self::$memcacheserver,self::$memcacheport);
					self::$vars[self::$namespace] = unserialize($_instance->get(session_id().self::$namespace));
			}

			if (self::$storagetype == "Files")
			{
				$dir = self::$storagedir."/".substr(session_id(),0,8)."/".substr(session_id(),8,8)."/".session_id();
				$file = rtrim(base64_encode(self::$namespace),"=");
				if (is_file($dir."/".$file))
				{
//					echo "$file ".filectime($dir."/".$file)."-".(time()-self::$storagelifetime)."<br>";
					if (filemtime($dir."/".$file) < (time() - self::$storagelifetime))
					{ 
//       					echo "delete $dir/$file";
						unlink($dir."/".$file);
					}
					else
					{
	    				self::$vars[self::$namespace] = unserialize(gzinflate(@file_get_contents($dir."/".rtrim(base64_encode(self::$namespace),"="))));
					}	
				}	
			}
		}
    	else
    	{
			if (self::$storagetype == "Session")
			{
	    		if (isset($_SESSION[self::$sessionname]))
				{
		    		foreach ($_SESSION[self::$sessionname] as $key => $val)
					{
						if (!isset(self::$vars[$key]))
			    		{
			    			self::$vars[$key] = unserialize($val);
			    		}
			    		self::$lpersistent[$key] = TRUE;
			    		unset($_SESSION[self::$sessionname][$key]);
					}
				}
			}
			if (self::$storagetype == 'Memcache')
			{
				$_instance = new Memcache;
				$_instance->connect(self::$memcacheserver,self::$memcacheport);
				
				if (isset($_SESSION[self::$sessionname]))
				{
					foreach ($_SESSION[self::$sessionname] as $key => $val)
					{ 
						self::$vars[$key] = unserialize($_instance->get(session_id().$key));
					}
				}
			}
			if (self::$storagetype == "Files")
			{
				$bdir = self::$storagedir."/".substr(session_id(),0,8)."/".substr(session_id(),8,8)."/".session_id();
				if (is_dir($bdir))
				{
					$dir = opendir($bdir);
					while ($file = readdir($dir)) 
					{
						if ($file != '.' && $file != '..')
						{
		    				$nameSpace = trim(base64_decode($file)); 
//							echo "RESTORING ".$nameSpace."<br>";
//							echo "$file ".filectime($bdir."/".$file)."-".(time()-self::$storagelifetime)."<br>";
							if (filectime($bdir."/".$file) < (time() - self::$storagelifetime))
							{
//     							echo "delete $bdir/$file";
								unlink($bdir."/".$file);
							}
							else
							{
								self::$vars[$nameSpace] = unserialize(gzinflate(file_get_contents($bdir."/".$file)));
							}
				    		self::$lpersistent[$nameSpace] = TRUE;
						}
					}
					closedir($dir);    
				}
			}
    	}
    }

    /**
	* Retrieve namespace files for caching purpuoses
	* 
	* Those files are not controled by time to life
	*
	* @param  string Directory to find namespace files
	* @return array   
	*/
    public static function loadNameSpaceFile($dir)
    {
    	if (is_file($dir."/".rtrim(base64_encode(self::$namespace),"=")))
    	{
    		self::$vars[self::$namespace] = unserialize(gzinflate(@file_get_contents($dir."/".rtrim(base64_encode(self::$namespace),"="))));
    		return self::$instance[self::$namespace];
    	}
    	else
    		return FALSE;	
    }

    /**
	* Save namespace in files for caching purpuoses
	* 
	* Those files are not controled by time to life
	*
	* @param  string Directory to save files
	* @return boolean   
	*/
    public static function saveNameSpaceFile($dir)
    {
    	if (is_dir($dir))
    	{
			$file = fopen($dir."/".rtrim(base64_encode(self::$namespace),"="),"w");
			fwrite($file,gzdeflate(serialize(self::$vars[self::$namespace])));
			fclose($file); 
			self::clearNameSpace();
    		return TRUE;
    	}
    	else
    		return FALSE;
    }
    /**
	* Get data
	*
	* @param  string  Varname to get
	* @return string|integer|boolean|date|array   
	*/
	public static function get($var)
    {
    	$data = FALSE;
    	if (isset(self::$vars[self::$namespace][$var]))
    	{
			$ttl=@self::$vars[self::$namespace][$var.'@ttl'];
			if ($ttl>=time())
				$data=self::$vars[self::$namespace][$var];
			else
				self::clear($var);
    	}
    	return $data;
    }
    
	/**
	* Get datakey
	*
	* @param  string  Varname to get
	* @param  string  Key to get
	* @return string|integer|boolean|date|array   
	*/
	public static function getKey($var,$key)
    {
    	$data = FALSE;
    	if (isset(self::$vars[self::$namespace][$var]))
    	{ 
			$ttl=@self::$vars[self::$namespace][$var.'@ttl'];
			if ($ttl>=time())
			{
				if (is_array(self::$vars[self::$namespace][$var]) && isset(self::$vars[self::$namespace][$var][$key]))
					$data=self::$vars[self::$namespace][$var][$key];
				if (is_object(self::$vars[self::$namespace][$var]) && isset(self::$vars[self::$namespace][$var]->{$key}))
					$data=self::$vars[self::$namespace][$var]->{$key};
				if (isset(self::$vars[self::$namespace][$var][$key.'@ttl']))
				{
					if (self::$vars[self::$namespace][$var][$key.'@ttl']>=time())
							$data = FALSE;
				}
			}
			else
				self::clearKey($var,$key);
    	}
   		return $data;
    }
    
    /**
	* Get data
	*
	* @param  string  Varname to get
	* @return string|integer|boolean|date|array   
	*/
	public static function getTTL($var, $key='')
    {
    	$data = FALSE;
		if (isset($key) && $key != '' && isset(self::$vars[self::$namespace][$var][$key.'@ttl']))
				$data=self::$vars[self::$namespace][$var][$key.'@ttl'];
    	if (!$data && isset(self::$vars[self::$namespace][$var.'@ttl']))
				$data=self::$vars[self::$namespace][$var.'@ttl'];
    	return $data;
    }

	/**
	* Get flash data
	*
	* Get a data and delete it from namespace
	* 
	* @param  string  Varname to get
	* @return string|integer|boolean|date|array   
	*/
	public static function getFlash($var,$key='')
    {
    	$data = FALSE;
		if ($key == '' && isset(self::$vars[self::$namespace][$var]))
		{
			$data=self::$vars[self::$namespace][$var];
			unset(self::$vars[self::$namespace][$var]);
		}
    	if ($key != '' && isset(self::$vars[self::$namespace][$var][$key]))
    	{
			$data=self::$vars[self::$namespace][$var][$key];
			unset(self::$vars[self::$namespace][$var][$key]);
    	}
    	return $data;
    }
    
	/**
	* Get flash datakey
	*
	* Get datakey and delete it from namespace
	* 
	* @param  string  Varname to get
	* @param  string  Key to get
	* @return string|integer|boolean|date|array   
	*/
    public static function getFlashKey($var,$key)
    {
    	$data = FALSE;
    	if (isset(self::$vars[self::$namespace][$var]))
    	{
			if (is_array(self::$vars[self::$namespace][$var]) && isset(self::$vars[self::$namespace][$var][$key]))
			{
    			$data=self::$vars[self::$namespace][$var][$key];
				unset(self::$vars[self::$namespace][$var][$key]);
			}
    		if (is_object(self::$vars[self::$namespace][$var]) && isset(self::$vars[self::$namespace][$var]->{$key}))
    		{
    			$data=self::$vars[self::$namespace][$var]->{$key};
				unset(self::$vars[self::$namespace][$var]->$key);
    		}
//    		if (isset($_SESSION[self::$sessionname][self::$namespace][$var][$key]))
//    			unset($_SESSION[self::$sessionname][self::$namespace][$var][$key]);
    	}
   		return $data;
    }
    
    /**
	* Set data
	*
	* @param  string  Varname to save
	* @param  string|integer|boolean|array  Data to save
	*/
    public static function set($var,$value,$ttl=0)
    {
    	self::$vars[self::$namespace][$var] = $value;
    	self::$vars[self::$namespace][$var.'@ttl'] = ($ttl==0?time()+(self::$storagelifetime):time()+$ttl);
    	return self::$instance[self::$namespace];
    }
    
    /**
	* Set datakey
	*
	* @param  string  Varname to save
	* @param  string  Key to save
	* @param  string|integer|boolean|array  Data to save
	*/
    public static function setKey($var,$key,$value,$ttl=0)
    {
    	self::$vars[self::$namespace][$var][$key] = $value;
    	self::$vars[self::$namespace][$var][$key.'@ttl'] = ($ttl==0?time()+(self::$storagelifetime):time()+$ttl);
    	return self::$instance[self::$namespace];
    }
    
    /**
	* Add data
	*
	* @param  string  Varname array to add a new element
	* @param  string|integer|boolean|array  Data to save
	*/
    public static function add($var,$value,$ttl=0)
    {
    	self::$vars[self::$namespace][$var][] = $value;
    	self::$vars[self::$namespace][$var][count(self::$vars[self::$namespace][$var]-1)] = ($ttl==0?time()+(self::$storagelifetime):time()+$ttl);
    	return self::$instance[self::$namespace];
    }

    /**
	* Test var
	*
	* @param  string  Varname to test
	* @return boolean   
	*/
	public static function test($var)
	{
		if (isset(self::$vars[self::$namespace][$var]))
		{
			$ttl=self::$vars[self::$namespace][$var.'@ttl'];
			if ($ttl>=time())
				return TRUE;
			else 
				self::clear($var);
		}
		else
			return FALSE;
	}
	
    /**
	* Test var key
	*
	* @param  string  Varname to test
	* @param  string  Key to test
	* @return boolean   
	*/
	public static function testKey($var,$key)
	{
    	if (isset(self::$vars[self::$namespace][$var][$key]))
		{
			$ttl=self::$vars[self::$namespace][$var][$key.'@ttl'];
			if ($ttl>=time())
				return TRUE;
			else 
				self::clearKey($var,$key);
		}
		else
			return FALSE;
	}

    /**
	* Clear var
	*
	* @param  string  Varname to clear
	* @return boolean   
	*/
    public static function clear($var)
    {
    	if (isset(self::$vars[self::$namespace][$var]))
    	{
    		unset(self::$vars[self::$namespace][$var]);
    		return TRUE;
    	}
    	else
    		return FALSE;
    }
    
    /**
	* Clear var key
	*
	* @param  string  Varname 
	* @param  string  Key to clear
	* @return boolean   
	*/
    public static function clearKey($var,$key)
    {
    	if (isset(self::$vars[self::$namespace][$var][$key]))
    	{
    		unset(self::$vars[self::$namespace][$var][$key]);
    		return TRUE;
    	}
    	else
    		return FALSE;
    }

	/**
	* Clear namespace
	*
	* @return boolean   
	*/
    public static function clearNameSpace()
    {
    	if (isset(self::$vars[self::$namespace]))
    	{
    		unset(self::$vars[self::$namespace]);
//    		if (isset($_SESSION[self::$sessionname][self::$namespace]))
//    			unset($_SESSION[self::$sessionname][self::$namespace]);
    		return TRUE;
    	}
    	else
    		return FALSE;
    }
    
	/**
	* Clear all namespaces
	*
	* @return boolean   
	*/
    public static function clearAllNameSpaces()
    {
		self::$vars=array();
//    	if (isset($_SESSION[self::$sessionname]))
//    		unset($_SESSION[self::$sessionname]);
		self::$lpersistent = array();
    }
    
    /**
	* Get all vars in namespace
	*
	* @return array   
	*/
    public static function getNameSpace()
    {
    	if (isset(self::$vars[self::$namespace]) && count(self::$vars[self::$namespace])>0)
    	{
    		return self::$vars[self::$namespace];
    	}
    	else
    		return array();
	}

	/**
	* Get all namespaces
	*
	* @return array   
	*/
    public static function getAllNameSpaces()
    {
    	if (isset(self::$vars))
    	{
    		return self::$vars;
    	}
    	else
    		return array();
	}
	
	/**
	* Set a class as an element of Core_Storage and get this class as new object
	* If exists current class, returns previous saved object
	*
	* @param  string  Classname 
	* @param  string  Prefix - allows to have copies of same class in Core_Storage
	* @return array   
	*/
	public static function getClass($class,$prefix="")
	{
    	if (!isset(self::$vars[self::$namespace][$class.$prefix]))
    		self::$vars[self::$namespace][$class.$prefix] = new $class();
    		
 		return self::$vars[self::$namespace][$class.$prefix]; 		
	}
	
	/**
	* Get list of vars saved for current namespace
	*
	* @return array   
	*/
	public static function listVars()
	{
		if (!isset(self::$vars[self::$namespace]) OR count(self::$vars[self::$namespace])==0)
			return array();
			
		$list = array();
		$index = 0;
		if (is_array(self::$vars[self::$namespace]) || is_object(self::$vars[self::$namespace]))
		{
			foreach (self::$vars[self::$namespace] as $key => $val)
			{
				if (strstr($key,'@ttl'))
							continue;
				$list[$index]["namespace"] 	= self::$namespace;
				$list[$index]["varname"] 	= $key;
				$list[$index]["vartype"] 	= gettype($val);
				$list[$index]["varpersist"] = isset(self::$lpersistent[self::$namespace])?self::$lpersistent[self::$namespace]:0||self::$gpersistent;
				if (isset(self::$vars[$key.'@ttl']))
				{
						$list[$index]["varTTL"] = date('Y-m-d H:i:s',self::$vars[$key.'@ttl']);
						if (self::$vars[$key.'@ttl'] < time())
							$list[$index]["expired"] = "Var expired";		
				}		
				$index++;
			}
		}
		return $list;
	}

	/**
	* Get list of vars saved for all namespaces
	*
	* @return array   
	*/
	public static function listAllVars()
	{
		$list = array();
		$index = 0;
		foreach (self::$vars as $key => $val)
		{
			if (strstr($key,'@ttl'))
				continue;
			if (isset(self::$vars[$key.'@ttl']) && self::$vars[$key.'@ttl'] < time())
				$list[$index]["expired"] = "Var expired";		
			foreach ($val as $key2 => $val2)
			{
				if (strstr($key2,'@ttl'))
					continue;
				$list[$index]["namespace"] 	= $key;
				$list[$index]["varname"] 	= $key2;
				$list[$index]["vartype"] 	= gettype($val2); 
				$list[$index]["varpersist"] = isset(self::$lpersistent[$key])?self::$lpersistent[$key]:0||self::$gpersistent;
				if (isset(self::$vars[$key][$key2.'@ttl']))
				{
					$list[$index]["varTTL"] = date('Y-m-d H:i:s',self::$vars[$key][$key2.'@ttl']);
					if (self::$vars[$key][$key2.'@ttl'] < time())
						$list[$index]["expired"] = "Var expired";		
				}		
				$index++;
			}
		}
		return $list;
	}
	
	/**
	* Get current used namespaces 
	*
	* @return array   
	*/
	public static function getUsedNameSpaces()
	{
		$listNames = array();

		foreach (self::$vars as $key => $val)
		{
			$listNames[] = $key;
		}
		
		asort($listNames);
		
		return $listNames;
	} 
	
	/**
	 * Set storage lifetime default
	 * 
	 * @param integer (seconds) $ttl
	 */
	public function setStorageLifeTime($ttl)
	{
		self::$storagelifetime = $ttl;
		return self::$instance[self::$namespace];
	}

	/**
	* Set storageType, Files or Session
	* 
	* By default, namespaces are saved in SESSION var, and handled by your app,
	* but can be changed to save files, as a caching system. 
	*
	* @param  string  storageMethod (Files/Session)
	* @param  string  dir - where to save files (must to exists)
	* @param  integer  time to life for files saved
	* @return array   
	*/
	public static function setStorageType($type="Session",$ttl=0,$dir="")
	{
		if ($type == "Session" )
			self::$storagetype = "Session";
		if ($type == "Memcache" )
			self::$storagetype = "Memcache";
		if ($type == "Files" && $dir != "")
		{
			self::$storagetype = "Files";
			self::$storagedir = rtrim($dir,"/");
			if ($ttl > 0)
				self::$storagelifetime = $ttl;
		}
		return self::$instance[self::$namespace];
	}

	/**
	* Internal use for file garbage cleaning operation 
	*
	* @return array   
	*/
	protected function recursiveRMDir($dir) 
	{
	   if (is_dir($dir)) 
	   {
	     $files = scandir($dir);
	     foreach ($files as $file) 
	     {
       		if ($file != "." && $file != "..") 
       		{
       			if (filetype($dir."/".$file) == "dir")
       			{ 
       				self::recursiveRMDir($dir."/".$file);
       			} 
       			else 
       			{
//					echo "$file ".filectime($dir."/".$file)."-".(time()-self::$storagelifetime)."<br>";
       				if (filectime($dir."/".$file) < (time() - self::$storagelifetime))
					{ 
//       					echo "delete $dir/$file";
						unlink($dir."/".$file);
					}		
       			}
       		}
	     }
	     @rmdir($dir);
	   }
	}

	/**
	* Include php files with TTL expiration
	* 
	* Use phpInclude to load PHP files dinamically, also with cache
	* 
	* @param  string  Varname
	* @param  string  File tyo include
	* @param  integer  time to life for saved files (blank or '0', disable cache)
	* @return string   Return PHP file
	*/
	
	public static function phpInclude ($name,$file,$ttl='')
	{
		$fcontents = "";

		if (substr($file,0,1)!="/")
			$file = $_SERVER["DOCUMENT_ROOT"]."/".$file;

		if (self::test($name) === FALSE || $ttl==0)
		{
			if (file_exists($file))
				$fcontents = file_get_contents($file);
			$fcontents = str_replace('<'.'?php','',$fcontents);
			$fcontents = str_replace('?>','',$fcontents);
			self::set($name,$fcontents);
			self::set($name."@ttl",($ttl==''?0:time()+$ttl));

			return ($fcontents);
		}
		else
		{
			$fcontents = self::get($name);
			$fcontentsTTL = self::get($name."@ttl");
			if ($fcontentsTTL != 0 && $fcontentsTTL > time())
			{
				self::clear($name);
				return sef::phpInclude($name,$file,$ttl);
			}
			else 
			{
				if ($fcontents === FALSE)
					$fcontents = "";
			}
			return ($fcontents);
		}
	}
	
	public function getInternalVars()
	{
		return self::$vars;
	}
}
