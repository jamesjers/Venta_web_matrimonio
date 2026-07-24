<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class ServicioAdicional extends Model
{
    protected $table = 'servicios_adicionales';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'precio_valor',
        'precio_adicional',
        'tipo_calculo',
        'unidad',
        'requiere_fotos',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
        'precio_valor' => 'decimal:2',
        'precio_adicional' => 'decimal:2',
        'unidad' => 'integer',
        'requiere_fotos' => 'boolean',
    ];

    /**
     * Servicios activos ordenados, con respaldo por defecto si la tabla no existe.
     *
     * @return Collection<int, ServicioAdicional>
     */
    public static function activosOrdenados(): Collection
    {
        try {
            if (Schema::hasTable('servicios_adicionales')) {
                $servicios = static::query()
                    ->where('activo', true)
                    ->orderBy('orden')
                    ->orderBy('id')
                    ->get();

                if ($servicios->isNotEmpty()) {
                    return $servicios;
                }
            }
        } catch (\Throwable $e) {
            // Caemos al respaldo.
        }

        return static::porDefecto();
    }

    /**
     * @return Collection<int, ServicioAdicional>
     */
    public static function porDefecto(): Collection
    {
        $items = [
            ['Invitados adicionales', 'Amplía la capacidad del panel y de las invitaciones.', '$70.000 COP por cada 50', 70000, 70000, 'invitados', 50, false],
            ['Galería privada con QR', 'Los invitados suben desde el navegador, sin instalar una app; incluye descarga consolidada.', '$250.000 COP hasta 500 fotos + $60.000 por cada 500 adicionales', 250000, 60000, 'fotografias', 500, false],
            ['Carga asistida de invitados', 'Cargamos y organizamos la lista inicial de hasta 100 invitados.', '$80.000 COP', 80000, 0, 'seleccion', 1, false],
            ['Módulo de mesas', 'Organización de hasta 20 mesas y consulta de ubicación para los invitados.', '$250.000 COP', 250000, 0, 'seleccion', 1, false],
            ['Videos de invitados', 'Carga de hasta 100 clips de máximo 30 segundos desde el navegador.', '$200.000 COP', 200000, 0, 'seleccion', 1, false],
            ['Diseño visual exclusivo', 'Diseño desde cero alineado con la identidad gráfica de la boda.', '$300.000 COP', 300000, 0, 'seleccion', 1, false],
            ['Presentación de fotos en tiempo real', 'Habilitamos un enlace en pantalla completa para abrirlo desde un computador conectado a TV o videobeam. No incluye equipo, internet ni operador.', '$70.000 COP', 70000, 0, 'seleccion', 1, true],
            ['Moderación remota de fotografías', 'Revisión de las fotos antes de mostrarlas durante hasta cuatro horas de evento.', '$280.000 COP', 280000, 0, 'seleccion', 1, true],
            ['Soporte técnico remoto durante el evento', 'Acompañamiento remoto por WhatsApp o llamada durante máximo cuatro horas.', '$180.000 COP', 180000, 0, 'seleccion', 1, false],
            ['Acompañamiento presencial en Bogotá', 'Soporte presencial durante máximo cuatro horas; otras ciudades se cotizan aparte.', '$520.000 COP', 520000, 0, 'seleccion', 1, false],
            ['Control de ingreso con QR', 'Check-in desde celular y registro de hora de llegada por invitado.', '$220.000 COP', 220000, 0, 'seleccion', 1, false],
            ['Recordatorios por WhatsApp', 'Segmentación y mensajes listos para enviar; no incluye cobros de API ni envío masivo automático.', '$80.000 COP', 80000, 0, 'seleccion', 1, false],
            ['Libro de mensajes digital', 'Mensajes escritos y notas de voz de hasta 60 segundos desde el mismo QR.', '$120.000 COP', 120000, 0, 'seleccion', 1, false],
            ['Renovación anual de dominio y alojamiento', 'Renovación por doce meses; almacenamiento adicional se cotiza según el uso.', '$300.000 COP', 300000, 0, 'seleccion', 1, false],
        ];

        return collect($items)->map(fn ($item) => new self([
            'nombre' => $item[0],
            'descripcion' => $item[1],
            'precio' => $item[2],
            'precio_valor' => $item[3],
            'precio_adicional' => $item[4],
            'tipo_calculo' => $item[5],
            'unidad' => $item[6],
            'requiere_fotos' => $item[7],
        ]));
    }
}
