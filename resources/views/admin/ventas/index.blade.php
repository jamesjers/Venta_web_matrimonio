@extends('layouts.admin')

@section('title', 'Ventas')

@section('content')
    <div class="page-head">
        <div>
            <h1>Ventas</h1>
            <p>Cada boda vendida, su precio, servidor y vigencia del hosting.</p>
        </div>
        <a href="{{ route('admin.ventas.create') }}" class="btn btn-primary">+ Nueva venta</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Novios</th>
                    <th>Plan</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Dominio / Servidor</th>
                    <th>Hosting hasta</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ventas as $venta)
                    <tr>
                        <td>
                            <strong>{{ $venta->novios }}</strong><br>
                            <span class="muted" style="font-size:0.82rem;">{{ $venta->contacto_nombre ?: $venta->telefono ?: '—' }}</span>
                        </td>
                        <td>{{ $venta->plan ?: '—' }}</td>
                        <td style="font-weight:700;">S/ {{ number_format((float) $venta->precio, 2) }}</td>
                        <td><span class="chip chip-{{ $venta->estado }}">{{ $venta->estadoLabel() }}</span></td>
                        <td>
                            {{ $venta->dominio ?: '—' }}<br>
                            <span class="muted" style="font-size:0.82rem;">{{ optional($venta->servidor)->nombre ?: 'Sin asignar' }}</span>
                        </td>
                        <td>{{ optional($venta->hosting_fin)->format('d/m/Y') ?: '—' }}</td>
                        <td style="text-align:right;white-space:nowrap;">
                            <a href="{{ route('admin.ventas.edit', $venta) }}" class="btn btn-sm btn-light">Editar</a>
                            <form method="POST" action="{{ route('admin.ventas.destroy', $venta) }}" class="inline-form" onsubmit="return confirm('¿Eliminar esta venta?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="muted" style="text-align:center;padding:26px;">Aún no hay ventas. <a href="{{ route('admin.ventas.create') }}">Registrar la primera →</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
