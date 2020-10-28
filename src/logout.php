<?php
session_start();
session_destroy();
echo '<link rel="stylesheet" href="style.css" type="text/css" />  
<div class="line"></div>';
include "horni.php";?>
<div class="obsah-container">
<div class="obsah">
<?php
echo "<font face=\"Comic Sans MS\" color=\"red\">Jste <b>úspěšně</b> odhlášen! <br> <a href=\"/\">Návrat na hlavní stránku</a>";
?>
</div>
</div>
<?php
echo "<meta http-equiv='refresh' content='2;url=\"/\"'>";
include ("paticka.php");
?>