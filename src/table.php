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
include_once "horni.php";
?>
<div class="obsah-container">
<div class="obsah">
<?php

if(isAdmin($_SESSION["userID"])){
	//funkce, co spocita pocet spolecnych ucastniku:
	function commonUserCount($id1,$id2){
		global $dbI;
		global $prefix;
		if($id1==$id2)
			return "X";
		$r = 0;
		$stmt = $dbI->prepare("SELECT userID FROM `".$prefix."UserSeminar` WHERE seminarID = ".$id1);
		$stmt->bind_result($userID);
		$stmt->execute();
		$stmt->store_result();
		while($stmt->fetch()){
			$stmt2 = $dbI->prepare("SELECT COUNT(userID) FROM `".$prefix."UserSeminar` WHERE userID = ".$userID." AND seminarID =".$id2);
			$stmt2->bind_result($count);
			$stmt2->execute();
			$stmt2->fetch();
			$stmt2->close();
			$r+=$count;
		}
		return $r;
	}
	echo "<div id=\"overflowmgmt\"><table class=\"results\">";
	$stmt = $dbI->prepare("SELECT seminarID,title FROM `".$prefix."Seminars` ORDER BY title");
	$stmt->bind_result($seminarID,$title);
	$stmt->execute();
	$stmt->store_result();
	echo "<tr><td id='empty'></td>";
	while($stmt->fetch()){
		echo "<th>".$title."</th>";
	}
	echo "</tr>";
	$stmt->close();
	$stmt = $dbI->prepare("SELECT seminarID,title FROM `".$prefix."Seminars` ORDER BY title");
	$stmt->bind_result($seminarID,$title);
	$stmt->execute();
	$stmt->store_result();
	while($stmt->fetch()){
		echo "<tr>";
		echo "<td id=\"lefth\">".$title."</td>";
		$stmt2 = $dbI->prepare("SELECT seminarID,title FROM `".$prefix."Seminars` ORDER BY title");
		$stmt2->bind_result($seminarID2,$title2);
		$stmt2->execute();
		$stmt2->store_result();
		while($stmt2->fetch()){
			$style = "";
			$cc = commonUserCount($seminarID,$seminarID2);
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
	echo "</table></div>";
	echo "<a href=\"/\">Návrat na hlavní stránku</a>";
}else{
	echo "K této stránce nemáte přístup";
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