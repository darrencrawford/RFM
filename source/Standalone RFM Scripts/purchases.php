<?php

//GET variables from URL
$contact_id = $_GET["contact_id"];
$purchases = $_GET["purchases"];

//Do math - add one to current number of purchases
$updated_purchases=$purchases+1;

$data = <<<STRING
//You must pass the contact ID as an argument to indicate which contact is being updated
<contact id="$contact_id">
<Group_Tag name="Buying Cycles">
<field name="Number of Purchases">$updated_purchases</field>
</Group_Tag>
</contact>
STRING;

$data = urlencode(urlencode($data));

// Replace the strings with your API credentials located in Admin > OfficeAutoPilot API Instructions and Key Manager
$appid = "2_8529_cx6KzRc4C";
$key = "UtSHVvy58TvbNlT";

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

