<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proovedor extends Model
{
    protected $table = 'proovedores';

    protected $fillable = [
        'id', 'contacto', 'telefono_contacto'
    ];

    public $timestamps = false;

    public function persona() {
        return $this->belongsTo(Persona::class);
    }
}
