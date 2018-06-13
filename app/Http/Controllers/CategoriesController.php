<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index() {
        $categorias = Categoria::all();
        return $categorias;
    }

    public function store(Request $request) {
        Categoria::create([
            'nombre' => $request->name,
            'descripcion' => $request->descripcion,
            'condicion' => '1'
        ]);
    }

    public function update(Request $request) {
        $categoria = Categoria::findOrFail($request->id);

        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        $categoria->save();
    }

    public function desactivar(Request $request) {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion = '0';
        $categoria->save();
    }

    public function activar(Request $request) {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion = '1';
        $categoria->save();
    }
}
