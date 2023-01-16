<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->date('fecha_cita');
            $table->string('fecha_formateada');
            $table->time('hora_cita');
            $table->string('nombre');
            $table->string('email');
            $table->string('telefono');
            $table->string('sexo');
            $table->boolean('tiene_discapacidad');
            $table->string('discapacidad')->nullable();
            $table->integer('status')->default(1);
            $table->foreignId('tramite_id')->constrained();
            $table->unsignedBigInteger('centro_atencion_id');
            $table->timestamps();
            
            $table->foreign('centro_atencion_id')->references('id')->on('centros_atencion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citas');
    }
};
