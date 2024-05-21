<?php
namespace App\Controllers;

use App\Services\ProductService;
use Leaf\Controller;

class ProductController extends Controller{
    public function index()
    {
        $data = ProductService::getAll();
        if(!$data)
            response()->json(204);
        response()->json($data, 200);
    }
    public function show($id){
        $data = ProductService::getById($id);
        if (!$data)
            response()->json(404);
        else
            response()->json($data, 200);
    }
    public function store(){
        $Producto = request()->get('Producto');
        $Caducidad = request()->get('Caducidad');
        $Lote = request()->get('Lote');
        $Stock = request()->get('Stock');
        $idProveedor = request()->get('idProveedor');
        $idCategoria = request()->get('idCategoria');
        $PrecioVenta = request()->get('PrecioCompra');
        $PrecioCompra = request()->get('PrecioVenta');
        $data = [
            $Producto,
            $Caducidad,
            $Lote,
            $Stock,
            $idProveedor,
            $idCategoria,
            $PrecioVenta,
            $PrecioCompra
        ];
        $newProduct = ProductService::newProduct($data);
        if (!$newProduct) {
            response()->json([], 409);
        } else {
            response()->json($newProduct, 201);
        }
        
    }
    public function destroy($id){
        response()->json(["MEssage"=>"no se puede eliminar el proveedor"]);

    }
    public function update($id){
        $Producto = request()->get('Producto');
        $Caducidad = request()->get('Caducidad');
        $Lote = request()->get('Lote');
        $Stock = request()->get('Stock');
        $idProveedor = request()->get('idProveedor');
        $idCategoria = request()->get('idCategoria');
        $PrecioVenta = request()->get('Curp');
        $PrecioCompra = request()->get('RFC');
        $data = [
            $Producto,
            $Caducidad,
            $Lote,
            $Stock,
            $idProveedor,
            $idCategoria,
            $PrecioVenta,
            $PrecioCompra,
            $id
        ];
        $newProduct = ProductService::editProduct($data);
        if (!$newProduct) {
            response()->json([], 409);
        } else {
            response()->json($newProduct, 201);
        }
    }
}