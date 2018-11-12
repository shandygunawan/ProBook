<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/php/script.php");
	include($_SERVER['DOCUMENT_ROOT']."/php/db.php");
	
	check_cookie();
	
	$user_id = $_COOKIE["id"];
	$db = new Database("localhost", "root", "", $dbName);
	$list_of_order = $db->getBookOrder($user_id);
	console_log($list_of_order);

	function cprint($string) {
		// echo $string . "<br/>";
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
			// cprint("<td class = 'block' style='vertical-align:top;'>");
			// cprint("<td class = 'block'; style='vertical-align:top; white-space: nowrap;>");
			cprint("<td style='vertical-align:top; width:200px; height:200px'>");
				cprint("<img src='..$order->PicturePath' class='squareImageLarge'></img>");
			cprint("</td>");
			cprint("<td style='vertical-align:top;'>");
			// cprint("<td style='vertical-align:top, width: 100%;'>");
				// cprint("<span class='bookTitleList'> $order->BookName </span>");
				cprint("<span class='bookTitleList'> $order->BookName </span> <br/>");
				cprint("<span style = 'padding-left: 10px;'> Jumlah : $order->Amount </span> <br/>");
				$comment_placeholder = "Belum direview";
				if ($is_reviewed) {
					$comment_placeholder = "Anda sudah memberikan review";
				}
				cprint("<span style = 'padding-left: 10px;'> $comment_placeholder </span>");
			cprint("</td>");
			cprint("<td style='float:right; vertical-align:top;'>");
			// cprint("<td style='vertical-align:top;'>");
			// cprint("<td style='vertical-align:top, horizontal-align:right;'>");
				$date_placeholder = formatDate($order->OrderDate);
				cprint("<span> $date_placeholder </span> <br/>");
				cprint("<span> Nomor Order : #$order->OrderID </span> <br/>");
				
			cprint("</td>");
		cprint("</tr>");
		cprint("<tr>");
			cprint("<td></td>");
			cprint("<td></td>");
			cprint("<td style='float:right;'>");
				if (!$is_reviewed) {
					cprint("<form method='post' action='review.php'>");
					cprint("<input type='hidden' name='book_id' value='"); echo $order->BookID; cprint("'>");
					cprint("<input type='hidden' name='order_id' value='"); echo $order->OrderID; cprint("'>");
					cprint("<button type='submit' class='buttonStyleBlueWide' name='review_orderid' value='");
					echo $order->OrderID;
					cprint("'> Review </button>");
					cprint("</form>");
					// cprint("<input type='button' class='buttonStyleBlueWide' value='Review' onclick= \"window.location.href='review.php?id=".."'\">");
				}
				else{
					cprint("<form> <button type='submit' class='buttonStyleBlueWide' name='review_orderid' style='visibility:hidden;'> Review </button></form>");
				}
			cprint("</td>");
		cprint("</tr>");
			// echo "<td style='vertical-align:top;'>";
			// 	echo "<span class='bookTitleList'>". "Jumlah : $order->BookName" . "</span>" ; echo "<br>";
			// echo "</td>";
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
				<!-- <table border = "1";'> -->
				<!-- <table style = 'width: 100%;'> -->
				<table style = 'width: 100%; display: inline-table;'>
					<?php
						foreach($list_of_order as $order) {
							CreateOrderTable($order);
							// echo "<tr> <td style='vertical-align:top;'>";
							// echo "<img src='..". $order->PicturePath. "' class='squareImageLarge'></img>";
							// echo "</td> <td style='vertical-align:top;'>";
							// echo "<span class='bookTitleList'>". $order->BookName. "</span>" ; echo "<br>";
							// echo "<span style='padding-left:10px;'>" . $order->Amount . "</span>"; 
							// echo " - ";
							// // echo printRating($order->AverageRating)."/5.0 (".$order->Voters." votes)" ; echo "<br>";
							// // echo "<p style='padding-left:10px; text-align:justify;'>" . $order->Synopsis . "</p>"; echo "<br>";
							// echo "</td></tr>";
							// echo "<tr>";
							// echo "<td><td/>";
							// echo "<td>";
							// echo "<form>";
							// echo "<input type='button' class='buttonStyleBlueWide' value='Detail' onclick=\"window.location.href='review.php?id=" .$order->OrderID. "'\">";
							// echo "</form></td></tr>";
						}
					?>
				</table>
			</div>
	</div>

	<script>document.getElementById("history_pageheader").style.backgroundColor = "#F26600"</script>
</body>

</html>
