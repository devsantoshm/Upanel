<?php

namespace Upanel\Http\Controllers;

use Upanel\DetalleVenta;
use Upanel\Notifications\NotifyAdmin;
use Upanel\User;
use Upanel\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == ''){
            $ventas = Venta::join('personas', 'ventas.idcliente', '=', 'personas.id')
                ->join('users', 'ventas.idusuario', '=', 'users.id')
                ->select(
                    'ventas.id',
                    'ventas.tipo_comprobante',
                    'ventas.serie_comprobante',
                    'ventas.num_comprobante',
                    'ventas.created_at',
                    'ventas.impuesto',
                    'ventas.total',
                    'ventas.estado',
                    'personas.nombre',
                    'users.usuario')
                ->orderBy('ventas.id', 'desc')
                ->paginate(3);
        }
        else{
            $ventas = Venta::join('personas', 'ventas.idcliente', '=', 'personas.id')
                ->join('users', 'ventas.idusuario', '=', 'users.id')
                ->select(
                    'ventas.id',
                    'ventas.tipo_comprobante',
                    'ventas.serie_comprobante',
                    'ventas.num_comprobante',
                    'ventas.created_at',
                    'ventas.impuesto',
                    'ventas.total',
                    'ventas.estado',
                    'personas.nombre',
                    'users.usuario')
                ->where('ventas.'.$criterio, 'like', '%'. $buscar . '%')
                ->orderBy('ventas.id', 'desc')
                ->paginate(3);
        }

        return [
            'pagination' => [
                'total'        => $ventas->total(),
                'current_page' => $ventas->currentPage(),
                'per_page'     => $ventas->perPage(),
                'last_page'    => $ventas->lastPage(),
                'from'         => $ventas->firstItem(),
                'to'           => $ventas->lastItem(),
            ],
            'ventas' => $ventas
        ];
    }

    public function obtenerCabecera(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;

        $venta = Venta::join('personas', 'ventas.idcliente', '=', 'personas.id')
            ->join('users', 'ventas.idusuario', '=', 'users.id')
            ->select(
                'ventas.id',
                'ventas.tipo_comprobante',
                'ventas.serie_comprobante',
                'ventas.num_comprobante',
                'ventas.created_at',
                'ventas.impuesto',
                'ventas.total',
                'ventas.estado',
                'personas.nombre',
                'users.usuario')
            ->where('ventas.id', '=', $id)
            ->orderBy('ventas.id', 'desc')
            ->take(1)
            ->get();

        return [
            'venta' => $venta
        ];
    }

    public function listarPdf () {

        $ventas = Venta::join('personas', 'ventas.idcliente', '=', 'personas.id')
            ->join('users', 'ventas.idusuario', '=', 'users.id')
            ->select(
                'ventas.id',
                'ventas.tipo_comprobante',
                'ventas.serie_comprobante',
                'ventas.num_comprobante',
                'ventas.created_at',
                'ventas.impuesto',
                'ventas.total',
                'ventas.estado',
                'personas.nombre',
                'users.usuario')
            ->orderBy('ventas.id', 'desc')
            ->get();

        $cont = Venta::count();

        $pdf = \PDF::loadView('pdf.ventaspdf', [
            'ventas' => $ventas,
            'cont' => $cont,
        ]);

        return $pdf->download('ventas.pdf');
    }

    public function obtenerDetalles(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;

        $detalles = DetalleVenta::join('articulos', 'detalle_ventas.idarticulo', '=', 'articulos.id')
            ->select(
                'detalle_ventas.cantidad',
                'detalle_ventas.precio',
                'detalle_ventas.descuento',
                'articulos.nombre as articulo'
            )
            ->where('detalle_ventas.idventa', '=', $id)
            ->orderBy('detalle_ventas.id', 'desc')
            ->get();

        return [
            'detalles' => $detalles
        ];
    }

    public function pdf(Request $request, $id) {

        $venta = Venta::join(
            'personas',
            'ventas.idcliente',
            '=',
            'personas.id'
        )
            ->join(
                'users',
                'ventas.idusuario',
                '=',
                'users.id'
            )
            ->select(
                'ventas.id',
                'ventas.tipo_comprobante',
                'ventas.serie_comprobante',
                'ventas.num_comprobante',
                'ventas.created_at',
                'ventas.impuesto',
                'ventas.total',
                'ventas.estado',
                'personas.nombre',
                'personas.tipo_documento',
                'personas.num_documento',
                'personas.direccion',
                'personas.email',
                'personas.telefono',
                'users.usuario'
            )
            ->where(
                'ventas.id',
                '=',
                $id
            )
            ->orderBy('ventas.id', 'desc')
            ->take('1')
            ->get();

        $detalles = DetalleVenta::join('articulos', 'detalle_ventas.idarticulo', '=', 'articulos.id')
            ->select(
                'detalle_ventas.cantidad',
                'detalle_ventas.precio',
                'detalle_ventas.descuento',
                'articulos.nombre as articulo'
            )
            ->where('detalle_ventas.idventa', '=', $id)
            ->orderBy('detalle_ventas.id', 'desc')
            ->get();

        $numVenta = Venta::select('num_comprobante')->where('id', $id)->get();

        $pdf = \PDF::loadView('pdf.venta', [
            'venta' => $venta,
            'detalles' => $detalles,
        ]);

        return $pdf->download('venta-'.$numVenta[0]->num_comprobante.'.pdf');
    }

    public function store(Request $request) {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $venta = new Venta();
            $venta->idcliente = $request->idcliente;
            $venta->idusuario = \Auth::user()->id;
            $venta->tipo_comprobante = $request->tipo_comprobante;
            $venta->serie_comprobante = $request->serie_comprobante;
            $venta->num_comprobante = $request->num_comprobante;
            $venta->impuesto = $request->impuesto;
            $venta->total = $request->total;
            $venta->estado = 'Registrado';
            $venta->save();

            $detalles = $request->data;

            foreach($detalles as $ep => $det)
            {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->id;
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];
                $detalle->descuento = $det['descuento'];
                $detalle->save();
            }

            $fechaActual = date('Y-m-d');

            $numventas = DB::table('ventas')->whereDate('created_at', $fechaActual)->count();
            $numIngresos = DB::table('ingresos')->whereDate('created_at', $fechaActual)->count();

            $arregloDatos = [
                'ventas' => [
                    'numero' => $numventas,
                    'msj' => 'ventas',
                ],
                'ingresos' => [
                    'numero' => $numIngresos,
                    'msj' => 'Ingresos'
                ]
            ];

            $allUsers = User::all();

            foreach ($allUsers as $n) {
                User::findOrFail($n->id)->notify( new NotifyAdmin($arregloDatos));
            }

            DB::commit();
            return [
                'id' => $venta->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request) {
        if (!$request->ajax()) return redirect('/');
        $venta = Venta::findOrFail($request->id);
        $venta->estado = 'Anulado';
        $venta->save();
    }
}
