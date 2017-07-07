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
        <title></title>
    </head>
    <body>
        <div id="header">
            <img src="css/milimix.png" alt="milimix" width="50" height="50"><br>

            sales with stock
        </div>
        <?php

//        echo 'sales with stock';
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


        <div class="container">
            <form name="index" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" value="1" name="zendform" />               
                <div class="left2">
                    geef de begindatum JJJJ-MM-DD HH:MM:SS : <input type="text" name="begindatum" value="2017- 00:00:00" /><br>
                    geef de einddatum JJJJ-MM-DD HH:MM:SS  : <input type="text" name="einddatum" value="2017- 24:00:00" /><br>
                </div>
                <div class="mid">
                    number of days : <input type="text" name="numberOfDays" value="1" /><br>                    
                </div>
                <div class="bottom">
                    <input type="submit" name="submit" value="selectie"/>
                </div>
            </form>
        </div>
        <?php
        if (isset($_POST['zendform'])) {
            $begindatum = $_POST['begindatum'];
            echo 'begindatum' . $begindatum . "<br>";
            $einddatum = $_POST['einddatum'];
            echo 'einddatum' . $einddatum . "<br><br>";
            $numberOfDays = $_POST['numberOfDays'];
            echo 'number do days = ' . $numberOfDays . "<br><br>";            
            ?>

            <?php
            #---- START PERIOD options ----
#SET @NumberOfDays = 365; #Edit with number of days you wish to report.
#SET @StartDate = '2017-05-30 00:00:00'; #Edit with your Start date and time (yyyy-mm-dd hr:min:sec).
#SET @EndDate = '2017-05-30 23:59:00'; #Edit with your End date and time (yyyy-mm-dd hr:min:sec).
#---- END PERIOD options ----
#
#---- START CUSTOM options ----
#SET @ProductName = '%mentos%'; #Edit with part (or whole) of product name. Case insensitive.
#SET @Supplier = '%<entry key="Supplier">%Cola%</entry>%'; #Edit with supplier. Place Supplier in Properties field >>
#SET @Type = '%<entry key="Type">%Shirt%</entry>%'; #Edit with type. Place Type in Properties field >>
            /* Start Properties (Attribute) field example >>
              <properties>
              <entry key="Supplier">Coca-Cola</entry>
              <entry key="Type">Adult T-Shirt</entry>
              </properties>
             */ #<< End Properties (Attribute) field example
#---- END CUSTOM options ----
            $sql = "SELECT
    PRODUCTS.REFERENCE,
    PRODUCTS.NAME,
    PRODUCTS.PRICEBUY,
    PRODUCTS.PRICESELL,
    STOCKCURRENT.UNITS AS 'units',
	#STOCKCURRENT.UNITS AS 'mili',
    SUM(TICKETLINES.UNITS) AS 'SOLD',
    SUM(TICKETLINES.PRICE * TICKETLINES.UNITS) AS 'SUBTOTAL',
    SUM((TICKETLINES.PRICE * TICKETLINES.UNITS) * TAXES.RATE) AS 'TAXES',
    SUM(TICKETLINES.PRICE * TICKETLINES.UNITS) + SUM((TICKETLINES.PRICE * TICKETLINES.UNITS) * TAXES.RATE) AS 'GROSSTOTAL',
    SUM(TICKETLINES.PRICE * TICKETLINES.UNITS) - SUM(PRODUCTS.PRICEBUY * TICKETLINES.UNITS) AS 'PROFIT'
FROM
    TICKETLINES
        LEFT OUTER JOIN
    PRODUCTS ON TICKETLINES.PRODUCT = PRODUCTS.ID
        LEFT OUTER JOIN
    TICKETS ON TICKETS.ID = TICKETLINES.TICKET
        LEFT OUTER JOIN
    RECEIPTS ON RECEIPTS.ID = TICKETS.ID
        LEFT OUTER JOIN
    STOCKCURRENT ON PRODUCTS.ID = STOCKCURRENT.PRODUCT,
    TAXES
WHERE
    RECEIPTS.ID = TICKETS.ID
        AND TICKETS.ID = TICKETLINES.TICKET
        AND TICKETLINES.PRODUCT = PRODUCTS.ID
        AND TICKETLINES.TAXID = TAXES.ID
		and stockcurrent.LOCATION = 'bc68d81f-df91-473d-a48f-666bfe130215'
		#and (stockcurrent.LOCATION = 'bc68d81f-df91-473d-a48f-666bfe130215' or stockcurrent.LOCATION = '2' or stockcurrent.LOCATION = '0')
        
       # AND RECEIPTS.DATENEW BETWEEN DATE_SUB(NOW(),INTERVAL @NumberOfDays DAY) AND NOW()
        AND RECEIPTS.DATENEW BETWEEN @StartDate AND @EndDate
        #--- END PERIOD option implementation ----
        #--- START CUSTOM option implementation. Use any single or multiple options ----
        #AND PRODUCTS.NAME LIKE @ProductName
        #AND CONVERT(PRODUCTS.ATTRIBUTES USING latin1) LIKE @Supplier
        #AND CONVERT(PRODUCTS.ATTRIBUTES USING latin1) LIKE @Type
        #--- END CUSTOM option implementation.
GROUP BY PRODUCTS.REFERENCE , PRODUCTS.NAME , PRODUCTS.PRICEBUY , PRODUCTS.PRICESELL
#ORDER BY GROSSTOTAL DESC

order by NAME
LIMIT 10000 #Edit this limit to return as many products as you wish. Top 10,000 Sales?";

#--- START PERIOD option implementation. Use either "@NumberOfDays" or "@StartDate AND @EndDate" ----

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

                </table>
                <?php
            }
        }
        ?>

        <form name="hoofdmenu" action="index.php" method="POST">
            <input type="submit" value="hoofdmenu" />
        </form>
    </body>
</html>
