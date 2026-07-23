<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanVenta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanVentaController extends Controller
{
    public function index(): View
    {
        return view('admin.planes.index', [
            'planes' => PlanVenta::query()->orderBy('orden')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.planes.form', [
            'plan' => new PlanVenta(['activo' => true]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        PlanVenta::create($this->validated($request));

        return redirect()->route('admin.planes.index')
            ->with('success', 'Plan creado correctamente.');
    }

    public function edit(PlanVenta $plan): View
    {
        return view('admin.planes.form', ['plan' => $plan]);
    }

    public function update(Request $request, PlanVenta $plan): RedirectResponse
    {
        $plan->update($this->validated($request));

        return redirect()->route('admin.planes.index')
            ->with('success', 'Plan actualizado correctamente.');
    }

    public function destroy(PlanVenta $plan): RedirectResponse
    {
        $plan->delete();

        return redirect()->route('admin.planes.index')
            ->with('success', 'Plan eliminado.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'subtitulo' => ['nullable', 'string', 'max:160'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'precio' => ['required', 'string', 'max:60'],
            'destacado' => ['nullable', 'boolean'],
            'caracteristicas' => ['nullable', 'string'],
            'infraestructura' => ['nullable', 'string', 'max:400'],
            'orden' => ['nullable', 'integer', 'min:0'],
            'activo' => ['nullable', 'boolean'],
        ]);

        // Una caracteristica por linea en el textarea -> array.
        $data['caracteristicas'] = collect(preg_split('/\r\n|\r|\n/', (string) ($data['caracteristicas'] ?? '')))
            ->map(fn ($linea) => trim($linea))
            ->filter()
            ->values()
            ->all();

        $data['destacado'] = $request->boolean('destacado');
        $data['activo'] = $request->boolean('activo');
        $data['orden'] = (int) ($data['orden'] ?? 0);

        return $data;
    }
}
