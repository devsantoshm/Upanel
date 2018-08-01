<?php

namespace Upanel;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $fillable = [
        'idcategoria','codigo','nombre','precio_venta','stock','descripcion','condicion'
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }
}
