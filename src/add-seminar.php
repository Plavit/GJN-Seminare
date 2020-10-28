<?php 
session_start();
require_once 'scripts/tools.php';
if(isAdmin($_SESSION["userID"])){
	require_once 'scripts/db-connect.php';
	$ptmt = $dbI->prepare("INSERT INTO `".$prefix."Seminars` (title,teacher,description,access) VALUES(?,?,?,?)");
	$ptmt->bind_param("sssi",$_POST["title"],$_POST["teacher"],$_POST["description"],$_POST["range"]);
	$ptmt->execute();
	$ptmt->close();
	echo "Seminář ".$_POST["title"]." byl přidán. <a href=\"/\">Návrat na hlavní stránku</a>";
}else{
	echo "Nejste admin.";
}
?>