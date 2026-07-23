<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servidores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->string('proveedor', 120)->nullable();
            $table->string('host', 190)->nullable();
            $table->string('ip', 60)->nullable();
            $table->string('plan_hosting', 120)->nullable();
            $table->unsignedInteger('capacidad_sitios')->default(1);
            $table->string('estado', 30)->default('activo');
            $table->decimal('costo_anual', 10, 2)->default(0);
            $table->date('vencimiento')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servidores');
    }
};
