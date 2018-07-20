<?php

namespace App\Http\Controllers;

use App\Articulo;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    public function index(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
                ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
                ->orderBy('articulos.id', 'desc')
                ->paginate(3);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
                ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
                ->where('articulos.'.$criterio, 'like', '%' . $buscar . '%')
                ->orderBy('articulos.id', 'desc')
                ->paginate(3);
        }


        return [
            'pagination' => [
                'total'        => $articulos->total(),
                'current_page' => $articulos->currentPage(),
                'per_page'     => $articulos->perPage(),
                'last_page'    => $articulos->lastPage(),
                'from'         => $articulos->firstItem(),
                'to'           => $articulos->lastItem(),
            ],
            'articulos' => $articulos
        ];
    }

    public function listarArticulo(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
                ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
                ->orderBy('articulos.id', 'desc')
                ->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
                ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
                ->where('articulos.'.$criterio, 'like', '%' . $buscar . '%')
                ->orderBy('articulos.id', 'desc')
                ->paginate(10);
        }


        return [
            'articulos' => $articulos
        ];
    }

    public function listarArticuloVenta(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
                ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
                ->where('articulos.stock', '>', '0')
                ->orderBy('articulos.id', 'desc')
                ->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
                ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
                ->where('articulos.'.$criterio, 'like', '%' . $buscar . '%')
                ->where('articulos.stock', '>', '0')
                ->orderBy('articulos.id', 'desc')
                ->paginate(10);
        }


        return [
            'articulos' => $articulos
        ];
    }


    public function buscarArticulo(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo', '=', $filtro)
            ->select('id', 'nombre')
            ->orderBy('nombre', 'asc')
            ->take(1)
            ->get();

        return [
            'articulos' => $articulos
        ];
    }

    public function buscarArticuloVenta(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo', '=', $filtro)
            ->select(
                'id',
                'nombre',
                'stock',
                'precio_venta'
            )
            ->where('stock', '>', '0')
            ->orderBy('nombre', 'asc')
            ->take(1)
            ->get();

        return [
            'articulos' => $articulos
        ];
    }

    public function store(Request $request) {
        if (!$request->ajax()) return redirect('/');

        Articulo::create([
            'idcategoria' => $request->idcategoria,
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'precio_venta' => $request->precio_venta,
            'stock' => $request->stock,
            'descripcion' => $request->descripcion,
            'condicion' => '1',
        ]);
    }

    public function update(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $articulos = Articulo::findOrFail($request->id);

            $articulos->idcategoria = $request->idcategoria;
            $articulos->codigo = $request->codigo;
            $articulos->nombre = $request->nombre;
            $articulos->precio_venta = $request->precio_venta;
            $articulos->stock = $request->stock;
            $articulos->descripcion = $request->descripcion;
            $articulos->condicion = '1';
            $articulos->save();
    }

    public function desactivar(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $articulos = Articulo::findOrFail($request->id);
        $articulos->condicion = '0';
        $articulos->save();
    }

    public function activar(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $articulos = Articulo::findOrFail($request->id);
        $articulos->condicion = '1';
        $articulos->save();
    }

}
