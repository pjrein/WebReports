<?php
$MyUsername = "root";  // mysql gebruikersnaam
$MyPassword = "welkom";  // mysql wachtwoord
$MyHostname = "localhost";      // dit is meestal "localhost" tenzij mysql op een andere server staat

$dbh = mysql_pconnect($MyHostname , $MyUsername, $MyPassword);
$selected = mysql_select_db("orta1",$dbh);

?>





