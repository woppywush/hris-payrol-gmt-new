<?php 
/* 
Create by 		: fikrirezaa@gmail.com
Created Date	: 18-July-2016
*/

function getBrowserType () {
	if (!empty($_SERVER['HTTP_USER_AGENT'])) 
	{ 
	   $HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT']; 
	}
	else if (!empty($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) 
	{ 
	   $HTTP_USER_AGENT = $HTTP_SERVER_VARS['HTTP_USER_AGENT']; 
	} 
	else if (!isset($HTTP_USER_AGENT)) 
	{ 
	   $HTTP_USER_AGENT = ''; 
	} 
	if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) 
	{ 
	   $browser_version = $log_version[2]; 
	   $browser_agent = 'opera'; 
	} 
	else if (ereg('MSIE ([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) 
	{ 
	   $browser_version = $log_version[1]; 
	   $browser_agent = 'ie'; 
	} 
	else if (ereg('OmniWeb/([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) 
	{ 
	   $browser_version = $log_version[1]; 
	   $browser_agent = 'omniweb'; 
	} 
	else if (ereg('Netscape([0-9]{1})', $HTTP_USER_AGENT, $log_version)) 
	{ 
	   $browser_version = $log_version[1]; 
	   $browser_agent = 'netscape';
	} 
	else if (ereg('Mozilla/([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) 
	{ 
	   $browser_version = $log_version[1]; 
	   $browser_agent = 'mozilla'; 
	} 
	else 
	{ 
	   $browser_version = 0; 
	   $browser_agent = 'other'; 
	}
	return $browser_agent;
}

function selfURL() { 
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
	$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
	
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
}

function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }
?>