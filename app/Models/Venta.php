<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venta extends Model
{
    protected $table = 'ventas';

    public const ESTADOS = [
        'cotizacion' => 'Cotización',
        'confirmada' => 'Confirmada',
        'montada' => 'Montada',
        'entregada' => 'Entregada',
        'cancelada' => 'Cancelada',
    ];

    protected $fillable = [
        'novios',
        'contacto_nombre',
        'telefono',
        'email',
        'plan',
        'precio',
        'estado',
        'fecha_evento',
        'dominio',
        'servidor_id',
        'hosting_inicio',
        'hosting_fin',
        'servicios',
        'notas',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'fecha_evento' => 'date',
        'hosting_inicio' => 'date',
        'hosting_fin' => 'date',
        'servicios' => 'array',
    ];

    public function servidor(): BelongsTo
    {
        return $this->belongsTo(Servidor::class);
    }

    public function estadoLabel(): string
    {
        return self::ESTADOS[$this->estado] ?? ucfirst((string) $this->estado);
    }
}
