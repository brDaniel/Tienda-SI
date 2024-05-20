<?php
namespace App\Services;
class DB{


    public static function openConnectionServices(){
        $serverName = "tiendadb";
        $connectionOptions = array(
            "Database" => "Abarrotera",
            "Uid" => "sa",
            "PWD" => "Passw0rd!"
        );
    
        // Establishes the connection
        $conn = \sqlsrv_connect($serverName, $connectionOptions);
    
        if (!$conn) {
            die(print_r(\sqlsrv_errors(), true));
        }
    
        return $conn;
    }
}
?>
