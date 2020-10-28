<?php
session_start();

    /* Funkce vybirani seminaru
     *
     * Funkcnost:
     * -nacte z databaze seminare
     * -zobrazi prihlasenemu uzivateli relevantni seminare
     *   -pokud uzivatel prekroci povoleny limit seminaru, pri odeslani na to bude upozornen a musi vyber opravit
     * -po uspesnem validnim vyberu odesle data
     */

//zkontroluje prihlaseneho uzivatele
if(!empty($_SESSION["userID"])){
	require_once 'scripts/db-connect.php';
	$dstmt = $dbI->prepare("SELECT older FROM `".$prefix."Users` WHERE userID = ?");
	$dstmt->bind_param("s",$_SESSION["userID"]);
	$dstmt->bind_result($older);
	$dstmt->execute();
	$dstmt->fetch();
	$dstmt->close();
	if($older==1&&sizeof($_POST)<=7||$older==0&&sizeof($_POST)<=5){//TODO reimplement
		$ostmt = $dbI->prepare("DELETE FROM `".$prefix."UserSeminar` WHERE userID =?");
		$ostmt->bind_param("i",$_SESSION["userID"]);
		$ostmt->execute();
		$ostmt->close();
		foreach($_POST as $key => $value){
			if($value=="on"){
				$stmt = $dbI->prepare("SELECT * FROM `".$prefix."UserSeminar` WHERE seminarID = ? AND userID =?");
				$stmt->bind_param("ii", $key, $_SESSION["userID"]);
				$stmt->execute();
				$stmt->store_result();
				if($stmt->num_rows==0){
					$stmt2 = $dbI->prepare("INSERT INTO `".$prefix."UserSeminar` VALUES(?,?)");
					$stmt2->bind_param("ii", $_SESSION["userID"],$key);
					$stmt2->execute();
					$stmt2->close();
				}
				$stmt->close();
			}
		}
		echo "Semináře vybrány úspěšně. <a href=\"/\">Návrat na hlavní stránku</a>";
	}else{
		echo "Limit překročen. Limit činí pro studenty třetího ročníku 5 a čtvrtého ročnku 7 seminářů. <a href=\"/\">Návrat na hlavní stránku</a>";
	}
}else{
	echo "Nejste přihlášen.";
}
?>