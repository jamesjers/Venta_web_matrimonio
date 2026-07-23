<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_la_configuracion_por_defecto_responde(): void
    {
        $config = \App\Models\ConfiguracionVenta::actual();

        $this->assertNotEmpty($config->marca);
    }
}
