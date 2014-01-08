<?php
/*
 *	Plugin Name: Login.inator
 *	Plugin URI: http://login.inator.co
 * 	Description: Read the contact's login information and determine if they should be sent to a specific page upon login.
 *	Version: 
 *	Author:
 *	Author URI:
 *	License: GPL2

=======
==Active Response==
If [Total Logins] is updated then ping RFM script to update total login count.

Call the login.inator script/shortcode/plugin when the user successfully logs in.
NB: The contact record may've already updated by the time this pulls the login count which means if it shows a 1 then it is really their 1st login.
Login.inator grabs the value of [Total Logins KinobodyElite]
If [Total Logins KinobodyElite] == 1 then redirect to 'Welcome New Member' page
If [Total Logins KinobodyElite] == 2 then redirect to 'Welcome back One Time Offer (OTO)' page
--> see the score.php for parsing this data from the XML feed.


=======

 */






?>