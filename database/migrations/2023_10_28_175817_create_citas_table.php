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
            $table->double('pago')->nullable();
            $table->text('observacion')->nullable();
            $table->time('hora')->nullable();
            $table->boolean('confirmar')->nullable();
            $table->boolean('multiuso')->nullable();
            $table->string('llego')->nullable();
            $table->string('entro')->nullable();
            
            $table->foreignId('multiuso_id')->nullable()->constrained('multiusos');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('paciente_id')->nullable();
            // $table->unsignedBigInteger('consultorio_id')->nullable();
            $table->unsignedBigInteger('medico_id')->nullable();
            $table->unsignedBigInteger('pago_tipo_id')->nullable();
            // $table->unsignedBigInteger('estado_id')->nullable();
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
