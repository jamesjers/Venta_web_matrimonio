<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planes_venta', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->string('subtitulo', 160)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('precio', 60)->default('A consultar');
            $table->boolean('destacado')->default(false);
            $table->json('caracteristicas')->nullable();
            $table->string('infraestructura', 400)->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        $now = now();
        $planes = [
            [
                'nombre' => 'Invitación',
                'subtitulo' => 'La invitación digital esencial',
                'descripcion' => 'Una invitación digital elegante con toda la información del evento en un solo lugar.',
                'precio' => '$849.000 COP',
                'destacado' => false,
                'caracteristicas' => [
                    'Diseño personalizado basado en plantilla',
                    'Dominio y alojamiento por un año',
                    'Certificado de seguridad SSL',
                    'Hasta 100 invitados',
                    'Fecha y cuenta regresiva',
                    'Información de ceremonia y recepción',
                    'Ubicación con Google Maps',
                    'Código de vestuario',
                    'Mesa de regalos',
                    'Galería de fotografías de la pareja',
                    'Confirmación básica de asistencia',
                    'Botón para compartir por WhatsApp',
                    'Código QR de acceso',
                    'Dos rondas de ajustes',
                ],
                'infraestructura' => 'Servidor de 1 vCPU, 1 GB de RAM y 10 GB de almacenamiento.',
                'orden' => 1,
            ],
            [
                'nombre' => 'Gestión de Invitados',
                'subtitulo' => 'Confirmaciones y cupos en un panel',
                'descripcion' => 'Ideal para administrar confirmaciones, cupos y acompañantes desde un solo panel.',
                'precio' => '$1.290.000 COP',
                'destacado' => false,
                'caracteristicas' => [
                    'Todo lo del Plan Invitación',
                    'Hasta 200 invitados',
                    'Invitaciones individuales o familiares',
                    'Control de cupos y acompañantes',
                    'Estados de asistencia',
                    'Registro de restricciones alimentarias',
                    'Panel administrativo',
                    'Búsqueda y filtros de invitados',
                    'Estadísticas de confirmación',
                    'Exportación de información a Excel',
                    'Recordatorios por correo electrónico',
                    'Plantillas de mensajes para WhatsApp',
                ],
                'infraestructura' => 'Recomendada: 1 o 2 vCPU, 2 GB de RAM y mínimo 25 GB de almacenamiento.',
                'orden' => 2,
            ],
            [
                'nombre' => 'Organización y Mesas',
                'subtitulo' => 'Ubica a tus invitados en la recepción',
                'descripcion' => 'Organiza a tus invitados y facilita su ubicación durante la recepción.',
                'precio' => '$1.790.000 COP',
                'destacado' => false,
                'caracteristicas' => [
                    'Todo lo del Plan Gestión de Invitados',
                    'Hasta 250 invitados',
                    'Creación y administración de mesas',
                    'Hasta 30 mesas',
                    'Capacidad máxima por mesa',
                    'Asignación y traslado de invitados',
                    'Alertas de sobrecupo',
                    'Clasificación por grupos familiares o sociales',
                    'Consulta de mesa por nombre',
                    'Código QR para consultar la ubicación',
                    'Listado para recepción y personal logístico',
                    'Exportación de la distribución de mesas',
                    'Capacitación para administrar el módulo',
                ],
                'infraestructura' => 'Recomendada: 2 vCPU, entre 2 y 4 GB de RAM y mínimo 50 GB de almacenamiento.',
                'orden' => 3,
            ],
            [
                'nombre' => 'Experiencia y Recuerdos',
                'subtitulo' => 'Organiza y comparte los recuerdos en vivo',
                'descripcion' => 'La experiencia completa para organizar el evento y compartir los recuerdos en tiempo real.',
                'precio' => '$2.590.000 COP',
                'destacado' => true,
                'caracteristicas' => [
                    'Todo lo del Plan Organización y Mesas',
                    'Hasta 250 invitados',
                    'Código QR para subir fotografías',
                    'Carga desde el celular sin instalar aplicaciones',
                    'Hasta 2.000 fotografías optimizadas',
                    'Galería privada de recuerdos',
                    'Presentación de fotos en tiempo real',
                    'Modo pantalla completa para proyector o televisor',
                    'Actualización automática de fotografías',
                    'Moderación y aprobación de contenido',
                    'Descarga consolidada de recuerdos',
                    'Página de agradecimiento',
                    'Prueba técnica previa',
                    'Soporte remoto durante el evento',
                    'Galería activa durante seis meses',
                ],
                'infraestructura' => 'Recomendada: mínimo 2 vCPU, 4 GB de RAM, 50 GB de almacenamiento y espacio independiente para fotografías.',
                'orden' => 4,
            ],
            [
                'nombre' => 'Premium',
                'subtitulo' => 'La experiencia exclusiva con acompañamiento',
                'descripcion' => 'Una experiencia exclusiva con mayor capacidad, personalización y acompañamiento durante el evento.',
                'precio' => '$3.890.000 COP',
                'destacado' => false,
                'caracteristicas' => [
                    'Todo lo del Plan Experiencia y Recuerdos',
                    'Diseño completamente personalizado',
                    'Dominio exclusivo',
                    'Hasta 400 invitados',
                    'Hasta 5.000 fotografías',
                    'Opción de cargar videos cortos',
                    'Presentación personalizada para el evento',
                    'Operador para moderar fotografías',
                    'Soporte presencial en Bogotá hasta por cuatro horas',
                    'Ensayo técnico en el lugar',
                    'Conexión de respaldo',
                    'Copias de seguridad',
                    'Entrega organizada de los recuerdos',
                    'Página activa durante un año',
                    'Tres rondas de ajustes',
                ],
                'infraestructura' => 'Recomendada: 4 vCPU, 8 GB de RAM, mínimo 100 GB de almacenamiento, copias externas y monitoreo.',
                'orden' => 5,
            ],
        ];

        foreach ($planes as $plan) {
            DB::table('planes_venta')->insert([
                'nombre' => $plan['nombre'],
                'subtitulo' => $plan['subtitulo'],
                'descripcion' => $plan['descripcion'],
                'precio' => $plan['precio'],
                'destacado' => $plan['destacado'],
                'caracteristicas' => json_encode($plan['caracteristicas']),
                'infraestructura' => $plan['infraestructura'],
                'orden' => $plan['orden'],
                'activo' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('planes_venta');
    }
};
