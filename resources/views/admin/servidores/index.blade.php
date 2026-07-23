@extends('layouts.admin')

@section('title', 'Servidores')

@section('content')
    <div class="page-head">
        <div>
            <h1>Servidores</h1>
            <p>Dónde se alojan las páginas de cada boda y su capacidad.</p>
        </div>
        <a href="{{ route('admin.servidores.create') }}" class="btn btn-primary">+ Nuevo servidor</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Servidor</th>
                    <th>Proveedor / Host</th>
                    <th>Ocupación</th>
                    <th>Estado</th>
                    <th>Vence</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($servidores as $servidor)
                    <tr>
                        <td>
                            <strong>{{ $servidor->nombre }}</strong><br>
                            <span class="muted" style="font-size:0.82rem;">{{ $servidor->plan_hosting ?: '—' }}</span>
                        </td>
                        <td>
                            {{ $servidor->proveedor ?: '—' }}<br>
                            <span class="muted" style="font-size:0.82rem;">{{ $servidor->host ?: $servidor->ip ?: '—' }}</span>
                        </td>
                        <td>{{ $servidor->ventas_count }} / {{ $servidor->capacidad_sitios }} sitios</td>
                        <td><span class="chip chip-{{ $servidor->estado }}">{{ $servidor->estadoLabel() }}</span></td>
                        <td>{{ optional($servidor->vencimiento)->format('d/m/Y') ?: '—' }}</td>
                        <td style="text-align:right;white-space:nowrap;">
                            <a href="{{ route('admin.servidores.edit', $servidor) }}" class="btn btn-sm btn-light">Editar</a>
                            <form method="POST" action="{{ route('admin.servidores.destroy', $servidor) }}" class="inline-form" onsubmit="return confirm('¿Eliminar este servidor?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="muted" style="text-align:center;padding:26px;">No hay servidores. <a href="{{ route('admin.servidores.create') }}">Agregar el primero →</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
