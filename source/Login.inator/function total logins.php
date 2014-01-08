<?php

function fetch_logins($contact_id, $appid, $key) {
	/*
	 * Get the number of logins from RFM field via fetch call.
	 * 
	*/

	include 'keys.php';

	//GET variables from URL
	$total_logins = $_GET["totallogins"];
	$total_logins = $total_logins + 1;

		
	//Setup the $data string with the contact id
	$data = <<<STRING
	<contact_id>$contact_id</contact_id>
STRING;

	
	$data = <<<STRING
	//You must pass the contact ID as an argument to indicate which contact is being updated
	<contact id="$contact_id">
	<Group_Tag name="RFM">
	<field name="Name of Purchase 3">$nameLastPurchase</field>
	</Group_Tag>
	</contact>
STRING;

	api_call($contact_id, $data, $appid, $key);






$contact_id = $_GET["contact_id"];




// fetch the data for that contact from OAP
$reqType= "fetch";
$postargs = "appid=".$appid."&key=".$key."&return_id=1&reqType=".$reqType."&data=".$data;
$request = "https://api.moon-ray.com/cdata.php";

$session = curl_init($request);
curl_setopt ($session, CURLOPT_POST, true);
curl_setopt ($session, CURLOPT_POSTFIELDS, $postargs);
curl_setopt($session, CURLOPT_HEADER, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($session);
curl_close($session);
header("Content-Type: text/xml");

// parse the xml contact record for the score in the <contact> element
// and set leadScore to equal that score
$leadScore = simplexml_load_string($response)->contact['score'];

// setup the data string with the contact id and leadScore
$data = <<<STRING
//You must pass the contact ID as an argument to indicate which contact is being updated
<contact id="$contact_id">
<Group_Tag name="Buying Cycles">
<field name="Lead Score">$leadScore</field>
</Group_Tag>
</contact>
STRING;


}

?>