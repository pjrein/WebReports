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
                $arResult[$i]['mi'] = '';
                $arResult[$i]['am'] = '';
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


//            echo "<pre>";
//            print_r($arResult);
//            echo "<pre>";
            $varProductID = array();
            $resultaat = array();
            $duplicates = array();
            $count = 0;
            for ($j = 0; $j < count($arResult); $j++) {
                if (!in_array($arResult[$j]['productID'], $resultaat)) {
                    // $varProductID[$j] = $arResult[$j]['productID'];
                    $varProductID[$j] = $arResult[$j]; //zijn unieke waarden
                    if ($varProductID[$j]['locid'] == 0) {
                        $varProductID[$j]['mi'] = $varProductID[$j]['units'];
                        // $count++;
                    }
                    if ($varProductID[$j]['locid'] == 2) {
                        $varProductID[$j]['am'] = $varProductID[$j]['units'];
                        // $count++;
                    }
                }
                if (in_array($arResult[$j]['productID'], $resultaat)) {
                    $duplicates[$j] = $arResult[$j]; //zijn dubbele waarden
                    $count++;
                }
                $resultaat[$j] = $arResult[$j]['productID'];
            }
            $duplicates = array_values($duplicates);
            $varProductID = array_values($varProductID);
            for ($x = 0; $x < count($duplicates); $x++) {
                for ($y = 0; $y < count($varProductID); $y++) {
                    if ($duplicates[$x]['productID'] == $varProductID[$y]['productID'] && $duplicates[$x]['locid'] == 2)
                        $varProductID[$y]['am'] = $varProductID[$y]['units'];
//                    if ($duplicates[$x]['productID'] == $varProductID[$y]['productID'] && $duplicates[$x]['locid'] == 0)
//                        $varProductID[$y]['mi'] = $varProductID[$y]['units'];


                    //  c
                    //       echo 'aantal varProductID  = ' . count($varProductID) . "<br>";
                    // echo 'dulicates ProductID  = ' . $duplicates[$x]['productID'] . "<br>";
                    // echo 'varProductID ProductID  = ' . $varProductID[$y]['productID'] . "<br>";
                }
            }
//            echo "<pre>";
//            print_r($resultaat);
//            echo "<pre>";
            echo "<pre>";
            print_r($duplicates);
            echo "<pre>";

            echo "<pre>";
            print_r($varProductID);
            echo "<pre>";
            // $varProductID = array_values($varProductID);
//            echo "<pre>";
//            print_r($varProductID);
//            echo "<pre>";
//            echo "<pre>";
//            print_r(array_count_values($arResult));
//            echo "<pre>";
            echo 'count = ' . count($arResult) . '<br>';
            echo 'aantal dubbele = ' . $count . '<br>';
            $j = 0;
            for ($j = 0; $j < $count; $j++) {
                for ($x = 0; $x < $i; $x++) {
                    //for each($arResult)
                    if (($varProductID[$j] = $arResult[$x]['productID'])) {
                        //   echo '$varProductID[$j]' . $varProductID[$j] . '     $arResult' . $arResult[$x]['productID'] . "<br>";
                        echo("<tr>\n<td>" . $arResult[$x]['loc'] . "</td> ");
                        echo("<td>" . $arResult[$x]['locid'] . "</td>");
                        echo("<td>" . $arResult[$x]['product'] . "</td>");
                        echo("<td>" . $arResult[$x]['productID'] . "</td>");
                        if ($arResult[$x]['locid'] == 2) {
                            echo("<td>" . " " . "</td>");
                            echo("<td>" . $arResult[$x]['units'] . "</td>");
                        }
                        if ($arResult[$x]['locid'] == 0) {
                            echo("<td>" . $arResult[$x]['units'] . "</td>");
                            echo("<td>" . " " . "</td>");
                        }
                    }
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
