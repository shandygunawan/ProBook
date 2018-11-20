<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/php/script.php");
	
	if(!checkActiveUser()) {
		clearAllCookies();
		header('Location: '. "login.php");
	}
	
	$user_id = $_COOKIE["user_id"];
	$list_of_order = $db_handler->getBookOrder($user_id);
	console_log($list_of_order);

	function cprint($string) {
		echo $string;
	}

	function formatDate($date) {
		$datum = strtotime($date);
		$year = date("Y", $datum);
		$month = date("F", $datum);
		$date = date("d", $datum);
		$date_placeholder = "$date $month $year";
		return $date_placeholder;
	}

	function CreateOrderTable($order) {
		$is_reviewed = $order->Comment;

		cprint("<tr>");
			cprint("<td rowspan = '2' style='vertical-align:top; width:200px; height:200px'>");
				cprint("<img src='..$order->PicturePath' class='squareImageLarge'></img>");
			cprint("</td>");
			cprint("<td rowspan = '2' style='vertical-align:top;'>");
				cprint("<span class='bookTitleList'> $order->BookName </span> <br/>");
				cprint("<span style = 'padding-left: 10px;'> Jumlah : $order->Amount </span> <br/>");
				$comment_placeholder = "Belum direview";
				if ($is_reviewed) {
					$comment_placeholder = "Anda sudah memberikan review";
				}
				cprint("<span style = 'padding-left: 10px;'> $comment_placeholder </span>");
			cprint("</td>");
			cprint("<td style='float:right; vertical-align:top;'>");
				$date_placeholder = formatDate($order->OrderDate);
				cprint("<span> $date_placeholder </span> <br/>");
				cprint("<span> Nomor Order : #$order->OrderID </span> <br/>");
			cprint("</td>");
		cprint("</tr>");

		cprint("<tr>");
			cprint("<td style='vertical-align:bottom;'>");
				if (!$is_reviewed) {
					cprint("<form method='post' action='review.php'>");
					cprint("<input type='hidden' name='book_id' value='"); echo $order->BookID; cprint("'>");
					cprint("<input type='hidden' name='order_id' value='"); echo $order->OrderID; cprint("'>");
					cprint("<button style = 'float: right;' type='submit' class='buttonStyleBlueWide' name='review_orderid' value='");
					echo $order->OrderID;
					cprint("'> Review </button>");
					cprint("</form>");
				}
				else{
					cprint("<form> <button type='submit' class='buttonStyleBlueWide' name='review_orderid' style='visibility:hidden;'> Review </button></form>");
				}
			cprint("</td>");
		cprint("</tr>");
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
