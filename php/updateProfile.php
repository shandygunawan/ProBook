<?php
	include("script.php");

    if(isset($_POST['user_id']) && isset($_POST['name']) && isset($_POST['address']) && isset($_POST['phone_number']) && isset($_POST['card_number']) && isset($_POST['filename'])){

        console_log($_POST['user_id']);
        console_log($_POST['name']);
        console_log($_POST['address']);
        console_log($_POST['phone_number']);
        console_log($_POST['card_number']);
        console_log($_POST['filename']);

        $oldUser = $db_handler->getUserByID($_POST['user_id']);
        
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
        $oldUser[0]->CardNumber = $_POST['card_number'];
        $oldUser[0]->PicturePath = "/asset/user_img/".$oldUser[0]->Username.".jpg";

        $db_handler->updateUserData($oldUser[0]);

        echo "success";

        console_log($oldUser);

        header("Location:"."../view/profile.php");
        
	}
	else {
        echo "Profile update failed";
    }	
?>
