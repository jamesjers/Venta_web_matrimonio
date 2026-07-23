<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planes_venta', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->string('subtitulo', 160)->nullable();
            $table->string('precio', 60)->default('A consultar');
            $table->boolean('destacado')->default(false);
            $table->json('caracteristicas')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        $now = now();
        DB::table('planes_venta')->insert([
            [
                'nombre' => 'Básico',
                'subtitulo' => 'Todo lo esencial para su boda',
                'precio' => 'S/ 199',
                'destacado' => false,
                'caracteristicas' => json_encode([
                    'Dominio con los nombres de los novios',
                    'Hosting incluido por 1 año',
                    'Invitación digital personalizada',
                    'Ubicación e itinerario',
                    'Confirmación de asistencia',
                    'Recordatorios por WhatsApp',
                    'Soporte por WhatsApp',
                ]),
                'orden' => 1,
                'activo' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre' => 'Premium',
                'subtitulo' => 'La experiencia completa, a su medida',
                'precio' => 'S/ 399',
                'destacado' => true,
                'caracteristicas' => json_encode([
                    'Todo lo del plan Básico',
                    'Control de ingreso con QR',
                    'Distribución de mesas',
                    'Fotos compartidas en vivo durante el evento',
                    'Recuerdos (fotos y videos de los invitados)',
                    'Diseño y visual 100% a medida',
                    'Servicios adicionales a solicitud',
                ]),
                'orden' => 2,
                'activo' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('planes_venta');
    }
};
