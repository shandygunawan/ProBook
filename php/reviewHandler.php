<?php

	include("script.php");
	include("db.php");

	
	if(isset($_POST['comment']) && isset($_POST['rate']) && isset($_POST['order_id']) ){
		

		$review = new stdClass;
		$review->Score = $_POST['rate'];
		$review->Comment = $_POST['comment'];
		$review->OrderID = $_POST['order_id'];

		$dbHandler = new Database("localhost", "root", "", $dbName);
		$dbHandler->updateReview($review);

		header("Location:"."../view/history.php");
	}
	else {
		echo "fail";
	}
	
?>