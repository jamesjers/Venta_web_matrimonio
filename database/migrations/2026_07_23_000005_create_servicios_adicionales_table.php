<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicios_adicionales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 190);
            $table->string('precio', 80)->default('A consultar');
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        $now = now();
        $servicios = [
            ['50 invitados adicionales', '$90.000 COP'],
            ['100 invitados adicionales', '$150.000 COP'],
            ['Carga inicial de invitados', 'Desde $120.000 COP'],
            ['Organización completa de mesas', 'Desde $250.000 COP'],
            ['1.000 fotografías adicionales', '$120.000 COP'],
            ['Activación de carga de videos', '$250.000 COP'],
            ['Diseño exclusivo desde cero', 'Desde $300.000 COP'],
            ['Soporte remoto durante el evento', '$250.000 COP'],
            ['Soporte presencial hasta cuatro horas', 'Desde $650.000 COP'],
            ['Operador para moderación de fotografías', 'Desde $350.000 COP'],
            ['Renovación anual de dominio y alojamiento', 'Desde $350.000 COP'],
        ];

        foreach ($servicios as $i => [$nombre, $precio]) {
            DB::table('servicios_adicionales')->insert([
                'nombre' => $nombre,
                'precio' => $precio,
                'orden' => $i + 1,
                'activo' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('servicios_adicionales');
    }
};
