<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanVenta;
use App\Models\Servidor;
use App\Models\Venta;
use Illuminate\View\View;

class VentasPanelController extends Controller
{
    public function __invoke(): View
    {
        $ventas = Venta::query()->latest()->get();

        $ingresos = $ventas
            ->whereIn('estado', ['confirmada', 'montada', 'entregada'])
            ->sum('precio');

        $porEstado = collect(Venta::ESTADOS)->map(function ($label, $estado) use ($ventas) {
            return [
                'label' => $label,
                'total' => $ventas->where('estado', $estado)->count(),
            ];
        });

        return view('admin.dashboard', [
            'totalVentas' => $ventas->count(),
            'ingresos' => $ingresos,
            'porEstado' => $porEstado,
            'ultimasVentas' => $ventas->take(6),
            'totalServidores' => Servidor::query()->count(),
            'totalPlanes' => PlanVenta::query()->count(),
        ]);
    }
}
