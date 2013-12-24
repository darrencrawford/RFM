<?php
/*
 *	Plugin Name: TransactionCounter
 *	Plugin URI: http://beforeunit.com
 * 	Description: Count the number of transactions a user has in OAP
 *	Version: 1.0
 *	Author: Before Unit
 *	Author URI: http://beforeunit.com
 *	License: GPL2
 

Get the variables from the URL
	$contact_id (oap contact id)
	$clickCount (current number of clicks)
	$lastclickdate (last click date)
	
Add 1 to the number of clicks
Update the last click date to today

Required: (ignore quotes for names when adding to OAP)
Using Field Editor add the Grouping called 'Buying Cycles'
then add a number field for 'Click Count'
and a date field for 'Last Click Date'

Setup your PING URL Like this:
http://yourdomain.com/clickcount.php?id=[contact_id]&clickcount=[Click Count]&lastclickdate=[Last Click Date]

*/

//GET variables from URL
$contact_id = $_GET["id"];
$oldCount = $_GET["transactions"];
	

//Write the exact URL being pinged to stats_log file 
$filename = '/home/stats/public_html/kinostats/logs/transactioncount_log';
	date_default_timezone_set('America/New_York');
	$logDate = date('l jS \of F Y h:i:s A');
	//$addr = "http://".$_SERVER['SERVER_NAME']."/".$_SERVER['REQUEST_URI']."?".$_SERVER['QUERY_STRING'];
	$addr = "/".$_SERVER['REQUEST_URI'];
	$write = $logDate." - ".$addr."\n";
	file_put_contents ( $filename ,  $write , FILE_APPEND | LOCK_EX);




//Do math - add one to current number of purchases
$newCount=$oldCount+1;


$data = <<<STRING
//You must pass the contact ID as an argument to indicate which contact is being updated
<contact id="$contact_id">
<Group_Tag name="RFM">
<field name="Number of Transactions">$newCount</field>
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

