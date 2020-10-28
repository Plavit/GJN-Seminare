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
	function commonSeminarCount($id1,$id2){
		global $dbI;
		global $prefix;
		if($id1==$id2)
			return "X";
		$r = 0;
		$stmt = $dbI->prepare("SELECT seminarID FROM `".$prefix."UserSeminar` WHERE userID = ".$id1);
		$stmt->bind_result($seminarID);
		$stmt->execute();
		$stmt->store_result();
		while($stmt->fetch()){
			$stmt2 = $dbI->prepare("SELECT COUNT(userID) FROM `".$prefix."UserSeminar` WHERE seminarID = ".$seminarID." AND userID =".$id2);
			$stmt2->bind_result($count);
			$stmt2->execute();
			$stmt2->fetch();
			$stmt2->close();
			$r+=$count;
		}
		return $r;
	}
	echo "<table border=\"1\">";
	$stmt = $dbI->prepare("SELECT userID,realName FROM `".$prefix."Users` ORDER BY realName");
	$stmt->bind_result($userID,$realName);
	$stmt->execute();
	$stmt->store_result();
	echo "<tr><td></td>";
	while($stmt->fetch()){
		echo "<td>".$realName."</td>";
	}
	echo "</tr>";
	$stmt->close();
	$stmt = $dbI->prepare("SELECT userID,realName FROM `".$prefix."Users` ORDER BY realName");
	$stmt->bind_result($userID,$realName);
	$stmt->execute();
	$stmt->store_result();
	while($stmt->fetch()){
		echo "<tr>";
		echo "<td>".$realName."</td>";
		$stmt2 = $dbI->prepare("SELECT userID,realName FROM `".$prefix."Users` ORDER BY realName");
		$stmt2->bind_result($userID2,$realName2);
		$stmt2->execute();
		$stmt2->store_result();
		while($stmt2->fetch()){
			$style = "";
			$cc = commonSeminarCount($userID,$userID2);
			if($cc!="X" && $cc>0)
				$style = "style = \"background-color: #FFA8A8;\"";
			if($cc=="X")
				$style = "style = \"background-color: #E0E0E0;\"";
			if($cc=="0")
				$style = "style = \"background-color: #A8FFA8;\"";
			echo "<td ".$style.">".$cc."</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
	echo "<a href=\"/\">Návrat na hlavní stránku</a>";
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