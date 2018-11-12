<?php

	//Global Variable
	$dbName = "wbd";
	
	//Functions
	function console_log( $data ){
	  	echo '<script>';
	  	echo 'console.log('. json_encode( $data ) .')';
	  	echo '</script>';
	}

	function create_alert($data){
		echo '<script>';
		echo 'alert('. json_encode($data) .')';
		echo '</script>';
	}

	function check_cookie(){
		if(isset($_COOKIE["id"]) != null){
			console_log("Cookie detected");
			console_log($_COOKIE["id"]);
			console_log($_COOKIE["username"]);
		}
		else {
			header("Location:"."../view/login.php");
		}
	}

	function printRating($score){
		if( floor($score) == $score ){
			echo $score.".0"; 	
		}
		else {
			echo $score;	
		}
	}

?>