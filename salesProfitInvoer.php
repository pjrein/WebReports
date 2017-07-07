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
        // put your code here
        ?>
        <form name="salesProfitInvoer" action="salesProfit.php" method="POST">
            geef de begindatum JJJJ-MM-DD HH:MM:SS : <input type="text" name="begindatum" value="2017- 00:00:00" /><br>
            geef de einddatum JJJJ-MM-DD HH:MM:SS  : <input type="text" name="einddatum" value="2017- 24:00:00" /><br>
            <input type="submit" name="salesProfitInvoerName" value="salesProfitInvoer" />
        </form>

    </body>
</html>
