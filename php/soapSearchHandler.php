<?php
	
	include_once("script.php");

	/* Process data from POST */
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$keyword = $request->keyword;

	if($keyword == null){
		echo "AJAX ERROR; keyword: ".$keyword;
	}
	else {
		$err = $client_search->getError();

		if($err){
			// Display the error
			echo "Constructor error. Message: ". $err;
			return null;
		}

		$result = $client_search->call('searchBooks', array('title'=>$keyword));
		
		if($result == null)
			echo "Error. Result null";
		else {
			echo $result;	
		}
	}
?>