<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicioAdicional;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServicioAdicionalController extends Controller
{
    public function index(): View
    {
        return view('admin.adicionales.index', [
            'servicios' => ServicioAdicional::query()->orderBy('orden')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.adicionales.form', [
            'servicio' => new ServicioAdicional(['activo' => true]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        ServicioAdicional::create($this->validated($request));

        return redirect()->route('admin.adicionales.index')
            ->with('success', 'Servicio adicional creado.');
    }

    public function edit(ServicioAdicional $adicional): View
    {
        return view('admin.adicionales.form', ['servicio' => $adicional]);
    }

    public function update(Request $request, ServicioAdicional $adicional): RedirectResponse
    {
        $adicional->update($this->validated($request));

        return redirect()->route('admin.adicionales.index')
            ->with('success', 'Servicio adicional actualizado.');
    }

    public function destroy(ServicioAdicional $adicional): RedirectResponse
    {
        $adicional->delete();

        return redirect()->route('admin.adicionales.index')
            ->with('success', 'Servicio adicional eliminado.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:190'],
            'precio' => ['required', 'string', 'max:80'],
            'precio_valor' => ['required', 'numeric', 'min:0'],
            'tipo_calculo' => ['required', 'in:seleccion,invitados,fotografias'],
            'unidad' => ['required', 'integer', 'min:1'],
            'orden' => ['nullable', 'integer', 'min:0'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $data['activo'] = $request->boolean('activo');
        $data['orden'] = (int) ($data['orden'] ?? 0);

        return $data;
    }
}
