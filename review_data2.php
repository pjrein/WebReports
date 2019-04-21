<?php
// Start MySQL Verbinding
include('dbconnect.php');
?>

<html>
    <head>
        <title>Arduino Temperature Log</title>
        <style type="text/css">           
            body { font-family: "Trebuchet MS", Arial; }
        </style>
        <link rel="stylesheet" href="css/tabel-style.css">
    </head>

    <body>
        <h1>Arduino Temperature Log</h1>
        <table class="fixed_headers">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date and Time</th>
                    <th>Sensor Serial</th>
                    <th>Celsius</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve all records and display them
                $result = mysqli_query($dbh, "SELECT * FROM temperature ORDER BY id ASC");
                
                    while ($row = mysqli_fetch_array($result)) {
                    echo '<tr>';
                    echo '   <td>' . $row["id"] . '</td>';
                    echo '   <td>' . $row["event"] . '</td>';
                    echo '   <td>' . $row["sensor"] . '</td>';
                    echo '   <td>' . $row["celsius"] . '</td>';
                }
                ?>
            </tbody>
        </table>
    </body>
</html>