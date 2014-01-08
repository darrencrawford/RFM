<?php
/*
 *	Plugin Name: Name of Purchase 2
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
http://clickstats.co/kinostats/name-purchase-1.php?id=[contact_id]&namelastpurchase=[Name of Last Purchase]

*/

//GET variables from URL
	$contact_id = $_GET["id"];
	$nameLastPurchase = $_GET["namelastpurchase"];

/*
	echo 'month '.$pieces[0].'<br/>';
	echo 'day '.$pieces[1].'<br/>';
	echo 'year'.$pieces[2].'<br/>';
	echo 'timestamp '.$timestamp.'<br/>';
	echo 'now '.$now.'<br/>';
	echo 'diff '.$diff.'<br/>';
	echo 'diff in days '.$diff_in_days.'<br/>';
*/

//Write the exact URL being pinged to stats_log file 
$filename = '/home/stats/public_html/kinostats/logs/name-purchase-2_log';
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
<field name="Name of Purchase 2">$nameLastPurchase</field>
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

