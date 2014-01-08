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
====================================================================
see the README file for exact links to include in your Ontraport sequences

====================================================================
*/



//Get appid and key for OAP
include 'keys.php';
	//echo $appid;

//Get specific variables to determine which function to call
	$contact_id = $_GET["id"];
	$rfm = $_GET['rfm'];
	


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


function days_between_1_2($contact_id, $date_purchase, $appid, $key) {
	
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

	//return $data; // send the data string back for the api_call function
	//return $logname; // send the logname back to be written

	api_call($contact_id, $data, $appid, $key);
	//write_log($logname); // write_log is for debugging
}

function days_between_2_3($contact_id, $date_purchase, $appid, $key) {
	
	//convert date to D-M-Y format
		$pieces = explode("-", $date_purchase);	
		$timestamp = $pieces[1].'-'.$pieces[0].'-'.$pieces[2];
		$timestamp = strtotime($timestamp);
		$now = time();
		$diff = $now-$timestamp;
		$diff = floor($diff/86400);
		$diff_in_days = $diff;
		$logname = 'days-between-2-3_log';

	//echo 'diff in function = '.$diff_in_days.'<br>';

	$data = <<<STRING
	//You must pass the contact ID as an argument to indicate which contact is being updated
	<contact id="$contact_id">
	<Group_Tag name="RFM">
	<field name="Days between Purchases 2 and 3">$diff_in_days</field>
	</Group_Tag>
	</contact>
STRING;

	//return $data; // send the data string back for the api_call function
	//return $logname; // send the logname back to be written

	api_call($contact_id, $data, $appid, $key);
	//write_log($logname); // write_log is for debugging
}

function days_between_3_4($contact_id, $date_purchase, $appid, $key) {
	
	//convert date to D-M-Y format
		$pieces = explode("-", $date_purchase);	
		$timestamp = $pieces[1].'-'.$pieces[0].'-'.$pieces[2];
		$timestamp = strtotime($timestamp);
		$now = time();
		$diff = $now-$timestamp;
		$diff = floor($diff/86400);
		$diff_in_days = $diff;
		$logname = 'days-between-3-4_log';

	//echo 'diff in function = '.$diff_in_days.'<br>';

	$data = <<<STRING
	//You must pass the contact ID as an argument to indicate which contact is being updated
	<contact id="$contact_id">
	<Group_Tag name="RFM">
	<field name="Days between Purchases 3 and 4">$diff_in_days</field>
	</Group_Tag>
	</contact>
STRING;

	//return $data; // send the data string back for the api_call function
	//return $logname; // send the logname back to be written

	api_call($contact_id, $data, $appid, $key);
	//write_log($logname); // write_log is for debugging
}

function days_between_4_5($contact_id, $date_purchase, $appid, $key) {
	
	//convert date to D-M-Y format
		$pieces = explode("-", $date_purchase);	
		$timestamp = $pieces[1].'-'.$pieces[0].'-'.$pieces[2];
		$timestamp = strtotime($timestamp);
		$now = time();
		$diff = $now-$timestamp;
		$diff = floor($diff/86400);
		$diff_in_days = $diff;
		$logname = 'days-between-4-5_log';

	//echo 'diff in function = '.$diff_in_days.'<br>';

	$data = <<<STRING
	//You must pass the contact ID as an argument to indicate which contact is being updated
	<contact id="$contact_id">
	<Group_Tag name="RFM">
	<field name="Days between Purchases 4 and 5">$diff_in_days</field>
	</Group_Tag>
	</contact>
STRING;

	//return $data; // send the data string back for the api_call function
	//return $logname; // send the logname back to be written

	api_call($contact_id, $data, $appid, $key);
	//write_log($logname); // write_log is for debugging
}

function days_between_last_now($contact_id, $date_purchase, $appid, $key) {
	//convert date to D-M-Y format
	$pieces = explode("-", $date_purchase);	
	$timestamp = $pieces[1].'-'.$pieces[0].'-'.$pieces[2];
	$temp = $timestamp;
	$timestamp = strtotime($timestamp);
	$now = time();
	$diff = $now-$timestamp;
	$diff = floor($diff/86400);
	$diff_in_days = $diff;
	$dateLastPurchase = time();

	$data = <<<STRING
	//You must pass the contact ID as an argument to indicate which contact is being updated
	<contact id="$contact_id">
	<Group_Tag name="RFM">
	<field name="Date of Last Purchase">$dateLastPurchase</field>
	<field name="Days since Last Purchase">$diff_in_days</field>
	</Group_Tag>
	</contact>
STRING;

	api_call($contact_id, $data, $appid, $key);
}


//Average days between transactions
function average_days_between($contact_id, $appid, $key) {
	/*
	 * Calculate the average days between transactions for the first 5 transactions
	 * http://example.com/stats/rfm1.php?id=[contact_id]&rfm=averagedaysbetween&transactions=[Number of Transactions]&lead_to_purchase=[Days between Lead and Purchase]&purchases2=[Days between Purchases 1 and 2]&purchases3=[Days between Purchases 2 and 3]&purchases4=[Days between Purchases 3 and 4]&purchases5=[Days between Purchases 4 and 5]
	*/

	//GET variables from URL
	$transactions = $_GET["transactions"];
	$lead_to_purchase = $_GET['lead_to_purchase'];
	$purchases2 = $_GET['purchases2'];
	$purchases3 = $_GET['purchases3'];
	$purchases4 = $_GET['purchases4'];
	$purchases5 = $_GET['purchases5'];

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

	api_call($contact_id, $data, $appid, $key);
}

//Clickcount Goes Here
function clickcount($contact_id, $appid, $key) {
	
	// Count number of clicks and update last click date
	$clickCount = $_GET["clickcount"];
	$lastClickDate = $_GET["lastclickdate"];
		
	if(empty($lastClickDate))
			{
				$lastClickDate = '1/1/1969';
			}
	$clickCount = $clickCount+1;
	$lastClickDate = date('m/d/Y');
	$lastClickDate = mktime($lastClickDate);

	$data = <<<STRING
	//You must pass the contact ID as an argument to indicate which contact is being updated
	<contact id="$contact_id">
	<Group_Tag name="RFM">
	<field name="Total Number of Clicks">$clickCount</field>
	<field name="Date of Last Click">$lastClickDate</field>
	</Group_Tag>
	</contact>
STRING;
	
	//echo $clickCount.'<br>';
	//echo $lastClickDate.'<br>';
	api_call($contact_id, $data, $appid, $key);

}

//Days Between Lead-Purchase
function days_between_lead_purchase($contact_id, $appid, $key) {
	//GET variables from URL
	$contact_id = $_GET["id"];
	$MDYDate = $_GET["dateadded"];

	$pieces = explode("-", $MDYDate);	
	$timestamp = $pieces[1].'-'.$pieces[0].'-'.$pieces[2];
	$timestamp = strtotime($timestamp);
	$now = time();
	$diff = $now-$timestamp;
	$diff = floor($diff/86400);
	$diff_in_days = $diff;

	$data = <<<STRING
	//You must pass the contact ID as an argument to indicate which contact is being updated
	<contact id="$contact_id">
	<Group_Tag name="RFM">
	<field name="Days between Lead and Purchase">$diff_in_days</field>
	</Group_Tag>
	</contact>
STRING;

	api_call($contact_id, $data, $appid, $key);
}

//Lifetime Value
function lifetimevalue($contact_id, $appid, $key) {
	//GET variables from URL
$contact_id = $_GET["contact_id"];
$purchases = $_GET["purchases"];
$last_amount = $_GET["last_amount"];
	$last_amount = substr($last_amount, 1);
	$last_amount = str_replace(",", "", $last_amount); //remove commas from the numbers
$lifevalue = $_GET["lifevalue"];
	$lifevalue = substr($lifevalue, 1);
	$lifevalue = str_replace(",", "", $lifevalue);


//Do math - add one to current number of purchases
$purchases=$purchases+1;
$lifevalue = $lifevalue + $last_amount;
$avgTrans = $lifevalue/$purchases; // do a calc to tally the average transaction value


	$data = <<<STRING
	//You must pass the contact ID as an argument to indicate which contact is being updated
	<contact id="$contact_id">
	<Group_Tag name="Buying Cycles">
	<field name="Number of Purchases">$purchases</field>
	<field name="Lifetime Value">$lifevalue</field>
	<field name="Average Transaction Value">$avgTrans</field>
	</Group_Tag>
	</contact>
STRING;
	
	api_call($contact_id, $data, $appid, $key);
}

//Name Purchase 1
function name_purchase_1($contact_id, $appid, $key) {
	//GET variables from URL
	$contact_id = $_GET["id"];
	$nameLastPurchase = $_GET["namelastpurchase"];

	$data = <<<STRING
	//You must pass the contact ID as an argument to indicate which contact is being updated
	<contact id="$contact_id">
	<Group_Tag name="RFM">
	<field name="Name of Purchase 1">$nameLastPurchase</field>
	</Group_Tag>
	</contact>
STRING;

	api_call($contact_id, $data, $appid, $key);
}

//Name Purchase 2
function name_purchase_2($contact_id, $appid, $key) {
	//GET variables from URL
	$contact_id = $_GET["id"];
	$nameLastPurchase = $_GET["namelastpurchase"];

	$data = <<<STRING
	//You must pass the contact ID as an argument to indicate which contact is being updated
	<contact id="$contact_id">
	<Group_Tag name="RFM">
	<field name="Name of Purchase 2">$nameLastPurchase</field>
	</Group_Tag>
	</contact>
STRING;

	api_call($contact_id, $data, $appid, $key);
}

//Name Purchase 3
function name_purchase_3($contact_id, $appid, $key) {
	//GET variables from URL
	$contact_id = $_GET["id"];
	$nameLastPurchase = $_GET["namelastpurchase"];

	$data = <<<STRING
	//You must pass the contact ID as an argument to indicate which contact is being updated
	<contact id="$contact_id">
	<Group_Tag name="RFM">
	<field name="Name of Purchase 3">$nameLastPurchase</field>
	</Group_Tag>
	</contact>
STRING;

	api_call($contact_id, $data, $appid, $key);
}


//Transaction Count
function transaction_count($contact_id, $appid, $key) {
	//GET variables from URL
	$contact_id = $_GET["id"];
	$oldCount = $_GET["transactions"];
	$last_amount = $_GET["last_amount"];
		$last_amount = substr($last_amount, 1); //remove $ sign
		$last_amount = str_replace(",", "", $last_amount); //remove commas from the numbers
	$totalSpent = $_GET["spent"];
		$totalSpent = substr($totalSpent, 1);
		$totalSpent = str_replace(",", "", $totalSpent);	


	//Do math - add one to current number of purchases
	$newCount = $oldCount+1;
	$newSpent = $totalSpent + $last_amount;


	$data = <<<STRING
	//You must pass the contact ID as an argument to indicate which contact is being updated
	<contact id="$contact_id">
	<Group_Tag name="RFM">
	<field name="Number of Transactions">$newCount</field>
	<field name="Total Spent">$newSpent</field>
	</Group_Tag>
	</contact>
STRING;

	api_call($contact_id, $data, $appid, $key);
}

function total_logins($contact_id, $appid, $key) {
	//GET variables from URL
	$contact_id = $_GET["id"];
	$total_logins = $_GET["totallogins"];
		$total_logins = $total_logins + 1;

	$data = <<<STRING
	//You must pass the contact ID as an argument to indicate which contact is being updated
	<contact id="$contact_id">
	<Group_Tag name="RFM">
	<field name="Total Logins KinobodyElite">$total_logins</field>
	</Group_Tag>
	</contact>
STRING;

	api_call($contact_id, $data, $appid, $key);
}



if ($rfm == 'daysbetween1-2') {
	$date_purchase = $_GET["datepurchase"];
	days_between_1_2($contact_id, $date_purchase, $appid, $key);		
	
	
	} elseif ($rfm == 'daysbetween2-3') {
		$date_purchase = $_GET["datepurchase"];
		days_between_2_3($contact_id, $date_purchase, $appid, $key);
	} elseif ($rfm == 'daysbetween3-4') {
		$date_purchase = $_GET["datepurchase"];
		days_between_3_4($contact_id, $date_purchase, $appid, $key);
	} elseif ($rfm == 'daysbetween4-5') {
		$date_purchase = $_GET["datepurchase"];
		days_between_4_5($contact_id, $date_purchase, $appid, $key);
	} elseif ($rfm == 'daysbetweenlastnow') {
		$date_purchase = $_GET["datepurchase"];
		days_between_last_now($contact_id, $date_purchase, $appid, $key);
	} elseif ($rfm == 'averagedaysbetween') {
		average_days_between($contact_id, $appid, $key);
	} elseif ($rfm == 'clickcounter') {
		clickcount($contact_id, $appid, $key);
	} elseif ($rfm == 'daysbetweenleadpurchase') {
		days_between_lead_purchase($contact_id, $appid, $key);
	} elseif ($rfm == 'lifetimevalue') {
		lifetimevalue($contact_id, $appid, $key);
	} elseif ($rfm == 'namepurchase1') {
		name_purchase_1($contact_id, $appid, $key);
	} elseif ($rfm == 'namepurchase2') {
		name_purchase_2($contact_id, $appid, $key);
	} elseif ($rfm == 'namepurchase3') {
		name_purchase_3($contact_id, $appid, $key);
	} elseif ($rfm == 'transactioncount') {
		transaction_count($contact_id, $appid, $key);
	} elseif ($rfm == 'totallogins') {
		total_logins($contact_id, $appid, $key);
	}
		else {
		echo "Monkey Buns! (AKA Error!)";
	}


?>