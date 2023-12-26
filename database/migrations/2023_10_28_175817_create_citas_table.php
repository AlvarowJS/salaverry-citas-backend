<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->boolean('silla')->nullable();
            $table->string('pago')->nullable();
            $table->time('hora')->nullable();
            $table->boolean('confirmar')->nullable();
            $table->boolean('llego')->nullable();
            $table->boolean('entro')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('paciente_id')->nullable();
            $table->unsignedBigInteger('consultorio_id')->nullable();
            $table->unsignedBigInteger('medico_id')->nullable();
            $table->unsignedBigInteger('pago_tipo_id')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
