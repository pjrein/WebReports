<!DOCTYPE html>
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
        $sql = "SELECT YEAR(receipts.DATENEW) AS YR , MONTH(receipts.DATENEW) as MON , ROUND(SUM(taxlines.BASE)) AS Total 
                    FROM taxlines, receipts 
                    WHERE receipts.ID = taxlines.RECEIPT and year(receipts.DATENEW) = '" . $_POST["jaar"] . "' group by yr,MON order by yr,MON ;";

        $con = my_conn();
        $result = mysqli_query($con, $sql);
        ?>
        <!--<h2> maandOmzet </h2>-->
        <h3>maandomzet <?php echo $_POST["jaar"]; ?>  </h3>   

        <table> 
            <tr> 
                <td><strong>Jaar</strong></td> 
                <td><strong>Maand</strong></td> 
                <td><strong>Monthly Sub Total</strong></td>

                <td></td>
            </tr>
            <!--</table>-->

            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo("<tr>\n<td>" . $row["YR"] . "</td> ");
                echo("<td>" . $row["MON"] . "</td>");
                echo("<td>" . $row["Total"] . "</td>");
            }
            ?>

        </table> 

        
        <form name="hoofdmenu" action="maandOmzetInvoer.php" method="POST">
            <input type="submit" value="maandOmzetInvoer" />
        </form>
        <form name="hoofdmenu" action="index.php" method="POST">
            <input type="submit" value="hoofdmenu" />
        </form>

    </body>
</html>
