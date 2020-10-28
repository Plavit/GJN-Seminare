<html>
<body>
<?php
echo '<link rel="stylesheet" href="style.css" type="text/css" />  
<div class="line"></div>';
include "horni.php";
?>
<div class="obsah-container">
<div class="obsah">
<?php
include "scripts/db-connect.php";
$preStmt = $dbI->prepare("SELECT realname,mail FROM `".$prefix."Users` WHERE mail = ?");
$preStmt->bind_param("s",$_POST["mail"]);
$preStmt->bind_result($realName,$userMail);
$preStmt->execute();
$preStmt->fetch();
if($userMail==$_POST["mail"]){
	echo $userMail.'<br><br>';
	$preStmt->close();
	$passcode=hash("adler32",uniqid(mt_rand(), true));
	$dbI->query("UPDATE `".$prefix."Users` SET `passcode`='".$passcode."' WHERE `mail` = '".$_POST["mail"]."'");
	echo $dbI->error;
	$msg = "Dobrý den, ".$realName.".\r\n\r\nVáš přihlašovací kód je ".$passcode.".";
	if(mail($userMail,"noreply",$msg)){
		echo "Odesláno".'<br><br>';
	}
	echo " ".$msg;
	
}
?>
</div>
</div>
<?php
include ("paticka.php");
?>
</body>
</html>