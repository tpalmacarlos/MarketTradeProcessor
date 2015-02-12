<?php

/**
 * To do: Set some filters/security here
 */

/**
 * Unpack JSON data
 */
$data = json_decode($_GET["tx"]);

/**
 * To do: Set some filters/security here
 */

/**
 * Add data to database
 */
$link = mysqli_connect( "localhost", "root", "", "markettradeprocessor_local" );
if( mysqli_connect_errno() ) {
    die( "Could not connect: " . mysql_error() );
}
//var_dump($data);
$data->timePlaced = date( "Y-m-d h:i:s", strtotime( $data->timePlaced ) );

$sql = "INSERT INTO tx (userId, currencyFrom, currencyTo, amountSell, amountBuy, rate, timePlaced, originatingCountry) VALUES ('" .
        $data->userId . "', '" . $data->currencyFrom . "', '" . $data->currencyTo . "', '" . $data->amountSell . "', '" . 
        $data->amountBuy . "', '" . $data->rate . "', '" . $data->timePlaced . "', '" . $data->originatingCountry . "')";

if( !mysqli_query( $link, $sql ) ) {
    die( "Error description: " . mysqli_error( $link ) );
}

mysqli_close($link);

?>


OK