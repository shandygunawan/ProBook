<?php

	include($_SERVER['DOCUMENT_ROOT']."/php/script.php");
	include($_SERVER['DOCUMENT_ROOT']."/php/db.php");
	check_cookie();


	$dbHandler = new Database("localhost", "root", "", $dbName);
	$book_array = $dbHandler->findBookByID($_POST['book_id']);
	$book_info = $book_array[0];

	/*
	if($_GET['id'] != null){
		$book_id = $_GET['id'];
		
		$dbHandler = new Database("localhost", "root", "", $dbName);
		$book_array = $dbHandler->findBookByID($book_id);
		$book_info = $book_array[0];

		$review_array = $dbHandler->getReviewAndReviewer($book_info->bookID);
	}
	*/

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require($_SERVER['DOCUMENT_ROOT']."/includes/page_header.php"); ?>
	<link rel="stylesheet" href="../css/star.css">
	<title>Review</title>
</head>

<body>
	<script src="/js/validation.js"></script>
	<div id="bodyPage" class="paddingLeftLarge paddingRightLarge paddingTopLarge fadeIn">
	<form method="post" action="../php/reviewHandler.php" onsubmit="return checkReviewForm()">
		<div>
			<img src="..<?php echo $book_info->PicturePath ?>" class="squareImageMedium" style="float:right;">
			<h1 id="book_title" style="margin-bottom: -10px"><?php echo $book_info->BookName ?></h1>
			<span id="book_author" style="font-size: 20px">&nbsp;<?php echo $book_info->Author ?></span>
		</div>
		<br><br>

		<div>
			<h2 style="margin-bottom:5px;">Add Rating</h2>
			
			<div class="rate">
			    <input type="radio" id="star5" name="rate" value="5" />
			    <label for="star5" title="text">5 stars</label>
			    <input type="radio" id="star4" name="rate" value="4" />
			    <label for="star4" title="text">4 stars</label>
			    <input type="radio" id="star3" name="rate" value="3" />
			    <label for="star3" title="text">3 stars</label>
			    <input type="radio" id="star2" name="rate" value="2" />
			    <label for="star2" title="text">2 stars</label>
			    <input type="radio" id="star1" name="rate" value="1" />
			    <label for="star1" title="text">1 star</label>
			</div>
			<br><br>
		</div>

		<div>
			<h2 style="margin-bottom:5px">Add Comment</h2>
			<textarea name="comment" id="comment" rows="6" style="width:100%"></textarea>
		</div>
		<p></p>
		
		<input type="button" value="Back" class="buttonStyleRedWide fontToLinotte" onclick="window.history.back()" />
		<input type="hidden" name="order_id" id="order_id" value="<?php echo $_POST['order_id'] ?>">
		<input type="submit" value="Submit" id="submit_button" name="submit_button" class="buttonStyleBlueWide fontToLinotte" style="float:right; font-size:20px; padding-left:20px; padding-right:20px; padding-bottom: 7px; padding-top: 7px">
		

	</form>
	</div>

	<script>document.getElementById("history_pageheader").style.backgroundColor = "#F26600"</script>
</body>

</html>
