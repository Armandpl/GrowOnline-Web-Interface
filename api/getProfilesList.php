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
$resultat=$bdd->query("SELECT Name FROM profile WHERE ID='0';");
$resultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le résultat soit récupérable sous forme d'objet
$current=$resultat->fetch()->Name;
$resultat->closeCursor();
echo '<option>Demo mode</option>';
$result = $bdd->query('SELECT Name FROM `profiles`');
while($data = $result->fetch())
{	
	$selected="";
	if($data['Name']==$current){$selected="selected='selected'";}
	echo '<option '.$selected.'>'.$data['Name'].'</option>';				
}
$result->closeCursor();

//$s = explode("up",exec("uptime"));
//$s = explode(",", $s[1]);
//if(!empty($s[0])) $uptime = $s[0];

?>