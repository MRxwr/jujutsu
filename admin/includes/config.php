<?php
$servername = "localhost";
$username = "u671249433_jujutsuUSER";
$password = "N@b$90949089";
$dbname = "u671249433_jujutsuDB";
$dbconnect = new MySQLi($servername,$username,$password,$dbname);
if ( $dbconnect->connect_error ){
die("Connection Failed: " .$dbconnect->connect_error );
}
$sql = "SET CHARACTER SET utf8mb4";
$dbconnect->query($sql);
?>
 