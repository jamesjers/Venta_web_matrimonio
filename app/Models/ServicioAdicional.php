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
        'precio',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
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

        return collect($items)->map(fn ($item) => new self([
            'nombre' => $item[0],
            'precio' => $item[1],
        ]));
    }
}
