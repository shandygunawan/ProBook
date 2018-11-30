<?php

	include_once("script.php");
	
	if(isset($_POST['comment']) && isset($_POST['rate']) && isset($_POST['order_id']) ){
		
		$client_order->call('updateOrderReview', array('order_id'=>$_POST['order_id'], 'score'=>$_POST['rate'], 'comment'=>$_POST['comment']));

		header("Location:"."../view/history.php");
	}
	else {
		echo "fail";
	}
	
?>