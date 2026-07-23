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
        'precio_valor',
        'tipo_calculo',
        'unidad',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
        'precio_valor' => 'decimal:2',
        'unidad' => 'integer',
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
            ['Invitados adicionales', '$90.000 COP por cada 50', 90000, 'invitados', 50],
            ['Galería y fotos compartidas', '$450.000 COP por cada 1.000 fotos', 450000, 'fotografias', 1000],
            ['Carga inicial de invitados', '$120.000 COP', 120000, 'seleccion', 1],
            ['Organización completa de mesas', '$250.000 COP', 250000, 'seleccion', 1],
            ['Activación de carga de videos', '$250.000 COP', 250000, 'seleccion', 1],
            ['Diseño exclusivo desde cero', '$300.000 COP', 300000, 'seleccion', 1],
            ['Soporte remoto durante el evento', '$250.000 COP', 250000, 'seleccion', 1],
            ['Soporte presencial hasta cuatro horas', '$650.000 COP', 650000, 'seleccion', 1],
            ['Operador para moderación de fotografías', '$350.000 COP', 350000, 'seleccion', 1],
            ['Renovación anual de dominio y alojamiento', '$350.000 COP', 350000, 'seleccion', 1],
        ];

        return collect($items)->map(fn ($item) => new self([
            'nombre' => $item[0],
            'precio' => $item[1],
            'precio_valor' => $item[2],
            'tipo_calculo' => $item[3],
            'unidad' => $item[4],
        ]));
    }
}
