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
            //$dbase = 'chromis2'; // DATABASE NAME
            $dbase = 'loja';
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

        <!--//        echo 'voorraadInvoer';
        // categorie opgeven zodat per categorie kan worden gekeken-->

        <!--        <form name="voorraadInvoer" action="voorraad.php" method="POST">
                        geef de begindatum JJJJ-MM-DD HH:MM:SS : <input type="text" name="begindatum" value="2016- 00:00:00" /><br>
                    geef de einddatum JJJJ-MM-DD HH:MM:SS  : <input type="text" name="einddatum" value="2016- 24:00:00" /><br>
                    <input type="submit" name="voorraadName" value="voorraad" />
                </form>-->
        <div class="container">
            <form name="index" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" value="1" name="zendform" />

                <div class="left">
                    selecteer reason: <br><select name="reason" size="12"  >
                        <?php
                        print " <option selected value=\" \"></option> ";
//                            while ($row = mysqli_fetch_assoc($resultcat)) {
// echo ("<option value=\"" . $reason["1"] . "\">" . $reason["stock.in.purchase"] . "</option>\n");
                        echo ("<option value = '1' >stock in purchase </option>\n");
                        echo ("<option value = '2' >stock in refund </option>\n");
                        echo ("<option value = '4' >stock in movement </option>\n");
                        echo ("<option value = '-1' >stock out sale </option>\n");
                        echo ("<option value = '-2' >stock out refund </option>\n");
                        echo ("<option value = '-3' >stock out break </option>\n");
                        echo ("<option value = '-4' >stock out movement </option>\n");
                        echo ("<option value = '-5' >stock out sample </option>\n");
                        echo ("<option value = '-6' >stock out free </option>\n");
                        echo ("<option value = '-7' >stock out used </option>\n");
                        echo ("<option value = '-8' >stock out subtract </option>\n");


// }
                        ?>
                    </select><br><br>
                </div>
                <div class="float">
                    geef de begindatum JJJJ-MM-DD HH:MM:SS : <input type="text" name="begindatum" value="2017- 00:00:00" /><br>
                    geef de einddatum JJJJ-MM-DD HH:MM:SS  : <input type="text" name="einddatum" value="2017- 24:00:00" /><br>
                </div>


                <div class="bottom">
                    <input type="submit" name="submit" value="selectie"/>
                </div>
            </form>
        </div>
        <?php
        if (isset($_POST['zendform'])) {
            $reason = $_POST['reason'];
            echo "reason " . $reason . "<br>";
            $begindatum = $_POST['begindatum'];
            echo 'begindatum'. $begindatum . "<br>";
            $einddatum = $_POST['einddatum'];
            echo 'einddatum'. $einddatum . "<br><br>";
            ?>

            <?php
            $sql = "Select
categories.NAME as cat,
products.NAME As product,
PRODUCTS.ID as productID,
stockdiary.DATENEW datum,
stockdiary.REASON,
locations.NAME As loc,
locations.id as locid,
stockdiary.UNITS as units,
PRODUCTS.CODE as EAN
From categories 
Inner Join products On products.CATEGORY = categories.ID 
Inner Join stockdiary On stockdiary.PRODUCT = products.ID 
Inner Join locations On stockdiary.LOCATION = locations.ID
Where
stockdiary.DATENEW > '" . $_POST["begindatum"] . "' AND stockdiary.DATENEW < '" . $_POST["einddatum"] . "' and
stockdiary.REASON = $reason
Order By
stockdiary.DATENEW,
categories.NAME,
products.NAME";

            //stockdiary.DATENEW > '" . $_POST["begindatum"] . "' AND stockdiary.DATENEW < '" . $_POST["einddatum"] . "' and
//stockdiary.DATENEW > '2017-07-04' and
//products.REFERENCE as productID        
//  and categories.NAME = 'test stock' order by products.name ";
// PRODUCTS.NAME LIKE '%chocolaat%';";
           // echo $sql . "<br>";
//        echo $sel;


            $con = my_conn();
            $result = mysqli_query($con, $sql);

            if ($result) {
                ?>
                <table>
                    <tr>
                        <td><strong>catagorie</strong></td>
                        <td><strong>EAN      </strong></td>
                        <td><strong>produkt  </strong></td>
                        <td><strong>mili     </strong></td>
                        <td><strong>am       </strong></td>
                        <td><strong>mimi     </strong></td>
                        <td></td>
                    </tr>
                    <?php
                    $i = 0;
                    $arResult = array();
                    while ($row = \mysqli_fetch_assoc($result)) {
                        $arResult[$i] = $row;
                        $arResult[$i]['mili'] = '';
                        $arResult[$i]['am'] = '';
                        $arResult[$i]['mimi'] = '';
                        $i++;
                    }

//                echo "<pre>";
//                print_r($arResult);
//                echo "<pre>";

                    $varProductID = array();
                    $resultaat = array(); //hulparray
                    $duplicates = array();
                    $count = 0;
                    for ($j = 0; $j < count($arResult); $j++) {
                        if (!in_array($arResult[$j]['productID'], $resultaat)) {
                            // $varProductID[$j] = $arResult[$j]['productID'];
                            $varProductID[$j] = $arResult[$j]; //zijn unieke waarden
                            if ($varProductID[$j]['locid'] == '0') {
                                $varProductID[$j]['mili'] = $varProductID[$j]['units'];
                            }
                            if ($varProductID[$j]['locid'] == '2') {
                                $varProductID[$j]['am'] = $varProductID[$j]['units'];
                            }
                            if ($varProductID[$j]['locid'] == 'bc68d81f-df91-473d-a48f-666bfe130215') {
                                $varProductID[$j]['mimi'] = $varProductID[$j]['units'];
                            }
                        }
                        if (in_array($arResult[$j]['productID'], $resultaat)) {
                            $duplicates[$j] = $arResult[$j]; //zijn dubbele waarden
                            $count++;
                        }
                        $resultaat[$j] = $arResult[$j]['productID'];
                    }
                }
//            echo "<pre>";
//                print_r($duplicates);
//                echo "<pre>";
                $duplicates = array_values($duplicates);
                $varProductID = array_values($varProductID);
// echo 'aantal varproductid' . count($varProductID);
                for ($i = 0; $i < count($varProductID); $i++) {
                    foreach ($duplicates as $dub) {
                        if ($dub['productID'] == $varProductID[$i]['productID']) {
                            if ($dub['locid'] == '0') {
                                $varProductID[$i]['mili'] = $varProductID[$i]['mili'] + $dub['units'];
                            }
                            if ($dub['locid'] == '2') {
                                $varProductID[$i]['am'] = $varProductID[$i]['am'] + $dub['units'];
                            }
                            if ($dub['locid'] == 'bc68d81f-df91-473d-a48f-666bfe130215') {
                                $varProductID[$i]['mimi'] = $varProductID[$i]['mimi'] + $dub['units'];
                            }
                        }
                    }
                }

                foreach ($varProductID as $uniek) {
                    echo("<tr>\n<td>" . $uniek['cat'] . "</td> ");
                    echo("<td>" . $uniek['EAN'] . "</td> ");
                    echo("<td>" . $uniek['product'] . "</td> ");
                    echo("<td>" . $uniek['mili'] . "</td>");
                    echo("<td>" . $uniek['am'] . "</td>");
                    echo("<td>" . $uniek['mimi'] . "</td>");
                }
            }
            ?>
        </table>




        <form name="hoofdmenu" action="index.php" method="POST">
            <input type="submit" value="hoofdmenu" />
        </form>
    </body>
</html>
