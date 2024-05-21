<?php

namespace App\Services;

use Leaf\Controller;

class SuplierService extends Controller{
    public function __construct()
    {
        
    }
    public static function getAll(){
        try {
            $conn = DB::openConnectionServices();
            $statement = "SELECT pr.idProveedor,pe.Nombre, pe.Paterno, pe.Materno,pe.Direccion,pe.Telefono,pr.Empresa
            FROM Proveedores as pr INNER JOIN Personas AS pe ON pr.idPersona = pe.idPersona";
            $getSupliers = \sqlsrv_query($conn, $statement);
            $supliers = [];
            if ($getSupliers == FALSE)
                die(print_r(\sqlsrv_errors()));

            while ($row = \sqlsrv_fetch_array($getSupliers, SQLSRV_FETCH_ASSOC)) {
                $suplier = [
                    "idProveedor" => $row['idProveedor'],
                    "Nombre" => $row['Nombre']." ".$row['Paterno']." ".$row['Materno'],
                    "Direccion" => $row['Direccion'],
                    "Telefono" => $row['Telefono'],
                    "Empresa" => $row['Empresa']
                ];
                array_push($supliers, $suplier);
            }
            \sqlsrv_free_stmt($getSupliers);
            \sqlsrv_close($conn);
            return ["categories" => $supliers];
        } catch (Exception $e) {
            return "Error";
        }

    }
    public static function getById(int $id)
    {
        try {
            $conn = DB::openConnectionServices();
            $statement = "SELECT pr.idProveedor,pe.Nombre, pe.Paterno, pe.Materno,pe.Direccion,pe.Telefono,pr.Empresa
            FROM Proveedores as pr INNER JOIN Personas AS pe ON pr.idPersona = pe.idPersona WHERE pr.idProveedor = ?";
            $suplier;
            $getSuplier = \sqlsrv_query($conn, $statement, [$id]);
            if ($getSuplier === FALSE)
                die(FormatErros(\sqlsrv_errors()));

            if( sqlsrv_fetch( $getSuplier) === false) {
                die( print_r( sqlsrv_errors(), true));
            }
            $idSuplier = \sqlsrv_get_field($getSuplier,0);

            if($idSuplier ===false)
                return null;
            $suplier = [
                "idProveedor"=> $idSuplier,
                "Nombre" => \sqlsrv_get_field($getSuplier,1),
                "Paterno" => \sqlsrv_get_field($getSuplier,2),
                "Materno" => \sqlsrv_get_field($getSuplier,3),
                "Direccion" => \sqlsrv_get_field($getSuplier,4),
                "Telefono" => \sqlsrv_get_field($getSuplier,5),
                "Empresa" => \sqlsrv_get_field($getSuplier,6)

            ];
            
            \sqlsrv_free_stmt($getSuplier);
            \sqlsrv_close($conn);
            return ["item"=>$suplier];
        } catch (Exception $e) {
            return "Error";
        }
    }

    public static function newSuplier(array $data){       
        try{
            $message;
            $conn = DB::openConnectionServices();
            $query = "EXEC sp_AgregarProveedor ?,?,?,?,?,?,?,?,?";
            $newSuplier = \sqlsrv_query($conn,$query,$data);
            if($newSuplier)
                $message= ["message"=>"Proveedor agregado!"];
            else
                die(print_r(\sqlsrv_errors(), true));  
            
            \sqlsrv_free_stmt($newSuplier);
            \sqlsrv_close($conn); 
            return $message;

        }catch(Exception $e){
            return "Error";
        }
    }

    public static function editsuplier(array $data){
        try {
            $conn = DB::openConnectionServices();
            $query = "exec sp_ActualizarProveedor ?,?,?,?,?,?,?,?,?,?";

            $updatedSuplier = \sqlsrv_query($conn,$query,$data);
            if($updatedSuplier ){
                $message= ["message"=>"Proveedor actualizado!"];
            }else{
                die(print_r(\sqlsrv_errors(),true));
            }

            \sqlsrv_free_stmt($updatedSuplier);
            \sqlsrv_close($conn); 
            return $message;
        } catch (Exception $e) {
            return "Error";
        }   
    }

    public static function deletesuplier($id){
        try{
            $message;
            $conn = DB::openConnectionServices();
            $query = "sp_DeleteProveeedor(?)";
            $deletedsuplier = \sqlsrv_query($conn,$query,[$id]);
            if($deletesuplier===false){
                die(print_r(\sqlsrv_errors()));
            }else{
                $message = ["message"=>"Proveedor eliminado"];
            }
            return $message;
        }catch(Exception $e){
            return "Error";
        }
    }

}
?>