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
        // echo 'hallo keuzemenu';
        ?>
        <form name = "salesProfit" action = "salesProfitInvoer.php" method = "POST">                 
            <input type="submit" value="salesProfit" name="salesProfitNAME" />
        </form>
        <form name="productSales" action="productSalesExtendedInvoer.php" method="POST">
            <input type="submit" value="productSales" name="productSalesname" />
        </form>
        <form name="maandOmzet" action="maandOmzetInvoer.php" method="POST">
            <input type="submit" value="maandOmzet" name="maandOmzetname" />
        </form>
        <form name="voorraad" action="voorraad.php" method="POST">
            <input type="submit" value="voorraad" name="voorraadname" />
        </form>
        <form name="diary" action="diary.php" method="POST">
            <input type="submit" value="diary" name="diarynakename" />
        </form>
    </body>
</html>
