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
        Schema::create('centros_atencion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 75);
            $table->string('direccion', 250);
            $table->string('telefono', 50)->nullable();
            $table->integer('numero_cajas')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('centros_atencion');
    }
};
