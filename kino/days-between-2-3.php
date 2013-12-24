<?php
/*
 *	Plugin Name: Days Between 2 and 3
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

	//echo "date added = ".$dateAdded.'<br/>';

/* 09-03-2013 is Sept 3, 2013
 * PHP reads it as March 9, 2013
 * Convert to DD-MM-YY
*/ 
	date_default_timezone_set('America/New_York');
	$m = substr($dateAdded,0,2);
	$d = substr($dateAdded,3,2);
	$y = substr($dateAdded,6,4);
	$dateAdded = $d."-".$m."-".$y;  //Change to new string of DD-MM-YYYY
		//echo '$dateAdded reformated = '.$dateAdded.'<br/>';
	$dateNow = time(); //Set todays date in UNIX time format
		//echo 'dateNow = '.$dateNow.'<br/>';
	$dateAdded = strtotime ($dateAdded); //Change dateAdded to UNIX time format
		//echo 'strtotime dateAdded = '.$dateAdded.'<br/>';
	$diff = $dateNow - $dateAdded; //Calculate time difference in seconds
	$diff_in_days = ($diff/86400); //Calculate time difference in days
	$diff_in_days = round($diff_in_days); //Round off the number of days
		//echo 'diff in days = '.$diff_in_days.'<br/>';

//Write the exact URL being pinged to stats_log file 
$filename = '/home/stats/public_html/kinostats/logs/days-between-2-3_log';
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
<field name="Days between Purchases 2 and 3">$diff_in_days</field>
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

