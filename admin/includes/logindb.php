<?php
session_start ();
require("config.php");
require("functions.php");
require("translate.php");
if( $employee = selectDBNew("employees",[$_POST["email"],sha1($_POST["password"])],"`email` LIKE ? AND `password` LIKE ? AND `hidden` != '2' AND `status` = '0'","") ){
	$GenerateNewCC = md5(rand());
	if( updateDB("employees",array("keepMeAlive"=>$GenerateNewCC),"`id` = '{$employee[0]["id"]}'") ){
		$_SESSION[$cookieSession."A"] = $email;
		setcookie($cookieSession."A", $GenerateNewCC, time() + (86400*30 ), "/");
		if( $employee[0]["empType"] == 5 ){
			header("Location: ../index.php?v=ListOfClasses");die();
		}else{
			header("Location: ../index.php?v=Home");die();
		}
	}
}else{
	header("Location: ../login.php?error=p");die();
}
?>