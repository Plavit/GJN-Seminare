<?php
session_start();
require_once 'scripts/tools.php';
?>
<html>
<body>
<div id=container>
<?php
echo '<link rel="stylesheet" href="style.css" type="text/css" />  
<div class="line"></div>';
include "horni.php";
?>
<div class="obsah-container">
<div class="obsah">
<?php
if(isAdmin($_SESSION["userID"])){
	if(!empty($_POST["limit"])){
		function deactivate($sID){
			global $dbI;
			global $prefix;
			$ptmt = $dbI->prepare("UPDATE `".$prefix."Seminars` SET deactivated=1 WHERE seminarID = ?");
			$ptmt->bind_param("i",$sID);
			$ptmt->execute();
			$ptmt->close();
			$ptmt = $dbI->prepare("DELETE FROM `".$prefix."UserSeminar` WHERE seminarID = ?");
			$ptmt->bind_param("i",$sID);
			$ptmt->execute();
			$ptmt->close();
		}
		$stmt = $dbI->prepare("SELECT seminarID FROM `".$prefix."UserSeminar`");
		$stmt->bind_result($seminarID);
		$stmt->execute();
		$stmt->store_result();
		while($stmt->fetch()){
			$stmt2 = $dbI->prepare("SELECT COUNT(seminarID) FROM `".$prefix."UserSeminar` WHERE seminarID = ".$seminarID);
			$stmt2->bind_result($count);
			$stmt2->execute();
			$stmt2->fetch();
			$stmt2->close();
			if($count<$_POST["limit"] or $count=0){
				deactivate($seminarID);
			}
		}
		echo "Semináře pod limit (".$_POST["limit"].") byly deaktivovány.<br><a href=\"/\">Návrat na hlavní stránku</a>";
	}else{
		echo "Nebyl zadán limit.";
	}
}else{
	echo "Nejste admin.";
}
?>
</div>
</div>
<?php
include ("paticka.php");
?>
</div>
</body>
</html>