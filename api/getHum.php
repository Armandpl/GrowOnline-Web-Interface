<?php
/*
METHOD: GET
RETURN: profileName;temperature;humidity;lamp;fan;pump;heater;uptime
*/
ini_set("display_errors",0);
error_reporting(0);
include("config.php");
session_start();
if(empty($_SESSION["login"])){
	echo("403");
	exit;
}
try{
	$bdd = new PDO("mysql:host=" . $configHostBdd . ";dbname=" . $configNameBdd .";charset=utf8", $configUserBdd, $configPassBdd);
}
catch (Exception $e){
        die($e->getMessage());
}


$result = $bdd->query('SELECT * FROM `env` ORDER BY `Date_` DESC LIMIT '.$_GET["id"].','.$_GET["id"]);

while($data=$result->fetch()){
		echo($data["Hum"].',');
}

$result->closeCursor();

?>
