<?php
	
	include("db.php");
	
	$dbHandler = new Database("localhost", "root", "", "wbd");

	$field = $_POST['field'];
	$value = $_POST['query'];

	//check username
	if($field == "username") {
		if(strlen($value) < 21 && $value != "" && count($dbHandler->getUserIDByUsername($value)) == 0) {
			echo "valid";
		}
		// cek database untuk username
		else {
			echo "invalid";
		}
	}

	//check email
	if($field == "email"){
		if(filter_var($value, FILTER_VALIDATE_EMAIL) && count($dbHandler->getUserIDByEmail($value)) == 0) {
			echo "valid";
		}
		else {
			echo "invalid";
		}
	}

	if($field == "phone_number"){
		if(strlen($value) > 8 && strlen($value) < 13){
			echo "valid";
		}
		else {
			echo "invalid";
		}
	}

?>