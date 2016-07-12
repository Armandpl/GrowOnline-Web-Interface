<?php
/*
METHOD: POST
USAGE: string login, string pass, string email, string mobile, checkbox alertemail, chexkbox alertsms, checkbox admin, string apikey, string avatar,(int id, bool update)
RETURN: 1 (user added), 2 (user updated), false (error)
*/

session_start();

if(empty($_POST["login"]) || empty($_POST["pass"])){
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

if(empty($_SESSION["login"]) || empty($_SESSION["admin"])){
	$result = $bdd->query('SELECT * FROM users;');

	$data = $result->fetchAll();
 
	if(count($data) > 0)
	{
		echo("403");
		exit();
	}	
}

$alertemail = 0;
$alertsms = 0;
$admin = 0;
$apikey = "";
$avatar = "";
$email = "";
$mobile = "";
if(!empty($_POST["alertemail"]) && $_POST["alertemail"] == "true") $alertemail = 1;
if(!empty($_POST["alertsms"]) && $_POST["alertsms"] == "true") $alertsms = 1;
if(!empty($_POST["admin"]) && $_POST["admin"] == "true") $admin = 1;
if(!empty($_POST["apikey"])) $apikey = $_POST["apikey"];
if(!empty($_POST["avatar"])) $avatar = $_POST["avatar"];
if(!empty($_POST["email"])) $email = $_POST["email"];
if(!empty($_POST["mobile"])) $mobile = $_POST["mobile"];

if(!empty($_POST["id"]) || !empty($_POST["update"])){
	$request = $bdd->prepare("UPDATE users SET login=:login, hash=:hash, email=:email, mobile=:mobile, alertemail=:alertemail, alertsms=:alertsms, admin=:admin, apikey=:apikey, avatar=:avatar WHERE id=:id;");			
	$hash = md5($_POST["pass"]);
	$request->execute(array(
		"login" => $_POST["login"],
		"hash" => $hash,
		"email" => $email,
		"mobile" => $mobile,
		"alertemail" => $alertemail,
		"alertsms" => $alertsms,
		"admin" => $admin,
		"apikey" => $apikey,
		"avatar" => $avatar,
		"id" => $_POST["id"]
	));
	echo("2");
}
else{

	$request = $bdd->prepare("INSERT INTO users (id, login, hash, email, mobile, alertemail, alertsms, admin, apikey, avatar) VALUES ('', :login, :hash, :email, :mobile, :alertemail, :alertsms, :admin, :apikey, :avatar);");
	$hash = md5($_POST["pass"]);
	$request->execute(array(
		"login" => $_POST["login"],
		"hash" => $hash,
		"email" => $email,
		"mobile" => $mobile,
		"alertemail" => $alertemail,
		"alertsms" => $alertsms,
		"admin" => $admin,
		"apikey" => $apikey,
		"avatar" => $avatar
	));
	echo("1");
}

?>