<?php
	
	include_once("script.php");
	require_once("./nusoap-0.9.5/lib/nusoap.php");

	/* Process data from POST */
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$service_type = $request->service_type;
	$value = $request->value;

	if($service_type == null or $value == null){
		echo "AJAX ERROR; Service_type: ".$service_type."; Value: ".$value;
	}
	else {
		//This is web service server WSDL URL address
		$wsdl = $localhost.$port_soap.$path_search.$path_wsdl;

		// Create a client object
		$client = new nusoap_client($wsdl, 'wsdl');
		$err = $client->getError();

		if($err){
			// Display the error
			echo "Constructor error. Message: ". $err;
			return null;
		}

		// call the method

		if($service_type == "searchBooks") {
			$result = $client->call('searchBooks', array('title'=>$value));
			echo $result;
		}
		else if ($service_type == 'getBookDetails') {
			$result = $client->call('getBookDetails', array('id'=>$value));		
			echo $result;
		}
		else {
			echo "Service type error. Message: ". $err;
		}
	}
?>