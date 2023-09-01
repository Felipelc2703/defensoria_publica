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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('clave');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedBigInteger('centro_atencion_id')->nullable();
            $table->unsignedBigInteger('rol_id');
            $table->unsignedBigInteger('juez_id')->nullable();
            $table->foreignId('juzgado_id')->nullable()->constrained();
            $table->foreignId('consejero_id')->nullable()->constrained();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('centro_atencion_id')->references('id')->on('centros_atencion');
            $table->foreign('rol_id')->references('id')->on('roles');
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
        Schema::dropIfExists('users');
    }
};
