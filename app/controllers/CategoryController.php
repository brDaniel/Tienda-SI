<?php

namespace App\Controllers;

use App\Services\CategoryService;
use Leaf\Controller;


class CategoryController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data = CategoryService::getAll();
        if (!$data)
            response()->json(204);
        else
            response()->json($data, 200);
    }

    public function show($id)
    {
        $data = CategoryService::getById($id);
        if (!$data)
            response()->json(404);
        else
            response()->json($data, 200);
    }
    public function store()
    {
        $categoria = request()->get('categoria');
        $refrigerado = request()->get('refrigeracion');

        $data = [
            "categoria" => $categoria,
            "refrigerado" => $refrigerado
        ];
        $newCategory = CategoryService::newCategory($data);
        if (!$newCategory) {
            response()->json([], 409);
        } else {
            response()->json($newCategory, 201);
        }
    }
    public function update($id)
    {
        $categoria = request()->rawData('categoria');
        $refrigerado = request()->rawData('refrigeracion');
        $data = [
            $categoria,
            $refrigerado,
            $id
        ];
        $editedCategory = CategoryService::editCategory($data);
        if (!$editedCategory) {
            response()->json([], 409);
        } else {
            response()->json($editedCategory, 200);
        }
    }
    public function destroy($id)
    {
        $deletedCategory = CategoryService::deleteCategory($id);
        if(!$deletedCategory){
            response()->json([],404);
        }
        
        response()->json(204);
    }
}
