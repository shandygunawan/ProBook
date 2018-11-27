<?php
	
	include_once($_SERVER['DOCUMENT_ROOT']."/php/script.php");
	
	if(!checkActiveUser()) {
		clearAllCookies();
		header('Location: '. "login.php");
	}
	
	$result = $client_order->call('getOrdersByUserId', array('user_id'=>$_COOKIE['user_id']));
	$list_of_order = json_decode($result);

	console_log($list_of_order);

	function formatDate($date) {
		$datum = strtotime($date);
		$year = date("Y", $datum);
		$month = date("F", $datum);
		$date = date("d", $datum);
		$date_placeholder = "$date $month $year";
		return $date_placeholder;
	}

	function CreateOrderTable($order) {
		GLOBAL $client_search;
		$is_reviewed = $order->Score;
		$result = $client_search->call('getBookDetails', array('id'=>$order->BookId));
		$book_info = json_decode($result);		

		// console_log($book_info);

		echo "<tr>";
			echo "<td rowspan = '2' style='vertical-align:top; width:200px; height:200px'>";
				echo "<img src='". $book_info->volumeInfo->imageLinks->thumbnail."' class='squareImageLarge'></img>";
			echo "</td>";
			echo "<td rowspan = '2' style='vertical-align:top;'>";
				echo "<span class='bookTitleList'>". $book_info->volumeInfo->title.".</span> <br/>";
				echo "<span style = 'padding-left: 10px;'> Jumlah : ". $order->Amount."</span> <br/>";
				$comment_placeholder = "Belum direview";
				if ($is_reviewed > 0) {
					$comment_placeholder = "Anda sudah memberikan review";
				}
				echo "<span style = 'padding-left: 10px;'>". $comment_placeholder ."</span>";
			echo "</td>";
			echo "<td style='float:right; vertical-align:top;'>";
				$date_placeholder = formatDate($order->OrderTime);
				echo "<span>". $date_placeholder ."</span> <br/>";
				echo "<span> Nomor Order : #". $order->OrderId. "</span> <br/>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td style='vertical-align:bottom;'>";
				if (!$is_reviewed) {
					echo "<form method='post' action='review.php'>";
					echo "<input type='hidden' name='book_id' value='".$order->BookId."'>";
					echo "<input type='hidden' name='order_id' value='".$order->OrderId."'>";
					echo "<button style = 'float: right;' type='submit' class='buttonStyleBlueWide' name='review_orderid'> review </button>";
					echo "</form>";
				}
				else{
					echo "<form> <button type='submit' class='buttonStyleBlueWide' name='review_orderid' style='visibility:hidden;'> Review </button></form>";
				}
			echo "</td>";
		echo "</tr>";
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>History</title>
	<?php include($_SERVER['DOCUMENT_ROOT']."/includes/page_header.php"); ?>
	
</head>

<body>
	<div id="bodyPage" class="paddingLeftLarge paddingRightLarge fadeIn">
		<script src="../js/script.js"></script>
			<div>
				<h1 class="paddingTopLarge"> History </h1>
				<span style="float:right; margin-top:-48px"> Found <u> <?php echo count($list_of_order) ?> </u> Result(s) </span>
			</div>

			<div id="book_order_list">
				<table style = 'width: 100%; display: inline-table;'>
					<?php
						foreach($list_of_order as $order) {
							CreateOrderTable($order);
						}
					?>
				</table>
			</div>
	</div>

	<script>document.getElementById("history_pageheader").style.backgroundColor = "#F26600"</script>
</body>

</html>
