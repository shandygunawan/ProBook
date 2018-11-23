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
?>