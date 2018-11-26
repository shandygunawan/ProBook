<?php

	// IGNORE THIS PAGE!!!
	// ONLY FOR FUNCTIONALITIES TESTING PURPOSE
	include("script.php");


	// call the method
	$result = $client_search->call('getBookDetails', array('id'=>"suP3AgAAQBAJ"));
		
	$book_info = json_decode($result);
	console_log($book_info);

	console_log($client_recommendation->call('searchBooksByCategory', array('category'=>"computers")));

	foreach($book_info->volumeInfo->categories as $category) {
		console_log($category);

		// $rec_list = json_decode($book_list);
		// console_log($rec_list);

	}

	// $result = $client->call('getBookDetails', array('id'=>'XLo9DgAAQBAJ'));	
	// console_log($result);
	// print_r($result).'\n';


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

