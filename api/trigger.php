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
extract($_POST);

if($target=="lamp")
{
	if(exec("gpio read ".$lampPin)=="1"){exec("gpio write ".$lampPin." 0");echo "ON";}
	else{exec("gpio write ".$lampPin." 1");echo "OFF";}
}
else if($target=="fan")
{
	if(exec("gpio read ".$fanPin)=="1"){exec("gpio write ".$fanPin." 0");echo "ON";}
	else{exec("gpio write ".$fanPin." 1");echo "OFF";}
}
else if($target=="waterPump")
{
	if(exec("gpio read ".$pumpPin)=="1"){exec("gpio write ".$pumpPin." 0");echo "ON";}
	else{exec("gpio write ".$pumpPin." 1");echo "OFF";}
}
else if($target=="heater")
{
	if(exec("gpio read ".$heaterPin)=="1"){exec("gpio write ".$heaterPin." 0");echo "ON";}
	else{exec("gpio write ".$heaterPin." 1");echo "OFF";}
}
?>