function overlayOn() {
    document.getElementById("overlay").style.display = "block";
}

function overlayOff() {
    document.getElementById("overlay").style.display = "none";
}

function showOrderPopUp(orderid){
	document.getElementById("latest_order_id").innerHTML = orderid;
	overlayOn();
}

function orderBook(userId, bookId){
	var xmlhttp = new XMLHttpRequest();

	// console.log(userId);
	// console.log(bookId);
	// console.log(document.getElementById("order_amount").value);

	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState != 4 && xmlhttp.status == 200){
			console.log("Validating");

		}
		else if(xmlhttp.readyState === 4 && xmlhttp.status == 200){

			if(xmlhttp.responseText === "fail"){
				alert("Your Order is not successful. Please try again.")
			}
			else {
				showOrderPopUp(xmlhttp.responseText);
			}
		}
		else{
			console.log("error");
			// document.getElementById(field).innerHTML = "Error Occured."
		}

	}

	xmlhttp.open("POST", "../php/orderValidation.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("amount="+ document.getElementById("order_amount").value + "&user_id=" + userId + "&book_id=" + bookId);
}

function ArraytoString(arr_param){
	var str_array = "";
	for(var i = 0; i < arr_param.length; i++){

		str_array.concat(arr_param[i]);
		// last authors name, no need for coma
		if((i+1) < arr_param.length){
			str_array.concat(", ");
		}	
	}

	return str_array;
}