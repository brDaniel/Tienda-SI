<?php
namespace App\Services;

use Exception;
use App\Services\DB;

class ProductService{
    public static function getAll(){
        try {
            $conn = DB::openConnectionServices();
            $query = "SELECT p.idProducto,
                             p.Producto,
                             p.Caducidad,
                             p.Lote,
                             p.Stock,
                             p.PrecioVenta,
                             p.PrecioCompra,
                             ps.Empresa as Proveedor,
                             c.Categoria FROM Productos as p 
                             INNER JOIN Proveedores as ps ON ps.idProveedor=p.idProveedor
                             iNNER JOIN Categorias as c ON c.idCategoria = p.idCategoria";

            $getProducts = \sqlsrv_query($conn, $query);
            $products = [];
            if ($getProducts == FALSE)
                die(print_r(\sqlsrv_errors()));

            while ($row = \sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC)) {
                $product = [
                    "idProducto" => $row['idProducto'],
                    "Producto" => $row['Producto'],
                    "Caducidad" => $row['Caducidad'],
                    "Lote" => $row['Lote'],
                    "Stock" => $row['Stock'],
                    "PrecioVenta"=> $row['PrecioVenta'],
                    "PrecioCompra"=>$row['PrecioCompra'],
                    "Proveedor"=>$row['Proveedor'],
                    "Categoria"=>$row['Categoria']
                ];
                array_push($products, $product);
            }
            \sqlsrv_free_stmt($getProducts);
            \sqlsrv_close($conn);
            return ["categories" => $products];
        } catch (Exception $e) {
            return "Error";
        }
    }
    public static function getById($id){
        try{
            $product;
            $conn = DB::openConnectionServices();
            $query = "SELECT p.idProducto,
                            p.Producto,
                            p.Caducidad,
                            p.Lote,
                            p.Stock,
                            p.PrecioVenta,
                            p.PrecioCompra,
                            ps.Empresa as Proveedor,
                            c.Categoria FROM Productos as p 
                            INNER JOIN Proveedores as ps ON ps.idProveedor=p.idProveedor
                            iNNER JOIN Categorias as c ON c.idCategoria = p.idCategoria WHERE p.idProducto = ?";
            $getProduct = \sqlsrv_query($conn, $query, [$id]);
            if ($getProduct === FALSE)
                die(print_r(\sqlsrv_errors()));
    
            if( sqlsrv_fetch( $getProduct) === false) {
                die( print_r( sqlsrv_errors(), true));
            }
            $idProduct = \sqlsrv_get_field($getProduct,0);
    
            if($idProduct ===false)
                return null;
            $product = [
                "idProducto" => $idProduct,
                "Producto" => \sqlsrv_get_field($getProduct,1),
                "Caducidad" => \sqlsrv_get_field($getProduct,2),
                "Lote" => \sqlsrv_get_field($getProduct,3),
                "Stock" => \sqlsrv_get_field($getProduct,4),
                "PrecioVenta"=> \sqlsrv_get_field($getProduct,5),
                "PrecioCompra"=> \sqlsrv_get_field($getProduct,6),
                "Proveedor"=> \sqlsrv_get_field($getProduct,7),
                "Categoria"=> \sqlsrv_get_field($getProduct,8)
            ];
            \sqlsrv_free_stmt($getProduct);
            \sqlsrv_close($conn);
            return ["item"=>$product];
        }catch(Exception $e){
            return "Error";
        }

    }
    public static function newProduct(array $data){
        try{
            $message;
            $conn = DB::openConnectionServices();
            $query = "INSERT INTO Productos (Producto,Caducidad,Lote,Stock,idProveedor,idCategoria,PrecioVenta,PrecioCompra) 
                    VALUES(?,?,?,?,?,?,?,?)";
            $newProduct = \sqlsrv_query($conn,$query,$data);
            if($newProduct)
                $message= ["message"=>"Producto agergado!"];
            else
                die(print_r(\sqlsrv_errors(), true));  
            
            \sqlsrv_free_stmt($newProduct);
            \sqlsrv_close($conn); 
            return $message;

        }catch(Exception $e){
            return "Error";
        }
    }
    public static function editProduct(arry $data){
        try{
            $message;
            $conn = DB::openConnectionServices();
            $query = "UPDATE Prtoductos SET Producto=?,Caducidad=?,Lote=?,Stock=?,idProveedor=?,idCategoria=?,PrecioVenta=?,PrecioCompra=? WHERE idProducto =?";
            $updatedProduct = \sqlserv_query($conn,$query,$data);
            if($updatedProduct){
                $message= ["message"=>"Producto actualizado!"];
            }else{
                die(print_r(\sqlsrv_errors(),true));
            }
            \sqlsrv_free_stmt($updatedCategory);
            \sqlsrv_close($conn); 
            return $message;
        }catch(Exception $e){
            return "ERROR";
        }
    }

}
?>