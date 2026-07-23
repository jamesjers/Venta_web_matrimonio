@php
    $marca = $config->marca ?: 'MatrimonioWeb';
    $lema = $config->lema ?: 'Páginas web para matrimonios, hechas a la medida de su historia';
    $wa = $config->whatsappDigitos();
    $email = $config->email ?: 'contacto@matrimonioweb.com';
    $heroTitulo = $config->hero_titulo ?: 'La web de su boda, de la invitación al último recuerdo';
    $heroTexto = $config->hero_texto ?: 'Diseñamos una página única con el dominio y los nombres de los novios, montada durante un año completo.';
    $waMsg = rawurlencode('Hola, quiero información sobre la página web para mi matrimonio.');
    $waLink = $wa !== '' ? "https://wa.me/{$wa}?text={$waMsg}" : '#planes';

    $servicios = [
        ['Ubicación', 'Ubicación e itinerario', 'Iglesia y salón con mapa, hora y detalles. Tus invitados llegan sin perderse.', '#1d6fa6'],
        ['Invitación', 'Invitación digital', 'Tarjeta elegante con música, historia y confirmación de asistencia en un clic.', '#0e5a5c'],
        ['Recordatorios', 'Recordatorios automáticos', 'Mensajes por WhatsApp a quienes no confirman. Menos ausencias, más asistentes.', '#128c7e'],
        ['Recuerdos', 'Recuerdos del gran día', 'Tus invitados suben fotos y videos y todo queda guardado en un solo lugar.', '#8a5cc0'],
        ['En vivo', 'Fotos compartidas en el evento', 'Una vista en común donde las fotos que suben los invitados aparecen durante la fiesta.', '#c0873a'],
        ['Ingreso', 'Control de ingreso con QR', 'Cada invitado con su código QR. Validas el acceso en segundos desde el celular.', '#b85c1a'],
        ['Mesas', 'Distribución de mesas', 'Organiza quién se sienta dónde arrastrando invitados a cada mesa.', '#3d5a80'],
        ['Todo', 'Invitados, gastos y checklist', 'Confirmados, presupuesto y tareas bajo control camino al gran día.', '#2f8f6f'],
    ];

    $pasos = [
        ['Nos cuentan de su boda', 'Fecha, estilo, lugares, fotos e historia de la pareja.'],
        ['Diseñamos a su medida', 'Elegimos colores, visual y los servicios que realmente necesitan.'],
        ['Montamos su dominio', 'Publicamos la web con los nombres de los novios, lista para compartir.'],
        ['Disfrutan todo el año', 'Su página queda montada durante 1 año, del save the date al agradecimiento.'],
    ];
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $marca }} · Páginas web para matrimonios a la medida</title>
    <meta name="description" content="{{ $lema }}. Invitación digital, ubicación, recordatorios por WhatsApp, ingreso con QR, distribución de mesas y fotos compartidas en vivo. Dominio con los nombres de los novios, montado por 1 año.">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/logo-matrimonio.svg') }}">
    <style>
        :root {
            --azul: #060f22;
            --azul-2: #0a1c39;
            --petroleo: #0e5a5c;
            --petroleo-2: #16a19b;
            --oro: #f6cc83;
            --oro-2: #eab455;
            --tinta: #16233c;
            --suave: #667a93;
            --lavado: #f3f7fb;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--tinta);
            background: #fff;
            line-height: 1.6;
            overflow-x: hidden;
        }
        a { color: inherit; text-decoration: none; }
        .wrap { width: 100%; max-width: 1180px; margin: 0 auto; padding: 0 24px; }
        .grad-text {
            background: linear-gradient(100deg, var(--oro) 0%, var(--petroleo-2) 90%);
            -webkit-background-clip: text; background-clip: text; color: transparent;
        }

        /* ---- NAV ---- */
        .nav {
            position: sticky; top: 0; z-index: 60;
            background: rgba(6, 15, 34, 0.72);
            backdrop-filter: blur(14px);
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .nav-in { display: flex; align-items: center; justify-content: space-between; padding: 14px 24px; max-width: 1180px; margin: 0 auto; }
        .logo { display: flex; align-items: center; gap: 11px; font-weight: 800; font-size: 1.1rem; letter-spacing: 0.2px; }
        .logo img { width: 36px; height: 36px; border-radius: 10px; }
        .nav-links { display: flex; align-items: center; gap: 30px; }
        .nav-links a { font-size: 0.92rem; font-weight: 600; color: rgba(255,255,255,0.82); }
        .nav-links a:hover { color: #fff; }
        .nav-cta { padding: 10px 20px; border-radius: 999px; background: linear-gradient(120deg, var(--oro), var(--oro-2)); color: var(--azul) !important; font-weight: 800 !important; }
        @media (max-width: 820px) { .nav-links a:not(.nav-cta) { display: none; } }

        /* ---- BOTONES ---- */
        .btn { display: inline-flex; align-items: center; gap: 10px; padding: 16px 30px; border-radius: 999px; font-size: 1rem; font-weight: 800; cursor: pointer; border: none; transition: transform .18s ease, box-shadow .18s ease, filter .18s ease; font-family: inherit; }
        .btn:hover { transform: translateY(-3px); }
        .btn svg { width: 20px; height: 20px; }
        .btn-oro { background: linear-gradient(120deg, var(--oro), var(--oro-2)); color: var(--azul); box-shadow: 0 18px 40px rgba(234,180,85,.35); }
        .btn-wa { background: linear-gradient(120deg, #25d366, #0e5a5c); color: #fff; box-shadow: 0 18px 40px rgba(18,140,126,.35); }
        .btn-line { background: transparent; color: #fff; border: 1.6px solid rgba(255,255,255,.45); }
        .btn-line:hover { background: rgba(255,255,255,.1); }

        /* ---- HERO ---- */
        .hero { position: relative; color: #fff; padding: 92px 0 120px;
            background:
                radial-gradient(1100px 600px at 8% -5%, rgba(22,161,155,.28), transparent 60%),
                radial-gradient(900px 600px at 100% 8%, rgba(37,99,175,.4), transparent 55%),
                linear-gradient(160deg, #050c1c 0%, #0a1c39 55%, #0a2a42 100%);
        }
        .blob { position: absolute; border-radius: 50%; filter: blur(70px); opacity: .55; pointer-events: none; z-index: 0; }
        .blob.b1 { width: 360px; height: 360px; background: #16a19b; top: -60px; left: -80px; animation: float1 12s ease-in-out infinite; }
        .blob.b2 { width: 420px; height: 420px; background: #2b5ea8; bottom: -120px; right: -100px; animation: float2 15s ease-in-out infinite; }
        @keyframes float1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(30px,40px)} }
        @keyframes float2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-40px,-30px)} }
        .hero-in { position: relative; z-index: 1; display: grid; grid-template-columns: 1.1fr .9fr; gap: 48px; align-items: center; }
        .eyebrow { display: inline-flex; align-items: center; gap: 8px; font-size: .76rem; text-transform: uppercase; letter-spacing: 2.5px; font-weight: 800; color: var(--oro); margin-bottom: 22px; }
        .eyebrow::before { content: ""; width: 26px; height: 2px; background: var(--oro); display: inline-block; }
        .hero h1 { margin: 0; font-size: clamp(2.4rem, 6vw, 4.1rem); line-height: 1.05; letter-spacing: -.02em; font-weight: 800; }
        .hero .lead { margin: 24px 0 0; font-size: 1.18rem; color: rgba(255,255,255,.85); max-width: 540px; }
        .hero-actions { margin-top: 38px; display: flex; gap: 16px; flex-wrap: wrap; }
        .hero-stats { margin-top: 44px; display: flex; gap: 40px; flex-wrap: wrap; }
        .hero-stats b { display: block; font-size: 1.7rem; font-weight: 800; background: linear-gradient(120deg,#fff,var(--oro)); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .hero-stats span { color: rgba(255,255,255,.72); font-size: .9rem; }

        /* Phone mockup (sin marco de caja) */
        .phone { position: relative; justify-self: center; width: 300px; }
        .phone-glow { position: absolute; inset: -40px; background: radial-gradient(circle, rgba(246,204,131,.35), transparent 65%); filter: blur(30px); z-index: 0; }
        .phone-screen {
            position: relative; z-index: 1; border-radius: 42px; padding: 20px;
            background: linear-gradient(180deg,#ffffff,#f3f7fb);
            box-shadow: 0 40px 80px rgba(2,8,23,.55), inset 0 0 0 8px rgba(10,28,57,.9);
            color: var(--tinta);
            animation: floatPhone 6s ease-in-out infinite;
        }
        @keyframes floatPhone { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
        .phone-top { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
        .phone-top img { width: 40px; height: 40px; border-radius: 11px; }
        .phone-top .pn { font-weight: 800; color: var(--azul-2); }
        .phone-top .ps { font-size: .74rem; color: var(--suave); }
        .phone-hero { height: 130px; border-radius: 20px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; letter-spacing: 1px; text-align: center;
            background: radial-gradient(circle at 30% 25%, rgba(246,204,131,.6), transparent 60%), linear-gradient(135deg,#0e5a5c,#1d6fa6); }
        .phone-list { margin-top: 12px; display: grid; gap: 8px; }
        .pl { display: flex; align-items: center; gap: 9px; font-size: .82rem; }
        .pl i { width: 26px; height: 26px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-style: normal; }
        .phone-cta { margin-top: 14px; text-align: center; padding: 11px; border-radius: 14px; font-weight: 800; font-size: .86rem; color: #fff; background: linear-gradient(120deg,#25d366,#0e5a5c); }
        @media (max-width: 900px) { .hero-in { grid-template-columns: 1fr; } .phone { margin-top: 20px; } }

        /* ---- MARQUEE ---- */
        .strip { background: var(--azul-2); color: rgba(255,255,255,.9); padding: 16px 0; overflow: hidden; white-space: nowrap; }
        .strip-track { display: inline-flex; gap: 42px; animation: slide 24s linear infinite; font-weight: 700; letter-spacing: .5px; }
        .strip-track span { opacity: .85; }
        .strip-track b { color: var(--oro); }
        @keyframes slide { from { transform: translateX(0); } to { transform: translateX(-50%); } }

        /* ---- SECCIONES ---- */
        section { padding: 96px 0; }
        .head { max-width: 720px; margin: 0 auto 60px; text-align: center; }
        .kicker { font-size: .78rem; text-transform: uppercase; letter-spacing: 2.5px; font-weight: 800; color: var(--petroleo); }
        .head h2 { margin: 12px 0 14px; font-size: clamp(2rem, 4.6vw, 3rem); color: var(--azul-2); line-height: 1.12; letter-spacing: -.01em; }
        .head p { margin: 0; color: var(--suave); font-size: 1.12rem; }

        /* Servicios: SIN cuadros, solo icono + texto */
        .servicios-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 44px 36px; }
        .serv { }
        .serv .ic { width: 58px; height: 58px; border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; box-shadow: 0 14px 30px rgba(14,40,72,.16); }
        .serv .ic svg { width: 30px; height: 30px; color: #fff; }
        .serv .t { font-size: .72rem; text-transform: uppercase; letter-spacing: 1.6px; font-weight: 800; color: var(--petroleo); }
        .serv h3 { margin: 5px 0 8px; font-size: 1.16rem; color: var(--azul-2); line-height: 1.25; }
        .serv p { margin: 0; color: var(--suave); font-size: .96rem; }
        @media (max-width: 960px) { .servicios-grid { grid-template-columns: repeat(2, 1fr); gap: 40px 28px; } }
        @media (max-width: 540px) { .servicios-grid { grid-template-columns: 1fr; } }

        /* Feature alterna (full-bleed, sin caja) */
        .feature-band { background: var(--lavado); }
        .feature-row { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
        .feature-row + .feature-row { margin-top: 90px; }
        .feature-row.rev .ft-media { order: 2; }
        .ft-media { height: 340px; border-radius: 30px; position: relative; overflow: hidden; box-shadow: 0 30px 60px rgba(14,40,72,.18); }
        .ft-media.m1 { background: radial-gradient(circle at 30% 30%, rgba(246,204,131,.5), transparent 55%), linear-gradient(140deg,#0e5a5c,#1d6fa6); }
        .ft-media.m2 { background: radial-gradient(circle at 70% 30%, rgba(138,92,192,.55), transparent 55%), linear-gradient(140deg,#2b3f77,#0a1c39); }
        .ft-media .emoji { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 5.5rem; }
        .ft-text .kicker { color: var(--petroleo); }
        .ft-text h3 { font-size: clamp(1.7rem,3.6vw,2.4rem); color: var(--azul-2); margin: 10px 0 14px; line-height: 1.15; }
        .ft-text p { color: var(--suave); font-size: 1.06rem; margin: 0 0 18px; }
        .ft-list { list-style: none; padding: 0; margin: 0; display: grid; gap: 12px; }
        .ft-list li { display: flex; gap: 12px; align-items: flex-start; font-weight: 600; color: var(--tinta); }
        .ft-list li svg { width: 22px; height: 22px; color: var(--petroleo-2); flex-shrink: 0; margin-top: 2px; }
        @media (max-width: 860px) { .feature-row { grid-template-columns: 1fr; gap: 30px; } .feature-row.rev .ft-media { order: 0; } .ft-media { height: 240px; } }

        /* Personalizacion + dominio band */
        .promesa { color: #fff; text-align: center; position: relative; overflow: hidden;
            background: radial-gradient(800px 400px at 50% -10%, rgba(22,161,155,.4), transparent 60%), linear-gradient(150deg,#0a1c39,#0e5a5c); }
        .promesa h2 { font-size: clamp(1.9rem,4.4vw,2.9rem); margin: 0 auto 16px; max-width: 780px; line-height: 1.15; }
        .promesa p { color: rgba(255,255,255,.85); font-size: 1.14rem; max-width: 620px; margin: 0 auto 12px; }
        .promesa-tags { margin-top: 30px; display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
        .promesa-tags span { border: 1px solid rgba(255,255,255,.3); border-radius: 999px; padding: 10px 20px; font-weight: 700; font-size: .95rem; }

        /* Pasos (sin caja) */
        .pasos { display: grid; grid-template-columns: repeat(4, 1fr); gap: 34px; counter-reset: paso; }
        .paso { position: relative; padding-top: 14px; border-top: 3px solid #e7eef5; }
        .paso::before { counter-increment: paso; content: "0" counter(paso); display: block; font-size: 2.4rem; font-weight: 800; line-height: 1; margin-bottom: 12px;
            background: linear-gradient(120deg, var(--petroleo-2), var(--oro-2)); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .paso h3 { margin: 0 0 6px; font-size: 1.1rem; color: var(--azul-2); }
        .paso p { margin: 0; color: var(--suave); font-size: .95rem; }
        @media (max-width: 860px) { .pasos { grid-template-columns: 1fr 1fr; gap: 28px; } }
        @media (max-width: 480px) { .pasos { grid-template-columns: 1fr; } }

        /* Planes: fila de tarjetas desplazables (soporta muchos planes) */
        .planes { background: var(--lavado); }
        .planes-scroll { display: flex; gap: 22px; overflow-x: auto; padding: 6px 4px 22px; scroll-snap-type: x mandatory; scrollbar-width: thin; }
        .plan { scroll-snap-align: start; flex: 0 0 300px; background: #fff; border: 1px solid var(--borde, #e4ebf2); border-radius: 22px; padding: 30px 26px; display: flex; flex-direction: column; box-shadow: 0 16px 40px rgba(14,40,72,.08); }
        .plan.top { background: linear-gradient(180deg,#0a1c39,#0e5a5c); color: #fff; border-color: transparent; box-shadow: 0 26px 56px rgba(14,90,92,.3); }
        .plan .badge { align-self: flex-start; background: linear-gradient(120deg,var(--oro),var(--oro-2)); color: var(--azul-2); font-size: .66rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; padding: 5px 12px; border-radius: 999px; margin-bottom: 14px; }
        .plan h3 { margin: 0; font-size: 1.3rem; }
        .plan .ideal { font-size: .86rem; opacity: .78; margin: 3px 0 12px; }
        .plan .desc { font-size: .88rem; opacity: .8; margin: 0 0 16px; line-height: 1.5; }
        .plan .desde { font-size: .72rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; opacity: .7; }
        .plan .price { font-size: 1.9rem; font-weight: 800; line-height: 1.1; }
        .plan.top .price { color: var(--oro); }
        .plan:not(.top) .price { color: var(--petroleo); }
        .plan ul { list-style: none; padding: 0; margin: 18px 0 20px; display: grid; gap: 10px; }
        .plan li { display: flex; gap: 10px; align-items: flex-start; font-size: .9rem; }
        .plan li svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 2px; color: var(--petroleo-2); }
        .plan.top li svg { color: var(--oro); }
        .plan .infra { font-size: .78rem; opacity: .7; line-height: 1.45; border-top: 1px solid rgba(120,140,170,.25); padding-top: 12px; margin-bottom: 18px; }
        .plan .btn { margin-top: auto; justify-content: center; width: 100%; padding: 13px; }
        .plan:not(.top) .btn-plan { background: var(--azul-2); color: #fff; }
        .plan.top .btn-plan { background: linear-gradient(120deg,var(--oro),var(--oro-2)); color: var(--azul-2); }
        .planes-hint { text-align: center; color: var(--suave); font-size: .85rem; margin-top: 6px; }

        /* Tabla comparativa */
        .tabla-wrap { overflow-x: auto; border-radius: 18px; border: 1px solid var(--borde,#e4ebf2); box-shadow: 0 16px 40px rgba(14,40,72,.08); }
        table.comparativa { width: 100%; border-collapse: collapse; background: #fff; min-width: 720px; }
        table.comparativa th, table.comparativa td { padding: 14px 16px; text-align: center; border-bottom: 1px solid #eef2f7; font-size: .92rem; }
        table.comparativa thead th { background: var(--azul-2); color: #fff; font-weight: 700; }
        table.comparativa thead th:first-child { text-align: left; border-top-left-radius: 18px; }
        table.comparativa tbody th { text-align: left; font-weight: 600; color: var(--azul-2); background: #f7fafc; }
        table.comparativa tbody tr:last-child td, table.comparativa tbody tr:last-child th { border-bottom: none; }
        table.comparativa .si { color: var(--petroleo); font-weight: 800; }
        table.comparativa .no { color: #c2ccd8; }
        table.comparativa .precio-row td, table.comparativa .precio-row th { font-weight: 800; color: var(--azul-2); background: #eef6f5; }

        /* Servicios adicionales */
        .adic-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px 32px; max-width: 900px; margin: 0 auto; }
        .adic { display: flex; justify-content: space-between; align-items: baseline; gap: 14px; padding: 12px 0; border-bottom: 1px dashed #d9e2ec; }
        .adic .n { color: var(--tinta); }
        .adic .p { font-weight: 800; color: var(--petroleo); white-space: nowrap; }
        .adic-nota { text-align: center; color: var(--suave); font-size: .86rem; max-width: 720px; margin: 26px auto 0; }
        @media (max-width: 680px) { .adic-grid { grid-template-columns: 1fr; } }

        /* Testimonio */
        .testi { text-align: center; }
        .testi .stars { color: var(--oro-2); font-size: 1.5rem; letter-spacing: 4px; }
        .testi blockquote { margin: 18px auto 0; max-width: 800px; font-size: clamp(1.35rem,3vw,1.9rem); font-weight: 600; color: var(--azul-2); line-height: 1.4; }
        .testi .who { margin-top: 22px; color: var(--suave); font-weight: 700; }

        /* CTA final */
        .cta { color: #fff; text-align: center; position: relative; overflow: hidden;
            background: radial-gradient(700px 380px at 50% 120%, rgba(246,204,131,.3), transparent 60%), linear-gradient(140deg,#0a1c39,#0a2a42); }
        .cta h2 { font-size: clamp(2rem,4.6vw,3rem); margin: 0 0 16px; }
        .cta p { color: rgba(255,255,255,.85); max-width: 560px; margin: 0 auto 34px; font-size: 1.12rem; }
        .cta-actions { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }

        /* Footer */
        .foot { background: #060f22; color: rgba(255,255,255,.7); padding: 40px 0; text-align: center; }
        .foot .logo { justify-content: center; color: #fff; margin-bottom: 12px; }
        .foot a { color: var(--oro); }

        /* Reveal */
        .reveal { opacity: 0; transform: translateY(26px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.in { opacity: 1; transform: none; }
        @media (prefers-reduced-motion: reduce) { .reveal { opacity: 1; transform: none; } .blob, .phone-screen, .strip-track { animation: none; } }
    </style>
</head>
<body id="top">
    <!-- NAV -->
    <header class="nav">
        <div class="nav-in">
            <a class="logo" href="#top"><img src="{{ asset('assets/logo-matrimonio.svg') }}" alt="">{{ $marca }}</a>
            <nav class="nav-links">
                <a href="#servicios">Servicios</a>
                <a href="#personalizacion">Personalización</a>
                <a href="#planes">Planes</a>
                <a class="nav-cta" href="{{ $waLink }}" @if($wa !== '') target="_blank" rel="noopener" @endif>Solicitar</a>
            </nav>
        </div>
    </header>

    <!-- HERO -->
    <div class="hero">
        <span class="blob b1"></span>
        <span class="blob b2"></span>
        <div class="wrap hero-in">
            <div>
                <span class="eyebrow">Páginas web para matrimonios</span>
                <h1>{!! e($heroTitulo) !!}</h1>
                <p class="lead">{{ $heroTexto }}</p>
                <div class="hero-actions">
                    <a class="btn btn-wa" href="{{ $waLink }}" @if($wa !== '') target="_blank" rel="noopener" @endif>
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Zm5.8 14.12c-.24.68-1.42 1.32-1.95 1.36-.5.04-.99.28-3.4-.72-2.87-1.19-4.7-4.15-4.85-4.34-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.09 1-2.38.24-.26.53-.33.71-.33.18 0 .35 0 .5.01.16.007.38-.06.59.45.24.55.79 1.92.86 2.06.07.14.12.3.02.49-.42.83-.87 1-.42.94-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.69-.8.87-1.08.18-.28.36-.23.61-.14.25.09 1.6.75 1.87.89.28.14.46.21.53.33.07.12.07.68-.17 1.36Z"/></svg>
                        Escríbenos por WhatsApp
                    </a>
                    <a class="btn btn-line" href="#servicios">Ver lo que incluye</a>
                </div>
                <div class="hero-stats">
                    <div><b>1 año</b><span>montada online</span></div>
                    <div><b>Tu dominio</b><span>con sus nombres</span></div>
                    <div><b>100%</b><span>a la medida</span></div>
                </div>
            </div>

            <!-- Phone -->
            <div class="phone" aria-hidden="true">
                <div class="phone-glow"></div>
                <div class="phone-screen">
                    <div class="phone-top">
                        <img src="{{ asset('assets/logo-matrimonio.svg') }}" alt="">
                        <div><div class="pn">Ana &amp; Diego</div><div class="ps">15 de febrero · 5:00 pm</div></div>
                    </div>
                    <div class="phone-hero">NUESTRA<br>HISTORIA</div>
                    <div class="phone-list">
                        <div class="pl"><i style="background:#e7f0fa;">📍</i> Iglesia &amp; salón con mapa</div>
                        <div class="pl"><i style="background:#e5f3ef;">💌</i> Confirma tu asistencia</div>
                        <div class="pl"><i style="background:#fdeede;">🎫</i> Tu QR de ingreso</div>
                        <div class="pl"><i style="background:#f1e9fa;">📸</i> Fotos compartidas en vivo</div>
                    </div>
                    <div class="phone-cta">Confirmar asistencia</div>
                </div>
            </div>
        </div>
    </div>

    <!-- STRIP -->
    <div class="strip" aria-hidden="true">
        <div class="strip-track">
            <span>Ubicación</span><b>·</b><span>Invitación digital</span><b>·</b><span>Recordatorios</span><b>·</b><span>Recuerdos</span><b>·</b><span>Fotos en vivo</span><b>·</b><span>Ingreso con QR</span><b>·</b><span>Mesas</span><b>·</b>
            <span>Ubicación</span><b>·</b><span>Invitación digital</span><b>·</b><span>Recordatorios</span><b>·</b><span>Recuerdos</span><b>·</b><span>Fotos en vivo</span><b>·</b><span>Ingreso con QR</span><b>·</b><span>Mesas</span><b>·</b>
        </div>
    </div>

    <!-- SERVICIOS -->
    <section id="servicios">
        <div class="wrap">
            <div class="head reveal">
                <div class="kicker">Todo en un solo lugar</div>
                <h2>Todos los servicios que necesita su boda</h2>
                <p>Antes, durante y después del gran día. Y si necesitan algo distinto, lo agregamos: la web se arma según lo que ustedes requieran.</p>
            </div>
            <div class="servicios-grid">
                @foreach ($servicios as $i => $s)
                    <div class="serv reveal" style="transition-delay: {{ $i * 60 }}ms;">
                        <div class="ic" style="background: {{ $s[3] }};">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2l2.5 5 5.5.8-4 3.9.95 5.5L12 20l-4.95 2.6.95-5.5-4-3.9 5.5-.8z"/></svg>
                        </div>
                        <div class="t">{{ $s[0] }}</div>
                        <h3>{{ $s[1] }}</h3>
                        <p>{{ $s[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FEATURES ALTERNAS -->
    <section id="personalizacion" class="feature-band">
        <div class="wrap">
            <div class="head reveal">
                <div class="kicker">A la medida</div>
                <h2>Su página, con su estilo y sus necesidades</h2>
                <p>El diseño y el visual son 100% personalizables, y elegimos juntos qué servicios incluir.</p>
            </div>

            <div class="feature-row reveal">
                <div class="ft-media m1"><div class="emoji">🎨</div></div>
                <div class="ft-text">
                    <div class="kicker">Diseño 100% personalizable</div>
                    <h3>Cada detalle a su gusto</h3>
                    <p>Colores, tipografías, fotos, historia de la pareja y secciones. Adaptamos la web al estilo de su boda y a lo que realmente necesitan, sin plantillas rígidas.</p>
                    <ul class="ft-list">
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg> Visual y colores a elección</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg> Solo los servicios que necesitan</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg> Servicios adicionales a solicitud</li>
                    </ul>
                </div>
            </div>

            <div class="feature-row rev reveal">
                <div class="ft-media m2"><div class="emoji">📸</div></div>
                <div class="ft-text">
                    <div class="kicker">En vivo durante el evento</div>
                    <h3>Fotos compartidas en tiempo real</h3>
                    <p>Los invitados suben sus fotos y videos desde el celular y aparecen en una vista compartida que pueden proyectar durante la fiesta. Todos los recuerdos quedan guardados en un solo lugar.</p>
                    <ul class="ft-list">
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg> Vista de fotos compartida en vivo</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg> Presentación automática para proyectar</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg> Descarga de todos los recuerdos</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- PROMESA DOMINIO -->
    <section class="promesa">
        <div class="wrap reveal">
            <div class="kicker" style="color:var(--oro);">Su dominio, sus nombres</div>
            <h2>Un dominio y servidor personalizados con los nombres de los novios, montado por 1 año</h2>
            <p>Publicamos su página en una dirección propia con sus nombres y la mantenemos online durante un año completo: del save the date al mensaje de agradecimiento.</p>
            <div class="promesa-tags">
                <span>🌐 Dominio con sus nombres</span>
                <span>🖥️ Servidor personalizado</span>
                <span>🗓️ 1 año montada</span>
                <span>🔒 Hosting incluido</span>
            </div>
        </div>
    </section>

    <!-- PASOS -->
    <section>
        <div class="wrap">
            <div class="head reveal">
                <div class="kicker">Cómo funciona</div>
                <h2>De la idea a su web en 4 pasos</h2>
                <p>Nosotros nos encargamos de lo técnico. Ustedes solo disfrutan su boda.</p>
            </div>
            <div class="pasos">
                @foreach ($pasos as $i => $p)
                    <div class="paso reveal" style="transition-delay: {{ $i * 70 }}ms;">
                        <h3>{{ $p[0] }}</h3>
                        <p>{{ $p[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- PLANES -->
    <section id="planes" class="planes">
        <div class="wrap">
            <div class="head reveal">
                <div class="kicker">Planes para tu matrimonio</div>
                <h2>Elige el plan según lo que necesitas</h2>
                <p>Del básico al premium: crece cuando quieras. Los precios pueden variar según invitados, personalización, almacenamiento y servicios adicionales.</p>
            </div>
            <div class="planes-scroll reveal">
                @foreach ($planes as $plan)
                    @php $car = is_array($plan->caracteristicas) ? $plan->caracteristicas : []; @endphp
                    <div class="plan {{ $plan->destacado ? 'top' : '' }}">
                        @if ($plan->destacado)<span class="badge">Más elegido</span>@endif
                        <h3>{{ $plan->nombre }}</h3>
                        <div class="ideal">{{ $plan->subtitulo }}</div>
                        <div class="desde">Desde</div>
                        <div class="price">{{ $plan->precio }}</div>
                        @if (!empty($plan->descripcion))<p class="desc">{{ $plan->descripcion }}</p>@endif
                        <ul>
                            @foreach ($car as $item)
                                <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg>{{ $item }}</li>
                            @endforeach
                        </ul>
                        @if (!empty($plan->infraestructura))<div class="infra">🖥️ {{ $plan->infraestructura }}</div>@endif
                        @php $planMsg = rawurlencode('Hola, me interesa el plan '.$plan->nombre.' para mi matrimonio.'); @endphp
                        <a class="btn btn-plan" href="{{ $wa !== '' ? "https://wa.me/{$wa}?text={$planMsg}" : '#contacto' }}" @if($wa !== '') target="_blank" rel="noopener" @endif>Quiero este plan</a>
                    </div>
                @endforeach
            </div>
            <p class="planes-hint">← Desliza para ver todos los planes →</p>
        </div>
    </section>

    <!-- TABLA COMPARATIVA -->
    @php
        // Matriz de comparacion (por posicion de plan). Se muestra si hay planes.
        $filasComparativa = [
            ['Invitación personalizada', ['Sí', 'Sí', 'Sí', 'Sí', 'Exclusiva']],
            ['Confirmación de asistencia', ['Sí', 'Sí', 'Sí', 'Sí', 'Sí']],
            ['Gestión de cupos', ['Básica', 'Sí', 'Sí', 'Sí', 'Sí']],
            ['Panel administrativo', ['No', 'Sí', 'Sí', 'Sí', 'Sí']],
            ['Organización de mesas', ['No', 'No', 'Sí', 'Sí', 'Sí']],
            ['Carga de fotografías', ['No', 'No', 'No', 'Sí', 'Sí']],
            ['Presentación en vivo', ['No', 'No', 'No', 'Sí', 'Sí']],
            ['Soporte durante el evento', ['No', 'No', 'No', 'Remoto', 'Presencial']],
            ['Invitados incluidos', ['100', '200', '250', '250', '400']],
        ];
        $mostrarComparativa = $planes->count() === count($filasComparativa[0][1]);
    @endphp
    @if ($mostrarComparativa)
    <section>
        <div class="wrap">
            <div class="head reveal">
                <div class="kicker">Comparación</div>
                <h2>Todos los planes lado a lado</h2>
                <p>Compara lo que incluye cada plan y elige con confianza.</p>
            </div>
            <div class="tabla-wrap reveal">
                <table class="comparativa">
                    <thead>
                        <tr>
                            <th>Característica</th>
                            @foreach ($planes as $plan)
                                <th>{{ $plan->nombre }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($filasComparativa as [$etiqueta, $valores])
                            <tr>
                                <th>{{ $etiqueta }}</th>
                                @foreach ($valores as $v)
                                    <td>
                                        @if ($v === 'Sí')<span class="si">Sí</span>
                                        @elseif ($v === 'No')<span class="no">—</span>
                                        @else {{ $v }}@endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        <tr class="precio-row">
                            <th>Precio desde</th>
                            @foreach ($planes as $plan)
                                <td>{{ $plan->precio }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endif

    <!-- SERVICIOS ADICIONALES -->
    @if ($adicionales->isNotEmpty())
    <section class="feature-band">
        <div class="wrap">
            <div class="head reveal">
                <div class="kicker">A tu medida</div>
                <h2>Servicios adicionales</h2>
                <p>Complementa cualquier plan con lo que necesites. Precios de referencia.</p>
            </div>
            <div class="adic-grid reveal">
                @foreach ($adicionales as $servicio)
                    <div class="adic">
                        <span class="n">{{ $servicio->nombre }}</span>
                        <span class="p">{{ $servicio->precio }}</span>
                    </div>
                @endforeach
            </div>
            <p class="adic-nota">Los valores pueden variar según el número de invitados, nivel de personalización, almacenamiento requerido, ubicación del evento y servicios adicionales contratados.</p>
        </div>
    </section>
    @endif

    <!-- TESTIMONIO -->
    <section class="testi">
        <div class="wrap reveal">
            <div class="stars">★★★★★</div>
            <blockquote>“Nuestros invitados confirmaron por WhatsApp, entraron con su QR sin filas y al día siguiente teníamos todas las fotos que subieron. La web fue el mejor detalle de la boda.”</blockquote>
            <div class="who">— Ana &amp; Diego, casados en febrero</div>
        </div>
    </section>

    <!-- CTA -->
    <section id="contacto" class="cta">
        <div class="wrap reveal">
            <h2>Empecemos la web de su matrimonio</h2>
            <p>Cuéntennos la fecha y el estilo de su boda. Les preparamos una propuesta a su medida, sin compromiso.</p>
            <div class="cta-actions">
                <a class="btn btn-wa" href="{{ $waLink }}" @if($wa !== '') target="_blank" rel="noopener" @endif>
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Zm5.8 14.12c-.24.68-1.42 1.32-1.95 1.36-.5.04-.99.28-3.4-.72-2.87-1.19-4.7-4.15-4.85-4.34-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.09 1-2.38.24-.26.53-.33.71-.33.18 0 .35 0 .5.01.16.007.38-.06.59.45.24.55.79 1.92.86 2.06.07.14.12.3.02.49-.42.83-.87 1-.42.94-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.69-.8.87-1.08.18-.28.36-.23.61-.14.25.09 1.6.75 1.87.89.28.14.46.21.53.33.07.12.07.68-.17 1.36Z"/></svg>
                    Escríbenos por WhatsApp
                </a>
                <a class="btn btn-line" href="mailto:{{ $email }}?subject={{ rawurlencode('Quiero una web para mi matrimonio') }}">Escribir un correo</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="foot">
        <div class="wrap">
            <div class="logo"><img src="{{ asset('assets/logo-matrimonio.svg') }}" alt="" style="width:30px;height:30px;border-radius:8px;">{{ $marca }}</div>
            <div>{{ $lema }}</div>
            <div style="margin-top:10px;">
                <a href="{{ $waLink }}" @if($wa !== '') target="_blank" rel="noopener" @endif>WhatsApp</a> &nbsp;·&nbsp; <a href="mailto:{{ $email }}">{{ $email }}</a>
            </div>
            <div style="margin-top:14px;opacity:.6;">© {{ date('Y') }} {{ $marca }}. Hecho con amor para celebrar el amor.</div>
        </div>
    </footer>

    <script>
        (function () {
            var els = document.querySelectorAll('.reveal');
            if (!('IntersectionObserver' in window)) { els.forEach(function (e) { e.classList.add('in'); }); return; }
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); } });
            }, { threshold: 0.12 });
            els.forEach(function (e) { io.observe(e); });
        })();
    </script>
</body>
</html>
