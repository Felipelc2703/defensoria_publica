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
        Schema::create('citas_consejeros', function (Blueprint $table) {
            $table->id();
            $table->integer('consecutivo');
            $table->year('anio');
            $table->string('folio');
            $table->date('fecha_cita');
            $table->string('fecha_formateada');
            $table->time('hora_cita');
            $table->string('expediente')->nullable();
            $table->string('asunto');
            $table->integer('status')->default(1);
            $table->string('motivo')->nullable();
            $table->foreignId('usuario_id')->constrained();
            $table->foreignId('consejero_id')->nullable()->constrained();
            // $table->unsignedBigInteger('juez_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citas_consejeros');
    }
};
