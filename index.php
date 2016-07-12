<?php

session_start();
if(empty($_SESSION["login"])){
	include("api/config.php");

	try{
		$bdd = new PDO("mysql:host=" . $configHostBdd . ";dbname=" . $configNameBdd .";charset=utf8", $configUserBdd, $configPassBdd);
	}
	catch (Exception $e){
	        die($e->getMessage());
	}

	$result = $bdd->query('SELECT * FROM users;');

	$data = $result->fetchAll();
 
	if(count($data) == 0)
	{
		header("Location: setup.php");
	}
	else
	{
		header("Location: login.php");
		exit();
	}
}
else{header("Location: dashboard.php");}
?>