<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador del negocio. Cambia estas credenciales tras el primer ingreso.
        User::query()->updateOrCreate(
            ['email' => 'admin@ventas-bodas.com'],
            [
                'name' => 'Administrador',
                'password' => 'ventasbodas2026',
            ],
        );
    }
}
