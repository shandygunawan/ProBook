<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/php/script.php");
	include($_SERVER['DOCUMENT_ROOT']."/php/db.php");

	if(isset($_COOKIE["id"]) != null){
		console_log("Cookie detected");
		console_log($_COOKIE["id"]);
		console_log($_COOKIE["username"]);
	}
	else {
		console_log("Cookie not detected");
	}

	
	if(isset($_POST["RegisterButton"])) {

        $user = new stdClass;
        $user->Name = $_POST["name"];
        $user->Username = $_POST["username"];
        $user->Email = $_POST["email"];
        $user->Password = $_POST["password"];
        $user->Address = $_POST["address"];
        $user->PhoneNumber = $_POST["phone_number"];
        $user->PicturePath = "/asset/user_img/default.jpg";

        $dbHandler = new Database("localhost", "root", "", $dbName);
        $dbHandler->addNewUser($user);

        $id = $dbHandler->getUserIDByUsername($_POST["username"]);

        setcookie("id", $id[0]->UserID, time() + 3600);
        setcookie("username", $_POST["username"], time() + 3600);
        header("Location:". "search.php");
	}
	
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require($_SERVER['DOCUMENT_ROOT']."/includes/head.php"); ?>
	<title>Register</title>
	<style type="text/css">
		body {background-color: #00AEEF}
	</style>
	<script src="../js/validation.js"></script>
</head>

<body>
	<div class="rectRegister fadeIn">
	<form method="post">
		<table class="center" style="width:100%">
			<tr>
				<h2 style="text-align:center; line-height:2px">
					REGISTER
				</h2>
			</tr>

			<tr>
				<td class="tdName">Name</td>
				<td> <input type="text" name="name" id="name"> </td>
			</tr>

			<tr>
				<td class="tdName">Username</td>
				<td> <input type="text" name="username" id="username" onkeyup="validate('username', this.value)"> </td>
				<td style="width:15px;"> <div id="username_check_icon"></div>
			</tr>

			<tr>
				<td class="tdName">Email</td>
				<td> <input type="text" name="email" id="email" onkeyup="validate('email', this.value)"> </td>
				<td> <div id="email_check_icon"></div>
			</tr>

			<tr>
				<td class="tdName">Password</td>
				<td> <input type="password" name="password" id="password"> </td>
			</tr>

			<tr>
				<td class="tdName">Confirm Password</td>
				<td> <input type="password" name="conf_password" id="conf_password" onkeyup="validatePassword(this.value)"> </td>
				<td> <div id="password_check_icon"></div> </td>
			</tr>

			<tr>
				<td class="tdName">Address</td>
				<td> <TEXTAREA name="address" id="address" ROWS="4" COLS="20"></TEXTAREA></td>
			</tr>

			<tr>
				<td class="tdName">Phone Number</td>
				<td> <input type="text" name="phone_number" id="phone_number" onkeyup="validatePhoneNumber(this.value)"> </td>
				<td> <div id="phone_number_check_icon"></div> </td>
			</tr>

		</table>

		<a href="login.php" class="textSmall paddingSmall">Already have an account?</a>
		<p></p>
		<input type="submit" value="REGISTER" name="RegisterButton" id="RegisterButton" class="buttonStyleOrange" onclick="return checkRegistrationForm()" style="margin:0 auto;display:block;">
	</form>
	</div>
</body>

</html>