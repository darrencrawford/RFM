<?php
setcookie('kinobodyelite','null');
// pre-login

$redirect = 'http://localhost:8888/plugins/RFM/source/readcookie.php';

$id = $_GET["id"];
setcookie('kinobodyelite',$id);

$go = $redirect.'?id='.$id;
header("Location:$go");



?>