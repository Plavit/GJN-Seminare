<?php 
session_start();
require_once 'scripts/tools.php';
if(isAdmin($_SESSION["userID"])){
	require_once 'scripts/db-connect.php';
	$nd = ($_GET["d"]==0?1:0);
	$ptmt = $dbI->prepare("UPDATE `".$prefix."Seminars` SET deactivated=? WHERE seminarID = ?");
	$ptmt->bind_param("ii",$nd,$_GET["id"]);
	$ptmt->execute();
	$ptmt->close();
	if($_POST["d"]==0){
		$ptmt = $dbI->prepare("DELETE FROM `".$prefix."UserSeminar` WHERE seminarID = ?");
		$ptmt->bind_param("i",$_GET["id"]);
		$ptmt->execute();
		$ptmt->close();
	}
	echo "Aktivita semináře byla změněna.<br><a href=\"/\">Návrat na hlavní stránku</a>";
}else{
	echo "Nejste admin.";
}
?>