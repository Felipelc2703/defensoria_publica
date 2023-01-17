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
        Schema::create('whatsapp', function (Blueprint $table) {
            $table->id();
            $table->string('telefono', 10);
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->boolean('dia1')->default(0);
            $table->boolean('dia2')->default(0);
            $table->boolean('dia3')->default(0);
            $table->boolean('dia4')->default(0);
            $table->boolean('dia5')->default(0);
            $table->boolean('dia6')->default(0);
            $table->boolean('dia7')->default(0);
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
        Schema::dropIfExists('whatsapp');
    }
};
