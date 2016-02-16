<?php
/*
METHOD: POST
USAGE: string name; time sunrise; time sunset; time interval; time working_time; double tank_capacity; double pump_flow; time watering_hour; double water_amount; double temperature; double humidity; monday; tuesday; 
RETURN: 1 (added), 2 (updated), false
*/


if(empty($_SESSION["login"]) ||empty($_POST["name"]) || empty($_POST["sunrise"]) || empty($_POST["sunset"]) || empty($_POST["interval"]) || empty($_POST["working_time"]) || empty($_POST["tank_capacity"]) || 
	empty($_POST["pump_flow"]) || empty($_POST["watering_hour"]) || empty($_POST["water_amount"]) || empty($_POST["temperature"]) || empty($_POST["humidity"]) || empty($_POST["monday"]) || 
	empty($_POST["tuesday"]) || empty($_POST["wednesday"]) || empty($_POST["thursday"]) || empty($_POST["friday"]) || empty($_POST["saturday"]) || empty($_POST["sunday"])){
	echo("false");
	exit();
}
include("config.php");

try{
	$bdd = new PDO("mysql:host=" . $configHostBdd . ";dbname=" . $configNameBdd .";charset=utf8", $configUserBdd, $configPassBdd);
}
catch (Exception $e){
        die($e->getMessage());
}

$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$results=$bdd->query("SELECT Name FROM Profiles;");
$results->setFetchMode(PDO::FETCH_OBJ);

while($entry=$results->fetch() ){
	
		if($entry->Name==$_POST["name"]){
			$updated=true;
			$request = $bdd->prepare("UPDATE Profiles SET Sunrise=:sunrise, Sunset=:sunset, Interval=:interval, Working_Time=:working_time, Tank_Capacity=:tank_capacity, Pump_Flow=:pump_flow, Watering_Hour=:watering_hour, Water_Amount=:water_amount, Temperature=:temperature, Humidity=:humidity, Monday=:monday, Tuesday=:tuesday, Wednesday=:wednesday, Thursday=:thursday, Friday=:friday, Saturday=:saturday, Sunday=:sunday WHERE Name=:name;");			
			$request->execute($_POST);
			break;
		}
		
}
$results->closeCursor();

if(!$updated){
	$request = $bdd->prepare("INSERT INTO Profiles (Name, Sunrise, Sunset, Interval, Working_Time, Tank_Capacity, Pump_Flow, Watering_Hour, Water_Amount, Temperature, Humidity, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday) VALUES (:profile, :sunrise, :sunset, :interval, :working_time, :tank_capacity, :pump_flow, :watering_hour, :water, :temperature, :humidity, :monday, :tuesday, :wednesday, :thursday, :friday, :saturday, :sunday);");}
	$request->execute($_POST);
	echo("1");
}
else{
	echo("2");
}
?>