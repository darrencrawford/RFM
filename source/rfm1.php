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

//Get specific variables to determine which function to call
	$contact_id = $_GET["id"];
	$rfm = $_GET['rfm'];

function days_between1() {
	$date_purchase = $_GET["datepurchase"];




$data = <<<STRING
//You must pass the contact ID as an argument to indicate which contact is being updated
<contact id="$contact_id">
<Group_Tag name="RFM">
<field name="Days between Purchases 1 and 2">$diff_in_days</field>
</Group_Tag>
</contact>
STRING;
}

function api_call($data) {
	// take the $data variable from the calculation function and make the API call
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
}




?>