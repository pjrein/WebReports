<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/mili-style.css">               
        <title>reports</title>
    </head>
    <body>
        <div id="header">
            <img src="css/milimix.png" alt="milimix" width="50" height="50"><br>
            reports menu
        </div>
        <?php

        function my_conn() {
            // echo 'verbinding maken met kassa : ';
            // $dbase = 'mili'; // DATABASE NAME
            $dbase = 'chromis2'; // DATABASE NAME
            //$dbase = 'chromis_test';
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


        <?php
        echo 'hallo vanuit voorraad <br>';
        $sql = " SELECT
	locations.NAME as loc, 
	locations.id as locid,
        PRODUCTS.NAME as product,
        PRODUCTS.ID as productID,
	STOCKCURRENT.UNITS as units
from stockcurrent
left JOIN LOCATIONS ON STOCKCURRENT.LOCATION = LOCATIONS.ID
left join products ON PRODUCTS.ID = STOCKCURRENT.PRODUCT
left JOIN CATEGORIES ON PRODUCTS.CATEGORY = CATEGORIES.ID

where
 (stockcurrent.LOCATION = 0 or stockcurrent.LOCATION = 2) and
PRODUCTS.NAME LIKE '%mentos%';";

        $con = my_conn();
        $result = mysqli_query($con, $sql);
        ?>

        <table> 
            <tr> 
                <td><strong>location</strong></td> 
                <td><strong>ID</strong></td> 
                <td><strong>produkt</strong></td>
                <td><strong>produkt-ID</strong></td>
                <td><strong>am</strong></td>
                <td><strong>mi</strong></td>
                <td></td>
            </tr>
            <!--</table>-->

            <?php
            $i = 0;
            $arResult = array();
            while ($row = mysqli_fetch_assoc($result)) {

//                $tel=0;
//                $varProdId = $row["productID"];
//                echo 'varProdId =  ' . $varProdId . "<br>";
//                if ($varProdId = $row["productID"])
//                {
//                    $tel = $tel + 1;
//                }
//                echo 'tel = ' . $tel;

                $arResult[$i] = $row;
                $i++;
//                echo("<tr>\n<td>" . $row["loc"] . "</td> ");
//                echo("<td>" . $row["locid"] . "</td>");
//                echo("<td>" . $row["product"] . "</td>");
//                echo("<td>" . $row["productID"] . "</td>");
//                if ($row["locid"] == 2) {
//                    echo("<td>" . " ". "</td>");
//                    echo("<td>" . $row["units"] . "</td>");
//                }
//                if ($row["locid"] == 0 ) {
//                    echo("<td>" . $row["units"] . "</td>");
//                    echo("<td>" . " " . "</td>");
//                }
            }
            echo "<pre>";
            print_r($arResult);
            echo "<pre>";

            for ($j = 0; $j < $i; $j++) {
               // echo 'array ' . $j . ' aantal = ' . $arResult[$j]['units'] . '<br>';
                $varProductID = $arResult[$j]['productID'];
                for($x=0; $x < $i-$j; $x++){
                   
                }
                 echo 'x =' . $x . '<br>';
                echo("<tr>\n<td>" . $arResult[$j]['loc'] . "</td> ");
                echo("<td>" . $arResult[$j]['locid'] . "</td>");
                echo("<td>" . $arResult[$j]['product'] . "</td>");
                echo("<td>" . $arResult[$j]['productID'] . "</td>");
                if ($arResult[$j]['locid'] == 2) {
                    echo("<td>" . " " . "</td>");
                    echo("<td>" . $arResult[$j]['units'] . "</td>");
                }
                if ($arResult[$j]['locid'] == 0) {
                    echo("<td>" . $arResult[$j]['units'] . "</td>");
                    echo("<td>" . " " . "</td>");
                }
            }
            ?>

        </table> 

        <form name="hoofdmenu" action="voorraadInvoer.php" method="POST">
            <input type="submit" value="voorraadInvoer" />
        </form>
        <form name="hoofdmenu" action="index.php" method="POST">
            <input type="submit" value="hoofdmenu" />
        </form>

    </body>
</html>
