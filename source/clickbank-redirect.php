<?php

/*
 * Redirect Clickbank HOPLINKS to correct sales page
*/

$redirects = array(
"spartan" => "http://www.spartanbodyprogram.com/",
"volume2" => "http://www.example.com/volume2.html",
"volume3" => "http://www.example.com/volume3.html",
"jv" => "http://www.example.com/special/index.html"
);

$x = $_GET["x"];

if (array_key_exists($x, $redirects)) {
$go = $redirects[$x];
header("Location:$go");
die();
}



?>