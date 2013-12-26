<?php 

include 'keys.php'; 


	echo '<br>';
	echo '<strong>Average Days Between Transactions: <br></strong>';
	echo $install_location.'rfm1.php?id=[contact_id]&rfm=averagedaysbetween&transactions=[Number of Transactions]&lead_to_purchase=[Days between Lead and Purchase]&purchases2=[Days between Purchases 1 and 2]&purchases3=[Days between Purchases 2 and 3]&purchases4=[Days between Purchases 3 and 4]&purchases5=[Days between Purchases 4 and 5]';


?>
