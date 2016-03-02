<?php
/*
METHOD: POST
USAGE: string name; string description; time sunrise; time sunset; time interval; time working_time; double tank_capacity; double pump_flow; time watering_hour; double water_amount; double temperature; double humidity; monday; tuesday; 
RETURN: 1 (added), 2 (updated), false (error)
*/

session_start();

if(empty($_SESSION["login"]) || empty($_SESSION["admin"])){
	echo("403");
	exit();
}

if(empty($_POST["name"]) || empty($_POST["sunrise"]) || empty($_POST["sunset"]) || empty($_POST["interval"]) || empty($_POST["working_time"]) || 
	empty($_POST["pump_flow"]) || empty($_POST["watering_hour"]) || empty($_POST["water_amount"]) || empty($_POST["temperature"]) || empty($_POST["humidity"])){
	echo("incomplete");
	exit();
}
include("config.php");

try{
	$bdd = new PDO("mysql:host=" . $configHostBdd . ";dbname=" . $configNameBdd .";charset=utf8", $configUserBdd, $configPassBdd);
}
catch (Exception $e){
        die($e->getMessage());
}

//print_r($_POST);

for($i=1; $i < 8; $i++) { 
	$days[$i] = 0;
}
if(!empty($_POST["monday"])) $days[1] = 1;
if(!empty($_POST["tuesday"])) $days[2] = 1;
if(!empty($_POST["wednesday"])) $days[3] = 1;
if(!empty($_POST["thursday"])) $days[4] = 1;
if(!empty($_POST["friday"])) $days[5] = 1;
if(!empty($_POST["saturday"])) $days[6] = 1;
if(!empty($_POST["sunday"])) $days[7] = 1;

$updated = false;




if(!empty($_POST["update"]) && !empty($_POST["id"])){
	$updated=true;
	$request = $bdd->prepare("UPDATE Profiles SET Description=:description, Sunrise=:sunrise, Sunset=:sunset, `Interval`=:interval, Working_Time=:working_time, Tank_Capacity=:tank_capacity, Pump_Flow=:pump_flow, Watering_Hour=:watering_hour, Water_Amount=:water_amount, Temperature=:temperature, Humidity=:humidity, Monday=:monday, Tuesday=:tuesday, Wednesday=:wednesday, Thursday=:thursday, Friday=:friday, Saturday=:saturday, Sunday=:sunday WHERE id=:id;");			
	$request->execute(array(
		"description" => $_POST["description"],
		"sunrise" => $_POST["sunrise"],
		"sunset" => $_POST["sunset"],
		"interval" => $_POST["interval"],
		"working_time" => $_POST["working_time"],
		"tank_capacity" => $_POST["tank_capacity"],
		"pump_flow" => $_POST["pump_flow"],
		"watering_hour" => $_POST["watering_hour"],
		"water_amount" => $_POST["water_amount"],
		"temperature" => $_POST["temperature"],
		"humidity" => $_POST["humidity"],
		"monday" => $days[1],
		"tuesday" => $days[2],
		"wednesday" => $days[3],
		"thursday" => $days[4],
		"friday" => $days[5],
		"saturday" => $days[6],
		"sunday" => $days[7],
		"id" => $_POST["id"]
	));
	echo("2");
	$request->closeCursor();
}

if(!$updated){
	$request = $bdd->prepare("INSERT INTO Profiles (Name, Description,Sunrise, Sunset, `Interval`, Working_Time, Tank_Capacity, Pump_Flow, Watering_Hour, Water_Amount, Temperature, Humidity, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday) VALUES (:name, :description, :sunrise, :sunset, :interval, :working_time, :tank_capacity, :pump_flow, :watering_hour, :water_amount, :temperature, :humidity, :monday, :tuesday, :wednesday, :thursday, :friday, :saturday, :sunday);");
	$request->execute(array(
		"name" => $_POST["name"],
		"description" => $_POST["description"],
		"sunrise" => $_POST["sunrise"],
		"sunset" => $_POST["sunset"],
		"interval" => $_POST["interval"],
		"working_time" => $_POST["working_time"],
		"tank_capacity" => $_POST["tank_capacity"],
		"pump_flow" => $_POST["pump_flow"],
		"watering_hour" => $_POST["watering_hour"],
		"water_amount" => $_POST["water_amount"],
		"temperature" => $_POST["temperature"],
		"humidity" => $_POST["humidity"],
		"monday" => $days[1],
		"tuesday" => $days[2],
		"wednesday" => $days[3],
		"thursday" => $days[4],
		"friday" => $days[5],
		"saturday" => $days[6],
		"sunday" => $days[7]
	));
	echo("1");
}
?>