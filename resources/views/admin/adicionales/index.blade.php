@extends('layouts.admin')

@section('title', 'Cotización personalizada')

@section('content')
    <div class="page-head">
        <div>
            <h1>Opciones de cotización</h1>
            <p>Administran el cálculo personalizado; no se publican como una lista independiente.</p>
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
                    <th>Cálculo</th>
                    <th>Estado</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->orden }}</td>
                        <td>
                            <strong>{{ $servicio->nombre }}</strong><br>
                            <span class="muted" style="font-size:.8rem;">{{ $servicio->descripcion }}</span>
                        </td>
                        <td style="font-weight:700;">{{ $servicio->precio }}</td>
                        <td>
                            {{ match($servicio->tipo_calculo) {
                                'invitados' => 'Por cada '.$servicio->unidad.' invitados',
                                'fotografias' => 'Por cada '.number_format($servicio->unidad, 0, ',', '.').' fotos',
                                default => 'Selección única',
                            } }}
                        </td>
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
                    <tr><td colspan="6" class="muted" style="text-align:center;padding:26px;">No hay opciones. <a href="{{ route('admin.adicionales.create') }}">Crear la primera →</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
