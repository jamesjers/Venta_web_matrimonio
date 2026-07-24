<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Administración · @yield('title', 'Ventas')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/logo-eventos.svg') }}">
    <style>
        :root {
            --azul: #0a1c39;
            --azul-2: #0e2a4d;
            --petroleo: #0e5a5c;
            --petroleo-2: #12807f;
            --oro: #eab455;
            --texto: #1c2a42;
            --suave: #6b7688;
            --borde: #e4ebf2;
            --bg: #f5f8fb;
            --ok: #1f8a70;
            --warn: #da8b00;
            --peligro: #b03636;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg);
            color: var(--texto);
            min-height: 100vh;
        }
        a { color: inherit; text-decoration: none; }
        .admin-top {
            background: linear-gradient(110deg, var(--azul) 0%, var(--azul-2) 55%, var(--petroleo) 100%);
            color: #fff;
            padding: 12px 22px;
            display: flex; align-items: center; justify-content: space-between;
            gap: 18px; flex-wrap: wrap;
            position: sticky; top: 0; z-index: 40;
        }
        .admin-brand { display: flex; align-items: center; gap: 11px; font-weight: 800; }
        .admin-brand img { width: 34px; height: 34px; border-radius: 9px; }
        .admin-brand small { display: block; font-weight: 500; font-size: 0.72rem; color: rgba(255,255,255,0.8); }
        .admin-nav { display: flex; gap: 6px; flex-wrap: wrap; }
        .admin-nav a {
            font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.9);
            padding: 7px 13px; border-radius: 999px; border: 1px solid transparent;
        }
        .admin-nav a:hover { background: rgba(255,255,255,0.12); }
        .admin-nav a.active { background: rgba(255,255,255,0.2); border-color: rgba(255,255,255,0.4); }
        .admin-top-right { display: flex; align-items: center; gap: 12px; font-size: 0.85rem; }
        .admin-wrap { max-width: 1100px; margin: 26px auto; padding: 0 20px 40px; }
        .page-head { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 20px; }
        .page-head h1 { margin: 0; font-size: 1.55rem; color: var(--azul); }
        .page-head p { margin: 4px 0 0; color: var(--suave); font-size: 0.95rem; }
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            border: none; border-radius: 10px; padding: 10px 16px;
            font-weight: 700; font-size: 0.9rem; cursor: pointer; font-family: inherit;
        }
        .btn-primary { background: var(--petroleo); color: #fff; }
        .btn-primary:hover { background: var(--petroleo-2); }
        .btn-light { background: #fff; color: var(--azul); border: 1px solid var(--borde); }
        .btn-light:hover { background: #eef4f9; }
        .btn-danger { background: #fff; color: var(--peligro); border: 1px solid #edc9c9; }
        .btn-danger:hover { background: #fbeaea; }
        .btn-sm { padding: 6px 11px; font-size: 0.82rem; border-radius: 8px; }
        .panel {
            background: #fff; border: 1px solid var(--borde); border-radius: 16px;
            padding: 22px; box-shadow: 0 8px 22px rgba(18,40,72,0.05);
        }
        .flash { border-radius: 12px; padding: 12px 16px; margin-bottom: 18px; font-weight: 600; }
        .flash-ok { background: #e7f6ef; color: #1c6a54; border: 1px solid #bde6d6; }
        .errores { background: #fdecec; color: #8d2b2b; border: 1px solid #f2c4c4; border-radius: 12px; padding: 12px 16px; margin-bottom: 18px; }
        .errores ul { margin: 8px 0 0; padding-left: 18px; }
        table { width: 100%; border-collapse: collapse; }
        .table-wrap { overflow-x: auto; border: 1px solid var(--borde); border-radius: 14px; background: #fff; }
        th, td { text-align: left; padding: 12px 14px; border-bottom: 1px solid #eef2f6; font-size: 0.9rem; vertical-align: middle; }
        th { background: #f7fafc; color: var(--suave); text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.5px; }
        tr:last-child td { border-bottom: none; }
        .chip { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 0.76rem; font-weight: 700; }
        .chip-cotizacion { background: #eef4fa; color: #3867b4; }
        .chip-confirmada { background: #fff5e2; color: #b5820f; }
        .chip-montada { background: #e8f0ff; color: #3558a8; }
        .chip-entregada { background: #e6f5ee; color: #1f8a70; }
        .chip-cancelada { background: #fdeaea; color: #b03636; }
        .chip-activo { background: #e6f5ee; color: #1f8a70; }
        .chip-mantenimiento { background: #fff5e2; color: #b5820f; }
        .chip-inactivo { background: #efeff1; color: #6b7688; }
        .field { margin-bottom: 16px; }
        .field label { display: block; font-weight: 600; color: var(--azul); margin-bottom: 6px; font-size: 0.9rem; }
        .field input, .field select, .field textarea {
            width: 100%; border: 1px solid var(--borde); border-radius: 9px; padding: 10px 12px;
            font-size: 0.94rem; font-family: inherit; color: var(--texto); background: #fff;
        }
        .field textarea { min-height: 96px; resize: vertical; }
        .field input:focus, .field select:focus, .field textarea:focus { outline: 2px solid rgba(14,90,92,0.18); border-color: var(--petroleo); }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 22px; }
        .stat { background: #fff; border: 1px solid var(--borde); border-radius: 16px; padding: 18px 20px; }
        .stat .v { font-size: 1.8rem; font-weight: 800; color: var(--petroleo); }
        .stat .l { color: var(--suave); font-size: 0.85rem; font-weight: 600; }
        .check-line { display: flex; align-items: center; gap: 9px; }
        .check-line input { width: auto; }
        .form-actions { display: flex; gap: 10px; margin-top: 8px; flex-wrap: wrap; }
        .inline-form { display: inline; }
        .muted { color: var(--suave); }
        @media (max-width: 780px) {
            .grid-2, .grid-3, .stat-row { grid-template-columns: 1fr; }
        }
    </style>
    @stack('head')
</head>
<body>
    <header class="admin-top">
        <div class="admin-brand">
            <img src="{{ asset('assets/logo-eventos.svg') }}" alt="">
            <div>
                Administración
                <small>Invitaciones y páginas web para eventos</small>
            </div>
        </div>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Resumen</a>
            <a href="{{ route('admin.ventas.index') }}" class="{{ request()->routeIs('admin.ventas.*') ? 'active' : '' }}">Ventas</a>
            <a href="{{ route('admin.servidores.index') }}" class="{{ request()->routeIs('admin.servidores.*') ? 'active' : '' }}">Servidores</a>
            <a href="{{ route('admin.planes.index') }}" class="{{ request()->routeIs('admin.planes.*') ? 'active' : '' }}">Planes y precios</a>
            <a href="{{ route('admin.adicionales.index') }}" class="{{ request()->routeIs('admin.adicionales.*') ? 'active' : '' }}">Cotizador</a>
            <a href="{{ route('admin.configuracion.edit') }}" class="{{ request()->routeIs('admin.configuracion.*') ? 'active' : '' }}">Configuración</a>
        </nav>
        <div class="admin-top-right">
            <a href="{{ route('servicio') }}" target="_blank" rel="noopener" style="color:#fff;opacity:0.9;">Ver página ↗</a>
            <form method="POST" action="{{ route('logout') }}" class="inline-form">
                @csrf
                <button class="btn btn-sm btn-light" type="submit">Salir</button>
            </form>
        </div>
    </header>

    <main class="admin-wrap">
        @if (session('success'))
            <div class="flash flash-ok">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="errores">
                Revisa los datos:
                <ul>
                    @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
