<!DOCTYPE html>
<?php
 include 'includes/biblio.php';
 ?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/tabel-style.css"> 
        <title>report stock</title>
    </head>
    <body>
        <div id="header">
            <img src="css/milimix.png" alt="milimix" width="50" height="50"><br>
            voorraad
        </div>
      
        <?php
        function selectie() {
            if (isset($_POST['zendform'])) {
//                $i = 0;
//                foreach ($_POST['reason'] as $reason) {
//                    $res[] = "reason.NAME = '" . $reason . "'";
//                    $i++;
//                }
//                $stloc = "where ((" . implode(" OR ", $loc) . ") and ";
                // $reason = $_POST['reason'];
//                 echo "<pre>";
//            print_r($reason);
//            echo "<pre>";
                // echo $reason;
                $i = 0;
                foreach ($_POST['categorie'] as $categorie) {
                    $cat[] = "categories.NAME = '" . $categorie . "'";
                    $i++;
                }
                $sel = "(" . implode(" OR ", $cat) . ")";
//                $sel = $stloc . "(" . implode(" OR ", $cat) . "))";
//                $_SESSION["sel"] = $sel;
                return $sel;
            }
        }
        ?>


        <?php

        function selectie_form() {

            // echo 'functie selectie_form';
            $con = my_conn();
            //$sqlloc = "select locations.NAME from locations";
            //$resultloc = mysqli_query($con, $sqlloc);
            $sqlcat = "SELECT categories.Name FROM categories";
            $resultcat = mysqli_query($con, $sqlcat);
            $reason = array();
            ?>
            <div class="container">
                <form name="index" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" value="1" name="zendform" />
                    <!--                    <div class="left">
                                            selecteer de locatie:<br> <select name="locatie[]" multiple="multiple" size='5' >
                    <?php
 //                   print " <option selected value=\" \"></option> ";
 //                   while ($row = mysqli_fetch_assoc($resultloc)) {
 //                       echo ("<option value=\"" . $row["NAME"] . "\">" . $row["NAME"] . "</option>\n");
 //                   }
                    ?>
                                            </select><br><br>
                                        </div>-->
                    <div class="container">
                    selecteer categorie: 
                    </div>
                    <br>
                    <div class="left">
                        <br><select name="categorie[]" size="14"  multiple="multiple">
                            <?php
                            print " <option selected value=\" \"></option> ";
                            while ($row = mysqli_fetch_assoc($resultcat)) {
                                echo ("<option value=\"" . $row["Name"] . "\">" . $row["Name"] . "</option>\n");
                            }
                            ?>
                        </select><br><br>
                    </div>
                    <!--                    <div class="mid">
                                            selecteer reason: <br><select name="reason" size="12"  >
                    <?php
 //                   print " <option selected value=\" \"></option> ";
 //                   echo ("<option value = '1' >stock in purchase </option>\n");
//                    echo ("<option value = '2' >2stock in refund </option>\n");
//                    echo ("<option value = '4' >stock in movement </option>\n");
//                    echo ("<option value = '-1' >stock out sale </option>\n");
//                    echo ("<option value = '-2' >stock out refund </option>\n");
 //                   echo ("<option value = '-3' >stock out break </option>\n");
 //                   echo ("<option value = '-4' >stock out movement </option>\n");
 //                   echo ("<option value = '-5' >stock out sample </option>\n");
//                    echo ("<option value = '-6' >stock out free </option>\n");
//                    echo ("<option value = '-7' >stock out used </option>\n");
 //                   echo ("<option value = '-8' >stock out subtract </option>\n");


                    // }
                    ?>
                                            </select><br><br>
                                        </div>-->
                    <div class="bottom">
                        <input type="submit" name="submit" value="selectie"/>
                    </div>
                </form>
            </div>
            <!--            <form name="backToMainPage" action="index.php">
                            <input type="submit" value="Back To Main Page"/>
                        </form>-->
            <?php
            mysqli_close($con);
        }
        ?>



        <?php
        $sel = selectie();
        // echo $sel;

        $sql = " SELECT
        categories.NAME as cat,
	locations.NAME as loc,
	locations.id as locid,
        PRODUCTS.NAME as product,
        PRODUCTS.CODE as EAN,
        PRODUCTS.ID as productID,
	STOCKCURRENT.UNITS as units
        from stockcurrent
        left JOIN LOCATIONS ON STOCKCURRENT.LOCATION = LOCATIONS.ID
        left join products ON PRODUCTS.ID = STOCKCURRENT.PRODUCT
        left JOIN CATEGORIES ON PRODUCTS.CATEGORY = CATEGORIES.ID
        where (stockcurrent.LOCATION = 0 or stockcurrent.LOCATION = 2 or stockcurrent.LOCATION= 'bc68d81f-df91-473d-a48f-666bfe130215' or stockcurrent.LOCATION= 'f8f72452-f51c-40c0-a930-b38e47275590')
        and $sel order by products.name";

//  and categories.NAME = 'test stock' order by products.name ";
// PRODUCTS.NAME LIKE '%chocolaat%';";
//        echo $sql . "<br>";
//        echo $sel;

        selectie_form();
        $con = my_conn();
        $result = mysqli_query($con, $sql);
        if ($result) {
            ?>

            <table class="fixed_headers">
                <thead>
                <tr>
                    <th><strong>catagorie</strong></th>
                    <th><strong>EAN      </strong></th>
                    <th><strong>produkt  </strong></th>
                    <th><strong>magazijn    </strong></th>
                    <th><strong>am       </strong></th>
                    <th><strong>mimi     </strong></th>
                    <th><strong>lilina     </strong></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <!--</table>-->

                <?php
                $i = 0;
                $arResult = array();
                while ($row = \mysqli_fetch_assoc($result)) {
                    $arResult[$i] = $row;
                    $arResult[$i]['mili'] = '';
                    $arResult[$i]['am'] = '';
                    $arResult[$i]['mimi'] = '';
                    $arResult[$i]['lilina'] = '';
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
                        if ($varProductID[$j]['locid'] == '0') {
                            $varProductID[$j]['mili'] = $varProductID[$j]['units'];
                        }
                        if ($varProductID[$j]['locid'] == '2') {
                            $varProductID[$j]['am'] = $varProductID[$j]['units'];
                        }
                        if ($varProductID[$j]['locid'] == 'bc68d81f-df91-473d-a48f-666bfe130215') {
                            $varProductID[$j]['mimi'] = $varProductID[$j]['units'];
                        }
                        if ($varProductID[$j]['locid'] == 'f8f72452-f51c-40c0-a930-b38e47275590') {
                            $varProductID[$j]['lilina'] = $varProductID[$j]['units'];
                        }
                    }
                    if (in_array($arResult[$j]['productID'], $resultaat)) {
                        $duplicates[$j] = $arResult[$j]; //zijn dubbele waarden
                        $count++;
                    }
                    $resultaat[$j] = $arResult[$j]['productID'];
                }

//            echo "<pre>";
//            print_r($duplicates);
//            echo "<pre>";

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
                            if ($dub['locid'] == 'f8f72452-f51c-40c0-a930-b38e47275590') {
                                $varProductID[$i]['lilina'] = $varProductID[$i]['lilina'] + $dub['units'];
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
                    echo("<td>" . $uniek['lilina'] . "</td>");
                }
            }
            ?>
                </tbody>
        </table>

        <!--        <form name="hoofdmenu" action="voorraad.php" method="POST">
                    <input type="submit" value="voorraadInvoer" />
                </form>-->
        <form name="hoofdmenu" action="index.php" method="POST">
            <input type="submit" value="hoofdmenu" />
        </form>

    </body>
</html>
