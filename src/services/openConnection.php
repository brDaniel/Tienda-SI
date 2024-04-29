<?php

function openConnection(){
    $serverName = "tiendadb";
    $connectionOptions = array(
        "Database" => "tienda",
        "Uid" => "sa",
        "PWD" => "Passw0rd!"
    );

    // Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if (!$conn) {
        die(print_r(sqlsrv_errors(), true));
    }

    return $conn;
}
?>
