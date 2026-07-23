<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class PlanVenta extends Model
{
    protected $table = 'planes_venta';

    protected $fillable = [
        'nombre',
        'subtitulo',
        'descripcion',
        'precio',
        'destacado',
        'caracteristicas',
        'infraestructura',
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
                'nombre' => 'Invitación',
                'subtitulo' => 'La invitación digital esencial',
                'descripcion' => 'Una invitación digital elegante con toda la información del evento en un solo lugar.',
                'precio' => '$799.000 COP',
                'destacado' => false,
                'caracteristicas' => [
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
                ],
                'infraestructura' => 'Servidor de 1 vCPU, 1 GB de RAM y 10 GB de almacenamiento.',
            ]),
            new self([
                'nombre' => 'Gestión de Invitados',
                'subtitulo' => 'Confirmaciones y cupos en un panel',
                'descripcion' => 'Ideal para administrar confirmaciones, cupos y acompañantes desde un solo panel.',
                'precio' => '$1.240.000 COP',
                'destacado' => false,
                'caracteristicas' => [
                    'Todo lo del Plan Invitación',
                    'Hasta 200 invitados',
                    'Control de cupos y acompañantes',
                    'Panel administrativo',
                    'Estadísticas de confirmación',
                    'Exportación de información a Excel',
                    'Recordatorios por correo electrónico',
                ],
                'infraestructura' => 'Recomendada: 1 o 2 vCPU, 2 GB de RAM y mínimo 25 GB de almacenamiento.',
            ]),
            new self([
                'nombre' => 'Organización y Mesas',
                'subtitulo' => 'Ubica a tus invitados en la recepción',
                'descripcion' => 'Organiza a tus invitados y facilita su ubicación durante la recepción.',
                'precio' => '$1.740.000 COP',
                'destacado' => false,
                'caracteristicas' => [
                    'Todo lo del Plan Gestión de Invitados',
                    'Hasta 250 invitados',
                    'Creación y administración de mesas (hasta 30)',
                    'Asignación y traslado de invitados',
                    'Código QR para consultar la ubicación',
                    'Exportación de la distribución de mesas',
                ],
                'infraestructura' => 'Recomendada: 2 vCPU, entre 2 y 4 GB de RAM y mínimo 50 GB de almacenamiento.',
            ]),
            new self([
                'nombre' => 'Experiencia y Recuerdos',
                'subtitulo' => 'Organiza y comparte los recuerdos en vivo',
                'descripcion' => 'La experiencia completa para organizar el evento y compartir los recuerdos en tiempo real.',
                'precio' => '$2.540.000 COP',
                'destacado' => true,
                'caracteristicas' => [
                    'Todo lo del Plan Organización y Mesas',
                    'Código QR para subir fotografías',
                    'Hasta 2.000 fotografías optimizadas',
                    'Presentación de fotos en tiempo real',
                    'Moderación y aprobación de contenido',
                    'Soporte remoto durante el evento',
                    'Galería activa durante seis meses',
                ],
                'infraestructura' => 'Recomendada: mínimo 2 vCPU, 4 GB de RAM, 50 GB de almacenamiento y espacio para fotografías.',
            ]),
            new self([
                'nombre' => 'Premium',
                'subtitulo' => 'La experiencia exclusiva con acompañamiento',
                'descripcion' => 'Una experiencia exclusiva con mayor capacidad, personalización y acompañamiento durante el evento.',
                'precio' => '$3.840.000 COP',
                'destacado' => false,
                'caracteristicas' => [
                    'Todo lo del Plan Experiencia y Recuerdos',
                    'Diseño completamente personalizado',
                    'Hasta 400 invitados',
                    'Hasta 5.000 fotografías y videos cortos',
                    'Soporte presencial en Bogotá (hasta 4 horas)',
                    'Copias de seguridad y conexión de respaldo',
                    'Página activa durante un año',
                ],
                'infraestructura' => 'Recomendada: 4 vCPU, 8 GB de RAM, mínimo 100 GB de almacenamiento, copias externas y monitoreo.',
            ]),
        ]);
    }
}
