<?php

	include($_SERVER['DOCUMENT_ROOT']."/php/script.php");
	include($_SERVER['DOCUMENT_ROOT']."/php/db.php");

	check_cookie();

	if($_GET['id'] != null){
		$book_id = $_GET['id'];
		
		$dbHandler = new Database("localhost", "root", "", $dbName);
		$book_array = $dbHandler->findBookByID($book_id);
		$book_info = $book_array[0];

		$review_array = $dbHandler->getReviewOnBook($book_info->BookID);
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Book Detail</title>
	<?php require($_SERVER['DOCUMENT_ROOT']."/includes/page_header.php"); ?>
</head>

<body>
	<div id="bodyPage" class="paddingLeftLarge paddingRightLarge paddingTopLarge fadeIn">
	<script src="../js/script.js"> </script>
	<p></p>
		<table>
		<form method="post">
			<tr>
				<td style="vertical-align: top;">
					<h1 id="book_title" style="margin-bottom: -5px"><?php echo $book_info->BookName; ?></h1>
					<span id="book_author" style="font-size: 20px"><?php echo $book_info->Author; ?></span>
					<p id="book_synopsis" style="text-align: justify;"><?php echo $book_info->Synopsis;?></p>
				</td>

				<td style="vertical-align: top; padding-top: 2%; text-align: center;">
					<img src="..<?php echo $book_info->PicturePath ?>" class="squareImageMedium paddingLeftSmall">
					<br>
					<img src="../asset/rating/<?php echo floor($book_info->AverageRating)?>star.png" style="width:110px;height:30px;" class="paddingLeftSmall">
					<br>
					<span class="paddingLeftSmall">
						<?php printRating($book_info->AverageRating); ?> / 5.0
					</span>
				</td>
			</tr>
			<tr><td><p></p></td></tr>
			<tr>
				<td> <h2 style="margin-bottom:5px;">Order</h2> </td>
			</tr>
			<tr>
				<td> Jumlah: 
					<select id="order_amount">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="hidden" name="user_id" id="user_id" value="<? echo $_COOKIE['id']; ?>">
					<input type="hidden" name="book_id" id="book_id" value="<? echo $book_info->BookID; ?>">
					<input type="button" value="Order" class="buttonStyleBlueWide" style="float: right;" onclick="return orderBook(<?php echo $_COOKIE['id'].",".$book_info->BookID ?>)">
				</td>
			</tr>
		</form>
		</table>
		<p></p>

		<h2 style="margin-bottom:5px">Reviews</h2>
		<table style="width:100%">
			<?php
				console_log($review_array);
				if(count($review_array) > 0) {
					foreach($review_array as $review) {
						echo "<tr> <td style='vertical-align:top; width:80px;'>";
						echo "<img src='..". $review->PicturePath. "' class='squareImageSmall' style='border: 1px solid black;'></img>";
						echo "</td> <td style='vertical-align:top;'>";
						echo "<span style='padding-left:5px;' class='reviewUsername'>@". $review->Username. "</span>" ; echo "<br>";
						echo "<p style='text-align:justify;padding-left:7px; margin-top:5px'>" . $review->Comment . "</p>"; echo "<br>";
						echo "</td><td style='text-align:center; vertical-align:center; float:right;'>";
						echo "<img src='../asset/star_rounded.png' class='squareImageSuperSmall'></img><br>";
						echo $review->Score.'.0/5.0';
						echo "</td></tr>";
						echo "<tr><td></td></tr>";
					}	
				}
				else {
					echo "<tr> <td> <h3> There is no review for this book. </h3> </td> </tr>";
				}	
			?>
		</table>
	</div>

	<div id="overlay">
		<div id="overlay_popup">
			<table style="width:100%">
				<tr>
					<td></td>
					<td><input type="image" src="../asset/exit_black.png" style="width:20px;height:20px; float:right;" onclick="overlayOff();"></td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td style='vertical-align: center'>
						<img style='width:30px;height:20px; text-align: center;' src='../asset/check_black.png'>
					</td>
					<td>
						<span style="font-weight: bolder; font-size: 14px">Pemesanan Berhasil!</span> <br>
						<span style="font-weight: lighter; font-size:12px">Nomor Transaksi : <span id="latest_order_id"></span> </span>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<script>document.getElementById("browse_pageheader").style.backgroundColor = "#F26600"</script>
</body>
</html>