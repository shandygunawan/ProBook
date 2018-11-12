<?php
	include($_SERVER['DOCUMENT_ROOT']."/php/script.php");
	include($_SERVER['DOCUMENT_ROOT']."/php/db.php");
	check_cookie();
	$dbHandler = new Database("localhost", "root", "", $dbName);
	
	$user_array = $dbHandler->getUserByID($_COOKIE["id"]);
	$user_info = $user_array[0];
	console_log($user_info);
	
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
	<?php require($_SERVER['DOCUMENT_ROOT']."/includes/page_header.php"); ?>
	<script>
		function showfvalue() {
			var z = document.getElementById("filesupload").value.split("\\").pop();
			document.getElementById("filename").value = z;
			}
	</script>
	<script>
		function clicker(btn) {
			btn.click();
			showfvalue();
		}
	</script>
	<script>
		function Back() {
			window.history.back();
			return false;
		}
	</script>
</head>

<body>
	<script src="../js/validation.js"></script>
	<div id="bodyPage" class="paddingLeftLarge paddingRightLarge fadeIn">
		<form method="post" action="../php/updateProfile.php" enctype="multipart/form-data" onsubmit="return checkEditProfileForm()">
			<h1 class="paddingTopLarge"> Edit Profile </h1>
			<table class="fontToLinotte tblfont" style="width:100%">
			<tr>
				<td style="width:30%"><img src="..<?php echo $user_info->PicturePath; ?>" width="256" height="256" style="border: 3px solid black"></td>
				<td valign="center" style="width:70%">
                   	Upload profile picture
                    <br>
					<input type="text" readonly="true" id="filename" style="width:60%" name="filename">
					<input type="file" id="filesupload" style="display: none;" onchange="showfvalue();" name="picturepath" accept=".jpg">
					<button type="button" onclick="clicker(filesupload);" style="width:9.5%"> Browse...  </button>
                </td>
			</tr>
			<tr>
				<td>Name</td>
				<td style="width:300px"><input type="text" id="name" style="width:70%" value="<?php echo $user_info->Name; ?>" name="name"> </td>
			</tr>
			<tr>
				<td>Address</td>
				<td style="width:300px"> <input type="text" id="address" style="width:70%" value="<?php echo $user_info->Address; ?>" name="address"></td>
			</tr>
			<tr>
				<td>Phone Number</td>
				<td style="width:300px"><input type="text" style="width:70%" value="<?php echo $user_info->PhoneNumber; ?>" name="phone_number" id="phone_number" onblur="validatePhoneNumber(this.value)"></td>
				<td style="width: 10px;height: 10px"> <div id="phone_number_check_icon"></div> </td>			
			</tr>
		</table>	
	
		<input type="hidden" name="user_id" id="user_id" value="<?php echo $_COOKIE['id']; ?>">
		<input type="submit" value="Save" id="submit_button" name="submit_button" class="buttonStyleBlueWide fontToLinotte" style="float:right; font-size:20px; padding-left:20px; padding-right:20px; padding-bottom: 7px; padding-top: 7px" >
		</form>
		<button onclick="Back();" name="button_back2" id="button_back2" class="buttonStyleRedWide fontToLinotte" type="button"> Back</button>
	</div>

    <script>document.getElementById("profile_pageheader").style.backgroundColor = "#F26600"</script>
</body>

</html>
