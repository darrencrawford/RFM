<?php

// Redirect based on an array for the value of X
// Use this to redirect based on logins to various pages

$redirects = array(
"volume1" => "http://www.example.com/volume1.html",
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