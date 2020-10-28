<?php
require_once 'scripts/db-connect.php';
session_start();
echo '<link rel="stylesheet" href="style.css" type="text/css" />  
<div class="line"></div>';
include "horni.php";?>
<div class="obsah-container">
<div class="obsah">
<?php
$mail = $_POST["mail"];
$code = $_POST["code"];
$stmt = $dbI->prepare("SELECT userID FROM `".$prefix."Users` WHERE mail =  ?   AND passcode =  ?");
$stmt->bind_param("ss",$mail,$code);
$stmt->bind_result($userID);
$stmt->execute();
$stmt->fetch();
$stmt->store_result();
if($userID!=null){
	echo "<div style='text-align: center'> <h2>Přihlášení</h2>Přihlášení proběhlo úspěšně, nyní budete přesměrováni<br> <a href=\"/\">Pokud ne, klikněte sem</a> </div>";
	$_SESSION["userID"]=$userID;
}else{
	echo "Emailová adresa či kód nesouhlasí.";
	echo $userID;
}
?>
</div>
</div>
<?php
echo "<meta http-equiv='refresh' content='2;url=\"/\"'>";
include ("paticka.php");
?>