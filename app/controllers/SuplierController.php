<?php

namespace App\Controllers;

use Leaf\Controller;
use App\Services\SuplierService;

class SuplierController extends Controller
{
    public function index()
    {
        $data = SuplierService::getAll();
        if (!$data)
            response()->json(204);
        response()->json($data, 200);
    }
    public function show($id)
    {
        $data = SuplierService::getById($id);
        if (!$data)
            response()->json(404);
        else
            response()->json($data, 200);
    }
    public function store()
    {
        $nombre = request()->get('Nombre');
        $paterno = request()->get('Paterno');
        $materno = request()->get('Materno');
        $sexo = request()->get('Sexo');
        $direccion = request()->get('Direccion');
        $telefono = request()->get('Telefono');
        $curp = request()->get('Curp');
        $rfc = request()->get('RFC');
        $empresa = request()->get('Empresa');
        $data = [
            $nombre,
            $paterno,
            $materno,
            $sexo,
            $direccion,
            $telefono,
            $curp,
            $rfc,
            $empresa,
        ];
        $newSuplier = SuplierService::newSuplier($data);
        if (!$newSuplier) {
            response()->json([], 409);
        } else {
            response()->json($newSuplier, 201);
        }
    }
    public function destroy($id)
    {
        response()->json(["MEssage"=>"no se puede eliminar el proveedor"]);
    }
    public function update($id)
    {
        $nombre = request()->rawData('Nombre');
        $paterno = request()->rawData('Paterno');
        $materno = request()->rawData('Materno');
        $sexo = request()->rawData('Sexo');
        $direccion = request()->rawData('Direccion');
        $telefono = request()->rawData('Telefono');
        $curp = request()->rawData('Curp');
        $rfc = request()->rawData('RFC');
        $empresa = request()->rawData('Empresa');
        $data = [
            $nombre,
            $paterno,
            $materno,
            $sexo,
            $direccion,
            $telefono,
            $curp,
            $rfc,
            $empresa,
            $id
        ];
        $newCategory = SuplierService::editsuplier($data);
        if (!$newCategory) {
            response()->json([], 409);
        } else {
            response()->json($newCategory, 201);
        }
        
    }
}
