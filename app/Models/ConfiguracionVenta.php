<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ConfiguracionVenta extends Model
{
    protected $table = 'configuracion_ventas';

    protected $fillable = [
        'marca',
        'lema',
        'whatsapp',
        'email',
        'hero_titulo',
        'hero_texto',
    ];

    /**
     * Devuelve la fila unica de configuracion (o una instancia con valores por
     * defecto si la tabla aun no existe o esta vacia). Tolerante a DB sin migrar.
     */
    public static function actual(): self
    {
        try {
            if (Schema::hasTable('configuracion_ventas')) {
                $config = static::query()->first();
                if ($config) {
                    return $config;
                }
            }
        } catch (\Throwable $e) {
            // Silencioso: caemos a los valores por defecto.
        }

        return new self([
            'marca' => 'MatrimonioWeb',
            'lema' => 'Páginas web para matrimonios, hechas a la medida de su historia',
            'whatsapp' => '51987654321',
            'email' => 'contacto@matrimonioweb.com',
            'hero_titulo' => 'La web de su boda, de la invitación al último recuerdo',
            'hero_texto' => 'Diseñamos una página única con el dominio y los nombres de los novios, montada durante un año completo.',
        ]);
    }

    public function whatsappDigitos(): string
    {
        return preg_replace('/\D/', '', (string) $this->whatsapp) ?? '';
    }
}
