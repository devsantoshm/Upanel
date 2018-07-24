<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request) {

        $anio = date('Y');

        $ingresos = DB::table('ingresos as i')->select(
            DB::raw('MONTH(i.created_at) as mes'),
            DB::raw('YEAR(i.created_at) as anio'),
            DB::raw('SUM(i.total) as total')
        )
        ->whereYear('i.created_at', $anio)
        ->groupBy(DB::raw('MONTH(i.created_at)'),
            DB::raw('YEAR(i.created_at)'
            ))
        ->get();

        return [
            'ingresos' => $ingresos,
            'anio' => $anio,
        ];
    }
}
