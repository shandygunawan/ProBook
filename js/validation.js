var isValidUsernameRegistration = false;
var isValidEmailRegistration = false;
var isValidphoneNumberRegistration = false;
var isValidLogin = false;

function checkRegistrationForm(){
	var name = document.getElementById("name").value;
	var username = document.getElementById("username").value;
	var email = document.getElementById("email").value;
	var password = document.getElementById("password").value;
	var conf_password = document.getElementById("conf_password").value;
	var address = document.getElementById("address").value;
	var phone_number = document.getElementById("phone_number").value;

	var errmsg = "";
	if(name == '' || username == '' || email == '' || password == '' || conf_password == '' || address == '' || phone_number == '' ) {
		errmsg = errmsg.concat("Fill all fields.\n");
	}
	
	if(isValidUsernameRegistration === false) {
		errmsg = errmsg.concat("Username is not correct or has been used.\n");
	}
	
	if(isValidEmailRegistration === false) {
		errmsg = errmsg.concat("Email is not correct or has been used.\n");
	}
	
	if(validatePassword(conf_password) === false) {
		errmsg = errmsg.concat("Password is not match.\n");
	}
	
	if(isValidphoneNumberRegistration === false) {
		errmsg = errmsg.concat("Phone number is not correct.\n");
	}
	
	if(errmsg === ""){

	}
	else {
		alert(errmsg);
		return false;
	}
	
}

function checkLoginForm(){
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;

	if(username == '' || password == '') {
		alert('Fill all fields');
		return false;
	}
	else{
		validateLogin(username, password);
		if(isValidLogin === true){
			return true;
		}
		else {
			alert("Username/Password is incorrect.");
			return false;
		}
	}

}

function validateLogin(username, password){
	var xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = function(){

		// console.log("state : " + xmlhttp.readyState);
		// console.log("status: " + xmlhttp.status);

		if(xmlhttp.readyState != 4 && xmlhttp.status == 200){
			console.log("Validating");

		}
		else if(xmlhttp.readyState === 4 && xmlhttp.status == 200){
			console.log(xmlhttp.responseText);

			if(xmlhttp.responseText === "valid"){
				isValidLogin = true;
				console.log("isValidLoginXML : " + isValidLogin);
			}

		}
		else{
			console.log("error");
			// document.getElementById(field).innerHTML = "Error Occured."
		}

	}
	xmlhttp.open("POST", "../php/loginValidation.php", false); //false = synchronous, supaya ga kebablasan jalan ke alert("username/password inccorrect")
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("username=" + username + "&password=" + password);
}

function validatePassword(confPassword){
	if(confPassword === document.getElementById("password").value){
		document.getElementById("password_check_icon").innerHTML = "<img src='../asset/check.png' style='width:10px;height:10px;'></img>";
		return true;
	}
	else {
		document.getElementById("password_check_icon").innerHTML = "<img src='../asset/wrong.png' style='width:10px;height:10px;'></img>";
		return false;
	}
}

function validatePhoneNumber(number){
	if(number.length > 8 && number.length < 13){
		document.getElementById("phone_number_check_icon").innerHTML = "<img src='../asset/check.png' style='width:10px;height:10px;'></img>";
		isValidphoneNumberRegistration = true;	
	}
	else {
		document.getElementById("phone_number_check_icon").innerHTML = "<img src='../asset/wrong.png' style='width:10px;height:10px;'></img>";
		isValidphoneNumberRegistration = false;	
	}
}

function validate(field, query){
	var xmlhttp = new XMLHttpRequest();


	xmlhttp.onreadystatechange = function(){

		// console.log("state : " + xmlhttp.readyState);
		// console.log("status: " + xmlhttp.status);

		if(xmlhttp.readyState != 4 && xmlhttp.status == 200){
			console.log("Validating");
			
			document.getElementById(field + "_check_icon").innerHTML = "<img src='../asset/loading.gif' style='width:10px;height:10px;'></img>";

		}
		else if(xmlhttp.readyState === 4 && xmlhttp.status == 200){
			console.log(xmlhttp.responseText);

			if(xmlhttp.responseText == "valid"){
				document.getElementById(field + "_check_icon").innerHTML = "<img src='../asset/check.png' style='width:10px;height:10px;'></img>";

				if(field === "username"){
					isValidUsernameRegistration = true;
				}
				else if(field === "email"){
					isValidEmailRegistration = true;
				}
			}
			else if(xmlhttp.responseText == "invalid"){
				document.getElementById(field + "_check_icon").innerHTML = "<img src='../asset/wrong.png' style='width:10px;height:10px;'></img>";

				if(field === "username"){
					isValidUsernameRegistration = false;
				}
				else if(field === "email"){
					isValidEmailRegistration = false;
				}
			}

		}
		else{
			console.log("error");
			// document.getElementById(field).innerHTML = "Error Occured."
		}
	}

	xmlhttp.open("POST", "../php/validation.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("field=" + field + "&query=" + query);
}

function checkStarChecked(){
	var radios = document.getElementsByName('rate');
	var checked = false;
	for (var i = 0; i < radios.length; i++) {
	    if (radios[i].type === 'radio' && radios[i].checked) {
	        checked = true;
	    }
	}
	return checked;
}

function checkReviewForm(){
	if(document.getElementById("comment").value == "" || checkStarChecked() == false) {
		alert("Give a comment and rating!");
		return false;
	}
}

function checkSearchForm(){
	if(document.getElementById("search_bar").value === ""){
		alert("Fill the search bar!");
		return false;
	}
}

function checkEditProfileForm(){
	var errmsg = "";
	if(document.getElementById("name").value === "" || document.getElementById("address") === "" || document.getElementById("phone_number") === ""){
		errmsg = errmsg.concat("Fill all fields.\n");
	}

	if(isValidphoneNumberRegistration === false) {
		errmsg = errmsg.concat("Phone number is not correct.\n");
	}

	if(errmsg === ""){

	}
	else {
		alert(errmsg);
		return false;
	}
	
}