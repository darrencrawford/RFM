<?php
/*
 *	Plugin Name: RFM One
 *	Plugin URI: http://beforeunit.com
 * 	Description: Single plugin to run all RFM procedures from
 *	Version: 1.0
 *	Author: Darren Crawford
 *	Author URI: http://beforeunit.com
 *	License: GPL2
 */

/* 
 * To-Do
 * 
*/

//Get appid and key for OAP
include 'keys.php';
	//echo $appid;

//Get specific variables to determine which function to call
	$contact_id = $_GET["id"];
	$rfm = $_GET['rfm'];
	$date_purchase = $_GET["datepurchase"];


function write_log($logname) {
	//Write the exact URL being pinged to stats_log file 
		$filename = '/home/stats/public_html/kinostats/logs/'.$logname;
		date_default_timezone_set('America/New_York');
		$logDate = date('l jS \of F Y h:i:s A');
		//$addr = "http://".$_SERVER['SERVER_NAME']."/".$_SERVER['REQUEST_URI']."?".$_SERVER['QUERY_STRING'];
		$addr = "/".$_SERVER['REQUEST_URI'];
		$write = $logDate." - ".$addr."\n";
		file_put_contents ( $filename ,  $write , FILE_APPEND | LOCK_EX);
}


function days_between_1($contact_id, $date_purchase, $appid, $key) {
	
	//convert date to D-M-Y format
		$pieces = explode("-", $date_purchase);	
		$timestamp = $pieces[1].'-'.$pieces[0].'-'.$pieces[2];
		$timestamp = strtotime($timestamp);
		$now = time();
		$diff = $now-$timestamp;
		$diff = floor($diff/86400);
		$diff_in_days = $diff;
		$logname = 'days-between-1-2_log';

	//echo 'diff in function = '.$diff_in_days.'<br>';

$data = <<<STRING
//You must pass the contact ID as an argument to indicate which contact is being updated
<contact id="$contact_id">
<Group_Tag name="RFM">
<field name="Days between Purchases 1 and 2">$diff_in_days</field>
</Group_Tag>
</contact>
STRING;

	return $data;
}



function api_call($contact_id, $data, $appid, $key) {
	
	$data = urlencode(urlencode($data));

	// Replace the strings with your API credentials located in Admin > OfficeAutoPilot API Instructions and Key Manager
	// $appid = "2_11369_H4sKVMEiL";
	// $key = "5VgmlzqqiY55TuI";

	$reqType= "update";
	$postargs = "appid=".$appid."&key=".$key."&return_id=1&reqType=".$reqType. "&data=" . $data;
	$request = "https://api.moon-ray.com/cdata.php";

	$session = curl_init($request);
	curl_setopt ($session, CURLOPT_POST, true);
	curl_setopt ($session, CURLOPT_POSTFIELDS, $postargs);
	curl_setopt($session, CURLOPT_HEADER, false);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($session);
	curl_close($session);
	header("Content-Type: text/xml");
	echo $response;
}


if ($rfm = 1) {
	$data = days_between_1($contact_id, $date_purchase, $appid, $key);
	sleep(1);
	api_call($contact_id, $data, $appid, $key);
	
	//api_call($data);
}


	//echo 'diff in days = '.$diff_in_days.'<br>';
	//echo 'purchase date = '.$date_purchase.'<br>';


?>