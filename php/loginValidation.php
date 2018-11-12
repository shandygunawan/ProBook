<?php

	include("script.php");
	include("db.php");
	
	$dbHandler = new Database("localhost", "root", "", $dbName);

	$username = $_POST['username'];
	$password = $_POST['password'];


	if(count($dbHandler->getUserIDByUsername($username)) == 1) {
		$passwordCheck = $dbHandler->getPasswordByUsername($username);
		if($password === $passwordCheck[0]->Password){
			echo "valid";

		}
		else {
			echo "Password incorrect";
		}
	}
	else {
		echo "Username not found";
	}

?>