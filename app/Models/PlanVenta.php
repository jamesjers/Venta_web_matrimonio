<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Collection;

class PlanVenta extends Model
{
    protected $table = 'planes_venta';

    protected $fillable = [
        'nombre',
        'subtitulo',
        'precio',
        'destacado',
        'caracteristicas',
        'orden',
        'activo',
    ];

    protected $casts = [
        'destacado' => 'boolean',
        'activo' => 'boolean',
        'caracteristicas' => 'array',
        'orden' => 'integer',
    ];

    /**
     * Planes activos ordenados, con respaldo por defecto si la tabla no existe.
     *
     * @return Collection<int, PlanVenta>
     */
    public static function activosOrdenados(): Collection
    {
        try {
            if (Schema::hasTable('planes_venta')) {
                $planes = static::query()
                    ->where('activo', true)
                    ->orderBy('orden')
                    ->orderBy('id')
                    ->get();

                if ($planes->isNotEmpty()) {
                    return $planes;
                }
            }
        } catch (\Throwable $e) {
            // Caemos al respaldo.
        }

        return static::planesPorDefecto();
    }

    /**
     * @return Collection<int, PlanVenta>
     */
    public static function planesPorDefecto(): Collection
    {
        return collect([
            new self([
                'nombre' => 'Básico',
                'subtitulo' => 'Todo lo esencial para su boda',
                'precio' => 'S/ 199',
                'destacado' => false,
                'caracteristicas' => [
                    'Dominio con los nombres de los novios',
                    'Hosting incluido por 1 año',
                    'Invitación digital personalizada',
                    'Ubicación e itinerario',
                    'Confirmación de asistencia',
                    'Recordatorios por WhatsApp',
                    'Soporte por WhatsApp',
                ],
            ]),
            new self([
                'nombre' => 'Premium',
                'subtitulo' => 'La experiencia completa, a su medida',
                'precio' => 'S/ 399',
                'destacado' => true,
                'caracteristicas' => [
                    'Todo lo del plan Básico',
                    'Control de ingreso con QR',
                    'Distribución de mesas',
                    'Fotos compartidas en vivo durante el evento',
                    'Recuerdos (fotos y videos de los invitados)',
                    'Diseño y visual 100% a medida',
                    'Servicios adicionales a solicitud',
                ],
            ]),
        ]);
    }
}
