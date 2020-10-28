<?php

    /*Pripojeni k databazi
     *
     * Funkcnost:
     * -pripoji se k databazi
     *    -pristup se da menit
     * -pokud v databazi zatim neexistuje nektera z pozadovanych tabulek, vytvori ji
     */

    //voli prefix nazvu tabulek, kterym se da nastavit
	$prefix="test";
	$dbI = new mysqli("wm73.wedos.net", "a81539_seminar", "C8Nvs2dv", "d81539_seminar", ini_get('mysqli.default_port'));
	$dbI->set_charset('utf8');
	if($dbI->query("SHOW TABLES LIKE ".$prefix."Users")->num_rows!=1){

		//prvni tabulka obsahujici informace o uzivatelich - studentech
		$dbI->query("CREATE TABLE IF NOT EXISTS `".$prefix."Users`
					(
					userID int PRIMARY KEY AUTO_INCREMENT,
					older BOOL DEFAULT 0,
					realname varchar(255),
					mail varchar(255),
					passcode varchar(255),
					admin BOOL DEFAULT 0,
					logged BOOL DEFAULT 0,
					registrationTime timestamp DEFAULT CURRENT_TIMESTAMP
					);");

		//druha tabulka obsahujici seminare a informace o nich
		$dbI->query("CREATE TABLE IF NOT EXISTS `".$prefix."Seminars`
					(
					seminarID int PRIMARY KEY AUTO_INCREMENT,
					title varchar(255),
					teacher varchar(255),
					description text,
					deactivated BOOL DEFAULT 0,
					access TINYINT(3) DEFAULT 0,
					time timestamp DEFAULT CURRENT_TIMESTAMP
					);");

		//treti tabulka, pridava "spojovaci tabulku" umoznujici relaci mnoho k mnoha
		$dbI->query("CREATE TABLE IF NOT EXISTS `".$prefix."UserSeminar`
					(
					userID int,
					seminarID int
					FOREIGN KEY (userID) REFERENCES Users (ID)
					FOREIGN KEY (seminarID) REFERENCES Seminars (ID)
					);");
	}
?>