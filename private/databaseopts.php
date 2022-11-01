<?php
session_start();
$dbhost = "127.0.0.1";
$dbuser = "store";
$dbpassword = "StoreAdmin12345$";
$dbread = "store";
$con = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbread);
?>