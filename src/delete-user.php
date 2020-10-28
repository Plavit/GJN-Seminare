<?php 
session_start();
require_once 'scripts/tools.php';
if(isAdmin($_SESSION["userID"])){
	require_once 'scripts/db-connect.php';
	$ptmt = $dbI->prepare("DELETE FROM `".$prefix."Users` WHERE userID = ?");
	$ptmt->bind_param("i",$_GET["id"]);
	$ptmt->execute();
	$ptmt->close();
	$ptmt = $dbI->prepare("DELETE FROM `".$prefix."UserSeminar` WHERE userID = ?");
	$ptmt->bind_param("i",$_GET["id"]);
	$ptmt->execute();
	$ptmt->close();
	echo "Uživatel ".$_POST["name"]." byl odebrán. <a href=\"/\">Návrat na hlavní stránku</a>";
}else{
	echo "Nejste admin.";
}
?>