<?php

namespace Tests\Feature;

use App\Models\PlanVenta;
use App\Models\ServicioAdicional;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_configuracion_por_defecto_responde(): void
    {
        $config = \App\Models\ConfiguracionVenta::actual();

        $this->assertNotEmpty($config->marca);
    }

    public function test_la_landing_muestra_el_cotizador_sin_exponer_caracteristicas_de_planes(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Arma tu cotización personalizada')
            ->assertSee('$749.000 COP')
            ->assertSee('Galería privada con QR')
            ->assertSee('Presentación de fotos en tiempo real')
            ->assertSee('sin instalar una app')
            ->assertDontSee('Recordatorios automáticos')
            ->assertDontSee('Perfil de administración')
            ->assertDontSee('Todos los planes lado a lado')
            ->assertDontSee('<h2>Servicios adicionales</h2>', false);
    }

    public function test_los_precios_y_opciones_del_cotizador_quedan_configurados(): void
    {
        $this->assertSame([
            'Invitación' => '$749.000 COP',
            'Gestión de Invitados' => '$1.149.000 COP',
            'Organización y Mesas' => '$1.599.000 COP',
            'Experiencia y Recuerdos' => '$2.299.000 COP',
            'Premium' => '$3.499.000 COP',
        ], PlanVenta::query()->orderBy('orden')->pluck('precio', 'nombre')->all());

        $invitados = ServicioAdicional::query()->where('tipo_calculo', 'invitados')->firstOrFail();
        $fotos = ServicioAdicional::query()->where('tipo_calculo', 'fotografias')->firstOrFail();

        $this->assertSame(50, $invitados->unidad);
        $this->assertSame('70000.00', $invitados->precio_valor);
        $this->assertSame(500, $fotos->unidad);
        $this->assertSame('250000.00', $fotos->precio_valor);
        $this->assertSame('60000.00', $fotos->precio_adicional);

        $presentacion = ServicioAdicional::query()->where('nombre', 'Presentación de fotos en tiempo real')->firstOrFail();
        $this->assertSame('70000.00', $presentacion->precio_valor);
        $this->assertStringContainsString('enlace en pantalla completa', $presentacion->descripcion);
    }

    public function test_el_administrador_ve_las_caracteristicas_al_registrar_una_venta(): void
    {
        $usuario = User::factory()->create();

        $this->actingAs($usuario)
            ->get(route('admin.ventas.create'))
            ->assertOk()
            ->assertSee('Perfil de administración')
            ->assertSee('Presentación de fotos en tiempo real')
            ->assertSee('Características internas de');
    }
}
