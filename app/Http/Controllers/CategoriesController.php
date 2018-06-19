<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use function PHPSTORM_META\elementType;

class CategoriesController extends Controller
{
    public function index(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == ''){
            $categorias = Categoria::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $categorias = Categoria::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }


        return [
            'pagination' => [
                'total'        => $categorias->total(),
                'current_page' => $categorias->currentPage(),
                'per_page'     => $categorias->perPage(),
                'last_page'    => $categorias->lastPage(),
                'from'         => $categorias->firstItem(),
                'to'           => $categorias->lastItem(),
            ],
            'categorias' => $categorias
        ];
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
