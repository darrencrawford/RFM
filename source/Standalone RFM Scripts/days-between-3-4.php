<?php
/*
 *	Plugin Name: Days Between 3 and 4
 *	Plugin URI: http://beforeunit.com
 * 	Description: Count the number of days between purchase X and Y.
 *	Version: 1.0
 *	Author: Before Unit
 *	Author URI: http://beforeunit.com
 *	License: GPL2
 

Get the variables from the URL
	$id (oap contact id)
	$dateAdded (date the contact was added to OAP database)
	
	
Calculate the number of days between today and the date they were added.

Setup your PING URL Like this:
http://clickstats.co/kinostats/days-between-lead-purchase.php?id=[contact_id]&datepurchase=[Date Added]

*/

//GET variables from URL
	$contact_id = $_GET["id"];
	$dateAdded = $_GET["datepurchase"];

//convert date to D-M-Y format
	$pieces = explode("-", $dateAdded);	
	$timestamp = $pieces[1].'-'.$pieces[0].'-'.$pieces[2];
	$timestamp = strtotime($timestamp);
	$now = time();
	$diff = $now-$timestamp;
	$diff = floor($diff/86400);
	$diff_in_days = $diff;

//Write the exact URL being pinged to stats_log file 
$filename = '/home/stats/public_html/kinostats/logs/days-between-3-4_log';
	date_default_timezone_set('America/New_York');
	$logDate = date('l jS \of F Y h:i:s A');
	//$addr = "http://".$_SERVER['SERVER_NAME']."/".$_SERVER['REQUEST_URI']."?".$_SERVER['QUERY_STRING'];
	$addr = "/".$_SERVER['REQUEST_URI'];
	$write = $logDate." - ".$addr."\n";
	file_put_contents ( $filename ,  $write , FILE_APPEND | LOCK_EX);


//Echo Outputs to Screen
	//echo 'Diff in Days = '.$diff_in_days.'<br/>';	


$data = <<<STRING
//You must pass the contact ID as an argument to indicate which contact is being updated
<contact id="$contact_id">
<Group_Tag name="RFM">
<field name="Days between Purchases 3 and 4">$diff_in_days</field>
</Group_Tag>
</contact>
STRING;

$data = urlencode(urlencode($data));

// Replace the strings with your API credentials located in Admin > OfficeAutoPilot API Instructions and Key Manager
$appid = "2_11369_H4sKVMEiL";
$key = "5VgmlzqqiY55TuI";

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




?>

