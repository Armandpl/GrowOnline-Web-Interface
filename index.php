<?php
session_start();
if(empty($_SESSION["login"])){
	header("Location: login.php");
	exit();
}
header("Location: dashboard.php");
?>