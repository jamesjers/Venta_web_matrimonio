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
            $table->string('descripcion', 300)->nullable()->after('nombre');
            $table->decimal('precio_adicional', 12, 2)->default(0)->after('precio_valor');
            $table->boolean('requiere_fotos')->default(false)->after('unidad');
        });

        $this->actualizar('Invitados adicionales', [
            'descripcion' => 'Amplía la capacidad del panel y de las invitaciones.',
            'precio' => '$90.000 COP por cada 50',
            'precio_valor' => 90000,
            'precio_adicional' => 90000,
            'tipo_calculo' => 'invitados',
            'unidad' => 50,
            'requiere_fotos' => false,
            'orden' => 1,
        ]);
        $this->actualizar('Galería y fotos compartidas', [
            'nombre' => 'Galería privada con QR',
            'descripcion' => 'Los invitados suben desde el navegador, sin instalar una app; incluye descarga consolidada.',
            'precio' => '$320.000 COP hasta 500 fotos + $80.000 por cada 500 adicionales',
            'precio_valor' => 320000,
            'precio_adicional' => 80000,
            'tipo_calculo' => 'fotografias',
            'unidad' => 500,
            'requiere_fotos' => false,
            'orden' => 2,
        ]);
        $this->actualizar('Carga inicial de invitados', [
            'nombre' => 'Carga asistida de invitados',
            'descripcion' => 'Cargamos y organizamos la lista inicial de hasta 100 invitados.',
            'precio' => '$120.000 COP',
            'precio_valor' => 120000,
            'orden' => 3,
        ]);
        $this->actualizar('Organización completa de mesas', [
            'nombre' => 'Módulo de mesas',
            'descripcion' => 'Organización de hasta 20 mesas y consulta de ubicación para los invitados.',
            'precio' => '$320.000 COP',
            'precio_valor' => 320000,
            'orden' => 4,
        ]);
        $this->actualizar('Activación de carga de videos', [
            'nombre' => 'Videos de invitados',
            'descripcion' => 'Carga de hasta 100 clips de máximo 30 segundos desde el navegador.',
            'precio' => '$280.000 COP',
            'precio_valor' => 280000,
            'orden' => 5,
        ]);
        $this->actualizar('Diseño exclusivo desde cero', [
            'nombre' => 'Diseño visual exclusivo',
            'descripcion' => 'Diseño desde cero alineado con la identidad gráfica de la boda.',
            'precio' => '$350.000 COP',
            'precio_valor' => 350000,
            'orden' => 6,
        ]);
        $this->actualizar('Operador para moderación de fotografías', [
            'nombre' => 'Moderación remota de fotografías',
            'descripcion' => 'Revisión de las fotos antes de mostrarlas durante hasta cuatro horas de evento.',
            'precio' => '$350.000 COP',
            'precio_valor' => 350000,
            'requiere_fotos' => true,
            'orden' => 8,
        ]);
        $this->actualizar('Soporte remoto durante el evento', [
            'nombre' => 'Soporte técnico remoto durante el evento',
            'descripcion' => 'Acompañamiento remoto por WhatsApp o llamada durante máximo cuatro horas.',
            'precio' => '$250.000 COP',
            'precio_valor' => 250000,
            'orden' => 9,
        ]);
        $this->actualizar('Soporte presencial hasta cuatro horas', [
            'nombre' => 'Acompañamiento presencial en Bogotá',
            'descripcion' => 'Soporte presencial durante máximo cuatro horas; otras ciudades se cotizan aparte.',
            'precio' => '$650.000 COP',
            'precio_valor' => 650000,
            'orden' => 10,
        ]);
        $this->actualizar('Renovación anual de dominio y alojamiento', [
            'descripcion' => 'Renovación por doce meses; almacenamiento adicional se cotiza según el uso.',
            'precio' => '$350.000 COP',
            'precio_valor' => 350000,
            'orden' => 14,
        ]);

        $this->crearSiFalta('Invitados adicionales', [
            'descripcion' => 'Amplía la capacidad del panel y de las invitaciones.',
            'precio' => '$90.000 COP por cada 50',
            'precio_valor' => 90000,
            'precio_adicional' => 90000,
            'tipo_calculo' => 'invitados',
            'unidad' => 50,
            'orden' => 1,
        ]);
        $this->crearSiFalta('Galería privada con QR', [
            'descripcion' => 'Los invitados suben desde el navegador, sin instalar una app; incluye descarga consolidada.',
            'precio' => '$320.000 COP hasta 500 fotos + $80.000 por cada 500 adicionales',
            'precio_valor' => 320000,
            'precio_adicional' => 80000,
            'tipo_calculo' => 'fotografias',
            'unidad' => 500,
            'orden' => 2,
        ]);
        $this->crearSiFalta('Presentación de fotos en tiempo real', [
            'descripcion' => 'Proyección automática en televisor o videobeam; requiere galería, pantalla e internet estable.',
            'precio' => '$220.000 COP',
            'precio_valor' => 220000,
            'requiere_fotos' => true,
            'orden' => 7,
        ]);
        $this->crearSiFalta('Control de ingreso con QR', [
            'descripcion' => 'Check-in desde celular y registro de hora de llegada por invitado.',
            'precio' => '$280.000 COP',
            'precio_valor' => 280000,
            'orden' => 11,
        ]);
        $this->crearSiFalta('Recordatorios por WhatsApp', [
            'descripcion' => 'Segmentación y mensajes listos para enviar; no incluye cobros de API ni envío masivo automático.',
            'precio' => '$120.000 COP',
            'precio_valor' => 120000,
            'orden' => 12,
        ]);
        $this->crearSiFalta('Libro de mensajes digital', [
            'descripcion' => 'Mensajes escritos y notas de voz de hasta 60 segundos desde el mismo QR.',
            'precio' => '$180.000 COP',
            'precio_valor' => 180000,
            'orden' => 13,
        ]);
    }

    public function down(): void
    {
        DB::table('servicios_adicionales')->whereIn('nombre', [
            'Presentación de fotos en tiempo real',
            'Control de ingreso con QR',
            'Recordatorios por WhatsApp',
            'Libro de mensajes digital',
        ])->delete();

        $restauraciones = [
            'Galería privada con QR' => ['nombre' => 'Galería y fotos compartidas', 'precio' => '$450.000 COP por cada 1.000 fotos', 'precio_valor' => 450000, 'unidad' => 1000],
            'Carga asistida de invitados' => ['nombre' => 'Carga inicial de invitados', 'precio' => '$120.000 COP', 'precio_valor' => 120000],
            'Módulo de mesas' => ['nombre' => 'Organización completa de mesas', 'precio' => '$250.000 COP', 'precio_valor' => 250000],
            'Videos de invitados' => ['nombre' => 'Activación de carga de videos', 'precio' => '$250.000 COP', 'precio_valor' => 250000],
            'Diseño visual exclusivo' => ['nombre' => 'Diseño exclusivo desde cero', 'precio' => '$300.000 COP', 'precio_valor' => 300000],
            'Moderación remota de fotografías' => ['nombre' => 'Operador para moderación de fotografías', 'precio' => '$350.000 COP', 'precio_valor' => 350000],
            'Soporte técnico remoto durante el evento' => ['nombre' => 'Soporte remoto durante el evento', 'precio' => '$250.000 COP', 'precio_valor' => 250000],
            'Acompañamiento presencial en Bogotá' => ['nombre' => 'Soporte presencial hasta cuatro horas', 'precio' => '$650.000 COP', 'precio_valor' => 650000],
        ];

        foreach ($restauraciones as $nombreActual => $datos) {
            DB::table('servicios_adicionales')->where('nombre', $nombreActual)->update($datos);
        }

        Schema::table('servicios_adicionales', function (Blueprint $table) {
            $table->dropColumn(['descripcion', 'precio_adicional', 'requiere_fotos']);
        });
    }

    /**
     * @param  array<string, mixed>  $datos
     */
    private function actualizar(string $nombreActual, array $datos): void
    {
        DB::table('servicios_adicionales')->where('nombre', $nombreActual)->update(
            array_merge($datos, ['updated_at' => now()])
        );
    }

    /**
     * @param  array<string, mixed>  $datos
     */
    private function crearSiFalta(string $nombre, array $datos): void
    {
        $consulta = DB::table('servicios_adicionales')->where('nombre', $nombre);
        $valores = array_merge([
            'tipo_calculo' => 'seleccion',
            'unidad' => 1,
            'precio_adicional' => 0,
            'requiere_fotos' => false,
            'activo' => true,
            'updated_at' => now(),
        ], $datos);

        if ($consulta->exists()) {
            $consulta->update($valores);

            return;
        }

        DB::table('servicios_adicionales')->insert(
            array_merge([
                'nombre' => $nombre,
                'tipo_calculo' => 'seleccion',
                'unidad' => 1,
                'precio_adicional' => 0,
                'requiere_fotos' => false,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ], $datos)
        );
    }
};
