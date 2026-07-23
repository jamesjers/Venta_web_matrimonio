@extends('layouts.admin')

@section('title', $venta->exists ? 'Editar venta' : 'Nueva venta')

@section('content')
    @php
        $editando = $venta->exists;
        $serviciosDisponibles = [
            'Ubicación e itinerario',
            'Invitación digital personalizada',
            'Recordatorios por WhatsApp',
            'Recuerdos (fotos y videos)',
            'Fotos compartidas durante el evento',
            'Control de ingreso con QR',
            'Distribución de mesas',
            'Gestión de invitados',
            'Presupuesto y checklist',
            'Diseño y visual a medida',
            'Dominio con los nombres de los novios',
            'Historia de la pareja',
        ];
        $serviciosVenta = old('servicios', is_array($venta->servicios) ? $venta->servicios : []);
        // Servicios escritos a mano que no están en la lista estándar.
        $serviciosExtra = old('servicios_extra', collect(is_array($venta->servicios) ? $venta->servicios : [])
            ->reject(fn ($s) => in_array($s, $serviciosDisponibles))
            ->implode("\n"));
    @endphp

    <div class="page-head">
        <div>
            <h1>{{ $editando ? 'Editar venta' : 'Nueva venta' }}</h1>
            <p>Registra los datos de la boda, el precio acordado y su personalización.</p>
        </div>
        <a href="{{ route('admin.ventas.index') }}" class="btn btn-light">← Volver</a>
    </div>

    <div class="panel">
        <form method="POST" action="{{ $editando ? route('admin.ventas.update', $venta) : route('admin.ventas.store') }}">
            @csrf
            @if ($editando) @method('PUT') @endif

            <div class="grid-2">
                <div class="field">
                    <label>Novios</label>
                    <input type="text" name="novios" value="{{ old('novios', $venta->novios) }}" placeholder="Ej: Ana & Diego" required>
                </div>
                <div class="field">
                    <label>Persona de contacto</label>
                    <input type="text" name="contacto_nombre" value="{{ old('contacto_nombre', $venta->contacto_nombre) }}">
                </div>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>Teléfono / WhatsApp</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $venta->telefono) }}">
                </div>
                <div class="field">
                    <label>Correo</label>
                    <input type="email" name="email" value="{{ old('email', $venta->email) }}">
                </div>
            </div>

            <div class="grid-3">
                <div class="field">
                    <label>Plan</label>
                    <input type="text" name="plan" list="planes-list" value="{{ old('plan', $venta->plan) }}" placeholder="Ej: Completo">
                    <datalist id="planes-list">
                        @foreach ($planes as $nombrePlan)
                            <option value="{{ $nombrePlan }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="field">
                    <label>Precio de venta (S/)</label>
                    <input type="number" step="0.01" name="precio" value="{{ old('precio', $venta->precio ?? 0) }}" min="0">
                </div>
                <div class="field">
                    <label>Estado</label>
                    <select name="estado">
                        @foreach (\App\Models\Venta::ESTADOS as $val => $label)
                            <option value="{{ $val }}" {{ old('estado', $venta->estado) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="field">
                <label>Fecha del evento</label>
                <input type="date" name="fecha_evento" value="{{ old('fecha_evento', optional($venta->fecha_evento)->format('Y-m-d')) }}">
            </div>

            <hr style="border:none;border-top:1px solid var(--borde);margin:20px 0;">
            <h3 style="margin:0 0 12px;color:var(--azul);font-size:1.05rem;">Dominio y hosting</h3>

            <div class="grid-3">
                <div class="field">
                    <label>Dominio personalizado</label>
                    <input type="text" name="dominio" value="{{ old('dominio', $venta->dominio) }}" placeholder="Ej: ana-y-diego.com">
                </div>
                <div class="field">
                    <label>Servidor</label>
                    <select name="servidor_id">
                        <option value="">— Sin asignar —</option>
                        @foreach ($servidores as $srv)
                            <option value="{{ $srv->id }}" {{ (string) old('servidor_id', $venta->servidor_id) === (string) $srv->id ? 'selected' : '' }}>{{ $srv->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Inicio del hosting</label>
                    <input type="date" name="hosting_inicio" value="{{ old('hosting_inicio', optional($venta->hosting_inicio)->format('Y-m-d')) }}">
                </div>
            </div>
            <p class="muted" style="margin-top:-6px;font-size:0.85rem;">
                Si dejas vacía la fecha de fin, se calcula automáticamente <strong>1 año</strong> después del inicio.
            </p>
            <div class="field" style="max-width:320px;">
                <label>Fin del hosting (opcional)</label>
                <input type="date" name="hosting_fin" value="{{ old('hosting_fin', optional($venta->hosting_fin)->format('Y-m-d')) }}">
            </div>

            <hr style="border:none;border-top:1px solid var(--borde);margin:20px 0;">
            <h3 style="margin:0 0 12px;color:var(--azul);font-size:1.05rem;">Servicios y personalización</h3>

            <div class="grid-3">
                @foreach ($serviciosDisponibles as $servicio)
                    <label class="check-line" style="margin-bottom:8px;font-weight:500;color:var(--texto);">
                        <input type="checkbox" name="servicios[]" value="{{ $servicio }}" {{ in_array($servicio, $serviciosVenta) ? 'checked' : '' }}>
                        {{ $servicio }}
                    </label>
                @endforeach
            </div>

            <div class="field" style="margin-top:14px;">
                <label>Otros servicios / personalizaciones (uno por línea)</label>
                <textarea name="servicios_extra" placeholder="Ej: Libro de firmas digital&#10;Cuenta regresiva animada">{{ $serviciosExtra }}</textarea>
            </div>

            <div class="field">
                <label>Notas internas</label>
                <textarea name="notas">{{ old('notas', $venta->notas) }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">{{ $editando ? 'Guardar cambios' : 'Registrar venta' }}</button>
                <a href="{{ route('admin.ventas.index') }}" class="btn btn-light">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
