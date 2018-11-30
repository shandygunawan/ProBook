// Using AJAX directly with AngularJS
searchApp.controller('searchController', function($scope,$http){
	$scope.formData={};
	$scope.search = function() {
		console.log($scope.formData.search_bar);

		if($scope.formData.search_bar === ""){
			alert("Fill the search bar!");
		}
		else {
			document.getElementById("loading_circle").style.display = "block";
			document.getElementById("search_result").innerHTML= "";
			document.getElementById("found_books_count").innerHTML = "";
			document.getElementById("book_table").style.display = "none";
			$http({
		        method : "POST",
		        url : "/php/soapSearchHandler.php",
		        data : {
		        	keyword: $scope.formData.search_bar
		        },
		        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		    }).then(function(response) {
		        document.getElementById("loading_circle").style.display = "none";
		        $scope.book_list = response.data; // response.data is already a JSON array
		        
		        document.getElementById("search_result").innerHTML = "Search Result";

		        if(response.data == "Error. Result null"){
		        	document.getElementById("found_books_count").innerHTML = "Found 0 Result(s)";
		        }
		        else {
		        	document.getElementById("found_books_count").innerHTML = "Found " + $scope.book_list.length.toString() + " Result(s)";	
		        	document.getElementById("book_table").style.display = "block";
		        }
		        

		    }, function(response) {
		        console.log(response.statusText);
		    });
		}
	}

	$scope.checkDescription = function(json_obj) {
		if(json_obj.hasOwnProperty('description')) {
			return json_obj.description.replace();
		}
		else {
			return "No description available.";
		}
	}

	$scope.checkAverageRating = function(json_obj) {
		if(json_obj.hasOwnProperty('averageRating')) {
			if((json_obj.averageRating % 1) == 0){
				return json_obj.averageRating.toFixed(1);
			}
			else {
				return json_obj.averageRating;
			}
			
		}
		else {
			return "No average rating available.";
		}	
	}
	
});