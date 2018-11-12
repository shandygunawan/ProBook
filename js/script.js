// function createCookie(name,value,days) {
//     if (days) {
//         var date = new Date();
//         date.setTime(date.getTime()+(days*24*60*60*1000));
//         var expires = "; expires="+date.toUTCString();
//     }
//     else var expires = "";
//     document.cookie = name+"="+value+expires+"; path=/";
// }

// function readCookie(name) {
//     var nameEQ = name + "=";
//     var ca = document.cookie.split(';');
//     for(var i=0;i < ca.length;i++) {
//         var c = ca[i];
//         while (c.charAt(0)==' ') c = c.substring(1,c.length);
//         if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
//     }
//     return null;
// }

// function eraseCookie(name) {
//     createCookie(name,"",-1);
// }


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