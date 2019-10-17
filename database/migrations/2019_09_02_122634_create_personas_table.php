<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('tipo_documento',20);
            $table->string('num_documento',15);
            $table->string('nombre',100)->nullable();
            $table->string('razon_social',100)->nullable();
            $table->string('direccion',70)->nullable();
            $table->string('telefono',12)->nullable();
            $table->string('correo',100)->nullable();
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
        Schema::dropIfExists('personas');
    }
}
