<?php

	if(isset($_GET["logout"])) {
		setcookie("id", null, time()-3600);
		header("Location: "."login.php");
	}
	else if(isset($_GET["browse"])) {
		header("Location: "."search.php");
	}
	else if(isset($_GET["profile"])) {
		header("Location: "."profile.php");
	}
	else if(isset($_GET["history"])) {
		header("Location: "."history.php");	
	}
?>

<?php require($_SERVER['DOCUMENT_ROOT']."/includes/head.php"); ?>
<table style="width:100%; border-collapse: collapse;">
	<tr>
		<td style="background-color: #00AEEF">
			<a href="?browse" class="title">
				<span style="color:#F2D800">
				Pro 
				</span>
				- Book
			</a>
		</td>
		<td style="background-color: #00AEEF">
			<span id="welcome" style="font-size: 30px;color: white; float:right; padding-right:5px; text-decoration: underline;">
				Hi, <?php echo $_COOKIE['username'];?>!
			</span>
		</td>
		<td style="background-color: #F26600; width:35px">
			<a href="?logout">
				<img src="../asset/power_button.png" alt="Log out" name="power_button" id="power_button" class="logOutButton">
			</a>	
		</td>
	</tr>
</table>

<div class="header-btn-group" style="width:100%">
	<a href="?browse"> <button class="button" id="browse_pageheader" style="width:33.3%">Browse</button> </a>
	<a href="?history"> <button class="button" id="history_pageheader" style="width:33.3%">History</button> </a>
	<a href="?profile"> <button class="button" id="profile_pageheader" style="width:33.4%">Profile</button> </a>
</div>

