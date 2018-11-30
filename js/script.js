const formatter = new Intl.NumberFormat('de-DE', {
  style: 'currency',
  currency: 'IDR',
  minimumFractionDigits: 2
})

function overlayOn() {
    document.getElementById("overlay").style.display = "block";
}

function overlayOff() {
    document.getElementById("overlay").style.display = "none";
}

function showOrderPopUp(orderid){
	
	if(orderid == "Database Insertion fail."){
		document.getElementById("transaction_status_icon").src = "../asset/exit_black.png";
		document.getElementById("transaction_status").innerHTML = "Order Failed!";	
		document.getElementById("transaction_message").innerHTML = "Your account's balance may be not sufficient.";	
	} else {
		document.getElementById("transaction_status_icon").src = "../asset/check_black.png";
		document.getElementById("transaction_status").innerHTML = "Order Successful!";	
		document.getElementById("transaction_message").innerHTML = "Order Number : " + orderid;	
	}
	
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

function updateOrderPrice(amount, price) {
	document.getElementById("order_price").innerHTML = formatter.format(amount*price);
}