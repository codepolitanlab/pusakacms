<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Extends profiles to be used as floating div over code or with firePHP
 * 
 * @author x.perez
 * 
 * 
 *
 */ 
class Core_Profiler extends CI_Profiler
{
    function __contruct($config = array())
    {
        parent::__construct($config);
    }
	
    function run()
    {  
		if (IS_AJAX) $position='relative'; else $position='absolute';
		
		profiler_log('SERVER',$_SERVER);
		profiler_log('COOKIES',$_COOKIE);
		profiler_log('CONFIG',CI::$APP->config->config);

		if ($this->CI->config->item("firePHP") != "firePHP")
		{
			// Load jQuery if not loaded
			$output = "<script type=\"text/Javascript\">!window.jQuery && document.write(unescape('%3Cscript src=\"http://code.jquery.com/jquery.min.js\"%3E%3C/script%3E'))</script>\n";
			// Calculate relative path to document_root
//			$relativePath = str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\','/',FCPATH));
//			$output = "<script type=\"text/javascript\" src=\"".$relativePath."media/js/jquery-1.9.1.min.js\"></script>\n";

	    	$i_currentDIV = rand(10,99).substr(md5($_SERVER["REQUEST_URI"]),0,6);
	   		$output .= "<div id='debugTrace".$i_currentDIV."X' style='position:$position;top:0px;left:0px;width:10px;border:#FFFFEB solid 1px;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#80000000,endColorstr=#10000000);background: rgba(135, 135, 135, 0.6);color:white;z-index:9999;'>";
	   		$output .= "<a href='Javascript:;' onclick='jQuery(\".codeigniter_profiler\").slideUp();jQuery(\".debugTraceProfiler2\").toggle();' style='text-decoration:none;font-size: 1em;'> <font color='white' size='1'>&laquo;</font> </a>";
	   		$output .= "</div>";
	   		$output .= "<div id='debugTrace".$i_currentDIV."' class='debugTraceProfiler2' style='position:$position;top:0px;left:10px;width:100%;border:#FFFFEB solid 1px;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#80000000,endColorstr=#10000000);background: rgba(135, 135, 135, 0.6);color:red;z-index:9999;'>";
		  	$output .= "<table align='center' border='0' width='98%'>";
		   	$output .= "<tr>";
		   	$output .= "<td align='left' width='10%'><a href='Javascript:;' onclick='jQuery(\".codeigniter_profiler".$i_currentDIV."\").slideUp();jQuery(\"#codeigniter_profiler_URI".$i_currentDIV."\").slideToggle();' style='text-decoration:none;font-size: 1em;color:#fff'> URI </a></td>";
		   	$output .= "<td align='left' width='10%'><a href='Javascript:;' onclick='jQuery(\".codeigniter_profiler".$i_currentDIV."\").slideUp();jQuery(\"#codeigniter_profiler_CTRL".$i_currentDIV."\").slideToggle();' style='text-decoration:none;font-size: 1em;color:#fff'> Controler </a></td>";
		   	$output .= "<td align='left' width='10%'><a href='Javascript:;' onclick='jQuery(\".codeigniter_profiler".$i_currentDIV."\").slideUp();jQuery(\"#codeigniter_profiler_MEM".$i_currentDIV."\").slideToggle();' style='text-decoration:none;font-size: 1em;color:#fff'> Memory </a></td>";
		   	$output .= "<td align='left' width='10%'><a href='Javascript:;' onclick='jQuery(\".codeigniter_profiler".$i_currentDIV."\").slideUp();jQuery(\"#codeigniter_profiler_BENCH".$i_currentDIV."\").slideToggle();' style='text-decoration:none;font-size: 1em;color:#fff'> Benchmarks </a></td>";
		   	$output .= "<td align='left' width='10%'><a href='Javascript:;' onclick='jQuery(\".codeigniter_profiler".$i_currentDIV."\").slideUp();jQuery(\"#codeigniter_profiler_VARS".$i_currentDIV."\").slideToggle();' style='text-decoration:none;font-size: 1em;color:#fff'> Variables </a></td>";
		   	$output .= "<td align='left' width='10%'><a href='Javascript:;' onclick='jQuery(\".codeigniter_profiler".$i_currentDIV."\").slideUp();jQuery(\"#codeigniter_profiler_SQL".$i_currentDIV."\").slideToggle();' style='text-decoration:none;font-size: 1em;color:#fff'> SQL </a></td>";
		   	$output .= "<td align='left' width='10%'><a href='Javascript:;' onclick='jQuery(\".codeigniter_profiler".$i_currentDIV."\").slideUp();jQuery(\"#codeigniter_profiler_CACHE".$i_currentDIV."\").slideToggle();' style='text-decoration:none;font-size: 1em;color:#fff'> CACHE </a></td>";
		   	$output .= "<td align='right' width='30%'><a href='Javascript:;' onclick='jQuery(\".codeigniter_profiler".$i_currentDIV."\").slideUp();jQuery(\"#debugTrace".$i_currentDIV."\").hide();' style='text-decoration:none;font-size: 1em;color:#fff'>".$this->CI->router->fetch_class()."/".$this->CI->router->fetch_method()."&nbsp;&nbsp;&nbsp; <strong>&lt;&lt;&lt;</strong> </a></td>";
		   	$output .= "<td align='right'>&nbsp;&nbsp;</td>";
		   	$output .= "</tr>";
		   	$output .= "<tr>";
		   	$output .= "<td colspan='99' onclick='jQuery(\".codeigniter_profiler\").slideUp();'>";
		   	$output .= "<div id='codeigniter_profiler_URI".$i_currentDIV."' class='codeigniter_profiler' style='position:relative;top:0px;padding:10px;width:90%;text-align:left;background-color:#fff;border:1px solid silver;z-index:9999;display:none;color:silver;'>";
			$output .= $this->_compile_uri_string();
			$output .= "</div>";
		   	$output .= "<div id='codeigniter_profiler_CTRL".$i_currentDIV."' class='codeigniter_profiler' style='position:relative;top:0px;padding:10px;width:90%;text-align:left;background-color:#fff;border:1px solid silver;z-index:9999;display:none;color:silver;'>";
			$output .= $this->_compile_controller_info();
			$output .= $this->compile_traceLines('CLASS');
			$output .= "</div>";
			$output .= "<div id='codeigniter_profiler_MEM".$i_currentDIV."' class='codeigniter_profiler' style='position:relative;top:0px;padding:10px;width:90%;text-align:left;background-color:#fff;border:1px solid silver;z-index:9999;display:none;color:silver;'>";
			$output .= $this->_compile_memory_usage();
			$output .= "</div>";
			$output .= "<div id='codeigniter_profiler_BENCH".$i_currentDIV."' class='codeigniter_profiler' style='position:relative;top:0px;padding:10px;width:90%;text-align:left;background-color:#fff;border:1px solid silver;z-index:9999;display:none;color:silver;'>";
			$output .= $this->_compile_benchmarks();
			$output .= "</div>";
			$output .= "<div id='codeigniter_profiler_VARS".$i_currentDIV."' class='codeigniter_profiler' style='position:relative;top:0px;padding:10px;width:90%;text-align:left;background-color:#fff;border:1px solid silver;z-index:9999;display:none;color:silver;'>";
			$output .= $this->_compile_get();
			$output .= $this->_compile_post();
			$output .= $this->compile_traceLines('DEBUG VARS');
			$output .= $this->compile_traceLines('CONFIG');
			$output .= $this->compile_traceLines('COOKIES');
			$output .= $this->compile_traceLines('SERVER');
			$output .= "</div>";
			$output .= "<div id='codeigniter_profiler_SQL".$i_currentDIV."' class='codeigniter_profiler' style='position:relative;top:0px;padding:10px;width:90%;text-align:left;background-color:#fff;border:1px solid silver;z-index:9999;display:none;color:silver;'>";
//			$output .= $this->compile_queries();
			$output .= $this->compile_queries();
			$output .= "</div>";
			$output .= "<div id='codeigniter_profiler_CACHE".$i_currentDIV."' class='codeigniter_profiler' style='position:relative;top:0px;padding:10px;width:90%;text-align:left;background-color:#fff;border:1px solid silver;z-index:9999;display:none;color:silver;'>";
			$output .= $this->compile_traceLines('CACHE');
			$output .= "</div>";
			$output .= "</td>";
			$output .= "</tr>";
		   	$output .= "</table>";
			$output .= "</div>";
			return $output;
		}
		else 
			$this->firePHP();
    }

	function compile_traceLines($type)
	{
			$output  = "\n\n<div id='codeigniter_tracelines_".md5($type)."'>";
			$output .= '<fieldset id="ci_profiler_queries" style="border:1px solid #AA00FF;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
			$output .= "\n";
			$output .= '<legend style="color:#AA00FF;">&nbsp;&nbsp;'.$type.'</a>&nbsp;&nbsp;</legend>';
			$output .= "\n";
			$output .= "\n\n<table style='border:none; width:100%'>\n";

			if (isset(CI::$APP->profiler_log[$type]))
			{
				foreach (CI::$APP->profiler_log[$type] as $key => $val)
				{
					$output .="<tr><td style='width:100%;color:#AA00FF;font-weight:normal;background-color:#eee;padding:5px'>";
					if (is_object($val) || is_array($val))
					{
						$output .= '<pre style="white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap; word-wrap: break-word;">'.print_r($val,true).'</pre>';
					}
					else
					{
						$output .= html_entity_decode($val);
					}
					$output .="</td></tr>\n";
				}
			}
			$output .= "</table>\n";
			$output .= "</fieldset></div>";

			return $output;
	}

    function compile_queries()
    {
		$dbs = array();

		// Let's determine which databases are currently connected to
		if (isset(CI::$APP->dbLoaded))
			$DBBaseObject = CI::$APP->dbLoaded;
		else
			$DBBaseObject = CI::$APP;
		foreach ($DBBaseObject as $key => $CI_object)
		{
			if (is_object($CI_object) && is_subclass_of(get_class($CI_object), 'CI_DB') )
					$dbs[$key] = $CI_object;
		}
		
		if (count($dbs) == 0)
		{
			$output  = "\n\n";
			$output .= '<fieldset id="ci_profiler_queries" style="border:1px solid #0000FF;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
			$output .= "\n";
			$output .= '<legend style="color:#0000FF;">&nbsp;&nbsp;'.$this->CI->lang->line('profiler_queries').'&nbsp;&nbsp;</legend>';
			$output .= "\n";
			$output .= "\n\n<table style='border:none; width:100%;'>\n";
			$output .="<tr><td style='width:100%;color:#0000FF;font-weight:normal;background-color:#eee;padding:5px'>".$this->CI->lang->line('profiler_no_db')."</td></tr>\n";
			$output .= "</table>\n";
			$output .= "</fieldset>";
		
			return $output;
		}
		
		// Load the text helper so we can highlight the SQL
		$this->CI->load->helper('text');
		
		// Key words we want bolded
		$highlight = array('SELECT', 'DISTINCT', 'FROM', 'WHERE', 'AND', 'LEFT&nbsp;JOIN', 'ORDER&nbsp;BY', 'GROUP&nbsp;BY', 'LIMIT', 'INSERT', 'INTO', 'VALUES', 'UPDATE', 'OR&nbsp;', 'HAVING', 'OFFSET', 'NOT&nbsp;IN', 'IN', 'LIKE', 'NOT&nbsp;LIKE', 'COUNT', 'MAX', 'MIN', 'ON', 'AS', 'AVG', 'SUM', '(', ')');
		
		$output  = "\n\n";
		
		$count = 0;
		
		foreach ($dbs as $dbgroup => $db)
		{
			$count++;
		
			$hide_queries = (count($db->queries) > $this->_query_toggle_count) ? ' display:none' : '';
		
			$output .= '<fieldset style="border:1px solid #0000FF;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
			$output .= "\n";
			$output .= '<legend style="color:#0000FF;">&nbsp;&nbsp;'.$this->CI->lang->line('profiler_database').':&nbsp; '.$dbgroup.' ('.$db->dbdriver.')&nbsp;&nbsp;&nbsp;'.$this->CI->lang->line('profiler_queries').': '.count($db->queries).'&nbsp;&nbsp;'.'</legend>';
			$output .= "\n";
			$output .= "\n\n<table style='width:100%;{$hide_queries}' id='ci_profiler_queries_db_{$count}'>\n";
		
			if (count($db->queries) == 0)
			{
				$output .= "<tr><td style='width:100%;color:#0000FF;font-weight:normal;background-color:#eee;padding:5px;'>".$this->CI->lang->line('profiler_no_queries')."</td></tr>\n";
			}
			else
			{
				foreach ($db->queries as $key => $val)
				{
					$time = number_format($db->query_times[$key], 4);
		
					$val = highlight_code($val, ENT_QUOTES);
		
					foreach ($highlight as $bold)
					{
						$val = str_replace($bold, '<strong>'.$bold.'</strong>', $val);
					}
		
					$output .= "<tr><td style='padding:5px; vertical-align: top;width:1%;color:#900;font-weight:normal;background-color:#ddd;'>".$time."&nbsp;&nbsp;</td><td style='padding:5px; color:#000;font-weight:normal;background-color:#ddd;'>".$val."</td></tr>\n";
				}
			}
		
			$output .= "</table>\n";
			$output .= "</fieldset>";
		
		}
		
		return $output;
		
		return;
	}
	
	function firePHP()
	{
		/**
	 * Add toolbar data to FirePHP console
	 */
		
		$firephp = FirePHP::getInstance(TRUE);
		
		$firephp->fb('FirePHP DEBUG TOOLBAR:');
		
		// Global VARS
		$globals = array(
			'Post'    => empty($_POST)    ? array() : $_POST,
			'Get'     => empty($_GET)     ? array() : $_GET,
			'Cookie'  => empty($_COOKIE)  ? array() : $_COOKIE,
			'Session' => empty($_SESSION) ? array() : $_SESSION
		);

		$tableT = array();
		$tableT[] = array("Vars","Values");
		$numVars = 0;
		foreach ($globals as $name => $global)
		{
			$table = array();
			
			foreach((array)$global as $key => $value)
			{
				if (is_object($value))
				{
					$value = get_class($value).' [object]';
				}
					
				$table[][$key]= $value;
				$numVars ++;
			}
			
			$message = "$name: ".count($global).' variables';
			$tableT[] = array($message,$table);
		}

		$message = "VARS: ".$numVars.' variables';
		
		$firephp->fb(array($message,$tableT), FirePHP::TABLE);
		
		// Benchmarks
		$benchmarks = $this->compile_benchmarks();
		$tableT = array();
		$tableT[] = array("Type","Time");
		$totalTime = 0;	
		foreach ($benchmarks as $key => $val)
		{
			$tableT[] = array($key,$val);
			$totalTime = $val;	
		}

		$firephp->fb(array("Benchmarks: ".number_format($totalTime,4),$tableT), FirePHP::TABLE);	
		
		// SQL statements
		
		$this->compile_queries();
		
		$dbs = array();

		// Let's determine which databases are currently connected to
		foreach (get_object_vars($this->CI) as $CI_object)
		{
			if (is_object($CI_object) && is_subclass_of(get_class($CI_object), 'CI_DB') )
			{
				$dbs[] = $CI_object;
			}
		}

		$tableT = array();
		$tableT[] = array("SQL","Time");	
		$totalTime = 0;	
		foreach ($dbs as $key => $val)
		{
			foreach ($val->queries as $key2 => $val2)
			{
				$tableT[] = array($val2,number_format($val->query_times[$key2],4));
				$totalTime += $val->query_times[$key2];	
			}
		}
		$tableT[] = array("Total: ",number_format($totalTime,4));
		$firephp->fb(array("SQL : ".number_format($totalTime,4),$tableT),FirePHP::TABLE);
		
		$tableT = array();
		$tableT[] = array("Memory","Time");
		$tableT[] = array("Program",number_format(memory_get_usage()));	
		$tableT[] = array("Max",number_format(memory_get_peak_usage()));	
		$firephp->fb(array("Memory",$tableT),FirePHP::TABLE);

		$tableT = array();
		$tableT[] = array("Class","Function","File");
		$tableT = array_merge($tableT,debug_backtrace());
		$firephp->fb(array("Files: ",$tableT), FirePHP::TABLE);	
		
			
		
		return;
	}
	
	function compile_benchmarks()
 	{
  		$profile = array();
 		foreach ($this->CI->benchmark->marker as $key => $val)
 		{
 			// We match the "end" marker so that the list ends
 			// up in the order that it was defined
 			if (preg_match("/(.+?)_end/i", $key, $match))
 			{ 			
 				if (isset($this->CI->benchmark->marker[$match[1].'_end']) AND isset($this->CI->benchmark->marker[$match[1].'_start']))
 				{
 					$profile[$match[1]] = $this->CI->benchmark->elapsed_time($match[1].'_start', $key);
 				}
 			}
 		}
 		
 		return $profile;
 	}	
	
		/**
	 * Compile memory usage
	 *
	 * Display total used memory
	 *
	 * @return	string
	 */
	protected function _compile_memory_usage()
	{
		$output  = "\n\n";
		$output .= '<fieldset id="ci_profiler_memory_usage" style="border:1px solid #5a0099;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#5a0099;">&nbsp;&nbsp;'.$this->CI->lang->line('profiler_memory_usage').'&nbsp;&nbsp;</legend>';
		$output .= "\n";

		if (function_exists('memory_get_usage') && ($usage = memory_get_usage()) != '')
		{
			$output .= "<div style='color:#5a0099;font-weight:normal;padding:4px 0 4px 0'>Used: ".number_format($usage).' bytes</div>';
		}
		else
		{
			$output .= "<div style='color:#5a0099;font-weight:normal;padding:4px 0 4px 0'>".$this->CI->lang->line('profiler_no_memory')."</div>";
		}
		if (function_exists('memory_get_peak_usage') && ($usage = memory_get_peak_usage()) != '')
		{
			$output .= "<div style='color:#5a0099;font-weight:normal;padding:4px 0 4px 0'>Peak: ".number_format($usage).' bytes</div>';
		}
		else
		{
			$output .= "<div style='color:#5a0099;font-weight:normal;padding:4px 0 4px 0'>".$this->CI->lang->line('profiler_no_memory')."</div>";
		}

		$output .= "</fieldset>";

		return $output;
	}

}