<?php
/*
METHOD: POST
RETURN: true (connected), false (error), logins (logins)
*/

include("config.php");

try{
	$bdd = new PDO("mysql:host=" . $configHostBdd . ";dbname=" . $configNameBdd .";charset=utf8", $configUserBdd, $configPassBdd);
}
catch (Exception $e){
        die($e->getMessage());
}

if(empty($_POST["login"]) || empty($_POST["pass"])){
	header("Location: ../login.php?false");
	exit();
}

$hash = md5($_POST['pass']);

$request = $bdd->prepare('SELECT * FROM users WHERE login = :login AND hash = :hash');
$request ->execute(array(
    'login' => $_POST["login"],
    'hash' => $hash
    ));

$result = $request->fetch();

if (!$result){
    header("Location: ../login.php?logins");
	exit();
}
else{
	session_start();
	$_SESSION["login"] = $result["login"];
	$_SESSION["id"] = $result["id"];
	if(empty($result["avatar"])) $_SESSION["avatar"] = "dist/img/user2-160x160.jpg";
	else $_SESSION["avatar"] = $result["avatar"];
	$_SESSION["status"] = "User";
	if($result["admin"] == 1){
		$_SESSION["admin"] = true;
		$_SESSION["status"] = "Admin";
	}
	header("Location: ../dashboard.php");
	exit();
}
header("Location: ../login.php?false");
exit();

?>