<?php
/*
METHOD: GET
RETURN: 1 (deleted), false (error)
*/

session_start();

if(empty($_SESSION["login"]) || empty($_SESSION["admin"])){
	header("Location: ../index.php");
	exit();
}

if(empty($_GET["name"])){
	header("Location: ../profiles.php");
	exit();
}
include("config.php");

try{
	$bdd = new PDO("mysql:host=" . $configHostBdd . ";dbname=" . $configNameBdd .";charset=utf8", $configUserBdd, $configPassBdd);
}
catch (Exception $e){
        die($e->getMessage());
}

//print_r($_GET);




$request = $bdd->prepare("DELETE FROM profiles WHERE Name=:name;");			
$request->execute(array(
	"name" => $_GET["name"]
));
$request->closeCursor();
header("Location: ../profiles.php");
?>