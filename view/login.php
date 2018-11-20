<?php
	
	include($_SERVER['DOCUMENT_ROOT']."/php/script.php");

	/* Check if Cookie is exist and access token is valid (User is active) */
	if(checkActiveUser()){
		header('Location: '. "search.php");
	}
	else {
		console_log("Cookie not detected");
	}


	/* Check if user has login */
	if(isset($_POST["LoginButton"])) {
		if(isset($_POST["username"]) && isset($_POST["password"])){
		  
		    /* SET ACCESS TOKEN */
		    $id = $db_handler->getUserIDByUsername($_POST["username"]);
		    assignToken($id[0]->UserID);

		    /* SET COOKIES */
		    assignCookies($id[0]->UserID, $_POST["username"]);

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
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<meta name="google-signin-client_id" content="1001089679311-4icnt83g9j7r755j5iatjpqvu6s21b9d.apps.googleusercontent.com">
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
	<br>
	<div class="g-signin2" data-onsuccess="onSignIn" align="center"></div>
	</div>

</body>
</html>