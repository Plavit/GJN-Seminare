<?php
session_start();
require_once 'scripts/tools.php';
if(isAdmin($_SESSION["userID"])){
	require_once 'scripts/db-connect.php';
	$ptmt = $dbI->prepare("SELECT userID FROM `".$prefix."UserSeminar` WHERE seminarID = ?");
	$ptmt->bind_param("i",$_GET["id"]);
	$ptmt->bind_result($userID);
	$ptmt->execute();
	$ptmt->store_result();
	echo "Uživatelé semináře ".$_GET["name"].":<br><br>";
	while($ptmt->fetch()){
		$ptmt2 = $dbI->prepare("SELECT realName FROM `".$prefix."Users` WHERE userID = ?");
		$ptmt2->bind_param("i",$userID);
		$ptmt2->bind_result($name);
		$ptmt2->execute();
		$ptmt2->fetch();
		$ptmt2->close();
		echo $name."<br>";
	}
	echo "<br><br><a href=\"/\">Návrat na hlavní stránku</a>";
}else{
	echo "Nejste admin.";
}
?>