<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfiguracionVenta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConfiguracionVentaController extends Controller
{
    public function edit(): View
    {
        return view('admin.configuracion', [
            'config' => ConfiguracionVenta::actual(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'marca' => ['required', 'string', 'max:120'],
            'lema' => ['nullable', 'string', 'max:200'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
            'hero_titulo' => ['nullable', 'string', 'max:200'],
            'hero_texto' => ['nullable', 'string', 'max:1000'],
        ]);

        $config = ConfiguracionVenta::query()->first() ?? new ConfiguracionVenta();
        $config->fill($data)->save();

        return redirect()
            ->route('admin.configuracion.edit')
            ->with('success', 'Configuración de la página de ventas actualizada.');
    }
}
