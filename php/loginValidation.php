<?php

	include_once("script.php");

	$username = $_POST['username'];
	$password = $_POST['password'];


	if(count($db_handler->getUserIDByUsername($username)) == 1) {
		$passwordCheck = $db_handler->getPasswordByUsername($username);
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