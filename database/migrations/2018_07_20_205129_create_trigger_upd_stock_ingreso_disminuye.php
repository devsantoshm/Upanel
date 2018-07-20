<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerUpdStockIngresoDisminuye extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER tr_updStockIngreso AFTER INSERT ON detalle_ingresos
        FOR EACH ROW BEGIN
        UPDATE articulos SET stock = stock + NEW.cantidad
        WHERE articulos.id = NEW.idarticulo;
        END

        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
