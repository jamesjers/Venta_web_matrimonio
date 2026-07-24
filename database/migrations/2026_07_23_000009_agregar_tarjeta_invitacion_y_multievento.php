<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Nuevo producto de entrada: Tarjeta de Invitación con panel propio ($349.000).
        if (! DB::table('planes_venta')->where('nombre', 'Tarjeta de Invitación')->exists()) {
            DB::table('planes_venta')->insert([
                'nombre' => 'Tarjeta de Invitación',
                'subtitulo' => 'Tu invitación digital con panel propio',
                'descripcion' => 'La tarjeta de invitación con dominio propio y un panel de control exclusivo para revisar el estado de las confirmaciones de esa invitación.',
                'precio' => '$349.000 COP',
                'destacado' => false,
                'caracteristicas' => json_encode([
                    'Tarjeta de invitación digital a la medida del evento',
                    'Dominio propio con el nombre del evento',
                    'Panel de control exclusivo de la tarjeta',
                    'Revisión del estado de las invitaciones (confirmaciones)',
                    'Confirmación de asistencia en un clic',
                    'Música, historia y detalles en la tarjeta',
                    'Ubicación con mapa e itinerario',
                    'Código de vestimenta y opciones de regalo',
                    'Dominio, alojamiento y certificado SSL incluidos',
                    'Enfocado solo en la tarjeta: sin gestión avanzada de invitados ni mesas',
                ]),
                'infraestructura' => 'Servidor compartido de 1 vCPU, 1 GB de RAM y 5 GB de almacenamiento.',
                'orden' => 0,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2) Encadenar el plan Invitación con la nueva Tarjeta (sin duplicar si ya se corrió).
        $invitacion = DB::table('planes_venta')->where('nombre', 'Invitación')->first();
        if ($invitacion) {
            $caracteristicas = json_decode((string) $invitacion->caracteristicas, true) ?: [];
            if (($caracteristicas[0] ?? null) !== 'Todo lo de la Tarjeta de Invitación') {
                array_unshift($caracteristicas, 'Todo lo de la Tarjeta de Invitación');
                DB::table('planes_venta')->where('id', $invitacion->id)->update([
                    'caracteristicas' => json_encode($caracteristicas),
                    'updated_at' => now(),
                ]);
            }
        }

        // 3) Rebranding multi-evento (solo si sigue con la marca original de matrimonios).
        DB::table('configuracion_ventas')->where('marca', 'MatrimonioWeb')->update([
            'marca' => 'Invita',
            'lema' => 'Invitaciones digitales y páginas web para tus eventos',
            'hero_titulo' => 'La web de su boda, de la invitación al último recuerdo',
            'hero_texto' => 'Diseñamos una página única con el dominio y los nombres de los novios, montada durante un año completo.',
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('planes_venta')->where('nombre', 'Tarjeta de Invitación')->delete();

        $invitacion = DB::table('planes_venta')->where('nombre', 'Invitación')->first();
        if ($invitacion) {
            $caracteristicas = json_decode((string) $invitacion->caracteristicas, true) ?: [];
            if (($caracteristicas[0] ?? null) === 'Todo lo de la Tarjeta de Invitación') {
                array_shift($caracteristicas);
                DB::table('planes_venta')->where('id', $invitacion->id)->update([
                    'caracteristicas' => json_encode($caracteristicas),
                    'updated_at' => now(),
                ]);
            }
        }

        DB::table('configuracion_ventas')->where('marca', 'Invita')->update([
            'marca' => 'MatrimonioWeb',
            'lema' => 'Páginas web para matrimonios, hechas a la medida de su historia',
            'updated_at' => now(),
        ]);
    }
};
