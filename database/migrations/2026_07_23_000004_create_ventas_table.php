<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('novios', 150);
            $table->string('contacto_nombre', 150)->nullable();
            $table->string('telefono', 40)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('plan', 120)->nullable();
            $table->decimal('precio', 10, 2)->default(0);
            $table->string('estado', 30)->default('cotizacion');
            $table->date('fecha_evento')->nullable();
            $table->string('dominio', 190)->nullable();
            $table->foreignId('servidor_id')->nullable()->constrained('servidores')->nullOnDelete();
            $table->date('hosting_inicio')->nullable();
            $table->date('hosting_fin')->nullable();
            $table->json('servicios')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
