<?php

	// IGNORE THIS PAGE!!!
	// ONLY FOR FUNCTIONALITIES TESTING PURPOSE
	include("script.php");

	require_once("./nusoap-0.9.5/lib/nusoap.php");

	// SOAP TESTING
	
	//This is your web service server WSDL URL address
	$wsdl = "http://localhost:5432/services/search?wsdl";

	// Create a client object
	$client = new nusoap_client($wsdl, 'wsdl');
	$err = $client->getError();

	if($err){
		// Display the error
		echo "<h2>Constructor error</h2>". $err;
		exit();
	}

	// call the method
	$result = $client->call('searchBooks', array('title'=>'Android development'));

	// $result = $client->call('getBookDetails', array('id'=>'XLo9DgAAQBAJ'));	
	console_log($result);
	print_r($result).'\n';


	// SET TOKEN TESTING
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

	// DELETE TOKEN TESTING
    foreach($dbHandler->getAllToken() as $token){
    	$dtcheck = new DateTime();
    	if($token->ExpiryTime < date("Y-m-d h:i:sa")) {
    		$dbHandler->deleteTokenByID($token->TokenID);
    	}
    }
    */
?>

