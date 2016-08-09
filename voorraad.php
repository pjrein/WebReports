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
PRODUCTS.NAME LIKE '%chocolaat%';";

        $con = my_conn();
        $result = mysqli_query($con, $sql);
        ?>

        <table> 
            <tr> 
                <td><strong>produkt</strong></td>
                <td><strong>mi</strong></td>
                <td><strong>am</strong></td>
                <td></td>
            </tr>
            <!--</table>-->

            <?php
            $i = 0;
            $arResult = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $arResult[$i] = $row;
                $arResult[$i]['mi'] = '';
                $arResult[$i]['am'] = '';
                $i++;
            }


//            echo "<pre>";
//            print_r($arResult);
//            echo "<pre>";
            $varProductID = array();
            $resultaat = array(); //hulparray
            $duplicates = array();
            $count = 0;
            for ($j = 0; $j < count($arResult); $j++) {
                if (!in_array($arResult[$j]['productID'], $resultaat)) {
                    // $varProductID[$j] = $arResult[$j]['productID'];
                    $varProductID[$j] = $arResult[$j]; //zijn unieke waarden
                    if ($varProductID[$j]['locid'] == 0) {
                        $varProductID[$j]['mi'] = $varProductID[$j]['units'];                      
                    }
                    if ($varProductID[$j]['locid'] == 2) {
                        $varProductID[$j]['am'] = $varProductID[$j]['units'];                        
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
           // echo 'aantal varproductid' . count($varProductID);
            for ($i = 0; $i < count($varProductID); $i++) {
                foreach ($duplicates as $dub) {
                    if ($dub['productID'] == $varProductID[$i]['productID']) {
                        if ($dub['locid'] == 0) {
                            $varProductID[$i]['mi'] = $dub['units'];
                        }
                        if ($dub['locid'] == 2) {
                            $varProductID[$i]['am'] = $dub['units'];
                        }
                    }
                }
            }

            foreach($varProductID as $uniek) {
                echo("<tr>\n<td>" . $uniek['product'] . "</td> ");
                echo("<td>" . $uniek['mi'] . "</td>");
                echo("<td>" . $uniek['am'] . "</td>");
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
