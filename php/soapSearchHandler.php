<?php
	
	include_once("script.php");
	require_once("./nusoap-0.9.5/lib/nusoap.php");

	if(!isset($_POST["service_type"]) or !isset($_POST['value'])){
		echo "AJAX ERROR";
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

		if($_POST['service_type'] == "searchBook") {
			$result = $client->call('searchBooks', array('title'=>$_POST['value']));
			return $result;
		}
		else if ($_POST['service_type'] == 'getBookDetails') {
			$result = $client->call('getBookDetails', array('id'=>'XLo9DgAAQBAJ'));		
			return $result;
		}
		else {
			echo "Service type error. Message: ". $err;
			return null;
		}
	}
?>