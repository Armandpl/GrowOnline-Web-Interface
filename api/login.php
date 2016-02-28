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
	header("Location: ../login.html?false");
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
    header("Location: ../login.html?logins");
	exit();
}
else{
	session_start();
	$_SESSION["login"] = $result["login"];
	if($result["admin"] == 1) $_SESSION["admin"] = true;
	header("Location: ../dashboard.html");
	exit();
}
header("Location: ../login.html?false");
exit();

?>