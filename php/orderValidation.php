<?php
	
	include("script.php");
	include("db.php");

	if( isset($_POST['amount']) && isset($_POST['user_id']) && isset($_POST['book_id']) ){
		$amount = $_POST['amount'];
		$user_id = $_POST['user_id'];
		$book_id = $_POST['book_id'];

		console_log($_POST['amount']);
		console_log($_POST['user_id']);
		console_log($_POST['book_id']);

		$order = new stdClass;
		$order->Amount = $amount;
		$order->UserID = $user_id;
		$order->BookID = $book_id;
		$order->OrderDate = date("Y-m-d");
		$order->Score = null;
		$order->Comment = null;

		$dbHandler = new Database("localhost", "root", "", $dbName);
		$dbHandler->addOrder($order);

		$order_id = $dbHandler->getBookOrder($_POST['user_id']);

		echo $order_id[0]->OrderID;
	}
	else {
		echo "fail";
	}
	
?>