<?php session_start();
require "vendor/autoload.php";
$host = "localhost";
$user = "root";
$pass = "";
$data = "tw_login_register";

$db = mysqli_connect($host, $user, $pass, $data);
?>