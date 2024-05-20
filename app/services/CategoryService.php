<?php

namespace App\Services;

use Exception;

use App\Services\DB;

class CategoryService
{

    public static function getAll()
    {
        try {
            $conn = DB::openConnectionServices();
            $statement = "SELECT idCategoria, Categoria,Refrigeracion FROM Categorias";
            $getCategories = \sqlsrv_query($conn, $statement);
            $categories = [];
            if ($getCategories == FALSE)
                die(\sqlsrv_errors());

            while ($row = \sqlsrv_fetch_array($getCategories, SQLSRV_FETCH_ASSOC)) {
                $category = [
                    "idCategoria" => $row['idCategoria'],
                    "Categoria" => $row['Categoria'],
                    "Refrigerado" => $row['Refrigeracion']
                ];
                array_push($categories, $category);
            }
            \sqlsrv_free_stmt($getCategories);
            \sqlsrv_close($conn);
            return ["categories" => $categories];
        } catch (Exception $e) {
            return "Error";
        }
    }

    public static function getById(int $id)
    {
        try {
            $conn = DB::openConnectionServices();
            $statement = "SELECT idCategoria, Categoria, Refrigeracion FROM Categorias WHERE idCategoria = ?";
            $category;
            $getCategory = \sqlsrv_query($conn, $statement, [$id]);
            if ($getCategory === FALSE)
                die(FormatErros(\sqlsrv_errors()));

            if( sqlsrv_fetch( $getCategory) === false) {
                die( print_r( sqlsrv_errors(), true));
            }
            $idCategoria = \sqlsrv_get_field($getCategory,0);
            if($idCategoria ===false)
                return null;
            $category = [
                "idCategoria" => $idCategoria,
                "Categoria" => \sqlsrv_get_field($getCategory,1),
                "Refrigerado" => \sqlsrv_get_field($getCategory,2)
            ];
            
            \sqlsrv_free_stmt($getCategory);
            \sqlsrv_close($conn);
            return ["item"=>$category];
        } catch (Exception $e) {
            return "Error";
        }
    }

    public static function newCategory(array $data){
        // TODO: limpiar datos
        $category = $data['categoria'];
        $refrigerado = $data['refrigerado'];
        try{
            $message;
            $conn = DB::openConnectionServices();
            $query = "INSERT INTO Categorias (Categoria,Refrigeracion) VALUES(?,?)";
            $newCategory = \sqlsrv_query($conn,$query,[$category,$refrigerado]);
            if($newCategory)
                $message= ["message"=>"Categoria agregada!"];
            else
                die(print_r(\sqlsrv_errors(), true));  
            
            \sqlsrv_free_stmt($newCategory);
            \sqlsrv_close($conn); 
            return $message;

        }catch(Exception $e){
            return "Error";
        }
    }

    public static function editCategory(array $data){
        try {
            $conn = DB::openConnectionServices();
            $query = "UPDATE Categorias SET Categoria = ?, refrigeracion = ? WHERE idCategoria = ?";

            $updatedCategory = \sqlsrv_query($conn,$query,$data);
            if($updatedCategory){
                $message= ["message"=>"Categoria actualizada!"];
            }else{}
                die(print_r(\sqlsrv_errors(),true));
            }

            \sqlsrv_free_stmt($updatedCategory);
            \sqlsrv_close($conn); 
            return $message;
        } catch (Exeception $e) {
            return "Error";
        }   
    }

    public static function deleteCategory($id){
        try{
            $message;
            $conn = DB::openConnectionServices();
            $query = "DElETE Categorias WHERE idCategoria = ?";
            $deletedCategory = \sqlsrv_query($conn,$query,[$id]);
            if($deleteCategory===false){
                die(print_r(\sqlsrv_errors()));
            }else{
                
                $message = ["message"=>"Categoria eliminada"];
            }
            return $message;
        }catch(Exception $e){
            return "Error";
        }
    }
}
