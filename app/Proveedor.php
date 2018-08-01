<?php

namespace Upanel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'id', 'contacto', 'telefono_contacto'
    ];

    public $timestamps = false;

    public function persona() {
        return $this->belongsTo(Persona::class);
    }
}
