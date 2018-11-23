<?php

	// IGNORE THIS PAGE!!!
	// ONLY FOR FUNCTIONALITIES TESTING PURPOSE
	include("script.php");

	require_once("./nusoap-0.9.5/lib/nusoap.php");

	//This is your web service server WSDL URL address
	$wsdl = "http://localhost:4789/services/search?wsdl";

	// Create a client object
	$client = new nusoap_client($wsdl, 'wsdl');
	$err = $client->getError();

	if($err){
		// Display the error
		echo "<h2>Constructor error</h2>". $err;
		exit();
	}

	// call the method
	$result = $client->call('searchBooks', array('title'=>'Guns, Germs'));

	print_r($result).'\n';
	


	/*
	console_log(date("Y-m-d");

	
	date_default_timezone_set("Asia/Jakarta");
	$dt = new DateTime();
	echo $dt->format("Y-m-d H:i:s");
	$dt->modify("+10 seconds");
	echo $dt->format("Y-m-d H:i:s");
	*/
	/*
	$token = new stdClass;
    $token->TokenID = generateToken(10);
    $token->ExpiryTime = $dt->format("Y-m-d H:i:s");
    $token->Browser = getBrowser();
    $token->IpAddress = getIPAddress();
    $token->UserID = 1;
    $dbHandler->addToken($token);
    */

    /*
    console_log($dbHandler->getAllToken());

    foreach($dbHandler->getAllToken() as $token){
    	$dtcheck = new DateTime();
    	if($token->ExpiryTime < date("Y-m-d h:i:sa")) {
    		$dbHandler->deleteTokenByID($token->TokenID);
    	}
    }
    */


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

