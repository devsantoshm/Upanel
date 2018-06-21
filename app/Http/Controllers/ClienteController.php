<?php

namespace App\Http\Controllers;

use App\Persona;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == ''){
            $personas = Persona::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $personas = Persona::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }


        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

    public function store(Request $request) {
        if (!$request->ajax()) return redirect('/');

        Persona::create([
            'nombre' => $request->nombre,
            'tipo_documento' => $request->tipo_documento,
            'num_documento' => $request->num_documento,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
        ]);
    }

    public function update(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $persona = Persona::findOrFail($request->id);
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->num_documento = $request->num_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;

        $persona->save();
    }

}
