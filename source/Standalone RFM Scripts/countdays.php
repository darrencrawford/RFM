<?php
// Calculate number of days between DATE1 and DATE2
$date1='';
$date2='';

$date1 = time(); // Now
$date2 = $_GET["start"]; // Day-Month-Year

// 09-03-2013 is Sept 3, 2013
// PHP reads it as March 9, 2013
// Convert to DD-MM-YY
$m = substr($date2,0,2);
$d = substr($date2,3,2);
$y = substr($date2,6,4);
$date2 = $d."-".$m."-".$y;


echo "day = ".$d."<br/>";
echo "month = ".$m."<br/>";
echo "year = ".$y."<br/>";
echo "date2 = ".$date2."<br/>";





echo '<br>';

echo 'date1 = '.$date1.'<br>start = '.$date2.'<br>';
$date2 = strtotime($date2);
echo 'date2 = '.$date2.'<br>';

$diff = $date1-$date2;
echo 'Difference is '.$diff." seconds.<br>";
$difference_in_days = ($diff / 86400);
echo 'Difference is '.$difference_in_days." days.<br>";
echo round($difference_in_days);

/*


*/



?>