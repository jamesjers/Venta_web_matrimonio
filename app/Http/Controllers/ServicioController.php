<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracionVenta;
use App\Models\PlanVenta;
use App\Models\ServicioAdicional;
use Illuminate\View\View;

class ServicioController extends Controller
{
    /**
     * Landing comercial: ofrece y vende el servicio de pagina web para matrimonios.
     * Precios, planes y datos de contacto se administran desde /admin.
     */
    public function __invoke(): View
    {
        return view('servicio.index', [
            'config' => ConfiguracionVenta::actual(),
            'planes' => PlanVenta::activosOrdenados(),
            'adicionales' => ServicioAdicional::activosOrdenados(),
        ]);
    }
}
