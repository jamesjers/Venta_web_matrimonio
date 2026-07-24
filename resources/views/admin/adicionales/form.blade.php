@extends('layouts.admin')

@section('title', $servicio->exists ? 'Editar servicio' : 'Nuevo servicio')

@section('content')
    @php $editando = $servicio->exists; @endphp

    <div class="page-head">
        <div>
            <h1>{{ $editando ? 'Editar opción de cotización' : 'Nueva opción de cotización' }}</h1>
            <p>Configura cómo se calcula esta opción dentro de la cotización personalizada.</p>
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

            <div class="field">
                <label>Descripción clara para el cliente</label>
                <textarea name="descripcion" maxlength="300" required
                    placeholder="Explica qué recibe, los límites y cualquier requisito.">{{ old('descripcion', $servicio->descripcion) }}</textarea>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Precio mostrado</label>
                    <input type="text" name="precio" value="{{ old('precio', $servicio->precio) }}" placeholder="Ej: $70.000 COP por cada 50" required>
                </div>
                <div class="field">
                    <label>Valor para el cálculo (COP)</label>
                    <input type="number" name="precio_valor" value="{{ old('precio_valor', $servicio->precio_valor ?? 0) }}" min="0" step="1" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Valor de cada bloque adicional (COP)</label>
                    <input type="number" name="precio_adicional" value="{{ old('precio_adicional', $servicio->precio_adicional ?? 0) }}" min="0" step="1">
                    <small class="muted">Se usa después del primer bloque de fotos. Para las demás opciones puede quedar en cero.</small>
                </div>
                <div class="field">
                    <label>Forma de cálculo</label>
                    <select name="tipo_calculo" required>
                        <option value="seleccion" {{ old('tipo_calculo', $servicio->tipo_calculo ?? 'seleccion') === 'seleccion' ? 'selected' : '' }}>Selección única</option>
                        <option value="invitados" {{ old('tipo_calculo', $servicio->tipo_calculo) === 'invitados' ? 'selected' : '' }}>Cantidad de invitados</option>
                        <option value="fotografias" {{ old('tipo_calculo', $servicio->tipo_calculo) === 'fotografias' ? 'selected' : '' }}>Cantidad de fotos</option>
                    </select>
                </div>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Unidad cobrada</label>
                    <input type="number" name="unidad" value="{{ old('unidad', $servicio->unidad ?? 1) }}" min="1" step="1" required>
                </div>
                <div class="field">
                    <label>Orden</label>
                    <input type="number" name="orden" value="{{ old('orden', $servicio->orden ?? 0) }}" min="0">
                </div>
            </div>

            <div class="field check-line">
                <input type="checkbox" id="activo" name="activo" value="1" {{ old('activo', $servicio->activo ?? true) ? 'checked' : '' }}>
                <label for="activo" style="margin:0;">Disponible en la cotización personalizada</label>
            </div>

            <div class="field check-line">
                <input type="checkbox" id="requiere_fotos" name="requiere_fotos" value="1" {{ old('requiere_fotos', $servicio->requiere_fotos ?? false) ? 'checked' : '' }}>
                <label for="requiere_fotos" style="margin:0;">Requiere contratar una galería de fotos</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">{{ $editando ? 'Guardar cambios' : 'Crear servicio' }}</button>
                <a href="{{ route('admin.adicionales.index') }}" class="btn btn-light">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
