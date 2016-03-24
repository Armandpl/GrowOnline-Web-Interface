<?php
/*
METHOD: GET
RETURN: profileName;temperature;humidity;lamp;fan;pump;putime
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

$profileName = "None";
$temperature = "N/A";
$humidity = "N/A";
$lamp = "N/A";
$fan = "N/A";
$pump = "N/A";
$uptime = "N/A";

$result = $bdd->query('SELECT * FROM `profile`');

while($data=$result->fetch()){
	$profileName = $data["Name"];
}
$result->closeCursor();


$result = $bdd->query('SELECT * FROM `env` ORDER BY `Date_` DESC LIMIT 1');
$data = $result->fetch();
$humidity = $data["Hum"];
$temperature = $data["Temp"];

$result->closeCursor();


if(exec("gpio read ".$lampPin)=="1"){
	$lamp = "OFF";
}
else if(exec("gpio read ".$lampPin)=="0"){
	$lamp = "ON";
}

if(exec("gpio read ".$fanPin)=="1"){
	$fan = "OFF";
}
else if(exec("gpio read ".$fanPin)=="0"){
	$fan = "ON";
}

if(exec("gpio read ".$pumpPin)=="1"){
	$pump = "OFF";
}
else if(exec("gpio read ".$pumpPin)=="0"){
	$pump = "ON";
}

$s = explode("up",exec("uptime"));
$s = explode(",", $s[1]);
if(!empty($s[0])) $uptime = $s[0];

echo($profileName . ";" . $temperature . ";" . $humidity . ";" . $lamp . ";" . $fan . ";" . $pump . ";" . $uptime);
?>