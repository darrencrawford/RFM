<?php

/*

Instructions:
1. Update the APP KEY AND APP ID Below.
2. Create a custom field for 'Lead Score' in the group 'Buying Cycles' as seen here: http://www.screencast.com/t/eXxTQ5T6q
3. Upload this script to your site and name it score.php
4. Ping the url like (http://yoursite.com/score.php?contact_id=[contact_id])
5. Setup Active response rules based on that field to do awesome stuff.


## The output of XML:

<result>
	<contact id="2455" date="1373930801" dlm="1374715081" score="10.00" purl="Test" bulk_mail="1">
...
	</contact>
</result>

## result is the root element
## contact is an element of root
## score is an attribute of contact

We want to get 'score' and echo it to the screen

*/

//GET variables
$contact_id = $_GET["contact_id"];

//Setup the $data string with the contact id
$data = <<<STRING
<contact_id>$contact_id</contact_id>
STRING;

// Replace the strings with your API credentials located in Admin > OfficeAutoPilot API Instructions and Key Manager
$appid = "2_8529_cx6KzRc4C";
$key = "UtSHVvy58TvbNlT";

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

?>