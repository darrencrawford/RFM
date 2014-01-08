<?php
/*
	* read cookie
	* fetch contact record
	* read total logins from xml
	* if total logins matches array redirect to that page
	* if not, redirect to members homepage.

	## result is the root element
	## contact is an element of root
	## score is an attribute of contact

*/	


//echo $_COOKIE["JustATest"];
$contact_id = $_COOKIE["kinobodyelite"];
//echo $contact_id.'<br>';


include 'keys.php';

$data = <<<STRING
<contact_id>$contact_id</contact_id>
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
//echo $response;	

//$xml = simplexml_load_string($response); 

$a1 = preg_split('/KinobodyElite">/', $response); // $a1 will give you an array where the first value is everything up to Logins"> and the send value is the 475 and everything after
$a2 = preg_split('/</', $a1[1]); // $a2 will give you an array where the first value is the number you're after. (This cuts off the < and everything after that, leaving the value.)
//echo $a2[0]; // should give you the value

$logins = $a2[0];
$logins = $logins + 50;

$redirect = 'http://example.com';

$go = $redirect.'?logins='.$logins;
header("Location:$go");


//$xml = simplexml_load_string($response)->contact->Group_Tag[@name='RFM']->field[@name='Total Logins KinobodyElite'];
//echo $xml;
//print_r($xml);

//$logins = $xml->xpath('/result/contact/Group_Tag[@name="RFM"]/field[@name="Total Logins KinobodyElite"]');
//echo $logins;

?>