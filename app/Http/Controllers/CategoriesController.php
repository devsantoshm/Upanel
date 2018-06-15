<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $categorias = Categoria::all();
        return $categorias;
    }

    public function store(Request $request) {
        if (!$request->ajax()) return redirect('/');

        Categoria::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'condicion' => '1'
        ]);
    }

    public function update(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $categoria = Categoria::findOrFail($request->id);

        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        $categoria->save();
    }

    public function desactivar(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion = '0';
        $categoria->save();
    }

    public function activar(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion = '1';
        $categoria->save();
    }
}
