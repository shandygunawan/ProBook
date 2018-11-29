<?php
	include("script.php");

	if( isset($_POST['amount']) && isset($_POST['user_id']) && isset($_POST['book_id']) ){
		$amount = $_POST['amount'];
		$user_id = $_POST['user_id'];
		$book_id = $_POST['book_id'];


		$user_info = $db_handler->getUserByID($_POST['user_id'])[0];
		$card_number = $user_info->CardNumber;

		$response = $client_search->call('getBookDetails', array('id'=>$book_id));
		$book_info = json_decode($response);
		$category = $book_info->volumeInfo->categories[0];
		$price = $book_info->saleInfo->retailPrice->amount;
		
		$response = $client_order->call('orderBook', array('book_id'=>$book_id,'user_id'=>$user_id,'jumlah'=>$amount, 'rekening'=>$card_number,'category'=>$category, 'harga'=>$price));

		if ($response == "success"){
			$order_id = $client_order->call('getNewestOrderByUserId', array('user_id'=>$user_id));
			echo $order_id;
		}
		else {
			echo "Database Insertion fail.";
		}
		
	}
	else {
		echo "HTTP fail";
	}
	
?>