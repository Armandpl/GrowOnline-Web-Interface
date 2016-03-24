<?php
ini_set("display_errors",0);
error_reporting(0);
include("config.php");
session_start();
if(empty($_SESSION["login"])){
	echo("403");
	exit;
}
try{$bdd = new PDO("mysql:host=" . $configHostBdd . ";dbname=" . $configNameBdd .";charset=utf8", $configUserBdd, $configPassBdd);}
catch (Exception $e){die($e->getMessage());}
extract($_POST);
if($select=="Demo mode"){$select="";}
$bdd->exec("UPDATE profile SET Name='$select' WHERE ID='0';");    
?>	