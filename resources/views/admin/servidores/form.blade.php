@extends('layouts.admin')

@section('title', $servidor->exists ? 'Editar servidor' : 'Nuevo servidor')

@section('content')
    @php $editando = $servidor->exists; @endphp

    <div class="page-head">
        <div>
            <h1>{{ $editando ? 'Editar servidor' : 'Nuevo servidor' }}</h1>
            <p>Datos del hosting donde se montan las páginas.</p>
        </div>
        <a href="{{ route('admin.servidores.index') }}" class="btn btn-light">← Volver</a>
    </div>

    <div class="panel">
        <form method="POST" action="{{ $editando ? route('admin.servidores.update', $servidor) : route('admin.servidores.store') }}">
            @csrf
            @if ($editando) @method('PUT') @endif

            <div class="grid-2">
                <div class="field">
                    <label>Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $servidor->nombre) }}" required>
                </div>
                <div class="field">
                    <label>Proveedor</label>
                    <input type="text" name="proveedor" value="{{ old('proveedor', $servidor->proveedor) }}" placeholder="Ej: DigitalOcean, Hostinger">
                </div>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Host / dominio base</label>
                    <input type="text" name="host" value="{{ old('host', $servidor->host) }}" placeholder="Ej: srv1.midominio.com">
                </div>
                <div class="field">
                    <label>IP</label>
                    <input type="text" name="ip" value="{{ old('ip', $servidor->ip) }}" placeholder="Ej: 192.168.0.10">
                </div>
            </div>

            <div class="grid-3">
                <div class="field">
                    <label>Plan de hosting</label>
                    <input type="text" name="plan_hosting" value="{{ old('plan_hosting', $servidor->plan_hosting) }}">
                </div>
                <div class="field">
                    <label>Capacidad (sitios)</label>
                    <input type="number" name="capacidad_sitios" value="{{ old('capacidad_sitios', $servidor->capacidad_sitios ?? 1) }}" min="0">
                </div>
                <div class="field">
                    <label>Estado</label>
                    <select name="estado">
                        @foreach (\App\Models\Servidor::ESTADOS as $val => $label)
                            <option value="{{ $val }}" {{ old('estado', $servidor->estado) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Costo anual (COP)</label>
                    <input type="number" step="0.01" name="costo_anual" value="{{ old('costo_anual', $servidor->costo_anual ?? 0) }}" min="0">
                </div>
                <div class="field">
                    <label>Vencimiento</label>
                    <input type="date" name="vencimiento" value="{{ old('vencimiento', optional($servidor->vencimiento)->format('Y-m-d')) }}">
                </div>
            </div>

            <div class="field">
                <label>Notas</label>
                <textarea name="notas">{{ old('notas', $servidor->notas) }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">{{ $editando ? 'Guardar cambios' : 'Registrar servidor' }}</button>
                <a href="{{ route('admin.servidores.index') }}" class="btn btn-light">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
