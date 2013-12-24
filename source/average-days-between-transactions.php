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
http://clickstats.co/kinostats/average-days-between-transactions.php?id=[contact_id]&transactions=[Number of Transactions]&lead_to_purchase=[Days between Lead and Purchase]&purchases2=[Days between Purchases 1 and 2]&purchases3=[Days between Purchases 2 and 3]&purchases4=[Days between Purchases 3 and 4]&purchases5=[Days between Purchases 4 and 5]

For statement.  If transactions = 1 then average = number of days.  if trans = 2 then average = (purchases1_2+purchases2_3)

*/

//Write the exact URL being pinged to stats_log file 
$filename = '/home/stats/public_html/kinostats/logs/average-days-between-transactions_log';
	date_default_timezone_set('America/New_York');
	$logDate = date('l jS \of F Y h:i:s A');
	//$addr = "http://".$_SERVER['SERVER_NAME']."/".$_SERVER['REQUEST_URI']."?".$_SERVER['QUERY_STRING'];
	$addr = "/".$_SERVER['REQUEST_URI'];
	$write = $logDate." - ".$addr."\n";
	file_put_contents ( $filename ,  $write , FILE_APPEND | LOCK_EX);

// /kinostats/average-days-between-transactions.php?id=3432&transactions=5&lead_to_purchase=112&purchases1_2=0&purchases2_3=0&purchases3_4=0&purchases4_5=0


//GET variables from URL
$contact_id = $_GET["id"];
	//echo 'id = '.$contact_id.'<br/>';
$transactions = $_GET["transactions"];
	//echo 'transactions = '.$transactions.'<br/>';
$lead_to_purchase = $_GET['lead_to_purchase'];
	//echo 'lead to purchase = '.$lead_to_purchase.'<br/>';
$purchases2 = $_GET['purchases2'];
	//echo 'purchases2 = '.$purchases2.'<br/>';
$purchases3 = $_GET['purchases3'];
	//echo 'purchases3 = '.$purchases3.'<br/>';
$purchases4 = $_GET['purchases4'];
	//echo 'purchases4 = '.$purchases4.'<br/>';
$purchases5 = $_GET['purchases5'];
	//echo 'purchases5 = '.$purchases5.'<br/>';


//echo $transactions;

	if ($transactions==1) {
		$average_transaction = $lead_to_purchase;
	} elseif ($transactions==2) {
		$average_transaction = (($lead_to_purchase+$purchases2)/2);
	} elseif ($transactions==3) {
		$average_transaction = (($lead_to_purchase+$purchases2+$purchases3)/3);
	} elseif ($transactions==4) {
		$average_transaction = (($lead_to_purchase+$purchases2+$purchases3+$purchases4)/4);
	} elseif ($transactions>=5) {
		$average_transaction = (($lead_to_purchase+$purchases2+$purchases3+$purchases4+$purchases5)/5);
	}

$average_transaction = round($average_transaction);
//echo 'Avg Trans = '.$average_transaction;


$data = <<<STRING
//You must pass the contact ID as an argument to indicate which contact is being updated
<contact id="$contact_id">
<Group_Tag name="RFM">
<field name="Average Days Between Purchases">$average_transaction</field>
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

