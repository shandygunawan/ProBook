<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/php/script.php");
	check_cookie();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Browse</title>
	<?php include($_SERVER['DOCUMENT_ROOT']."/includes/page_header.php"); ?>
	
</head>

<body>
	<script src="/js/validation.js"></script>
	<div id="bodyPage" class="paddingLeftLarge paddingRightLarge fadeIn">
		<form method="post" action="search_result.php" onsubmit="return checkSearchForm();">
			<h1 class="paddingTopLarge"> Search Book </h1>
			<input type="text" class="search_bar" placeholder="Input search terms..." id="search_bar" name="search_bar">
			<p></p>
			<div style="text-align: right;">
				<input type="submit" value="Search" class="buttonStyleBlueWide fontToLinotte" name="searchButton" id="searchButton">
			</div>
		</form>
	</div>

	<script>document.getElementById("browse_pageheader").style.backgroundColor = "#F26600"</script>
</body>

</html>