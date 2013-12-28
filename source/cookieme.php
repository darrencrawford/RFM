<?php
setcookie("TestCookie", $contact_id);
$contact_id = $_GET['id'];
//$contact_id = 555;
setcookie("TestCookie", $contact_id);
//setcookie("TestCookie", $contact_id, time()+3600);  /* expire in 1 hour */
//setcookie("TestCookie", $contact_id, time()+3600, "/~rasmus/", "example.com", 1);

echo 'your contact id is '.$_COOKIE['TestCookie'];
echo $_COOKIE["TestCookie"];
//echo $HTTP_COOKIE_VARS["TestCookie"];

// Another way to debug/test is to view all cookies
print_r($_COOKIE);

?>