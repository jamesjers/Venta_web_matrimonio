@extends('layouts.admin')

@section('title', 'Planes y precios')

@section('content')
    <div class="page-head">
        <div>
            <h1>Planes y precios</h1>
            <p>Estos planes y sus precios se muestran en la página de ventas.</p>
        </div>
        <a href="{{ route('admin.planes.create') }}" class="btn btn-primary">+ Nuevo plan</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Orden</th>
                    <th>Plan</th>
                    <th>Precio</th>
                    <th>Destacado</th>
                    <th>Estado</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($planes as $plan)
                    <tr>
                        <td>{{ $plan->orden }}</td>
                        <td>
                            <strong>{{ $plan->nombre }}</strong><br>
                            <span class="muted" style="font-size:0.82rem;">{{ $plan->subtitulo }}</span>
                        </td>
                        <td style="font-weight:700;">{{ $plan->precio }}</td>
                        <td>{!! $plan->destacado ? '<span class="chip chip-entregada">Sí</span>' : '<span class="muted">—</span>' !!}</td>
                        <td>{!! $plan->activo ? '<span class="chip chip-activo">Activo</span>' : '<span class="chip chip-inactivo">Oculto</span>' !!}</td>
                        <td style="text-align:right;white-space:nowrap;">
                            <a href="{{ route('admin.planes.edit', $plan) }}" class="btn btn-sm btn-light">Editar</a>
                            <form method="POST" action="{{ route('admin.planes.destroy', $plan) }}" class="inline-form" onsubmit="return confirm('¿Eliminar este plan?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="muted" style="text-align:center;padding:26px;">No hay planes. <a href="{{ route('admin.planes.create') }}">Crear el primero →</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
