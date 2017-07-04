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
//        echo 'voorraadInvoer';
// categorie opgeven zodat per categorie kan worden gekeken
        ?>
        <form name="voorraadInvoer" action="voorraad.php" method="POST">
<!--                geef de begindatum JJJJ-MM-DD HH:MM:SS : <input type="text" name="begindatum" value="2016- 00:00:00" /><br>
            geef de einddatum JJJJ-MM-DD HH:MM:SS  : <input type="text" name="einddatum" value="2016- 24:00:00" /><br>-->
            <input type="submit" name="voorraadName" value="voorraad" />
        </form>
        <div class="container">
                <form name="index" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" value="1" name="zendform" />
                    <!--                    <div class="left">
                                            selecteer de locatie:<br> <select name="locatie[]" multiple="multiple" size='5' >
                    
                                            </select><br><br>
                                        </div>-->
                   
                    <div class="left">
                        selecteer reason: <br><select name="reason" size="12"  >
                            <?php
                            print " <option selected value=\" \"></option> ";
//                            while ($row = mysqli_fetch_assoc($resultcat)) {
                               // echo ("<option value=\"" . $reason["1"] . "\">" . $reason["stock.in.purchase"] . "</option>\n");
                                echo ("<option value = '1' >stock in purchase </option>\n");
                                echo ("<option value = '2' >stock in refund </option>\n");
                                echo ("<option value = '4' >stock in movement </option>\n");
                                echo ("<option value = '-1' >stock out sale </option>\n");
                                echo ("<option value = '-2' >stock out refund </option>\n");
                                echo ("<option value = '-3' >stock out break </option>\n");
                                echo ("<option value = '-4' >stock out movement </option>\n");
                                echo ("<option value = '-5' >stock out sample </option>\n");
                                echo ("<option value = '-6' >stock out free </option>\n");
                                echo ("<option value = '-7' >stock out used </option>\n");
                                echo ("<option value = '-8' >stock out subtract </option>\n");
                                
                                
                           // }
                            ?>
                        </select><br><br>
                    </div>
                    <div class="bottom">
                        <input type="submit" name="submit" value="selectie"/>
                    </div>
                </form>
            </div>
        <?php
        
        if (isset($_POST['zendform'])){
         $reason = $_POST['reason'];         
         echo "reason " . $reason;
        }
        ?>
        
    </body>
</html>
