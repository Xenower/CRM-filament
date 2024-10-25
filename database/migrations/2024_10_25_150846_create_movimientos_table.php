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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_propietario')->nullable();
            $table->string('nombre', 50);
            $table->decimal('monto_ingreso', 12, 2)->nullable();
            $table->decimal('monto_total', 12, 2)->nullable();
            $table->dateTime('fecha_actualizacion')->nullable();
            $table->decimal('total_depositos', 12, 2)->nullable();
            $table->decimal('total_retiros', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
