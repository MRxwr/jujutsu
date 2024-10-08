<?php
require ("config.php");
require ("functions.php");
require ("translate.php");
if ( isset($_COOKIE[$cookieSession."A"]) && !empty($_COOKIE[$cookieSession."A"]) ){
	session_start ();
	$svdva = $_COOKIE[$cookieSession."A"];
	if ( $user = selectDBNew("employees",[$svdva],"`keepMeAlive` LIKE ?","") ){
		$userID = $user[0]["id"];
		$email = $user[0]["email"];
		$username = $user[0]["fullName"];
		$empUsername = $user[0]["fullName"];
		$userType = $user[0]["empType"];
		$_SESSION[$cookieSession."A"] = $email;	
	}else{
		header("Location: logout.php");die();
	}
}else{
	header("Location: logout.php");die();
}
