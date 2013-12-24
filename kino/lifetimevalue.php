<?php
/*
Get the variables from the URL
	$contact_id (oap contact id)
	$purchases (current # of products purchased)
	$lastAmt (last purchase amount)
	$lifevalue (lifetime value amount)

Add 1 to the number of purchases
Update the contact record with the new total # of purchases

Version: 0.1
Last update: July 15, 2013


Setup your PING URL Like this:
http://yourdomain.com/lifetimevalue.php?contact_id=[contact_id]&purchases=[Number of Purchases]&last_amount=[Last Charge Amount]&lifevalue=[Lifetime Value]

*/


//Write the exact URL being pinged to stats_log file 
$filename = '/home/darren/public_html/stats/stats_log';

date_default_timezone_set('America/New_York');
$logDate = date('l jS \of F Y h:i:s A');
//$addr = "http://".$_SERVER['SERVER_NAME']."/".$_SERVER['REQUEST_URI']."?".$_SERVER['QUERY_STRING'];
$addr = "/".$_SERVER['REQUEST_URI'];

$write = $logDate." - ".$addr."\n";

file_put_contents ( $filename ,  $write , FILE_APPEND | LOCK_EX);



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


/* Echo's saved for testing
echo "Contact ID: ".$contact_id;
echo "<br/>";
echo "purchases: ".$purchases;
echo "<br/>";
echo "LTV: ".$lifevalue;
echo "<br/>";
echo "avg transaction: ".$avgTrans;
echo "<br/>";
*/

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

