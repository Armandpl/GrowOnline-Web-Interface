<?php
/*
METHOD: POST
USAGE: (string login, string pass, string email, string mobile, checkbox alertemail, chexkbox alertsms, checkbox admin, string apikey, string avatar), int id
RETURN: 1 (user added), 2 (user updated), false (error)
*/

session_start();
if(empty($_SESSION["login"]) && empty($_SESSION["id"])){
	echo("403");
	exit();
}

if(empty($_SESSION["admin"]) && !empty($_POST["id"]) && $_SESSION["id"] !== $_POST["id"]){
	echo("403");
	exit();
}

if(empty($_POST["login"]) || empty($_POST["email"]) || empty($_POST["mobile"]) || empty($_POST["id"])){
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

$alertemail = 0;
$alertsms = 0;
$admin = 0;
$apikey = "";
$avatar = "";
if(!empty($_POST["alertemail"]) && $_POST["alertemail"] == "true") $alertemail = 1;
if(!empty($_POST["alertsms"]) && $_POST["alertsms"] == "true") $alertsms = 1;
if(!empty($_POST["admin"]) && $_POST["admin"] == "true") $admin = 1;
if(!empty($_POST["apikey"])) $apikey = $_POST["apikey"];
if(!empty($_POST["avatar"])) $avatar = $_POST["avatar"];

$bound = array(
	"login" => $_POST["login"],
	"email" => $_POST["email"],
	"mobile" => $_POST["mobile"],
	"alertemail" => $alertemail,
	"alertsms" => $alertsms,
	"admin" => $admin,
	"apikey" => $apikey,
	"avatar" => $avatar,
	"id" => $_POST["id"]
);

if(empty($_POST["pass"])){
	$req = "UPDATE users SET login=:login, email=:email, mobile=:mobile, alertemail=:alertemail, alertsms=:alertsms, admin=:admin, apikey=:apikey, avatar=:avatar WHERE id=:id;";
}
else{
	$req = "UPDATE users SET login=:login, hash=:hash, email=:email, mobile=:mobile, alertemail=:alertemail, alertsms=:alertsms, admin=:admin, apikey=:apikey, avatar=:avatar WHERE id=:id;";
	$hash = md5($_POST["pass"]);
	$bound["hash"] = $hash;
}

$request = $bdd->prepare($req);			

$request->execute($bound);
echo("2");