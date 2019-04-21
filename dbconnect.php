<?php
$MyUsername = "root";  // mysql gebruikersnaam
$MyPassword = "welkom";  // mysql wachtwoord
$MyHostname = "localhost";      // dit is meestal "localhost" tenzij mysql op een andere server staat
$MyDbase = "orta1";

$dbh = @mysqli_connect($MyHostname , $MyUsername, $MyPassword, $MyDbase);
//$selected = mysql_select_db("orta1",$dbh);
if (!$dbh) {
                die("connection failed : " . mysqli_connect_error());
            }
            return $dbh;

?>



<!--$dbase = 'chromis2'; // DATABASE NAME
            //$dbase = 'loja';
            $host = 'localhost'; //DATABASE HOST LOCATION/SERVER
            $user = 'root'; //USER NAME
            $pass = 'welkom'; //PASSWORD
            $link = @mysqli_connect($host, $user, $pass, $dbase);

            if (!$link) {
                die("connection failed : " . mysqli_connect_error());
            }
            return $link;
-->
