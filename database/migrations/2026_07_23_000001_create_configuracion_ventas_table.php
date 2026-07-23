<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_ventas', function (Blueprint $table) {
            $table->id();
            $table->string('marca', 120)->default('MatrimonioWeb');
            $table->string('lema', 200)->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('hero_titulo', 200)->nullable();
            $table->text('hero_texto')->nullable();
            $table->timestamps();
        });

        // Fila unica de configuracion por defecto.
        DB::table('configuracion_ventas')->insert([
            'marca' => 'MatrimonioWeb',
            'lema' => 'Páginas web para matrimonios, hechas a la medida de su historia',
            'whatsapp' => '51987654321',
            'email' => 'contacto@matrimonioweb.com',
            'hero_titulo' => 'La web de su boda, de la invitación al último recuerdo',
            'hero_texto' => 'Diseñamos una página única con el dominio y los nombres de los novios, montada durante un año completo. Ubicación, invitación, recordatorios, ingreso con QR y las fotos compartidas del gran día en un solo lugar.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_ventas');
    }
};
