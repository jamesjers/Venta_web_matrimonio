<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servidor extends Model
{
    protected $table = 'servidores';

    public const ESTADOS = [
        'activo' => 'Activo',
        'mantenimiento' => 'En mantenimiento',
        'inactivo' => 'Inactivo',
    ];

    protected $fillable = [
        'nombre',
        'proveedor',
        'host',
        'ip',
        'plan_hosting',
        'capacidad_sitios',
        'estado',
        'costo_anual',
        'vencimiento',
        'notas',
    ];

    protected $casts = [
        'capacidad_sitios' => 'integer',
        'costo_anual' => 'decimal:2',
        'vencimiento' => 'date',
    ];

    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class);
    }

    public function estadoLabel(): string
    {
        return self::ESTADOS[$this->estado] ?? ucfirst((string) $this->estado);
    }

    public function sitiosOcupados(): int
    {
        return $this->ventas()->count();
    }
}
