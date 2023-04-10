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
        Schema::create('citas_juzgados', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->date('fecha_cita');
            $table->string('fecha_formateada');
            $table->time('hora_cita');
            $table->string('expediente');
            $table->string('asunto');
            $table->string('nombre');
            $table->string('curp');
            $table->string('email');
            $table->string('telefono');
            $table->string('sexo');
            $table->integer('status')->default(1);
            $table->string('motivo')->nullable();
            $table->foreignId('juzgado_id')->nullable()->constrained();
            $table->unsignedBigInteger('juez_id')->nullable();
            $table->timestamps();

            $table->foreign('juez_id')->references('id')->on('jueces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citas_juzgados');
    }
};
