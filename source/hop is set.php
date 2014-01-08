<?php
if(isset($_GET['hop'])) {
    $cbid = htmlentities($_GET['hop']);
    header('location: affiliatesalespage.php?a='.$cbid);
}
?>