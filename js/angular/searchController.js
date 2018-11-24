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
		        	keyword: $scope.formData.search_bar
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