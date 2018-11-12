<?php
	include("script.php");
	include("db.php");

    if(isset($_POST['user_id']) && isset($_POST['name']) && isset($_POST['address']) && isset($_POST['phone_number']) && isset($_POST['filename'])){

        $dbHandler = new Database("localhost", "root", "", $dbName);
        $oldUser = $dbHandler->getUserByID($_POST['user_id']);
        
        if(isset($_FILES['picturepath']) && $_FILES['picturepath']['name'] != ""){
            console_log("file_upload");
            $file_name = $_FILES['picturepath']['name'];
            $file_tmp = $_FILES['picturepath']['tmp_name'];
            $old_file = "../asset/user_img/".$oldUser[0]->Username.".jpg";
            
            if(file_exists("../asset/user_img/".$oldUser[0]->Username.".jpg")){
                if(!unlink($old_file)){
                echo "Error deleting old user's image";
                }
                else {
                    move_uploaded_file($file_tmp, "../asset/user_img/".$oldUser[0]->Username.".jpg");    
                }
            }
            else {
                move_uploaded_file($file_tmp, "../asset/user_img/".$oldUser[0]->Username.".jpg");
            }
            
        }
        
        $oldUser[0]->Name = $_POST['name'];
        $oldUser[0]->Address = $_POST['address'];
        $oldUser[0]->PhoneNumber = $_POST['phone_number'];
        $oldUser[0]->PicturePath = "/asset/user_img/".$oldUser[0]->Username.".jpg";
        
        $dbHandler->updateUserData($oldUser[0]);

        echo "success";
        header("Location:"."../view/profile.php");
        
	}
	else {
        echo "Profile update failed";
    }	
?>
