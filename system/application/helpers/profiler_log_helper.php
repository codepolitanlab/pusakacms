<?php
/* 
 * Profiler log
 *
 * Allow to display log in the TRACE tab of the main profiler
 */

if (!function_exists('profiler_log'))
{
	/**
	 * Set a line in the profiler log
	 *
	 * @param string $line
	 */
	function profiler_log($type,$line,$vars = '')
	{
        if (!isset(CI::$APP->profiler_log))
            CI::$APP->profiler_log = array();
		if (CI::$APP->config->item('log_profiler'))
		{
			if ($vars == '')
				CI::$APP->profiler_log[$type][] = $line;
			else
				CI::$APP->profiler_log[$type][] = '<b>'.$line.'</b><hr><pre>'.htmlspecialchars(print_r($vars,TRUE)).'</pre>';
		}
	}
}
?>