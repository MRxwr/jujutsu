<?php
$servername = "localhost";
$username = "u671249433_createidv2User";
$password = "N@b$90949089";
$dbname = "u671249433_createidv2Db";
$dbconnect = new MySQLi($servername,$username,$password,$dbname);
if ( $dbconnect->connect_error ){
die("Connection Failed: " .$dbconnect->connect_error );
}
$sql = "SET CHARACTER SET utf8mb4";
$dbconnect->query($sql);
?>
 