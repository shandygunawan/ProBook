<?php
	include_once("script.php");

	if(isset($_POST['id']) and isset($_POST['username'])){
		assignToken($_POST['id']);
		assignCookies($_POST['id'], $_POST['username']);

		header('Location: '. "../view/search.php");
	}
	
?>