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
	<title>Browse</title>
	<?php include($_SERVER['DOCUMENT_ROOT']."/includes/page_header.php"); ?>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular.min.js"></script>
	<script src="../js/angular/searchApp.js"></script>
	<script src="../js/angular/searchController.js"></script>
</head>

<body>
	<div id="bodyPage" class="paddingLeftLarge paddingRightLarge fadeIn" ng-app="searchApp" ng-controller="searchController">
		<div ng-include="'/view/angular/search_bar.html'"></div>
		<div class="loader" id="loading_circle" style='display:none;margin-left:auto; margin-right:auto;'></div>
		<div ng-include="'/view/angular/search_result.html'"></div>
	</div>

	<script>document.getElementById("browse_pageheader").style.backgroundColor = "#F26600"</script>
</body>

</html>