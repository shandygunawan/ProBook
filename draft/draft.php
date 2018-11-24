<?php
	
	/*
	// IN SEARCH_RESULT.php

	include($_SERVER['DOCUMENT_ROOT']."/php/script.php");

	if(!checkActiveUser()) {
		clearAllCookies();
		header('Location: '. "login.php");
	}

	if($_POST['search_bar'] != null){
		$book_name = $_POST['search_bar'];
		console_log($book_name);
		
		$list_of_books = $db_handler->findBookByTitle($book_name);
		console_log($list_of_books);
	}

	foreach($list_of_books as $book) {
		echo "<tr> <td style='vertical-align:top;'>";
		echo "<img src='..". $book->PicturePath. "' class='squareImageLarge'></img>";
		echo "</td> <td style='vertical-align:top;'>";
		echo "<span class='bookTitleList'>". $book->BookName. "</span>" ; echo "<br>";
		echo "<span style='padding-left:10px;'>" . $book->Author . "</span>"; 
		echo " - ";
		echo printRating($book->AverageRating)."/5.0 (".$book->Voters." votes)" ; echo "<br>";
		echo "<p style='padding-left:10px; text-align:justify;'>" . $book->Synopsis . "</p>"; echo "<br>";
		echo "</td></tr>";
		echo "<tr>";
		echo "<td><td/>";
		echo "<td>";
		echo "<form>";
		echo "<input type='button' class='buttonStyleBlueWide' value='Detail' onclick=\"window.location.href='detail.php?id=" .$book->BookID. "'\">";
		echo "</form></td></tr>";
		// echo "<button type='submit' class='buttonStyleBlueWide' style='float:right;' name='book_title' value='".$book['bookName']."'>Detail";
		// echo "</button></form></td></tr>";
	}
	*/

	/*
	// IN DETAIL.PHP

	console_log($review_array);
	if(count($review_array) > 0) {
		foreach($review_array as $review) {
			echo '<tr> <td style='vertical-align:top; width:80px;'>';
			echo '<img src='..'. $review->PicturePath. '' class='squareImageSmall' style='border: 1px solid black;'></img>';
			echo '</td> <td style='vertical-align:top;'>';
			echo '<span style='padding-left:5px;' class='reviewUsername'>@'. $review->Username. '</span>' ; echo '<br>';
			echo '<p style='text-align:justify;padding-left:7px; margin-top:5px'>' . $review->Comment . '</p>'; echo '<br>';
			echo '</td><td style='text-align:center; vertical-align:center; float:right;'>';
			echo '<img src='../asset/star_rounded.png' class='squareImageSuperSmall'></img><br>';
			echo $review->Score.'.0/5.0';
			echo '</td></tr>';
			echo '<tr><td></td></tr>';
		}	
	}
	else {
		echo '<tr> <td> <h3> There is no review for this book. </h3> </td> </tr>';
	}	
	*/
?>