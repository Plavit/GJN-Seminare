<?php 
session_start();
require_once 'scripts/tools.php';
if(isAdmin($_SESSION["userID"])){
	require_once 'scripts/db-connect.php';
	$ptmt = $dbI->prepare("INSERT INTO ".$prefix."Users (older,realname,mail,admin) VALUES(?,?,?,?)");
	$finAdmin = (empty($_POST["admin"])?0:1);
	$ptmt->bind_param("issi",$_POST["old"],$_POST["name"],$_POST["mail"],$finAdmin);
	$ptmt->execute();
	$ptmt->close();
	echo "Uživatel ".$_POST["name"]." byl přidán. <a href=\"/\">Návrat na hlavní stránku</a>";
}else{
	echo "Nejste admin.";
}
?>