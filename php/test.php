<?php
	
	include("db.php");
	include("script.php");

	console_log(date("Y-m-d"));

	$dbHandler = new Database("localhost", "root", "", $dbName);

	$order_id = $dbHandler->getBookOrder(2);
	
	console_log($_SESSION['orderID']);

	// console_log($output);

	// $dbHandler = new Database("localhost", "root", "", $dbName);

	// $username = "higgsfield";
	// $password = "Ihsan_wibu";

	// console_log($dbHandler->getUserByID(1));

	// if(count($dbHandler->getUserIDByUsername($username)) == 1) {
	// 	$passwordCheck = $dbHandler->getPasswordByUsername($username);
	// 	console_log($passwordCheck[0]->Password);
	// 	$id = $dbHandler->getUserIDByUsername($username);
	// 	console_log($id[0]->userID);
	// }
	// 	if($password === $passwordCheck[0]['Password']){
	// 		echo "valid";

	// 		$id = $dbHandler->getUserIDByUsername($username);

	// 	    setcookie("id", $id[0]['userID'], time() + 100);

	// 	}
	// 	else {
	// 		echo "Password incorrect";
	// 	}
	// }
	// else {
	// 	echo "Username not found";
	// }


?>
