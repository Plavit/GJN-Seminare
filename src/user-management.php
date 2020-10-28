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
	include "user-mng-form.html";
	echo "Vítej ".$realName." na aplikaci pro registraci seminářů.<brs>";
	$stmt = $dbI->prepare("SELECT userID,older,realname,mail,admin FROM `".$prefix."Users`");
	$stmt->bind_result($userID,$older,$realname,$mail,$admin);
	$stmt->execute();
	$stmt->store_result();
	echo "<table border=\"1\"><tr style = \"background-color: #E0E0E0;\"><td>Jméno</td><td>Email</td><td>Ročník</td><td>Typ</td><td>Počet seminářů</td><td>-</td></tr>";
	while($stmt->fetch()){
		$stmt2 = $dbI->prepare("SELECT COUNT(userID) FROM `".$prefix."UserSeminar` WHERE userID = ".$userID);
		$stmt2->bind_result($count);
		$stmt2->execute();
		$stmt2->fetch();
		$stmt2->close();
		echo "<tr><td><a href=\"show-user.php?id=".$userID."&name=".$realname."\">".$realname."</a></td><td>".$mail."</td><td>".($admin!=1?($older==1?"Pátý ročník":"Čtvrtý ročník"):"-")."</td><td>".($admin==1?"Admin":"Uživatel")."</td><td>".$count."</td><td>"."<a href=\"delete-user.php?id=".$userID."\">Smazat</a>"."</td></tr>";
	}
	echo "</table><br>";
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