<?php
	include_once($_SERVER['DOCUMENT_ROOT']."/php/script.php");

	if(!checkActiveUser()) {
		clearAllCookies();
		header('Location: '. "login.php");
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Under Construction</title>
	<?php include($_SERVER['DOCUMENT_ROOT']."/includes/page_header.php"); ?>
</head>

<body>
	<div id="bodyPage" class="paddingLeftLarge paddingRightLarge fadeIn">
		<h1 class="paddingTopLarge"> This page is under construction. </h1>
	</div>
</body>

</html>