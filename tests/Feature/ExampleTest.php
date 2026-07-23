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
            ->assertSee('$799.000 COP')
            ->assertDontSee('Perfil de administración')
            ->assertDontSee('Todos los planes lado a lado')
            ->assertDontSee('<h2>Servicios adicionales</h2>', false);
    }

    public function test_los_precios_y_opciones_del_cotizador_quedan_configurados(): void
    {
        $this->assertSame('$799.000 COP', PlanVenta::query()->where('nombre', 'Invitación')->value('precio'));
        $this->assertSame('$1.240.000 COP', PlanVenta::query()->where('nombre', 'Gestión de Invitados')->value('precio'));

        $invitados = ServicioAdicional::query()->where('tipo_calculo', 'invitados')->firstOrFail();
        $fotos = ServicioAdicional::query()->where('tipo_calculo', 'fotografias')->firstOrFail();

        $this->assertSame(50, $invitados->unidad);
        $this->assertSame('90000.00', $invitados->precio_valor);
        $this->assertSame(1000, $fotos->unidad);
        $this->assertSame('450000.00', $fotos->precio_valor);
    }

    public function test_el_administrador_ve_las_caracteristicas_al_registrar_una_venta(): void
    {
        $usuario = User::factory()->create();

        $this->actingAs($usuario)
            ->get(route('admin.ventas.create'))
            ->assertOk()
            ->assertSee('Perfil de administración')
            ->assertSee('Características internas de');
    }
}
