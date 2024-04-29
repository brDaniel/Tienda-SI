<?php
// $route = explode('/', $_SERVER['REQUEST_URI']);
require_once "./services/openConnection.php";
$conn = openConnection();

$statement = "SELECT id_producto, producto FROM Productos";
$getProducts = sqlsrv_query($conn,$statement);

while($row = sqlsrv_fetch_array($getProducts,SQLSRV_FETCH_ASSOC)){
    echo($row['id_producto']."::".$row['producto']);
    echo("<br/>");

}