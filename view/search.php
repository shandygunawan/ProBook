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
</head>

<body>
	<div id="bodyPage" class="paddingLeftLarge paddingRightLarge fadeIn" ng-app="searchApp" ng-controller="searchController">
		<div ng-include="'/view/angular/search_bar.html'"></div>
		<h3 id="waiting_text"></h3>
		<div ng-include="'/view/angular/search_result.html'"></div>
	</div>

	<script>
		var searchApp = angular.module("searchApp", []);

		// Using AJAX directly with AngularJS
		searchApp.controller('searchController', function($scope,$http){
			$scope.formData={};
			$scope.search = function() {
				console.log($scope.formData.search_bar);

				if($scope.formData.search_bar === ""){
					alert("Fill the search bar!");
				}
				else {
					document.getElementById("waiting_text").innerHTML="Retrieving Data. Please wait.";
					$http({
				        method : "POST",
				        url : "/php/soapSearchHandler.php",
				        data : {
				        	service_type : "searchBooks",
				        	value: $scope.formData.search_bar
				        },
				        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				    }).then(function(response) {
				        document.getElementById("waiting_text").innerHTML="";
				        console.log(response.data);
				        $scope.book_list = response.data; // response.data is already a JSON array
				        
				        document.getElementById("search_result").innerHTML= "Search Result";
				        document.getElementById("found_books_count").innerHTML= "Found " + $scope.book_list.length.toString() + " Result(s)";

				    }, function(response) {
				        console.log(response.statusText);
				    });
				}
			}

			$scope.getBookDetails = function() {
				console.log($scope.formData.book_id);

				if($scope.formData.book_id == null){
					alert("Book Detail Error Null");
				}
				else {
					$http({
				        method : "POST",
				        url : "/php/soapSearchHandler.php",
				        data : {
				        	service_type : "getBookDetails",
				        	value: $scope.formData.book_id
				        },
				        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				    }).then(function(response) {
				        console.log(response.data);
				    }, function(response) {
				        console.log(response.statusText);
				    });
				}
			}

			$scope.checkDescription = function(json_obj) {
				if(json_obj.hasOwnProperty('description')) {
					return json_obj.description;
				}
				else {
					return "No description available.";
				}
			}

			$scope.checkAverageRating = function(json_obj) {
				if(json_obj.hasOwnProperty('averageRating')) {
					return json_obj.averageRating;
				}
				else {
					return "No average rating available.";
				}	
			}
			
		});
	</script>

	<script>document.getElementById("browse_pageheader").style.backgroundColor = "#F26600"</script>
</body>

</html>