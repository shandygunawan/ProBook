<?php
	include($_SERVER['DOCUMENT_ROOT'].'/php/script.php');
	// require_once($_SERVER['DOCUMENT_ROOT'].'/php/nusoap-0.9.5/lib/nusoap.php');

	// error_reporting(0);

	if(!checkActiveUser()) {
		clearAllCookies();
		header('Location: '. 'login.php');
	}

	if($_GET['book_id'] != null){
		console_log($_GET['book_id']);

		$err = $client_search->getError();

		if($err){
			// Display the error
			echo 'Constructor error. Message: '. $err;
			return null;
		}

		$result = $client_search->call('getBookDetails', array('id'=>$_GET['book_id']));
		$book_info = json_decode($result);
		console_log($book_info);

		if(!isset($book_info)){
			header('Location: '. "construction.php");
		}

		$rec_list = [];

		foreach($book_info->volumeInfo->categories as $category) {
			$result = $client_search->call('getBookRecommendation', array('category'=>$category));
			if(isset($result)){
				array_push($rec_list, json_decode($result));
			}
		}

		console_log($rec_list);

		$result = $client_order->call('getReviewsByBookId', array('book_id'=>$_GET['book_id']));
		$review_list = json_decode($result);
	}
?>

<!DOCTYPE html>
<html lang='en'>

<head>
	<title><?php echo $book_info->volumeInfo->title; ?></title>
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/page_header.php'); ?>
</head>

<body>
	<div id='bodyPage' class='paddingLeftLarge paddingRightLarge paddingTopLarge fadeIn'>
	<script src='../js/script.js'> </script>
	<p></p>
		<table>
		<!-- <form method='post'> -->
			<tr>
				<td style='vertical-align: top;'>
					<h1 id='book_title' style='margin-bottom: -5px'><?php echo $book_info->volumeInfo->title; ?></h1>
					<span id='book_author' style='font-size: 20px'><?php echo printAuthors($book_info->volumeInfo->authors); ?></span>
					<p id='book_synopsis' style='text-align: justify;'><?php printDescription($book_info->volumeInfo->description);?></p>
				</td>

				<td style='vertical-align: top; padding-top: 2%; text-align: center;'>
					<img src='<?php echo $book_info->volumeInfo->imageLinks->thumbnail ?>' class='squareImageMedium paddingLeftSmall'>
					<br>
					<img src='../asset/rating/<?php
						if(isset($book_info->volumeInfo->averageRating)){
							echo floor($book_info->volumeInfo->averageRating);	
						}
						else {
							echo '0';
						}
					?>star.png' style='width:110px;height:30px;' class='paddingLeftSmall'>
					<br>
					<span class='paddingLeftSmall'>
						<?php

							if(isset($book_info->volumeInfo->averageRating)){
								printRating($book_info->volumeInfo->averageRating); 	
							}
							else {
								echo '-';
							}
						?> / 5.0
					</span>
				</td>
			</tr>
			<tr><td><p></p></td></tr>
			<tr>
				<td> <h2 style='margin-bottom:5px;'>Order</h2> </td>
			</tr>
			<?php
				if($book_info->saleInfo->saleability == 'FOR_SALE') {
					echo
					"
					<form method='post'>
						<tr>
							<td> 
								Amount: 
								<select id='order_amount' onchange='updateOrderPrice(this.value, ".$book_info->saleInfo->retailPrice->amount.")'>
									<option value='1'>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
									<option value='4'>4</option>
									<option value='5'>5</option>
									<option value='6'>6</option>
									<option value='7'>7</option>
									<option value='8'>8</option>
									<option value='9'>9</option>
									<option value='10'>10</option>
								</select>
								&nbsp;&nbsp;&nbsp;
								Price : <span id='order_price'> <script> document.write(formatter.format(".$book_info->saleInfo->retailPrice->amount.")) </script> </span>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type='hidden' name='user_id' id='user_id' value='".$_COOKIE['user_id']."'>
								<input type='hidden' name='book_id' id='book_id' value='".$book_info->id."'>
								<input type='button' value='Order' class='buttonStyleBlueWide' style='float: right;' onclick='return orderBook(".$_COOKIE['user_id'].", \"".$book_info->id."\")'>
							</td>
						</tr>
					</form> 
					";
				}
				else {
					echo "<tr> <td> <h3> This book is not for sale. </h3> </td> </tr>";
				}
			?>
		<!-- </form> -->
		</table>
		<p></p>
		<h2 style='margin-bottom:5px'>Recommendation</h2>
		<table style="width:100%"> <?php printRecommendationList($rec_list) ?> </table>
		<p></p>
		<h2 style='margin-bottom:5px'>Reviews</h2>
		<table style='width:100%'>
		<?php printReviewList($review_list) ?>
		</table>
	</div>

	<div id='overlay'>
		<div id='overlay_popup'>
			<table style='width:100%'>
				<tr>
					<td></td>
					<td><input type='image' src='../asset/exit_black.png' style='width:20px;height:20px; float:right;' onclick='overlayOff();'></td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td style='vertical-align: center'>
						<img style='width:30px;height:20px; text-align: center;' id='transaction_status_icon'>
					</td>
					<td>
						<span style='font-weight: bolder; font-size: 14px' id='transaction_status'>Pemesanan Berhasil!</span> <br>
						<span style='font-weight: lighter; font-size:12px' id='transaction_message'></span>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<script>document.getElementById('browse_pageheader').style.backgroundColor = '#F26600'</script>
</body>
</html>