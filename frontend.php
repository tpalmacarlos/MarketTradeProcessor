<?php

/*
 * Load up data and render Google graph
 */
$link = mysqli_connect( "localhost", "root", "", "markettradeprocessor_local" );
if( mysqli_connect_errno() ) {
    die( "Could not connect: " . mysql_error() );
}

$sql = "SELECT currencyFrom, count, sum FROM stats";

$result = $link->query( $sql );

if( $result->num_rows > 0 ) {
    // output data of each row
    while( $row = $result->fetch_assoc() ) {
        $data1 .= "['" . $row["currencyFrom"] . "', " . $row["count"] . "],";
        $data2 .= "['" . $row["currencyFrom"] . "', " . $row["sum"] . "],";
    }
    $data1 = rtrim( $data1, ',' );
    $data2 = rtrim( $data2, ',' );
} else {
    echo "0 results"; exit;
}
mysqli_close($link);


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cool stats</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {

            var data1 = google.visualization.arrayToDataTable([
                ['Currency', 'Number of Tx'],
                <?=$data1?>
              
            ]);

            var options1 = {
              title: 'Number of sales per currency'
            };

            var chart1 = new google.visualization.PieChart(document.getElementById('piechart1'));

            chart1.draw(data1, options1);
            
            var data2 = google.visualization.arrayToDataTable([
                ['Currency', 'Amount of Tx'],
                <?=$data2?>
              
            ]);

            var options2 = {
              title: 'Amount of sales per currency'
            };

            var chart2 = new google.visualization.PieChart(document.getElementById('piechart2'));

            chart2.draw(data2, options2);
          }
        </script>
    </head>
    <body>
        <div id="piechart1" style="width: 900px; height: 500px;"></div>
        <div id="piechart2" style="width: 900px; height: 500px;"></div>
    </body>
</html>
