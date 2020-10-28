<?php

    /* Soubor obsahujici casto/opakovane volane funkce
     *
     * Funkcnost:
     * -definuje jednotlive funkce, ktere se v programu opakuji
     *
     */

//pripoji se k databazi
require_once 'scripts/db-connect.php';

//funkce urcujici, zda je uzivatel s danym id admin, vraci TRUE/FALSE
function isAdmin($id){
	global $dbI,$prefix;
	$stmt_ = $dbI->prepare("SELECT admin FROM `".$prefix."Users` WHERE userID = ? LIMIT 1");
	$stmt_->bind_param("i",$id);
	$stmt_->bind_result($admin);
	$stmt_->execute();
	$stmt_->fetch();
	$stmt_->close();
	if($admin == 1)
		return TRUE;
	return FALSE;
}

//funkce pocitajici, kolik ma uzivatel s danym id seminaru
function numberOfSeminars($id){
	global $dbI,$prefix;
	$stmt_ = $dbI->prepare("SELECT COUNT(*) userID FROM `".$prefix."UserSeminars` WHERE userID = ?");
	$stmt_->bind_param("i",$id);
	$stmt_->bind_result($number);
	$stmt_->execute();
	$stmt_->fetch();
	$stmt_->close();
	return $number;
}

//funkce pocitajici, kolik ma seminar s danym id registrovanych uzivatelu
function numberOfUsers($id){
	global $dbI,$prefix;
	$stmt_ = $dbI->prepare("SELECT COUNT(*) seminarID FROM `".$prefix."UserSeminars` WHERE seminarID = ?");
	$stmt_->bind_param("i",$id);
	$stmt_->bind_result($number);
	$stmt_->execute();
	$stmt_->fetch();
	$stmt_->close();
	return $number;
}
?>