@extends('layouts.admin')

@section('title', 'Servicios adicionales')

@section('content')
    <div class="page-head">
        <div>
            <h1>Servicios adicionales</h1>
            <p>Se muestran en la página de ventas. Los precios se editan aquí.</p>
        </div>
        <a href="{{ route('admin.adicionales.create') }}" class="btn btn-primary">+ Nuevo servicio</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Orden</th>
                    <th>Servicio</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->orden }}</td>
                        <td><strong>{{ $servicio->nombre }}</strong></td>
                        <td style="font-weight:700;">{{ $servicio->precio }}</td>
                        <td>{!! $servicio->activo ? '<span class="chip chip-activo">Activo</span>' : '<span class="chip chip-inactivo">Oculto</span>' !!}</td>
                        <td style="text-align:right;white-space:nowrap;">
                            <a href="{{ route('admin.adicionales.edit', $servicio) }}" class="btn btn-sm btn-light">Editar</a>
                            <form method="POST" action="{{ route('admin.adicionales.destroy', $servicio) }}" class="inline-form" onsubmit="return confirm('¿Eliminar este servicio?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="muted" style="text-align:center;padding:26px;">No hay servicios adicionales. <a href="{{ route('admin.adicionales.create') }}">Crear el primero →</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
