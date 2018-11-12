<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/php/script.php");
	include($_SERVER['DOCUMENT_ROOT']."/php/db.php");

	check_cookie();

	if($_POST['search_bar'] != null){
		$book_name = $_POST['search_bar'];
		console_log($book_name);
		
		$dbHandler = new Database("localhost", "root", "", $dbName);
		$list_of_books = $dbHandler->findBookByTitle($book_name);
		console_log($list_of_books);	
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Browse</title>
	<?php require($_SERVER['DOCUMENT_ROOT']."/includes/page_header.php"); ?>
</head>

<body>
	<div id="bodyPage" class="paddingLeftLarge paddingRightLarge fadeIn">

		<form method="post" action="search_result.php">
			<div>
				<h1 class="paddingTopLarge"> Search Result </h1>
				<span style="float:right; margin-top:-48px">Found <u><?php echo count($list_of_books) ?></u> Result(s)</span>
			</div>

			<div id="list_books">
				<table>
				<?php
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
				?>
				</table>
			</div>
		</form>
	</div>
	<script>document.getElementById("browse_pageheader").style.backgroundColor = "#F26600"</script>

</body>

</html>