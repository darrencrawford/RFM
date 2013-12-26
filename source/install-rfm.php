<?php
/*
 *	Plugin Name: Install RFM Section
 *	Plugin URI: 
 * 	Description: 
 *	Version: 
 *	Author:
 *	Author URI:
 *	License: GPL2

Install RFM section in the contact records

 */


include 'key.php';

	//data must be wrapped with <data> tags
	//Field types need to be set on creation
	$data = <<<STRING
	<data>
	<Group_Tag name="RFM">
	<field name="Date of Last Purchase" type="date"/>
	<field name="Days since Last Purchase" type="numeric"/>
	<field name="Date of 1st Purchase" type="date"/>
	<field name="Date of 2nd Purchase" type="date"/>
	<field name="Date of 3rd Purchase" type="date"/>
	<field name="Date of 4th Purchase" type="date"/>
	<field name="Date of 5th Purchase" type="date"/>
	<field name="Days between Lead and Purchase" type="numeric"/>
	<field name="Days between Purchases 1 and 2" type="numeric"/>
	<field name="Days between Purchases 2 and 3" type="numeric"/>
	<field name="Days between Purchases 3 and 4" type="numeric"/>
	<field name="Days between Purchases 4 and 5" type="numeric"/>
	<field name="Number of Transactions" type="numeric"/>
	<field name="Number of Subscription Cycles" type="numeric"/>
	<field name="Total Spent" type="currency"/>
	<field name="Name of Purchase 1" type="text"/>
	<field name="Name of Purchase 2" type="text"/>
	<field name="Name of Purchase 3" type="text"/>
	<field name="Total Number of Clicks" type="numeric"/>
	<field name="Date of Last Click" type="date"/>
	<field name="Name of Last Purchase" type="text"/>
	<field name="Amount of Last Purchase" type="currency"/>
	<field name="Average Days Between Purchases" type="numeric"/>
	</Group_Tag>
	</data>
STRING;

	$data = urlencode(urlencode($data));


	$reqType= "add_section";
	$postargs = "appid=".$appid."&key=".$key."&reqType=".$reqType."&data=".$data;
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