<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('idcategoria')->unsigned();
            $table->foreign('idcategoria')->references('id')->on('categorias');
            $table->string('codigo',20);
            $table->string('descripcion',50);
            $table->string('unidad_medida',4);
            $table->decimal('stock',11,1);
            $table->decimal('precio_compra',11,2);
            $table->decimal('precio_venta',11,2);
            $table->string('ruta',100);
            $table->boolean('estado')->default(1);
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
