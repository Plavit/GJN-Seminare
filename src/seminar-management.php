<?php 
session_start();
require_once 'scripts/db-connect.php';
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
	include "seminar-mng-form.html";
	echo "Vítej ".$realName." na aplikaci pro registraci seminářů.<brs>";
	$stmt = $dbI->prepare("SELECT * FROM `".$prefix."Seminars`");
	$stmt->bind_result($seminarID,$title,$teacher,$description,$deactivated,$range,$time);
	$stmt->execute();
	$stmt->store_result();
	echo "<table border=\"1\"><tr style = \"background-color: #E0E0E0;\"><td>Název</td><td>Vyučující</td><td>Popis</td><td>Aktivita</td><td>Počet přihlášených</td><td>Otevřené pro</td><td>-</td></tr>";
	while($stmt->fetch()){
		$stmt2 = $dbI->prepare("SELECT COUNT(seminarID) FROM `".$prefix."UserSeminar` WHERE seminarID = ".$seminarID);
		$stmt2->bind_result($count);
		$stmt2->execute();
		$stmt2->fetch();
		$stmt2->close();
		echo "<tr><td><a href=\"show-seminar.php?id=".$seminarID."&name=".$title."\">".$title."</a></td><td>".$teacher."</td><td style=\"max-width: 200px;\">".$description."</td><td><a href=\"toggle-seminar.php?id=".$seminarID."&d=".$deactivated."\">".($deactivated==0?"Aktivní":"Neaktivní")."</td><td>".$count."</td><td>".($range==0?"Oba ročníky":(range==1?"Třetí ročník":"Čtvrtý ročník"))."</td><td>"."<a href=\"delete-seminar.php?id=".$seminarID."\">Smazat</a>"."</td></tr>";
	}
	echo "</table><br>";
	include 'deactivate-limit-form.html';
	echo "<a href=\"/\">Návrat na hlavní stránku</a>";
}else{
	echo "Nejte administrátor!";
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