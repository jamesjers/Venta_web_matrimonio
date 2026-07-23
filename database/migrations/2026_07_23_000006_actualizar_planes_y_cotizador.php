<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servicios_adicionales', function (Blueprint $table) {
            $table->decimal('precio_valor', 12, 2)->default(0)->after('precio');
            $table->string('tipo_calculo', 30)->default('seleccion')->after('precio_valor');
            $table->unsignedInteger('unidad')->default(1)->after('tipo_calculo');
        });

        $preciosPlanes = [
            'Invitación' => '$799.000 COP',
            'Gestión de Invitados' => '$1.240.000 COP',
            'Organización y Mesas' => '$1.740.000 COP',
            'Experiencia y Recuerdos' => '$2.540.000 COP',
            'Premium' => '$3.840.000 COP',
        ];

        foreach ($preciosPlanes as $nombre => $precio) {
            DB::table('planes_venta')->where('nombre', $nombre)->update(['precio' => $precio]);
        }

        DB::table('planes_venta')->where('nombre', 'Invitación')->update([
            'caracteristicas' => json_encode([
                'Perfil de administración',
                'Revisión del estado de las invitaciones',
                'Actualización de invitaciones',
                'Música en la tarjeta de invitación',
                'Hasta 100 invitados',
                'Ubicación de la ceremonia y la recepción',
                'Código de vestimenta',
                'Opciones de regalo',
                'Dominio y alojamiento por un año',
                'Certificado de seguridad SSL',
            ]),
        ]);

        DB::table('servicios_adicionales')->where('nombre', '50 invitados adicionales')->update([
            'nombre' => 'Invitados adicionales',
            'precio' => '$90.000 COP por cada 50',
            'precio_valor' => 90000,
            'tipo_calculo' => 'invitados',
            'unidad' => 50,
        ]);
        DB::table('servicios_adicionales')->where('nombre', '100 invitados adicionales')->update([
            'activo' => false,
        ]);
        DB::table('servicios_adicionales')->where('nombre', '1.000 fotografías adicionales')->update([
            'nombre' => 'Galería y fotos compartidas',
            'precio' => '$450.000 COP por cada 1.000 fotos',
            'precio_valor' => 450000,
            'tipo_calculo' => 'fotografias',
            'unidad' => 1000,
        ]);

        $preciosServicios = [
            'Carga inicial de invitados' => 120000,
            'Organización completa de mesas' => 250000,
            'Activación de carga de videos' => 250000,
            'Diseño exclusivo desde cero' => 300000,
            'Soporte remoto durante el evento' => 250000,
            'Soporte presencial hasta cuatro horas' => 650000,
            'Operador para moderación de fotografías' => 350000,
            'Renovación anual de dominio y alojamiento' => 350000,
        ];

        foreach ($preciosServicios as $nombre => $precioValor) {
            DB::table('servicios_adicionales')->where('nombre', $nombre)->update([
                'precio' => '$'.number_format($precioValor, 0, ',', '.').' COP',
                'precio_valor' => $precioValor,
                'tipo_calculo' => 'seleccion',
                'unidad' => 1,
            ]);
        }
    }

    public function down(): void
    {
        $preciosPlanes = [
            'Invitación' => '$849.000 COP',
            'Gestión de Invitados' => '$1.290.000 COP',
            'Organización y Mesas' => '$1.790.000 COP',
            'Experiencia y Recuerdos' => '$2.590.000 COP',
            'Premium' => '$3.890.000 COP',
        ];

        foreach ($preciosPlanes as $nombre => $precio) {
            DB::table('planes_venta')->where('nombre', $nombre)->update(['precio' => $precio]);
        }

        DB::table('servicios_adicionales')->where('nombre', 'Invitados adicionales')->update([
            'nombre' => '50 invitados adicionales',
            'precio' => '$90.000 COP',
        ]);
        DB::table('servicios_adicionales')->where('nombre', '100 invitados adicionales')->update([
            'activo' => true,
        ]);
        DB::table('servicios_adicionales')->where('nombre', 'Galería y fotos compartidas')->update([
            'nombre' => '1.000 fotografías adicionales',
            'precio' => '$120.000 COP',
        ]);

        Schema::table('servicios_adicionales', function (Blueprint $table) {
            $table->dropColumn(['precio_valor', 'tipo_calculo', 'unidad']);
        });
    }
};
