<?php

// Just fetch the user record by email address.

include 'keys.php';

//GET variables
$contact_email = $_GET['email'];


//Setup the $data string with the contact id
$data = <<<STRING
<E-Mail>$contact_email</E-Mail>
STRING;


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
echo $response;

/*
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

// enclode the url
$data = urlencode(urlencode($data));

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

// end of the sequence.  By now the 'Lead Score' custom field has been updated with the current Leadscore.
*/

?>