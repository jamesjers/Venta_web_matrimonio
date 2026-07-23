@extends('layouts.admin')

@section('title', $plan->exists ? 'Editar plan' : 'Nuevo plan')

@section('content')
    @php
        $editando = $plan->exists;
        $caracteristicasTexto = old('caracteristicas', is_array($plan->caracteristicas) ? implode("\n", $plan->caracteristicas) : '');
    @endphp

    <div class="page-head">
        <div>
            <h1>{{ $editando ? 'Editar plan' : 'Nuevo plan' }}</h1>
            <p>Define el precio y las características internas. En la página pública solo se muestran el nombre, la descripción y el precio.</p>
        </div>
        <a href="{{ route('admin.planes.index') }}" class="btn btn-light">← Volver</a>
    </div>

    <div class="panel">
        <form method="POST" action="{{ $editando ? route('admin.planes.update', $plan) : route('admin.planes.store') }}">
            @csrf
            @if ($editando) @method('PUT') @endif

            <div class="grid-2">
                <div class="field">
                    <label>Nombre del plan</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $plan->nombre) }}" required>
                </div>
                <div class="field">
                    <label>Subtítulo</label>
                    <input type="text" name="subtitulo" value="{{ old('subtitulo', $plan->subtitulo) }}" placeholder="Ej: La opción más elegida">
                </div>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Precio (texto libre)</label>
                    <input type="text" name="precio" value="{{ old('precio', $plan->precio) }}" placeholder="Ej: $799.000 COP o A medida" required>
                </div>
                <div class="field">
                    <label>Orden</label>
                    <input type="number" name="orden" value="{{ old('orden', $plan->orden ?? 0) }}" min="0">
                </div>
            </div>

            <div class="field">
                <label>Descripción corta</label>
                <input type="text" name="descripcion" value="{{ old('descripcion', $plan->descripcion) }}" placeholder="Ej: La experiencia completa para organizar el evento.">
            </div>

            <div class="field">
                <label>Características internas (una por línea)</label>
                <textarea name="caracteristicas" placeholder="Invitación digital personalizada&#10;Recordatorios por WhatsApp&#10;Dominio y hosting por 1 año">{{ $caracteristicasTexto }}</textarea>
            </div>

            <div class="field">
                <label>Infraestructura (texto que aparece al pie del plan)</label>
                <input type="text" name="infraestructura" value="{{ old('infraestructura', $plan->infraestructura) }}" placeholder="Ej: Servidor de 1 vCPU, 1 GB de RAM y 10 GB de almacenamiento.">
            </div>

            <div class="grid-2">
                <div class="field check-line">
                    <input type="checkbox" id="destacado" name="destacado" value="1" {{ old('destacado', $plan->destacado) ? 'checked' : '' }}>
                    <label for="destacado" style="margin:0;">Marcar como destacado ("Más elegido")</label>
                </div>
                <div class="field check-line">
                    <input type="checkbox" id="activo" name="activo" value="1" {{ old('activo', $plan->activo ?? true) ? 'checked' : '' }}>
                    <label for="activo" style="margin:0;">Mostrar en la página</label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">{{ $editando ? 'Guardar cambios' : 'Crear plan' }}</button>
                <a href="{{ route('admin.planes.index') }}" class="btn btn-light">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
