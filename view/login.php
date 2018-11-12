<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/php/script.php");
	include($_SERVER['DOCUMENT_ROOT']."/php/db.php");


	if(isset($_COOKIE["id"])){
		console_log("Cookie detected");
		console_log("Cookie id :" + $_COOKIE["id"]);
		console_log("Cookie username :" + $_COOKIE["username"]);
		header('Location: '. "search.php");
	}
	else {
		console_log("Cookie not detected");
	}


	if(isset($_POST["LoginButton"])) {
		if(isset($_POST["username"]) && isset($_POST["password"])){
			$username = $_POST["username"];
			$password = $_POST["password"];
			$dbHandler = new Database("localhost", "root", "", $dbName);

		    $id = $dbHandler->getUserIDByUsername($username);

		    setcookie("id", $id[0]->UserID, time() + 3600);
		    setcookie("username", $username, time() + 3600);
		    header('Location: '. "search.php");
		}
		else {
			console_log("not isset");	
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require($_SERVER['DOCUMENT_ROOT']."/includes/head.php"); ?>
	<title>Login</title>
	<style type="text/css">
		body {background-color: #00AEEF}
	</style>

	<script src="../js/validation.js"></script>
</head>

<body>
	<div class="rectLogin fadeIn">
	<form method="post">
			<table class="center" style="width:100%">
				<tr>
					<h2 style="text-align:center;line-height:2px">
						LOGIN
					</h2>
				</tr>

				<tr>
					<td class="tdName">Username</td>
					<td class="tdTextField"> <input type="text" name="username" id="username"></td>
				</tr>

				<tr>
					<td class="tdName">Password</td>
					<td class="tdTextField"> <input type="password" name="password" id="password"> </td>
				</tr>

			</table>
		<a href="register.php" class="textSmall paddingSmall">Don't have an account?</a>
		<p></p>
		<input type="submit" value="LOGIN" class="buttonStyleOrange" name="LoginButton" id="LoginButton" onclick="return checkLoginForm()" style="margin:0 auto;display:block;">
	</form>
	</div>

</body>
</html>