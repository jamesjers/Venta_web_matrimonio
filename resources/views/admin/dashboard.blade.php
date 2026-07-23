@extends('layouts.admin')

@section('title', 'Resumen')

@section('content')
    <div class="page-head">
        <div>
            <h1>Resumen del negocio</h1>
            <p>Ventas, ingresos y estado de los servidores de un vistazo.</p>
        </div>
        <a href="{{ route('admin.ventas.create') }}" class="btn btn-primary">+ Nueva venta</a>
    </div>

    <div class="stat-row">
        <div class="stat">
            <div class="v">{{ $totalVentas }}</div>
            <div class="l">Ventas registradas</div>
        </div>
        <div class="stat">
            <div class="v">$ {{ number_format((float) $ingresos, 0, ',', '.') }} COP</div>
            <div class="l">Ingresos (confirmadas+)</div>
        </div>
        <div class="stat">
            <div class="v">{{ $totalServidores }}</div>
            <div class="l">Servidores</div>
        </div>
        <div class="stat">
            <div class="v">{{ $totalPlanes }}</div>
            <div class="l">Planes publicados</div>
        </div>
    </div>

    <div class="grid-2">
        <div class="panel">
            <h2 style="margin-top:0;font-size:1.1rem;color:var(--azul);">Ventas por estado</h2>
            <table>
                <tbody>
                    @foreach ($porEstado as $estado => $info)
                        <tr>
                            <td><span class="chip chip-{{ $estado }}">{{ $info['label'] }}</span></td>
                            <td style="text-align:right;font-weight:700;">{{ $info['total'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="panel">
            <h2 style="margin-top:0;font-size:1.1rem;color:var(--azul);">Últimas ventas</h2>
            @if ($ultimasVentas->isEmpty())
                <p class="muted">Aún no hay ventas registradas. <a href="{{ route('admin.ventas.create') }}">Registrar la primera →</a></p>
            @else
                <table>
                    <tbody>
                        @foreach ($ultimasVentas as $venta)
                            <tr>
                                <td>
                                    <strong>{{ $venta->novios }}</strong><br>
                                    <span class="muted" style="font-size:0.82rem;">{{ $venta->plan ?: 'Sin plan' }}</span>
                                </td>
                                <td><span class="chip chip-{{ $venta->estado }}">{{ $venta->estadoLabel() }}</span></td>
                                <td style="text-align:right;font-weight:700;">$ {{ number_format((float) $venta->precio, 0, ',', '.') }} COP</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
