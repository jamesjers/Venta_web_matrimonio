@extends('layouts.admin')

@section('title', $venta->exists ? 'Editar venta' : 'Nueva venta')

@section('content')
    @php
        $editando = $venta->exists;
        $serviciosVenta = old('servicios', is_array($venta->servicios) ? $venta->servicios : []);
        // Servicios escritos a mano que no están en la lista estándar.
        $serviciosExtra = old('servicios_extra', collect(is_array($venta->servicios) ? $venta->servicios : [])
            ->reject(fn ($s) => in_array($s, $serviciosDisponibles))
            ->implode("\n"));
        $planesJson = json_encode($planes->map(fn ($plan) => [
            'nombre' => $plan->nombre,
            'precio' => $plan->precio,
            'caracteristicas' => $plan->caracteristicas ?? [],
        ])->values(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
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
                        @foreach ($planes as $plan)
                            <option value="{{ $plan->nombre }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="field">
                    <label>Precio de venta (COP)</label>
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

            <div id="detalle-plan" class="panel" style="display:none;margin:-2px 0 18px;padding:16px;background:#f7fafc;box-shadow:none;">
                <strong id="detalle-plan-titulo" style="color:var(--azul);"></strong>
                <ul id="detalle-plan-lista" style="columns:2;margin:10px 0 0;padding-left:20px;"></ul>
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

    <script>
        (function () {
            var planes = {!! $planesJson !!};
            var inputPlan = document.querySelector('input[name="plan"]');
            var inputPrecio = document.querySelector('input[name="precio"]');
            var detalle = document.getElementById('detalle-plan');
            var titulo = document.getElementById('detalle-plan-titulo');
            var lista = document.getElementById('detalle-plan-lista');

            function valorNumerico(precio) {
                var digitos = String(precio || '').replace(/\D/g, '');
                return digitos ? Number(digitos) : 0;
            }

            function mostrarPlan(actualizarPrecio) {
                var plan = planes.find(function (item) { return item.nombre === inputPlan.value; });
                if (!plan) {
                    detalle.style.display = 'none';
                    return;
                }

                titulo.textContent = 'Características internas de ' + plan.nombre;
                lista.innerHTML = '';
                plan.caracteristicas.forEach(function (caracteristica) {
                    var item = document.createElement('li');
                    item.textContent = caracteristica;
                    lista.appendChild(item);
                });
                detalle.style.display = 'block';

                if (actualizarPrecio) {
                    inputPrecio.value = valorNumerico(plan.precio);
                }
            }

            inputPlan.addEventListener('change', function () { mostrarPlan(true); });
            inputPlan.addEventListener('input', function () { mostrarPlan(false); });
            mostrarPlan(false);
        })();
    </script>
@endsection
