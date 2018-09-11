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
            product sales extended
        </div>
        <?php

        function my_conn() {
            // echo 'verbinding maken met kassa : ';
             $dbase = 'chromis2'; // DATABASE NAME
            //$dbase = 'loja'; // DATABASE NAME
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
        // echo 'productSalesExtended';

        $sql = "   SELECT CUSTOMERS.TAXID, 
                        CUSTOMERS.NAME AS CUSTOMER, 
                        CATEGORIES.NAME AS CATEGORY, 
                        PRODUCTS.REFERENCE, 
                        PRODUCTS.NAME AS PRODUCT, 
                        SUM(TICKETLINES.UNITS) AS UNIT, 
                        SUM(TICKETLINES.UNITS * TICKETLINES.PRICE) AS TOTAL, 
                        SUM(TICKETLINES.UNITS * TICKETLINES.PRICE) / SUM(TICKETLINES.UNITS) AS MEANPRICE
                        FROM TICKETS 
                        LEFT OUTER JOIN CUSTOMERS ON TICKETS.CUSTOMER = CUSTOMERS.ID, TICKETLINES 
                        LEFT OUTER JOIN PRODUCTS ON TICKETLINES.PRODUCT = PRODUCTS.ID 
                        LEFT OUTER JOIN CATEGORIES ON PRODUCTS.CATEGORY = CATEGORIES.ID, 
                        RECEIPTS
                        WHERE RECEIPTS.ID = TICKETS.ID AND 
                        TICKETS.ID = TICKETLINES.TICKET AND 
                        CATEGORIES.ID = PRODUCTS.CATEGORY and
                         RECEIPTS.DATENEW > '" . $_POST["begindatum"] . "' AND RECEIPTS.DATENEW < '" . $_POST["einddatum"] . "'  
                       # RECEIPTS.DATENEW > '2016-02-18 00:00:00' AND RECEIPTS.DATENEW < '2016-02-18 24:00:00' #and
                        #products.REFERENCE = '20005832' 
                        #categories.NAME = 'doce'
                        #products.PRICESELL= '35'
                        GROUP BY CUSTOMERS.ID, 
                        CATEGORIES.ID, 
                        PRODUCTS.ID
                        ORDER BY CUSTOMERS.NAME, 
                        CATEGORIES.NAME, 
                        PRODUCTS.NAME;";
        $con = my_conn();
        $result = mysqli_query($con, $sql);
        ?>

        <h2> Products Sales: Extended </h2>
        <h3> Period <?php echo $_POST["begindatum"] . '       ' . $_POST["einddatum"]; ?>  </h3>
        <table> 
            <tr> 
                <!--<td><strong>CATEGRORIE</strong></td>--> 
                <td><strong>EAN</strong></td> 
                <td><strong>PRODUCT</strong></td> 
                <!--<td><strong>INKOOP</strong></td>-->
                <td><strong>PRIJS</strong></td>
                <td><strong>AANTAL</strong></td> 
                <td><strong>TOTAAL</strong></td>
<!--                    <td><strong>PROFIT/LOSS</strong></td> 
                <td><strong>TICKETID</strong></td> -->
                <!--<td><strong>DATE</strong></td>--> 
                <td></td>
            </tr>

            <?php
            $aantal = 0;
            $totaal = 0;
            $winst = 0;
            while ($row = mysqli_fetch_assoc($result)) {
//                echo("<tr>\n<td>" . $row["CATEGORY"] . "</td> ");
                echo("<tr>\n<td>" . $row["REFERENCE"] . "</td> ");
                echo("<td>" . $row["PRODUCT"] . "</td>");
//                echo("<td>" . $row["PRICEBUY"] . "</td>");
                echo("<td>" . $row["MEANPRICE"] . "</td>");
                echo("<td>" . $row["UNIT"] . "</td>");
                echo("<td>" . $row["TOTAL"] . "</td>");
//                echo("<td>" . $row["PROFITLOSS"] . "</td>");
//                echo("<td>" . $row["TICKETID"] . "</td>");
                //echo("<td>" . $row["DATE"] . "</td>");
                $aantal = $aantal + $row["UNIT"];
                $totaal = $totaal + $row["TOTAL"];
//                $winst = $winst + $row["PROFITLOSS"];
            }
//  echo '$aantal '. $aantal ;
            ?>
            <tr> 
                <td><strong></strong></td> 
                <td><strong></strong></td> 
                <td><strong></strong></td>
                <!--<td><strong></strong></td>-->
                <td><strong>AANTAL</strong></td> 
                <td><strong>TOTAAL</strong></td>
<!--                <td><strong>PROFIT/LOSS</strong></td> 
                <td><strong></strong></td> 
                <td><strong></strong></td> -->
                <!--<td></td>-->
            </tr>
            <tr> 
                <td><strong></strong></td> 
                <td><strong></strong></td> 
                <!--<td><strong></strong></td>-->
                <td><strong>SUB TOTAAL</strong></td>
                <td><strong><?php echo $aantal ?></strong></td> 
                <td><strong><?php echo $totaal ?></strong></td>
<!--                <td><strong><?php echo $winst ?></strong></td> 
                <td><strong></strong></td> 
                <td><strong></strong></td> -->
                <!--<td></td>-->
            </tr> 


        </table>
        <form name="hoofdmenu" action="index.php" method="POST">
            <input type="submit" value="hoofdmenu" />
        </form>

    </body>
</html>
