<?php

function my_conn() {
    // echo 'verbinding maken met kassa : ';
    $dbase = 'chromis2'; // DATABASE NAME
    //$dbase = 'mili_chromis1'; // DATABASE NAME
    $host = 'localhost'; //DATABASE HOST LOCATION/SERVER
    $user = 'root'; //USER NAME
    $pass = 'welkom'; //PASSWORD
    $link = @mysqli_connect($host, $user, $pass, $dbase);

    if (!$link) {
        die("connection failed : " . mysqli_connect_error());
    }
    return $link;
}
?>

