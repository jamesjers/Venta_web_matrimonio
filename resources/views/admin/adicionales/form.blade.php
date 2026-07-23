@extends('layouts.admin')

@section('title', $servicio->exists ? 'Editar servicio' : 'Nuevo servicio')

@section('content')
    @php $editando = $servicio->exists; @endphp

    <div class="page-head">
        <div>
            <h1>{{ $editando ? 'Editar servicio adicional' : 'Nuevo servicio adicional' }}</h1>
            <p>Nombre y precio tal como aparecerán en la página.</p>
        </div>
        <a href="{{ route('admin.adicionales.index') }}" class="btn btn-light">← Volver</a>
    </div>

    <div class="panel">
        <form method="POST" action="{{ $editando ? route('admin.adicionales.update', $servicio) : route('admin.adicionales.store') }}">
            @csrf
            @if ($editando) @method('PUT') @endif

            <div class="field">
                <label>Nombre del servicio</label>
                <input type="text" name="nombre" value="{{ old('nombre', $servicio->nombre) }}" required>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Precio (texto libre)</label>
                    <input type="text" name="precio" value="{{ old('precio', $servicio->precio) }}" placeholder="Ej: $90.000 COP o Desde $120.000 COP" required>
                </div>
                <div class="field">
                    <label>Orden</label>
                    <input type="number" name="orden" value="{{ old('orden', $servicio->orden ?? 0) }}" min="0">
                </div>
            </div>

            <div class="field check-line">
                <input type="checkbox" id="activo" name="activo" value="1" {{ old('activo', $servicio->activo ?? true) ? 'checked' : '' }}>
                <label for="activo" style="margin:0;">Mostrar en la página</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">{{ $editando ? 'Guardar cambios' : 'Crear servicio' }}</button>
                <a href="{{ route('admin.adicionales.index') }}" class="btn btn-light">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
