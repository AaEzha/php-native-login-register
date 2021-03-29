<?php 
include "database.php"; 

unset($_SESSION['tw_login']);
unset($_SESSION['message']);
session_destroy();

$_SESSION['message'] = "Berhasil sign out";
header("Location:index.php");
return false;
?>