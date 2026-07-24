<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $planes = [
            'Invitación' => '$749.000 COP',
            'Gestión de Invitados' => '$1.149.000 COP',
            'Organización y Mesas' => '$1.599.000 COP',
            'Experiencia y Recuerdos' => '$2.299.000 COP',
            'Premium' => '$3.499.000 COP',
        ];

        foreach ($planes as $nombre => $precio) {
            DB::table('planes_venta')->where('nombre', $nombre)->update([
                'precio' => $precio,
                'updated_at' => now(),
            ]);
        }

        $servicios = [
            'Invitados adicionales' => ['$70.000 COP por cada 50', 70000, 70000],
            'Galería privada con QR' => ['$250.000 COP hasta 500 fotos + $60.000 por cada 500 adicionales', 250000, 60000],
            'Carga asistida de invitados' => ['$80.000 COP', 80000, 0],
            'Módulo de mesas' => ['$250.000 COP', 250000, 0],
            'Videos de invitados' => ['$200.000 COP', 200000, 0],
            'Diseño visual exclusivo' => ['$300.000 COP', 300000, 0],
            'Presentación de fotos en tiempo real' => ['$70.000 COP', 70000, 0],
            'Moderación remota de fotografías' => ['$280.000 COP', 280000, 0],
            'Soporte técnico remoto durante el evento' => ['$180.000 COP', 180000, 0],
            'Acompañamiento presencial en Bogotá' => ['$520.000 COP', 520000, 0],
            'Control de ingreso con QR' => ['$220.000 COP', 220000, 0],
            'Recordatorios por WhatsApp' => ['$80.000 COP', 80000, 0],
            'Libro de mensajes digital' => ['$120.000 COP', 120000, 0],
            'Renovación anual de dominio y alojamiento' => ['$300.000 COP', 300000, 0],
        ];

        foreach ($servicios as $nombre => [$precio, $precioValor, $precioAdicional]) {
            DB::table('servicios_adicionales')->where('nombre', $nombre)->update([
                'precio' => $precio,
                'precio_valor' => $precioValor,
                'precio_adicional' => $precioAdicional,
                'updated_at' => now(),
            ]);
        }

        DB::table('servicios_adicionales')->where('nombre', 'Presentación de fotos en tiempo real')->update([
            'descripcion' => 'Habilitamos un enlace en pantalla completa para abrirlo desde un computador conectado a TV o videobeam. No incluye equipo, internet ni operador.',
        ]);
    }

    public function down(): void
    {
        $planes = [
            'Invitación' => '$799.000 COP',
            'Gestión de Invitados' => '$1.240.000 COP',
            'Organización y Mesas' => '$1.740.000 COP',
            'Experiencia y Recuerdos' => '$2.540.000 COP',
            'Premium' => '$3.840.000 COP',
        ];

        foreach ($planes as $nombre => $precio) {
            DB::table('planes_venta')->where('nombre', $nombre)->update(['precio' => $precio]);
        }

        $servicios = [
            'Invitados adicionales' => ['$90.000 COP por cada 50', 90000, 90000],
            'Galería privada con QR' => ['$320.000 COP hasta 500 fotos + $80.000 por cada 500 adicionales', 320000, 80000],
            'Carga asistida de invitados' => ['$120.000 COP', 120000, 0],
            'Módulo de mesas' => ['$320.000 COP', 320000, 0],
            'Videos de invitados' => ['$280.000 COP', 280000, 0],
            'Diseño visual exclusivo' => ['$350.000 COP', 350000, 0],
            'Presentación de fotos en tiempo real' => ['$220.000 COP', 220000, 0],
            'Moderación remota de fotografías' => ['$350.000 COP', 350000, 0],
            'Soporte técnico remoto durante el evento' => ['$250.000 COP', 250000, 0],
            'Acompañamiento presencial en Bogotá' => ['$650.000 COP', 650000, 0],
            'Control de ingreso con QR' => ['$280.000 COP', 280000, 0],
            'Recordatorios por WhatsApp' => ['$120.000 COP', 120000, 0],
            'Libro de mensajes digital' => ['$180.000 COP', 180000, 0],
            'Renovación anual de dominio y alojamiento' => ['$350.000 COP', 350000, 0],
        ];

        foreach ($servicios as $nombre => [$precio, $precioValor, $precioAdicional]) {
            DB::table('servicios_adicionales')->where('nombre', $nombre)->update([
                'precio' => $precio,
                'precio_valor' => $precioValor,
                'precio_adicional' => $precioAdicional,
            ]);
        }

        DB::table('servicios_adicionales')->where('nombre', 'Presentación de fotos en tiempo real')->update([
            'descripcion' => 'Proyección automática en televisor o videobeam; requiere galería, pantalla e internet estable.',
        ]);
    }
};
