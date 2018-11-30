<?php

	include($_SERVER['DOCUMENT_ROOT']."/php/script.php");

	if(!checkActiveUser()) {
		clearAllCookies();
		header('Location: '. "login.php");
	}
	
	$user_array = $db_handler->getUserByID($_COOKIE["user_id"]);
	$user_info = $user_array[0];
	console_log($user_info);

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $user_info->Username ?>'s Profile</title>
	<?php require($_SERVER['DOCUMENT_ROOT']."/includes/page_header.php"); ?>
</head>

<body>
	<div id="bodyPageTop" class="rectProfile">
		<div style="text-align:right">
			<a href="edit_profile.php"> <img src="../asset/edit_icon.png" style="width:64px;height:64px"> </img> </a> 
		</div>
		<div id="profilepict" style="text-align:center;margin-top: 10px;" class="fontToLinotte"> 
			<img src="..<?php echo $user_info->PicturePath; ?>" class="roundimg squareImageSuperLarge fadeIn"> </img> 
		</div>
		<div style="text-align:center" class="profilename fadeIn"> <?php echo $user_info->Name; ?> </div>
	</div>

	<div id="bodyPageBottom fadeIn">
		<h1 class="paddingLeftLarge paddingTopMedium"> My Profile </h1>
		<table class="fontToLinotte tblfont" style="padding-left:60px">
			<tr>
				<td style="width:64px"><img src="../asset/people icon.png" class="squareImageSuperSmall"></td>
				<td>Username</td>
				<td style="padding-left:5%"><?php echo $user_info->Username; ?></td>
			</tr>

			<tr>
				<td style="width:64px"><img src="../asset/email icon.svg" class="squareImageSuperSmall"></td>
				<td>E-mail</td>
				<td style="padding-left:5%"><?php echo $user_info->Email; ?></td>
			</tr>

			<tr>
				<td style="width:64px"><img src="../asset/home icon.svg" class="squareImageSuperSmall"></td>
				<td>Address</td>
				<td style="width:700px; padding-left:5%; "><?php echo $user_info->Address; ?></td>
			</tr>

			<tr>
				<td style="width:64px"><img src="../asset/Telp icon.png" class="squareImageSuperSmall"></td>
				<td>Phone Number</td>
				<td style="padding-left:5%"><?php echo $user_info->PhoneNumber; ?></td>
			</tr>

			<tr>
				<td style="width:64px"><img src="../asset/card icon.png" class="squareImageSuperSmall"></td>
				<td>Card Number</td>
				<td style="padding-left:5%"><?php echo $user_info->CardNumber; ?></td>
			</tr>
		</table>	
	</div>
	<script>document.getElementById("profile_pageheader").style.backgroundColor = "#F26600"</script>
</body>

</html>