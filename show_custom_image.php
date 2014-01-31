<?php
// show image based on passed variable
// cbc = custom banner code

$adcode = $_GET['cbc'];

if($adcode=='933e'){
	//show image x with link
	echo "<a href='http://beforeunit.com'><img src='http://placekitten.com/600/300'></a>";
} elseif ($adcode=='48e5'){
	//show image y with link
	echo "<a href='http://example.com'><img src='http://placekitten.com/650/300'></a>";
} else {
	//show default image and link
	$x = rand(0,1);
	if($x==0) {
		echo "<a href='http://example.com'><img src='http://placekitten.com/250/250'></a>";
	} elseif ($x==1){
		echo "<a href='http://example.com'><img src='http://placekitten.com/500/500'></a>";
	}
}
	


?>