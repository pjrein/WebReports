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
        echo 'vanuit maandOmzetInvoer';
        ?>
        <form name="maandOmzetInvoer" action="maandOmzet.php" method="POST">
            geef het jaar op JJJJ: <input type="text" name="jaar" value="20" /><br>
        <!--geef de einddatum JJJJ-MM-DD HH:MM:SS  : <input type="text" name="einddatum" value="2016- 24:00:00" /><br>-->
            <input type="submit" name="maandOmzetInvoer" value="maandOmzetInvoer" />
        </form>


    </body>
</html>
