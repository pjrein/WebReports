<?php
include 'includes/biblio.php';
?>

<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/tabel-style.css">               
        <title>report diary</title>
    </head>
    <body>
        <div id="header">
            <img src="css/milimix.png" alt="milimix" width="50" height="50"><br>
            diary
        </div>
    

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
                    selecteer reason:
                <div class="left">
                    <br>
                    <br><select name="reason" size="12"  >
                        <?php
                        print " <option selected value=\" \"></option> ";
//                            while ($row = mysqli_fetch_assoc($resultcat)) {
// echo ("<option value=\"" . $reason["1"] . "\">" . $reason["stock.in.purchase"] . "</option>\n");
                        echo ("<option value = '1' >+1 stock in purchase </option>\n");
                        echo ("<option value = '2' >+2 stock in refund </option>\n");
                        echo ("<option value = '4' >+4 stock in movement </option>\n");
                        echo ("<option value = '-1' >-1 stock out sale </option>\n");
                        echo ("<option value = '-2' >-2 stock out refund </option>\n");
                        echo ("<option value = '-3' >-3 stock out break </option>\n");
                        echo ("<option value = '-4' >-4 stock out movement </option>\n");
                        echo ("<option value = '-5' >-5 stock out sample </option>\n");
                        echo ("<option value = '-6' >-6 stock out free </option>\n");
                        echo ("<option value = '-7' >-7 stock out used </option>\n");
                        echo ("<option value = '-8' >-8 stock out subtract </option>\n");


// }
                        ?>
                    </select>
                </div>
                <div class="bottom">
                    geef de begindatum JJJJ-MM-DD HH:MM:SS : <input type="text" name="begindatum" value="2019- 00:00:00" /><br>
                    geef de einddatum JJJJ-MM-DD HH:MM:SS  : <input type="text" name="einddatum" value="2019- 24:00:00" /><br>
                </div>
<!--                <div class="bottom">
                    <label for="begintest">Geef hier de begindatum : </label>
                    geef de begintest JJJJ-MM-DD HH:MM:SS : 
                    <input id="begintest" type="datetime-local" name="begintest" value="2019-01-01T00:00" /><br>
                    geef de eindtest JJJJ-MM-DD HH:MM:SS  : <input type="datetime-local" name="eindtest" value="2019-01-02T00:00" /><br>
                </div>-->

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
//            $begintest = $_POST['begintest'];
            echo 'begindatum' . $begindatum . "<br>";
//            date_default_timezone_set('UTC');
            
//            echo 'begintest-format-mysql' . date_format('Y-m-d H:i:s', strtotime($begintest));
            $einddatum = $_POST['einddatum'];
//            $eindtest = $_POST['eindtest'];
            echo 'einddatum' . $einddatum . "<br><br>";
//            echo 'begintest' . date('Y-m-d H:i:s', strtotime($begintest));
//            echo "<br>" .'eindtest' . date('Y-m-d H:i:s', strtotime($eindtest)) ;
//            ?>

            <?php
            $sql = "Select
categories.NAME as cat,
products.NAME As product,
PRODUCTS.ID as productID,
stockdiary.DATENEW datum,
stockdiary.REASON,
stockcurrent.units as magazijn,
locations.NAME As loc,
locations.id as locid,
stockdiary.UNITS as units,
PRODUCTS.CODE as EAN
From categories 
Inner Join products On products.CATEGORY = categories.ID 
Inner Join stockdiary On stockdiary.PRODUCT = products.ID 
Inner Join locations On stockdiary.LOCATION = locations.ID
inner join stockcurrent on stockcurrent.PRODUCT = products.id
Where
stockcurrent.LOCATION = '0' and
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
                <table class="fixed_headers">
                    <thead>
                        <tr>
                            <th><strong>catagorie</strong></th>
                            <th><strong>EAN      </strong></th>
                            <th><strong>produkt  </strong></th>
                            <th><strong>magazijn  </strong></th>
                            <th><strong>lilina     </strong></th>
                            <th><strong>am       </strong></th>
                            <th><strong>mipi     </strong></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $arResult = array();
                        while ($row = \mysqli_fetch_assoc($result)) {
                            $arResult[$i] = $row;
                            $arResult[$i]['lilina'] = '';
                            $arResult[$i]['am'] = '';
                            $arResult[$i]['mipi'] = '';
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
                                if ($varProductID[$j]['locid'] == 'f8f72452-f51c-40c0-a930-b38e47275590') {
                                    $varProductID[$j]['lilina'] = $varProductID[$j]['units'];
                                }
                                if ($varProductID[$j]['locid'] == '2') {
                                    $varProductID[$j]['am'] = $varProductID[$j]['units'];
                                }
                                if ($varProductID[$j]['locid'] == 'bc68d81f-df91-473d-a48f-666bfe130215') {
                                    $varProductID[$j]['mipi'] = $varProductID[$j]['units'];
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
                                if ($dub['locid'] == 'f8f72452-f51c-40c0-a930-b38e47275590') {
                                    $varProductID[$i]['lilina'] = $varProductID[$i]['lilina'] + $dub['units'];
                                }
                                if ($dub['locid'] == '2') {
                                    $varProductID[$i]['am'] = $varProductID[$i]['am'] + $dub['units'];
                                }
                                if ($dub['locid'] == 'bc68d81f-df91-473d-a48f-666bfe130215') {
                                    $varProductID[$i]['mipi'] = $varProductID[$i]['mipi'] + $dub['units'];
                                }
                            }
                        }
                    }

                    foreach ($varProductID as $uniek) {
                        echo("<tr>\n<td>" . $uniek['cat'] . "</td> ");
                        echo("<td>" . $uniek['EAN'] . "</td> ");
                        echo("<td>" . $uniek['product'] . "</td> ");
                        echo("<td>" . $uniek['magazijn'] . "</td> ");
                        echo("<td>" . $uniek['lilina'] . "</td>");
                        echo("<td>" . $uniek['am'] . "</td>");
                        echo("<td>" . $uniek['mipi'] . "</td>");
                    }
                }
                ?>
            </tbody>
        </table>



        <div class="container">
            <form name="hoofdmenu" action="index.php" method="POST">
                <input type="submit" value="hoofdmenu" />
            </form>
        </div>
    </body>
</html>
