<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanVenta;
use App\Models\ServicioAdicional;
use App\Models\Servidor;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class VentaController extends Controller
{
    public function index(): View
    {
        return view('admin.ventas.index', [
            'ventas' => Venta::query()->with('servidor')->latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.ventas.form', [
            'venta' => new Venta(['estado' => 'cotizacion']),
            'servidores' => Servidor::query()->orderBy('nombre')->get(),
            'planes' => PlanVenta::query()->orderBy('orden')->orderBy('id')->get(),
            'serviciosDisponibles' => $this->serviciosDisponibles(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Venta::create($this->validated($request));

        return redirect()->route('admin.ventas.index')
            ->with('success', 'Venta registrada correctamente.');
    }

    public function edit(Venta $venta): View
    {
        return view('admin.ventas.form', [
            'venta' => $venta,
            'servidores' => Servidor::query()->orderBy('nombre')->get(),
            'planes' => PlanVenta::query()->orderBy('orden')->orderBy('id')->get(),
            'serviciosDisponibles' => $this->serviciosDisponibles(),
        ]);
    }

    public function update(Request $request, Venta $venta): RedirectResponse
    {
        $venta->update($this->validated($request));

        return redirect()->route('admin.ventas.index')
            ->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy(Venta $venta): RedirectResponse
    {
        $venta->delete();

        return redirect()->route('admin.ventas.index')
            ->with('success', 'Venta eliminada.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'novios' => ['required', 'string', 'max:150'],
            'contacto_nombre' => ['nullable', 'string', 'max:150'],
            'telefono' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:150'],
            'plan' => ['nullable', 'string', 'max:120'],
            'precio' => ['nullable', 'numeric', 'min:0'],
            'estado' => ['required', Rule::in(array_keys(Venta::ESTADOS))],
            'fecha_evento' => ['nullable', 'date'],
            'dominio' => ['nullable', 'string', 'max:190'],
            'servidor_id' => ['nullable', 'exists:servidores,id'],
            'hosting_inicio' => ['nullable', 'date'],
            'hosting_fin' => ['nullable', 'date'],
            'servicios' => ['nullable', 'array'],
            'servicios.*' => ['string', 'max:150'],
            'servicios_extra' => ['nullable', 'string'],
            'notas' => ['nullable', 'string', 'max:1000'],
        ]);

        // Servicios seleccionados + personalizaciones escritas a mano.
        $servicios = collect($data['servicios'] ?? []);
        $extra = collect(preg_split('/\r\n|\r|\n/', (string) ($request->input('servicios_extra') ?? '')))
            ->map(fn ($linea) => trim($linea))
            ->filter();
        $data['servicios'] = $servicios->merge($extra)->unique()->values()->all();
        unset($data['servicios_extra']);

        // El hosting se monta por 1 año: si hay inicio y no hay fin, se calcula.
        if (! empty($data['hosting_inicio']) && empty($data['hosting_fin'])) {
            $data['hosting_fin'] = Carbon::parse($data['hosting_inicio'])->addYear()->toDateString();
        }

        $data['precio'] = (float) ($data['precio'] ?? 0);

        return $data;
    }

    /**
     * @return array<int, string>
     */
    private function serviciosDisponibles(): array
    {
        $caracteristicas = PlanVenta::query()
            ->orderBy('orden')
            ->get()
            ->flatMap(fn (PlanVenta $plan) => $plan->caracteristicas ?? []);

        $opcionesPersonalizadas = ServicioAdicional::query()
            ->where('activo', true)
            ->orderBy('orden')
            ->pluck('nombre');

        return $caracteristicas
            ->merge($opcionesPersonalizadas)
            ->unique()
            ->values()
            ->all();
    }
}
