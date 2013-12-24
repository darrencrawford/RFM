<?php
/*
ClickCounter
Version: 0.1
Last update: July 16, 2013

Get the variables from the URL
	$contact_id (oap contact id)
	$clickcount (current number of clicks)
	$lastclickdate (last click date)
	
Add 1 to the number of clicks
Update the last click date to today

Required: (ignore quotes for names when adding to OAP)
Using Field Editor add the Grouping called 'Buying Cycles'
then add a number field for 'Click Count'
and a date field for 'Last Click Date'

Setup your PING URL Like this:
http://yourdomain.com/clickcount.php?contact_id=[contact_id]&clickcount=[Click Count]&lastclickdate=[Last Click Date]

*/

//GET variables from URL
$contact_id = $_GET["contact_id"];
$clickcount = $_GET["clickcount"];
$lastclickdate = $_GET["lastclickdate"];
$xdate = $lastclickdate;
	
if(empty($lastclickdate))
		{
			$lastclickdate = '1/1/1969';
		}

//Write the exact URL being pinged to stats_log file 
$filename = '/home/darren/public_html/stats/stats_log';

date_default_timezone_set('America/New_York');
$logDate = date('l jS \of F Y h:i:s A');
//$addr = "http://".$_SERVER['SERVER_NAME']."/".$_SERVER['REQUEST_URI']."?".$_SERVER['QUERY_STRING'];
$addr = "/".$_SERVER['REQUEST_URI'];

$write = $logDate." - ".$addr."\n";

file_put_contents ( $filename ,  $write , FILE_APPEND | LOCK_EX);




//Do math - add one to current number of purchases
$clickcount=$clickcount+1;
$lastclickdate=date('m/d/Y');
	$lastclickdate = mktime($lastclickdate);


$data = <<<STRING
//You must pass the contact ID as an argument to indicate which contact is being updated
<contact id="$contact_id">
<Group_Tag name="Buying Cycles">
<field name="Click Count">$clickcount</field>
<field name="Last Click Date">$lastclickdate</field>
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

