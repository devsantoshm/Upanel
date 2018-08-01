<?php

namespace Upanel;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $fillable = [
        'idproveedor',
        'udusuario',
        'tipo_comprobante',
        'num_comprobante',
        'serie_comprobante',
        'fecha_hora',
        'impuesto',
        'total',
        'estado',
        ];

    public function usuario() {
        return $this->belongsTo(User::class);
    }

    public function proveedor() {
        return $this->belongsTo(Proveedor::class);
    }
}
