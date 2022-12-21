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
        Schema::create('requisito_tramite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requisito_id')->constrained();
            $table->foreignId('tramite_id')->constrained();
            $table->boolean('obligatorio')->default(false);
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
        Schema::dropIfExists('requisito_tramite');
    }
};
