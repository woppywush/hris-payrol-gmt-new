<?php
/* 
Create by 		: fikrirezaa@gmail.com
Created Date	: 18-July-2016
*/

require_once('visitors_connections.php');

$visitors = mysqli_connect("localhost", "root", "toor", "skpd1");

ini_set('error_reporting', 'E_ALL ^ E_NOTICE');

$visitor_ip = GetHostByName($REMOTE_ADDR);
$visitor_browser = getBrowserType();
$visitor_hour = date("h");
$visitor_minute = date("i");
$visitor_day = date("d");
$visitor_month = date("m");
$visitor_year = date("Y");
$visitor_refferer = GetHostByName($HTTP_REFERER);
$visited_page = selfURL();

$sql = "INSERT INTO visitor VALUES ('','$visitor_ip', '$visitor_browser', '$visitor_hour', '$visitor_minute', '$visitor_day', '$visitor_month', '$visitor_year', '$visitor_refferer', '$visitor_page', '$visitor_date')";

//echo "<pre>Debug: $sql</pre>\m";

$result = mysqli_query($visitors, $sql);
/*
if ( false===$result ) {
  printf("error: %s\n", mysqli_error($con));
}
else {
  //echo selfURL();
}
*/
mysqli_close($con);
//print_r($result);die();

?>