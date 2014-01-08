<?php

	//example use is oap_vars.php?email=[email]


	require_once 'OAPApi.class.php';

	$oap = new OapApi('[API AppId]','[API Key]');
	//$oap->debug = true;

	//get email on the URL vars
	$email = $_GET['email'];

	$email_data = $oap->findByEmail($email);

	$custom_field_value = '';

	if(count($email_data->contact->Group_Tag) > 0) {
			foreach($email_data->contact->Group_Tag as $item) {
				if(isset($item->field) && count($item->field) > 0) {
					foreach($item->field as $field) {
						$field_group = (string)$item->attributes()->name;
						$field_name = (string)$field->attributes()->name; 


						if($field_group == 'RFM' && $field_name == 'Total Logins') {
							$custom_field_value = (string)$field[0];
						}

					}
				}
			}
		}

	echo '<pre>';
	echo '"Total Logins" value is: '.$custom_field_value; 
	echo '</pre>';


?>