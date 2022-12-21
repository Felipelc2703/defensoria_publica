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
        Schema::create('tramite_centro', function (Blueprint $table) {
            $table->id();
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
        Schema::dropIfExists('tramite_centro');
    }
};
