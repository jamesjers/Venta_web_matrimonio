@extends('layouts.admin')

@section('title', 'Configuración')

@section('content')
    <div class="page-head">
        <div>
            <h1>Configuración de la página de ventas</h1>
            <p>Marca, contacto y textos principales que ven tus clientes.</p>
        </div>
        <a href="{{ route('servicio') }}" target="_blank" rel="noopener" class="btn btn-light">Ver página ↗</a>
    </div>

    <div class="panel">
        <form method="POST" action="{{ route('admin.configuracion.update') }}">
            @csrf
            @method('PUT')

            <div class="grid-2">
                <div class="field">
                    <label>Nombre de la marca</label>
                    <input type="text" name="marca" value="{{ old('marca', $config->marca) }}" required>
                </div>
                <div class="field">
                    <label>Lema</label>
                    <input type="text" name="lema" value="{{ old('lema', $config->lema) }}">
                </div>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label>WhatsApp (formato internacional, solo dígitos)</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $config->whatsapp) }}" placeholder="Ej: 51987654321">
                </div>
                <div class="field">
                    <label>Correo de contacto</label>
                    <input type="email" name="email" value="{{ old('email', $config->email) }}">
                </div>
            </div>

            <div class="field">
                <label>Título del hero (portada)</label>
                <input type="text" name="hero_titulo" value="{{ old('hero_titulo', $config->hero_titulo) }}">
            </div>

            <div class="field">
                <label>Texto del hero</label>
                <textarea name="hero_texto">{{ old('hero_texto', $config->hero_texto) }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Guardar configuración</button>
            </div>
        </form>
    </div>
@endsection
