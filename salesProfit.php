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
            sales profit
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
//        echo "<pre>";
//        print_r($_REQUEST);
//        echo "<pre>";   
//        if ($_REQUEST['salesProfitNAME'] != 'salesProfit') {
//            echo 'vanuit index';
//            $_POST["begindatum"] = '';
//            $_POST["einddatum"] = '';            
//    }
        // ....discount nog niet mee geteld in report
        // ... categorieen nog niet in report


        $sql = "SELECT PRODUCTS.CODE, 
                            TICKETS.TICKETID, 
                            RECEIPTS.DATENEW AS DATE, 
                            PRODUCTS.NAME, 
                            PRODUCTS.PRICEBUY, 
                            PRODUCTS.PRICESELL, 
                            SUM(TICKETLINES.UNITS) AS UNITSSOLD, 
                            SUM(TICKETLINES.UNITS * TICKETLINES.PRICE) AS TOTAL, 
                            SUM(TICKETLINES.UNITS * TICKETLINES.PRICE) - SUM(TICKETLINES.UNITS * PRODUCTS.PRICEBUY) AS PROFITLOSS
                        FROM RECEIPTS, TICKETS, TICKETLINES, PRODUCTS
                        WHERE RECEIPTS.ID = TICKETS.ID AND TICKETS.ID = TICKETLINES.TICKET AND TICKETLINES.PRODUCT = PRODUCTS.ID and
                        RECEIPTS.DATENEW > '" . $_POST["begindatum"] . "' AND RECEIPTS.DATENEW < '" . $_POST["einddatum"] . "'                                           
                        GROUP BY PRODUCTS.CODE, PRODUCTS.NAME , TICKETS.TICKETID, RECEIPTS.DATENEW, PRODUCTS.PRICEBUY, PRODUCTS.PRICESELL
                        ORDER BY RECEIPTS.DATENEW ;";

//         RECEIPTS.DATENEW > '2016-02-15 00:00:00' AND RECEIPTS.DATENEW < '2016-02-15 24:00:00'
//               "SUM(TICKETLINES.UNITS*TICKETLINES.PRICE) - SUM(TICKETLINES.UNITS * PRODUCTS.PRICEBUY) " +
        //        "AS ACTUAL_PROFIT " +


        $con = my_conn();
        $result = mysqli_query($con, $sql);
        ?>

        <h2> Products Sales: Profit </h2>
        <h3> Period <?php echo $_POST["begindatum"] . '       ' . $_POST["einddatum"]; ?>  </h3>
        <table> 
            <tr> 
                <td><strong>EAN</strong></td> 
                <td><strong>PRODUCT</strong></td> 
                <td><strong>INKOOP</strong></td>
                <td><strong>VERKOOP</strong></td>
                <td><strong>AANTAL</strong></td> 
                <td><strong>TOTAAL</strong></td>
                <td><strong>PROFIT/LOSS</strong></td> 
                <td><strong>TICKETID</strong></td> 
                <!--<td><strong>DATE</strong></td>--> 
                <td></td>
            </tr>

            <?php
            $aantal = 0;
            $totaal = 0;
            $winst = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                echo("<tr>\n<td>" . $row["CODE"] . "</td> ");
                echo("<td>" . $row["NAME"] . "</td>");
                echo("<td>" . $row["PRICEBUY"] . "</td>");
                echo("<td>" . $row["PRICESELL"] . "</td>");
                echo("<td>" . $row["UNITSSOLD"] . "</td>");
                echo("<td>" . $row["TOTAL"] . "</td>");
                echo("<td>" . $row["PROFITLOSS"] . "</td>");
                echo("<td>" . $row["TICKETID"] . "</td>");
                //echo("<td>" . $row["DATE"] . "</td>");
                $aantal = $aantal + $row["UNITSSOLD"];
                $totaal = $totaal + $row["TOTAL"];
                $winst = $winst + $row["PROFITLOSS"];
            }
//  echo '$aantal '. $aantal ;
            ?>
            <tr> 
                <td><strong></strong></td> 
                <td><strong></strong></td> 
                <td><strong></strong></td>
                <td><strong></strong></td>
                <td><strong>AANTAL</strong></td> 
                <td><strong>TOTAAL</strong></td>
                <td><strong>PROFIT/LOSS</strong></td> 
                <td><strong></strong></td> 
                <td><strong></strong></td> 
                <!--<td></td>-->
            </tr>
            <tr> 
                <td><strong></strong></td> 
                <td><strong></strong></td> 
                <td><strong></strong></td>
                <td><strong>SUB TOTAAL</strong></td>
                <td><strong><?php echo $aantal ?></strong></td> 
                <td><strong><?php echo $totaal ?></strong></td>
                <td><strong><?php echo $winst ?></strong></td> 
                <td><strong></strong></td> 
                <td><strong></strong></td> 
                <!--<td></td>-->
            </tr>
        </table> 
        <!--</form>-->
        <form name="hoofdmenu" action="index.php" method="POST">
            <input type="submit" value="hoofdmenu" />
        </form>
    </body>
</html>
