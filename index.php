<?php
session_start();
if(empty($_SESSION["login"])){
	header("Location: login.html");
	exit();
}
header("Location: dashboard.html");
?>