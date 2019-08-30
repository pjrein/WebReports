<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!--        <link rel="stylesheet" href="css/mili-style.css">               -->
        <link rel="stylesheet" href="css/tabel-style.css"> 
        <title>reports</title>
    </head>
    <body>
        <div id="header">
            <img src="css/milimix.png" alt="milimix" width="50" height="50"><br>
            reports menu     
        </div>
        <div class="container">
            Keuze menu: 
        </div>
        <br><br>
        <form name = "salesProfit" action = "salesProfitInvoer.php" method = "POST">                 
            <input type="submit" value="salesProfit" name="salesProfitNAME" />
        </form>
        <form name="productSales" action="productSalesExtendedInvoer.php" method="POST">
            <input type="submit" value="productSalesExtended" name="productSalesname" />
        </form>
        <form name="maandOmzet" action="maandOmzetInvoer.php" method="POST">
            <input type="submit" value="maandOmzet" name="maandOmzetname" />
        </form>
        <form name="voorraad" action="stock.php" method="POST">
            <input type="submit" value="stock" name="voorraadname" />
        </form>
        <form name="diary" action="diary.php" method="POST">
            <input type="submit" value="diary" name="diaryname" />
        </form>
        <form name="salesWithStock" action="sales with stock.php" method="POST">
            <input type="submit" value="sales with stock" name="salesWithStockname" />
        </form>
    </body>
</html>
