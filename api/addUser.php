<?php
/*
METHOD: POST
USAGE: string login, string pass, string email, string mobile, checkbox alertmail, chexkbox alertsms, checkbox admin, (int id, bool update)
RETURN: 1 (user added), 2 (user updated), false (error)
*/

session_start();
if(empty($_SESSION["login"]) || empty($_SESSION["admin"]) || empty($_POST["login"]) || empty($_POST["pass"]) || empty($_POST["email"]) || empty($_POST["mobile"])){
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

$alertemail = 0;
$alertsms = 0;
$admin = 0;
if(!empty($_POST["alertemail"])) $alertemail = 1;
if(!empty($_POST["alertsms"])) $alertsms = 1;
if(!empty($_POST["admin"])) $admin = 1;

if(!empty($_POST["id"]) || !empty($_POST["update"])){
	$request = $bdd->prepare("UPDATE users SET login=:login, hash=:hash, email=:email, mobile=:mobile, alertemail=:alertemail, alertsms=:alertsms, admin=:admin WHERE id=:id;");			
	$hash = md5($_POST["pass"]);
	$request->execute(array(
		"login" => $_POST["login"],
		"hash" => $hash,
		"email" => $_POST["email"],
		"mobile" => $_POST["mobile"],
		"alertemail" => $alertemail,
		"alertsms" => $alertsms,
		"admin" => $admin,
		"id" => $_POST["id"]
	));
	echo("2");
}
else{

	$request = $bdd->prepare("INSERT INTO users (id, login, hash, email, mobile, alertemail, alertsms, admin) VALUES ('', :login, :hash, :email, :mobile, :alertemail, :alertsms, :admin);");
	$hash = md5($_POST["pass"]);
	$request->execute(array(
		"login" => $_POST["login"],
		"hash" => $hash,
		"email" => $_POST["email"],
		"mobile" => $_POST["mobile"],
		"alertemail" => $alertemail,
		"alertsms" => $alertsms,
		"admin" => $admin
	));
	echo("1");
}

?>