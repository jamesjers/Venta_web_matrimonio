<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servidor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServidorController extends Controller
{
    public function index(): View
    {
        return view('admin.servidores.index', [
            'servidores' => Servidor::query()->withCount('ventas')->orderBy('nombre')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.servidores.form', [
            'servidor' => new Servidor(['estado' => 'activo', 'capacidad_sitios' => 1]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Servidor::create($this->validated($request));

        return redirect()->route('admin.servidores.index')
            ->with('success', 'Servidor registrado correctamente.');
    }

    public function edit(Servidor $servidor): View
    {
        return view('admin.servidores.form', ['servidor' => $servidor]);
    }

    public function update(Request $request, Servidor $servidor): RedirectResponse
    {
        $servidor->update($this->validated($request));

        return redirect()->route('admin.servidores.index')
            ->with('success', 'Servidor actualizado correctamente.');
    }

    public function destroy(Servidor $servidor): RedirectResponse
    {
        $servidor->delete();

        return redirect()->route('admin.servidores.index')
            ->with('success', 'Servidor eliminado.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'proveedor' => ['nullable', 'string', 'max:120'],
            'host' => ['nullable', 'string', 'max:190'],
            'ip' => ['nullable', 'string', 'max:60'],
            'plan_hosting' => ['nullable', 'string', 'max:120'],
            'capacidad_sitios' => ['nullable', 'integer', 'min:0'],
            'estado' => ['required', Rule::in(array_keys(Servidor::ESTADOS))],
            'costo_anual' => ['nullable', 'numeric', 'min:0'],
            'vencimiento' => ['nullable', 'date'],
            'notas' => ['nullable', 'string', 'max:1000'],
        ]);
    }
}
