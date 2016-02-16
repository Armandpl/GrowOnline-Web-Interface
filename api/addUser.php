<?php
/*
METHOD: POST
USAGE: string login, string pass, string email, string mobile, bool alertmail, bool alertsms, bool admin, (int id, bool update)
RETURN: 1 (user added), 2 (user updated), 0 (error)
*/

session_start();

if(empty($_SESSION["login"]) || empty($_SESSION["admin"]) || empty($_POST["login"]) || empty($_POST["pass"]) || empty($_POST["email"]) || empty($_POST["mobile"]) || empty($_POST["alertmail"]) || 
	empty($_POST["alertsms"]) || empty($_POST["admin"])){
	echo ("false");
	exit();
}

include("config.php");

try{
	$bdd = new PDO("mysql:host=" . $configHostBdd . ";dbname=" . $configNameBdd .";charset=utf8", $configUserBdd, $configPassBdd);
}
catch (Exception $e){
        die($e->getMessage());
}

if(!empty($_POST["id"]) || !empty($_POST["update"])){
	$request = $bdd->prepare("UPDATE users SET login=:login, hash=:hash, email=:email, mobile=:mobile, alertemail=:alertemail, alertsms=:alertsms, admin=:admin WHERE id=:id;");			
	$array = $_POST;
	$array["hash"] = md5($_POST["pass"]);
	$request->execute($array);
	echo("2");
}
else{
	$request = $bdd->prepare("INSERT INTO users (login, hash, email, mobile, alertemail, alertsms, admin) VALUES (:login, :hash, :email, :mobile, :alertsms, :admin);");
	$array = $_POST;
	$array["hash"] = md5($_POST["pass"]);
	$request->execute($array);
	echo("1");
}

?>