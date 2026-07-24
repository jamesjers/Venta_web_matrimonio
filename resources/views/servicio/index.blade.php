@php
    $marca = $config->marca ?: 'Invita';
    $lema = $config->lema ?: 'Invitaciones digitales y páginas web para tus eventos';
    $wa = $config->whatsappDigitos();
    $email = $config->email ?: 'contacto@invita.com';
    $heroTitulo = $config->hero_titulo ?: 'La web de su boda, de la invitación al último recuerdo';
    $heroTexto = $config->hero_texto ?: 'Diseñamos una página única con el dominio y los nombres de los novios, montada durante un año completo.';
    $logo = asset('assets/logo-eventos.svg');

    $waLink = $wa !== ''
        ? 'https://wa.me/'.$wa.'?text='.rawurlencode('Hola, quiero información sobre una invitación digital o página web para mi evento.')
        : '#planes';

    // Producto de entrada: Tarjeta de Invitación con panel propio.
    $tarjeta = $planes->firstWhere('nombre', 'Tarjeta de Invitación');
    $tarjetaPrecio = $tarjeta->precio ?? '$349.000 COP';
    $tarjetaCaract = ($tarjeta && is_array($tarjeta->caracteristicas) && count($tarjeta->caracteristicas))
        ? $tarjeta->caracteristicas
        : [
            'Tarjeta de invitación digital a la medida del evento',
            'Dominio propio con el nombre del evento',
            'Panel de control exclusivo de la tarjeta',
            'Revisión del estado de las invitaciones (confirmaciones)',
            'Confirmación de asistencia en un clic',
            'Música, historia y detalles en la tarjeta',
            'Ubicación con mapa e itinerario',
            'Dominio, alojamiento y certificado SSL incluidos',
        ];
    $tarjetaWa = $wa !== ''
        ? 'https://wa.me/'.$wa.'?text='.rawurlencode('Hola, quiero la Tarjeta de Invitación con panel de control ('.$tarjetaPrecio.') para mi evento.')
        : '#planes';

    // Selector de tipo de evento (parte superior). Matrimonio usa los textos del panel.
    $eventos = [
        'matrimonio' => [
            'chip' => 'Matrimonios', 'icon' => '💍',
            'eyebrow' => 'Bodas & Matrimonios',
            'titulo' => $heroTitulo,
            'texto' => $heroTexto,
            'acento' => '#e7b765', 'acento2' => '#16a19b', 'acentoInk' => '#0e7a72',
            'phName' => 'Ana & Diego', 'phSub' => '15 de febrero · 5:00 pm', 'phHero' => 'NUESTRA HISTORIA',
            'wa' => 'una página web para mi matrimonio', 'waCorto' => 'mi matrimonio',
            'servHead' => 'Todos los servicios que necesita tu boda',
            'testiQuote' => '“Nuestros invitados confirmaron desde la tarjeta, entraron con su QR sin filas y al día siguiente teníamos todas las fotos. La web fue el mejor detalle de la boda.”',
            'testiWho' => '— Ana & Diego, casados en febrero',
            'ctaHead' => 'Empecemos la web de su matrimonio',
        ],
        'quince' => [
            'chip' => '15 años', 'icon' => '👑',
            'eyebrow' => 'Fiesta de 15 años',
            'titulo' => 'La página de tus 15, tan única como tú',
            'texto' => 'Todo lo de una boda, ahora para tus 15: invitación digital, confirmaciones, galería de fotos, fotos en vivo, ingreso con QR y recuerdos, con tu tema y tu dominio propio.',
            'acento' => '#e46aa6', 'acento2' => '#9c5cd0', 'acentoInk' => '#c2417f',
            'phName' => 'Mis 15 · Valentina', 'phSub' => '20 de abril · 7:00 pm', 'phHero' => 'MIS 15',
            'wa' => 'una página web para mis 15 años', 'waCorto' => 'mis 15 años',
            'servHead' => 'Todos los servicios que necesitan tus 15',
            'testiQuote' => '“Mis invitados confirmaron desde la tarjeta, la galería se llenó de fotos y el baile sorpresa quedó en pantalla. ¡Mis 15 fueron inolvidables!”',
            'testiWho' => '— Valentina, celebró sus 15 en abril',
            'ctaHead' => 'Empecemos la web de tus 15',
        ],
        'otros' => [
            'chip' => 'Otros eventos', 'icon' => '🎉',
            'eyebrow' => 'Bautizos, grados, cumpleaños y más',
            'titulo' => 'La web perfecta para tu evento especial',
            'texto' => 'Bautizos, primeras comuniones, grados, cumpleaños, baby shower o eventos corporativos, con invitación digital y dominio propio.',
            'acento' => '#3fb0a6', 'acento2' => '#2b6fb0', 'acentoInk' => '#1f7a70',
            'phName' => 'Nuestro evento', 'phSub' => 'Fecha · Hora', 'phHero' => '¡BIENVENIDOS!',
            'wa' => 'una página web para mi evento', 'waCorto' => 'mi evento',
            'servHead' => 'Todos los servicios que necesita tu evento',
            'testiQuote' => '“Enviamos la invitación por WhatsApp, controlamos las confirmaciones desde el panel y todo salió perfecto. Súper fácil de organizar.”',
            'testiWho' => '— Familia Restrepo, bautizo en marzo',
            'ctaHead' => 'Empecemos la web de tu evento',
        ],
    ];
    // Datos que consume el selector en el navegador.
    $eventosJs = collect($eventos)->map(fn ($e) => [
        'eyebrow' => $e['eyebrow'], 'titulo' => $e['titulo'], 'texto' => $e['texto'],
        'acento' => $e['acento'], 'acento2' => $e['acento2'], 'acentoInk' => $e['acentoInk'],
        'phName' => $e['phName'], 'phSub' => $e['phSub'], 'phHero' => $e['phHero'],
        'wa' => $e['wa'], 'waCorto' => $e['waCorto'],
        'servHead' => $e['servHead'], 'testiQuote' => $e['testiQuote'], 'testiWho' => $e['testiWho'], 'ctaHead' => $e['ctaHead'],
    ]);
    $ini = $eventos['matrimonio'];
    $iniCorto = $ini['waCorto'];

    // Presentacion de los planes adaptada por tipo de evento.
    // El precio y el orden vienen de la BD; aqui solo se ajustan nombres y textos por evento.
    // Se alinea por posicion del plan (0 = producto de entrada ... n = premium).
    $planesEvento = [
        'matrimonio' => $planes->values()->map(fn ($p) => [
            'nombre' => $p->nombre, 'subtitulo' => $p->subtitulo, 'descripcion' => $p->descripcion,
        ])->all(),
        'quince' => [
            ['nombre' => 'Tarjeta de tus 15', 'subtitulo' => 'Tu invitación digital con panel propio', 'descripcion' => 'La tarjeta de tus 15 con dominio propio y un panel exclusivo para revisar el estado de las confirmaciones.'],
            ['nombre' => 'Invitación 15 años', 'subtitulo' => 'La invitación digital esencial', 'descripcion' => 'Una invitación elegante con la música, la historia y todos los detalles de tus 15 en un solo lugar.'],
            ['nombre' => 'Gestión de Invitados', 'subtitulo' => 'Confirmaciones y cupos en un panel', 'descripcion' => 'Administra confirmaciones, cupos y acompañantes de tus 15 desde un solo panel.'],
            ['nombre' => 'Salón y Mesas', 'subtitulo' => 'Ubica a tus invitados y tu corte de honor', 'descripcion' => 'Organiza el salón, tu corte de honor y la ubicación de cada invitado en la fiesta.'],
            ['nombre' => 'Fiesta y Recuerdos', 'subtitulo' => 'Fotos y baile sorpresa en vivo', 'descripcion' => 'La experiencia completa: galería de fotos, fotos en vivo en pantalla y todos los recuerdos de tus 15.'],
            ['nombre' => 'Premium XV', 'subtitulo' => 'La experiencia exclusiva con acompañamiento', 'descripcion' => 'Máxima capacidad, diseño exclusivo y acompañamiento durante toda tu fiesta de 15.'],
        ],
        'otros' => [
            ['nombre' => 'Tarjeta de Invitación', 'subtitulo' => 'Tu invitación digital con panel propio', 'descripcion' => 'La tarjeta de tu evento con dominio propio y un panel exclusivo para revisar el estado de las confirmaciones.'],
            ['nombre' => 'Invitación del Evento', 'subtitulo' => 'La invitación digital esencial', 'descripcion' => 'Una invitación elegante con toda la información de tu evento en un solo lugar.'],
            ['nombre' => 'Gestión de Invitados', 'subtitulo' => 'Confirmaciones y cupos en un panel', 'descripcion' => 'Administra confirmaciones, cupos y acompañantes de tu evento desde un solo panel.'],
            ['nombre' => 'Organización y Mesas', 'subtitulo' => 'Ubica a tus invitados en el evento', 'descripcion' => 'Organiza a tus invitados y facilita su ubicación durante el evento.'],
            ['nombre' => 'Experiencia y Recuerdos', 'subtitulo' => 'Organiza y comparte los recuerdos en vivo', 'descripcion' => 'La experiencia completa para organizar el evento y compartir los recuerdos en tiempo real.'],
            ['nombre' => 'Premium', 'subtitulo' => 'La experiencia exclusiva con acompañamiento', 'descripcion' => 'Mayor capacidad, personalización y acompañamiento durante todo tu evento.'],
        ],
    ];
    $planesEventoJs = collect($planesEvento);

    // Iconos de servicios (trazo).
    $iconos = [
        'pin' => '<path d="M12 21s-6-5.2-6-10a6 6 0 1 1 12 0c0 4.8-6 10-6 10Z"/><circle cx="12" cy="11" r="2.2"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
        'check' => '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>',
        'camera' => '<path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/>',
        'live' => '<circle cx="12" cy="12" r="3"/><path d="M5.6 5.6a9 9 0 0 0 0 12.8M18.4 5.6a9 9 0 0 1 0 12.8"/>',
        'qr' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h3v3M21 14v.01M14 21h.01M17 21h4v-4"/>',
        'table' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18M9 5v14M15 5v14"/>',
        'list' => '<path d="M8 6h13M8 12h13M8 18h13"/><path d="M3 6h.01M3 12h.01M3 18h.01"/>',
    ];
    $servicios = [
        ['Ubicación', 'Ubicación e itinerario', 'Lugar del evento con mapa, hora y detalles. Tus invitados llegan sin perderse.', '#1d6fa6', 'pin'],
        ['Invitación', 'Invitación digital', 'Tarjeta elegante con música, historia y confirmación de asistencia en un clic.', '#0e5a5c', 'mail'],
        ['Confirmaciones', 'Estado de invitaciones', 'Desde tu panel revisas quién confirmó, quién falta y el total de asistentes.', '#128c7e', 'check'],
        ['Recuerdos', 'Recuerdos del evento', 'Activa una galería privada para fotos y, si lo necesitas, videos cortos con límites definidos.', '#8a5cc0', 'camera'],
        ['En vivo', 'Fotos compartidas en vivo', 'Con el módulo en vivo, las fotos aprobadas aparecen en una pantalla durante la fiesta.', '#c0873a', 'live'],
        ['Ingreso', 'Control de ingreso con QR', 'Cada invitado con su código QR. Validas el acceso en segundos desde el celular.', '#b85c1a', 'qr'],
        ['Mesas', 'Distribución de mesas', 'Organiza quién se sienta dónde arrastrando invitados a cada mesa.', '#3d5a80', 'table'],
        ['Todo', 'Invitados, gastos y checklist', 'Confirmados, presupuesto y tareas bajo control camino al gran día.', '#2f8f6f', 'list'],
    ];

    $pasos = [
        ['Nos cuentan del evento', 'Fecha, estilo, lugar, fotos e historia de los protagonistas.'],
        ['Diseñamos a su medida', 'Elegimos colores, visual y los servicios que realmente necesitan.'],
        ['Montamos su dominio', 'Publicamos la web con el nombre del evento, lista para compartir.'],
        ['Disfrutan todo el año', 'Su página queda montada durante 1 año, del save the date al agradecimiento.'],
    ];
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $marca }} · Invitaciones digitales y páginas web para eventos</title>
    <meta name="description" content="{{ $lema }}. Tarjeta de invitación con panel de control desde {{ $tarjetaPrecio }}, y páginas web para matrimonios, 15 años y todo tipo de eventos. Invitación digital, confirmaciones, ingreso con QR, mesas y fotos en vivo con dominio propio.">
    <link rel="icon" type="image/svg+xml" href="{{ $logo }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,500;1,600&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            --serif: "Playfair Display", Georgia, "Times New Roman", serif;
            /* Acento del evento activo (se cambia desde el selector superior). */
            --ev: #e7b765; --ev-2: #16a19b; --ev-ink: #0e7a72;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: "Inter", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--tinta);
            background: #fff;
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        .wrap { width: 100%; max-width: 1180px; margin: 0 auto; padding: 0 24px; }
        .hero h1, .head h2, .tarjeta-info h2, .promesa h2, .cta h2,
        .ft-text h3, .plan h3, .testi blockquote, .phone-hero {
            font-family: var(--serif); font-weight: 700; letter-spacing: -.005em;
        }

        /* ---- NAV ---- */
        .nav {
            position: sticky; top: 0; z-index: 60;
            background: rgba(6, 15, 34, 0.72);
            backdrop-filter: blur(14px);
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .nav-in { display: flex; align-items: center; justify-content: space-between; padding: 13px 24px; max-width: 1180px; margin: 0 auto; }
        .logo { display: flex; align-items: center; gap: 11px; font-weight: 800; font-size: 1.12rem; letter-spacing: 0.2px; }
        .logo img { width: 38px; height: 38px; border-radius: 11px; }
        .nav-links { display: flex; align-items: center; gap: 28px; }
        .nav-links a { font-size: 0.92rem; font-weight: 600; color: rgba(255,255,255,0.82); }
        .nav-links a:hover { color: #fff; }
        .nav-cta { padding: 10px 20px; border-radius: 999px; background: linear-gradient(120deg, var(--ev), var(--ev-2)); color: #10203a !important; font-weight: 800 !important; }
        @media (max-width: 880px) { .nav-links a:not(.nav-cta) { display: none; } }

        /* Sub-barra fija con el selector de evento */
        .subnav { border-top: 1px solid rgba(255,255,255,0.08); background: rgba(6,15,34,0.5); }
        .subnav-in { display: flex; align-items: center; justify-content: center; gap: 14px; padding: 10px 24px; max-width: 1180px; margin: 0 auto; flex-wrap: wrap; }
        .subnav-label { color: rgba(255,255,255,.55); font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.4px; }
        @media (max-width: 520px) { .subnav-label { display: none; } }

        /* ---- BOTONES ---- */
        .btn { display: inline-flex; align-items: center; gap: 10px; padding: 16px 30px; border-radius: 999px; font-size: 1rem; font-weight: 800; cursor: pointer; border: none; transition: transform .18s ease, box-shadow .18s ease, filter .18s ease; font-family: inherit; }
        .btn:hover { transform: translateY(-3px); }
        .btn svg { width: 20px; height: 20px; }
        .btn-oro { background: linear-gradient(120deg, var(--ev), var(--ev-2)); color: #10203a; box-shadow: 0 18px 40px rgba(0,0,0,.25); }
        .btn-wa { background: linear-gradient(120deg, #25d366, #0e5a5c); color: #fff; box-shadow: 0 18px 40px rgba(18,140,126,.35); }
        .btn-line { background: transparent; color: #fff; border: 1.6px solid rgba(255,255,255,.45); }
        .btn-line:hover { background: rgba(255,255,255,.1); }

        /* ---- HERO ---- */
        .hero { position: relative; color: #fff; padding: 64px 0 118px;
            background:
                radial-gradient(1100px 600px at 8% -5%, rgba(22,161,155,.28), transparent 60%),
                radial-gradient(900px 600px at 100% 8%, rgba(37,99,175,.4), transparent 55%),
                linear-gradient(160deg, #050c1c 0%, #0a1c39 55%, #0a2a42 100%);
        }
        .blob { position: absolute; border-radius: 50%; filter: blur(70px); opacity: .5; pointer-events: none; z-index: 0; transition: background .5s ease; }
        .blob.b1 { width: 360px; height: 360px; background: var(--ev-2); top: -60px; left: -80px; animation: float1 12s ease-in-out infinite; }
        .blob.b2 { width: 420px; height: 420px; background: var(--ev); bottom: -120px; right: -100px; animation: float2 15s ease-in-out infinite; opacity: .32; }
        @keyframes float1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(30px,40px)} }
        @keyframes float2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-40px,-30px)} }

        /* Selector de evento */
        .switch { position: relative; z-index: 2; display: inline-flex; gap: 6px; padding: 5px; border-radius: 999px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14); backdrop-filter: blur(6px); flex-wrap: wrap; justify-content: center; }
        .switch button { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border: none; border-radius: 999px; background: transparent; color: rgba(255,255,255,.82); font: inherit; font-weight: 700; font-size: .9rem; cursor: pointer; transition: background .2s ease, color .2s ease, transform .2s ease; }
        .switch button:hover { color: #fff; }
        .switch button.active { background: linear-gradient(120deg, var(--ev), var(--ev-2)); color: #10203a; box-shadow: 0 10px 24px rgba(0,0,0,.28); }
        .switch button .em { font-size: 1.05rem; }

        .hero-in { position: relative; z-index: 1; display: grid; grid-template-columns: 1.1fr .9fr; gap: 48px; align-items: center; }
        .eyebrow { display: inline-flex; align-items: center; gap: 8px; font-size: .76rem; text-transform: uppercase; letter-spacing: 2.5px; font-weight: 800; color: var(--ev); margin-bottom: 18px; transition: color .4s ease; }
        .eyebrow::before { content: ""; width: 26px; height: 2px; background: var(--ev); display: inline-block; transition: background .4s ease; }
        .hero h1 { margin: 0; font-size: clamp(2.4rem, 6vw, 4.05rem); line-height: 1.05; letter-spacing: -.02em; font-weight: 800; }
        .hero .lead { margin: 22px 0 0; font-size: 1.16rem; color: rgba(255,255,255,.85); max-width: 540px; }
        .hero-actions { margin-top: 32px; display: flex; gap: 16px; flex-wrap: wrap; }
        .hero-badge { margin-top: 22px; display: inline-flex; align-items: center; gap: 10px; font-size: .92rem; color: rgba(255,255,255,.9); }
        .hero-badge b { color: var(--ev); }
        .hero-badge .dot { width: 8px; height: 8px; border-radius: 50%; background: #25d366; box-shadow: 0 0 0 4px rgba(37,211,102,.2); }
        .hero-stats { margin-top: 36px; display: flex; gap: 40px; flex-wrap: wrap; }
        .hero-stats b { display: block; font-size: 1.7rem; font-weight: 800; background: linear-gradient(120deg,#fff,var(--oro)); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .hero-stats span { color: rgba(255,255,255,.72); font-size: .9rem; }

        /* Phone mockup */
        .phone { position: relative; justify-self: center; width: 300px; }
        .phone-glow { position: absolute; inset: -40px; background: radial-gradient(circle, rgba(246,204,131,.3), transparent 65%); filter: blur(30px); z-index: 0; }
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
            background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.35), transparent 60%), linear-gradient(135deg,var(--ev-2),var(--ev)); transition: background .4s ease; }
        .phone-list { margin-top: 12px; display: grid; gap: 8px; }
        .pl { display: flex; align-items: center; gap: 9px; font-size: .82rem; }
        .pl i { width: 26px; height: 26px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-style: normal; }
        .phone-cta { margin-top: 14px; text-align: center; padding: 11px; border-radius: 14px; font-weight: 800; font-size: .86rem; color: #fff; background: linear-gradient(120deg,#25d366,#0e5a5c); }
        @media (max-width: 900px) { .hero-in { grid-template-columns: 1fr; } .phone { margin-top: 20px; } }

        /* ---- MARQUEE ---- */
        .strip { background: var(--azul-2); color: rgba(255,255,255,.9); padding: 15px 0; overflow: hidden; white-space: nowrap; }
        .strip-track { display: inline-flex; gap: 40px; animation: slide 26s linear infinite; font-weight: 700; letter-spacing: .5px; }
        .strip-track span { opacity: .85; }
        .strip-track b { color: var(--ev); }
        @keyframes slide { from { transform: translateX(0); } to { transform: translateX(-50%); } }

        /* ---- SECCIONES ---- */
        section { padding: 92px 0; }
        .head { max-width: 730px; margin: 0 auto 58px; text-align: center; }
        .kicker { font-size: .78rem; text-transform: uppercase; letter-spacing: 2.5px; font-weight: 800; color: var(--ev-ink); transition: color .4s ease; }
        .head h2 { margin: 12px 0 14px; font-size: clamp(2rem, 4.6vw, 3rem); color: var(--azul-2); line-height: 1.12; letter-spacing: -.01em; }
        .head p { margin: 0; color: var(--suave); font-size: 1.12rem; }

        /* ---- TARJETA DESTACADA ($349k) ---- */
        .tarjeta-band { background: linear-gradient(160deg,#0a1c39,#0e3b47); color: #fff; position: relative; overflow: hidden; }
        .tarjeta-band::after { content:""; position:absolute; width:460px; height:460px; border-radius:50%; background: radial-gradient(circle, rgba(246,204,131,.22), transparent 65%); top:-160px; right:-120px; }
        .tarjeta-box { position: relative; z-index: 1; display: grid; grid-template-columns: 1.05fr .95fr; gap: 44px; align-items: center; }
        .tarjeta-info .kicker { color: var(--ev); }
        .tarjeta-info h2 { font-size: clamp(1.9rem,4.2vw,2.7rem); margin: 12px 0 12px; line-height: 1.14; }
        .tarjeta-info p { color: rgba(255,255,255,.82); font-size: 1.08rem; margin: 0 0 22px; max-width: 520px; }
        .tarjeta-price { display: flex; align-items: baseline; gap: 12px; margin-bottom: 18px; flex-wrap: wrap; }
        .tarjeta-price .desde { font-size: .78rem; text-transform: uppercase; letter-spacing: 1.6px; font-weight: 700; color: rgba(255,255,255,.7); }
        .tarjeta-price .val { font-size: clamp(2.1rem,5vw,3rem); font-weight: 800; color: var(--ev); line-height: 1; }
        .tarjeta-price .tag { font-size: .8rem; font-weight: 700; color: #10203a; background: linear-gradient(120deg,var(--ev),var(--ev-2)); padding: 6px 12px; border-radius: 999px; }
        .tarjeta-actions { display: flex; gap: 14px; flex-wrap: wrap; }
        .tarjeta-card { position: relative; z-index: 1; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.16); border-radius: 24px; padding: 30px; backdrop-filter: blur(8px); }
        .tarjeta-card h3 { margin: 0 0 4px; font-size: 1.15rem; }
        .tarjeta-card .sub { margin: 0 0 18px; color: rgba(255,255,255,.65); font-size: .9rem; }
        .tarjeta-list { list-style: none; padding: 0; margin: 0; display: grid; gap: 12px; }
        .tarjeta-list li { display: flex; gap: 11px; align-items: flex-start; font-size: .95rem; color: rgba(255,255,255,.92); }
        .tarjeta-list li svg { width: 20px; height: 20px; color: var(--ev); flex-shrink: 0; margin-top: 2px; }
        @media (max-width: 860px) { .tarjeta-box { grid-template-columns: 1fr; gap: 30px; } }

        /* Servicios */
        .servicios-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 42px 34px; }
        .serv .ic { width: 58px; height: 58px; border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 17px; box-shadow: 0 14px 30px rgba(14,40,72,.16); }
        .serv .ic svg { width: 28px; height: 28px; color: #fff; }
        .serv .t { font-size: .72rem; text-transform: uppercase; letter-spacing: 1.6px; font-weight: 800; color: var(--ev-ink); transition: color .4s ease; }
        .serv h3 { margin: 5px 0 8px; font-size: 1.16rem; color: var(--azul-2); line-height: 1.25; }
        .serv p { margin: 0; color: var(--suave); font-size: .96rem; }
        @media (max-width: 960px) { .servicios-grid { grid-template-columns: repeat(2, 1fr); gap: 40px 28px; } }
        @media (max-width: 540px) { .servicios-grid { grid-template-columns: 1fr; } }

        /* Feature alterna */
        .feature-band { background: #fff; }
        .feature-row { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
        .feature-row + .feature-row { margin-top: 88px; }
        .feature-row.rev .ft-media { order: 2; }
        .ft-media { height: 340px; border-radius: 30px; position: relative; overflow: hidden; box-shadow: 0 30px 60px rgba(14,40,72,.18); }
        .ft-media.m1 { background: radial-gradient(circle at 30% 30%, rgba(255,255,255,.3), transparent 55%), linear-gradient(140deg,var(--ev-2),var(--ev)); transition: background .4s ease; }
        .ft-media.m2 { background: radial-gradient(circle at 70% 30%, rgba(138,92,192,.55), transparent 55%), linear-gradient(140deg,#2b3f77,#0a1c39); }
        .ft-media .emoji { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 5.5rem; }
        .ft-text h3 { font-size: clamp(1.7rem,3.6vw,2.4rem); color: var(--azul-2); margin: 10px 0 14px; line-height: 1.15; }
        .ft-text p { color: var(--suave); font-size: 1.06rem; margin: 0 0 18px; }
        .ft-list { list-style: none; padding: 0; margin: 0; display: grid; gap: 12px; }
        .ft-list li { display: flex; gap: 12px; align-items: flex-start; font-weight: 600; color: var(--tinta); }
        .ft-list li svg { width: 22px; height: 22px; color: var(--ev-ink); flex-shrink: 0; margin-top: 2px; }
        @media (max-width: 860px) { .feature-row { grid-template-columns: 1fr; gap: 30px; } .feature-row.rev .ft-media { order: 0; } .ft-media { height: 240px; } }

        /* Promesa dominio */
        .promesa { color: #fff; text-align: center; position: relative; overflow: hidden;
            background: radial-gradient(800px 400px at 50% -10%, rgba(22,161,155,.4), transparent 60%), linear-gradient(150deg,#0a1c39,#0e5a5c); }
        .promesa h2 { font-size: clamp(1.9rem,4.4vw,2.9rem); margin: 0 auto 16px; max-width: 800px; line-height: 1.15; }
        .promesa p { color: rgba(255,255,255,.85); font-size: 1.14rem; max-width: 640px; margin: 0 auto 12px; }
        .promesa-tags { margin-top: 30px; display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
        .promesa-tags span { border: 1px solid rgba(255,255,255,.3); border-radius: 999px; padding: 10px 20px; font-weight: 700; font-size: .95rem; }

        /* Pasos */
        .pasos { display: grid; grid-template-columns: repeat(4, 1fr); gap: 34px; counter-reset: paso; }
        .paso { position: relative; padding-top: 14px; border-top: 3px solid #e7eef5; }
        .paso::before { counter-increment: paso; content: "0" counter(paso); display: block; font-size: 2.4rem; font-weight: 800; line-height: 1; margin-bottom: 12px;
            background: linear-gradient(120deg, var(--ev-2), var(--ev)); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .paso h3 { margin: 0 0 6px; font-size: 1.1rem; color: var(--azul-2); }
        .paso p { margin: 0; color: var(--suave); font-size: .95rem; }
        @media (max-width: 860px) { .pasos { grid-template-columns: 1fr 1fr; gap: 28px; } }
        @media (max-width: 480px) { .pasos { grid-template-columns: 1fr; } }

        /* Planes */
        .planes { background: var(--lavado); }
        .planes-scroll { display: flex; gap: 22px; overflow-x: auto; padding: 6px 4px 22px; scroll-snap-type: x mandatory; scrollbar-width: thin; }
        .plan { scroll-snap-align: start; flex: 0 0 300px; background: #fff; border: 1px solid #e4ebf2; border-radius: 22px; padding: 30px 26px; display: flex; flex-direction: column; box-shadow: 0 16px 40px rgba(14,40,72,.08); }
        .plan.top { background: linear-gradient(180deg,#0a1c39,#0e5a5c); color: #fff; border-color: transparent; box-shadow: 0 26px 56px rgba(14,90,92,.3); }
        .plan.entry { border-color: var(--ev); box-shadow: 0 22px 50px rgba(14,40,72,.14); }
        .plan .badge { align-self: flex-start; background: linear-gradient(120deg,var(--ev),var(--ev-2)); color: #10203a; font-size: .66rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; padding: 5px 12px; border-radius: 999px; margin-bottom: 14px; }
        .plan .badge.g { background: linear-gradient(120deg,#25d366,#0e5a5c); color: #fff; }
        .plan h3 { margin: 0; font-size: 1.3rem; }
        .plan .ideal { font-size: .86rem; opacity: .78; margin: 3px 0 12px; }
        .plan .desc { font-size: .88rem; opacity: .8; margin: 0 0 16px; line-height: 1.5; min-height: 68px; }
        .plan .desde { font-size: .72rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; opacity: .7; }
        .plan .price { font-size: 1.9rem; font-weight: 800; line-height: 1.1; }
        .plan.top .price { color: var(--ev); }
        .plan:not(.top) .price { color: var(--ev-ink); transition: color .4s ease; }
        .plan .btn { margin-top: auto; justify-content: center; width: 100%; padding: 13px; }
        .plan:not(.top) .btn-plan { background: var(--azul-2); color: #fff; }
        .plan.top .btn-plan { background: linear-gradient(120deg,var(--ev),var(--ev-2)); color: #10203a; }
        .planes-hint { text-align: center; color: var(--suave); font-size: .85rem; margin-top: 6px; }

        /* Cotizador */
        .cotizador { background: #fff; }
        .cotiza-box { display: grid; grid-template-columns: 1.25fr .75fr; gap: 28px; align-items: start; }
        .cotiza-opciones, .cotiza-total { border: 1px solid #e4ebf2; border-radius: 22px; padding: 26px; box-shadow: 0 16px 40px rgba(14,40,72,.08); }
        .cotiza-total { position: sticky; top: 88px; background: linear-gradient(160deg,#0a1c39,#0e5a5c); color: #fff; }
        .cotiza-opciones h3, .cotiza-total h3 { margin: 0 0 6px; font-size: 1.25rem; }
        .cotiza-ayuda { margin: 0 0 22px; color: var(--suave); font-size: .92rem; }
        .cotiza-cantidades { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
        .cotiza-campo label { display: block; font-weight: 800; color: var(--azul-2); margin-bottom: 6px; }
        .cotiza-campo small { display: block; color: var(--suave); margin-top: 5px; }
        .cotiza-campo input, .cotiza-campo select { width: 100%; border: 1px solid #dbe5ee; border-radius: 12px; padding: 12px 14px; font: inherit; color: var(--tinta); background:#fff; }
        .cotiza-campo input:focus, .cotiza-campo select:focus { outline: 3px solid rgba(22,161,155,.2); border-color: var(--petroleo-2); }
        .cotiza-lista { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .cotiza-servicio { display: flex; gap: 11px; align-items: flex-start; border: 1px solid #e4ebf2; border-radius: 14px; padding: 14px; cursor: pointer; }
        .cotiza-servicio:has(input:checked) { border-color: var(--ev); background: rgba(0,0,0,.02); }
        .cotiza-servicio input { margin-top: 5px; accent-color: var(--ev-ink); }
        .cotiza-servicio span { display: block; font-weight: 700; color: var(--azul-2); line-height: 1.3; }
        .cotiza-servicio small, .cotiza-servicio em { display:block; font-style:normal; }
        .cotiza-servicio small { color: var(--suave); font-weight:500; margin-top:5px; line-height:1.4; }
        .cotiza-servicio em { color: var(--ev-ink); font-size:.82rem; margin-top:6px; }
        .cotiza-total .desde { opacity: .75; font-size: .78rem; text-transform: uppercase; letter-spacing: 1.4px; }
        .cotiza-total .valor { color: var(--ev); font-size: clamp(2rem,4vw,2.7rem); font-weight: 800; line-height: 1.1; margin: 4px 0 18px; }
        .cotiza-resumen { list-style: none; padding: 16px 0; margin: 0 0 20px; border-top: 1px solid rgba(255,255,255,.2); border-bottom: 1px solid rgba(255,255,255,.2); display: grid; gap: 8px; font-size: .9rem; }
        .cotiza-resumen li { display: flex; justify-content: space-between; gap: 12px; }
        .cotiza-total .btn { width: 100%; justify-content: center; padding: 13px 18px; }
        .cotiza-nota { margin: 14px 0 0; opacity: .72; font-size: .78rem; line-height: 1.45; }
        @media (max-width: 860px) { .cotiza-box { grid-template-columns: 1fr; } .cotiza-total { position: static; } }
        @media (max-width: 620px) { .cotiza-cantidades, .cotiza-lista { grid-template-columns: 1fr; } }

        /* Testimonio */
        .testi { text-align: center; }
        .testi .stars { color: var(--ev-ink); font-size: 1.5rem; letter-spacing: 4px; transition: color .4s ease; }
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
    <!-- NAV + SELECTOR DE EVENTO (fijo arriba) -->
    <header class="nav">
        <div class="nav-in">
            <a class="logo" href="#top"><img src="{{ $logo }}" alt="">{{ $marca }}</a>
            <nav class="nav-links">
                <a href="#tarjeta">Tarjeta $349k</a>
                <a href="#servicios">Servicios</a>
                <a href="#planes">Planes</a>
                <a href="#cotizador">Cotiza</a>
                <a class="nav-cta" href="{{ $waLink }}" @if($wa !== '') target="_blank" rel="noopener" @endif>Solicitar</a>
            </nav>
        </div>
        <div class="subnav">
            <div class="subnav-in">
                <span class="subnav-label">Estás viendo:</span>
                <div class="switch" role="tablist" aria-label="Tipo de evento">
                    @foreach ($eventos as $clave => $ev)
                        <button type="button" data-ev="{{ $clave }}" class="{{ $clave === 'matrimonio' ? 'active' : '' }}" aria-pressed="{{ $clave === 'matrimonio' ? 'true' : 'false' }}">
                            <span class="em" aria-hidden="true">{{ $ev['icon'] }}</span>{{ $ev['chip'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </header>

    <!-- HERO -->
    <div class="hero" id="hero" data-whatsapp="{{ $wa }}">
        <span class="blob b1"></span>
        <span class="blob b2"></span>
        <div class="wrap">
            <div class="hero-in">
                <div>
                    <span class="eyebrow" id="ev-eyebrow">{{ $ini['eyebrow'] }}</span>
                    <h1 id="ev-title">{{ $ini['titulo'] }}</h1>
                    <p class="lead" id="ev-lead">{{ $ini['texto'] }}</p>
                    <div class="hero-badge">
                        <span class="dot"></span> Tarjeta de invitación con panel <b>desde {{ $tarjetaPrecio }}</b>
                    </div>
                    <div class="hero-actions">
                        <a class="btn btn-wa" id="hero-wa" href="{{ $waLink }}" @if($wa !== '') target="_blank" rel="noopener" @endif>
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Zm5.8 14.12c-.24.68-1.42 1.32-1.95 1.36-.5.04-.99.28-3.4-.72-2.87-1.19-4.7-4.15-4.85-4.34-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.09 1-2.38.24-.26.53-.33.71-.33.18 0 .35 0 .5.01.16.007.38-.06.59.45.24.55.79 1.92.86 2.06.07.14.12.3.02.49-.42.83-.87 1-.42.94-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.69-.8.87-1.08.18-.28.36-.23.61-.14.25.09 1.6.75 1.87.89.28.14.46.21.53.33.07.12.07.68-.17 1.36Z"/></svg>
                            Escríbenos por WhatsApp
                        </a>
                        <a class="btn btn-line" href="#tarjeta">Ver la tarjeta $349k</a>
                    </div>
                    <div class="hero-stats">
                        <div><b>1 año</b><span>montada online</span></div>
                        <div><b>Tu dominio</b><span>con el nombre del evento</span></div>
                        <div><b>100%</b><span>a la medida</span></div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="phone" aria-hidden="true">
                    <div class="phone-glow"></div>
                    <div class="phone-screen">
                        <div class="phone-top">
                            <img src="{{ $logo }}" alt="">
                            <div><div class="pn" id="ph-name">{{ $ini['phName'] }}</div><div class="ps" id="ph-sub">{{ $ini['phSub'] }}</div></div>
                        </div>
                        <div class="phone-hero" id="ph-hero">{{ $ini['phHero'] }}</div>
                        <div class="phone-list">
                            <div class="pl"><i style="background:#e7f0fa;">📍</i> Lugar del evento con mapa</div>
                            <div class="pl"><i style="background:#e5f3ef;">💌</i> Confirma tu asistencia</div>
                            <div class="pl"><i style="background:#fdeede;">🎫</i> Tu QR de ingreso</div>
                            <div class="pl"><i style="background:#f1e9fa;">📸</i> Fotos compartidas en vivo</div>
                        </div>
                        <div class="phone-cta">Confirmar asistencia</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- STRIP -->
    <div class="strip" aria-hidden="true">
        <div class="strip-track">
            <span>Invitación digital</span><b>·</b><span>Confirmaciones</span><b>·</b><span>Ubicación con mapa</span><b>·</b><span>Ingreso con QR</span><b>·</b><span>Galería de fotos</span><b>·</b><span>Fotos en vivo</span><b>·</b><span>Distribución de mesas</span><b>·</b>
            <span>Invitación digital</span><b>·</b><span>Confirmaciones</span><b>·</b><span>Ubicación con mapa</span><b>·</b><span>Ingreso con QR</span><b>·</b><span>Galería de fotos</span><b>·</b><span>Fotos en vivo</span><b>·</b><span>Distribución de mesas</span><b>·</b>
        </div>
    </div>

    <!-- TARJETA DESTACADA $349.000 -->
    <section id="tarjeta" class="tarjeta-band">
        <div class="wrap">
            <div class="tarjeta-box reveal">
                <div class="tarjeta-info">
                    <div class="kicker">Nuestro producto estrella</div>
                    <h2>Tarjeta de invitación digital con su propio panel de control</h2>
                    <p>La forma más fácil de invitar: una tarjeta elegante con dominio propio y un panel exclusivo para revisar el estado de las invitaciones de esa tarjeta. Solo eso, sin complicaciones.</p>
                    <div class="tarjeta-price">
                        <span class="desde">Precio único</span>
                        <span class="val">{{ $tarjetaPrecio }}</span>
                        <span class="tag">Dominio + panel incluidos</span>
                    </div>
                    <div class="tarjeta-actions">
                        <a class="btn btn-oro" href="{{ $tarjetaWa }}" @if($wa !== '') target="_blank" rel="noopener" @endif>Quiero mi tarjeta</a>
                        <a class="btn btn-line" href="#planes">Comparar con los planes</a>
                    </div>
                </div>
                <div class="tarjeta-card">
                    <h3>Qué incluye la tarjeta</h3>
                    <p class="sub">Enfocada solo en tu invitación y sus confirmaciones.</p>
                    <ul class="tarjeta-list">
                        @foreach ($tarjetaCaract as $item)
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 13 4 4L19 7"/></svg>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICIOS -->
    <section id="servicios">
        <div class="wrap">
            <div class="head reveal">
                <div class="kicker">Todo en un solo lugar</div>
                <h2 id="ev-serv-head">{{ $ini['servHead'] }}</h2>
                <p>Antes, durante y después del gran día. Y si necesitas algo distinto, lo agregamos: la web se arma según lo que requieras. Todos aplican al evento que elijas arriba.</p>
            </div>
            <div class="servicios-grid">
                @foreach ($servicios as $i => $s)
                    <div class="serv reveal" style="transition-delay: {{ $i * 55 }}ms;">
                        <div class="ic" style="background: {{ $s[3] }};">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $iconos[$s[4]] !!}</svg>
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
                    <p>Colores, tipografías, fotos, historia de los protagonistas y secciones. Adaptamos la web al estilo del evento y a lo que realmente necesitan, sin plantillas rígidas.</p>
                    <ul class="ft-list">
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg> Visual y colores a elección</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg> Solo los servicios que necesitan</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg> Cotización personalizada según sus necesidades</li>
                    </ul>
                </div>
            </div>

            <div class="feature-row rev reveal">
                <div class="ft-media m2"><div class="emoji">📊</div></div>
                <div class="ft-text">
                    <div class="kicker">Panel de control del evento</div>
                    <h3>Revisa el estado de las invitaciones</h3>
                    <p>Desde tu panel ves quién confirmó, quién falta y cuántos asisten. Con la Tarjeta de Invitación el panel se enfoca solo en esa tarjeta; con los planes superiores, gestionas cupos, acompañantes y más.</p>
                    <ul class="ft-list">
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg> Estado de confirmaciones en tiempo real</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg> Actualización de los datos de la tarjeta</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg> Acceso privado con tu dominio propio</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- PROMESA DOMINIO -->
    <section class="promesa">
        <div class="wrap reveal">
            <div class="kicker" style="color:var(--oro);">Su dominio, su nombre</div>
            <h2>Un dominio y servidor personalizados con el nombre del evento, montado por 1 año</h2>
            <p>Publicamos su página en una dirección propia con el nombre del evento y la mantenemos online durante un año completo: del save the date al mensaje de agradecimiento.</p>
            <div class="promesa-tags">
                <span>🌐 Dominio con su nombre</span>
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
                <p>Nosotros nos encargamos de lo técnico. Ustedes solo disfrutan su evento.</p>
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
                <div class="kicker">Planes para tu evento</div>
                <h2>Elige según lo que necesitas</h2>
                <p>Cada plan se adapta al tipo de evento que elijas arriba. Empieza con la tarjeta de invitación o elige una solución de mayor alcance; los detalles se revisan contigo en la cotización.</p>
            </div>
            <div class="planes-scroll reveal" data-whatsapp="{{ $wa }}">
                @foreach ($planes as $plan)
                    @php $esTarjeta = $plan->nombre === 'Tarjeta de Invitación'; @endphp
                    <div class="plan {{ $plan->destacado ? 'top' : '' }} {{ $esTarjeta ? 'entry' : '' }}" data-plan-index="{{ $loop->index }}" data-plan-precio="{{ $plan->precio }}">
                        @if ($plan->destacado)
                            <span class="badge">Más elegido</span>
                        @elseif ($esTarjeta)
                            <span class="badge g">Punto de entrada</span>
                        @endif
                        <h3 class="plan-nombre">{{ $plan->nombre }}</h3>
                        <div class="ideal plan-sub">{{ $plan->subtitulo }}</div>
                        <div class="desde">Desde</div>
                        <div class="price">{{ $plan->precio }}</div>
                        <p class="desc plan-desc">{{ $plan->descripcion }}</p>
                        @php $planMsg = rawurlencode('Hola, me interesa el plan '.$plan->nombre.' ('.$plan->precio.') para '.$iniCorto.'.'); @endphp
                        <a class="btn btn-plan plan-cta" href="{{ $wa !== '' ? "https://wa.me/{$wa}?text={$planMsg}" : '#contacto' }}" @if($wa !== '') target="_blank" rel="noopener" @endif>Quiero este plan</a>
                    </div>
                @endforeach
            </div>
            <p class="planes-hint">← Desliza para ver todos los planes →</p>
            <script type="application/json" id="planes-data">{!! $planesEventoJs->toJson(JSON_UNESCAPED_UNICODE) !!}</script>
        </div>
    </section>

    <!-- COTIZACIÓN PERSONALIZADA -->
    @php
        $planBase = $planes->firstWhere('nombre', 'Invitación') ?? $planes->firstWhere('nombre', 'Tarjeta de Invitación') ?? $planes->first();
        $precioBase = (int) preg_replace('/\D/', '', (string) optional($planBase)->precio);
        $precioBase = $precioBase > 0 ? $precioBase : 749000;
        $nombreBase = optional($planBase)->nombre ?: 'Invitación';
        $opcionInvitados = $adicionales->firstWhere('tipo_calculo', 'invitados');
        $opcionFotos = $adicionales->firstWhere('tipo_calculo', 'fotografias');
        $opcionesSeleccion = $adicionales->where('tipo_calculo', 'seleccion');
    @endphp
    <section id="cotizador" class="cotizador">
        <div class="wrap">
            <div class="head reveal">
                <div class="kicker">A tu medida</div>
                <h2>Arma tu cotización personalizada</h2>
                <p>Partimos del plan {{ $nombreBase }} para 100 personas. Ajusta cantidades y elige únicamente los servicios que deseas.</p>
            </div>
            <div class="cotiza-box reveal" id="cotiza-app" data-base="{{ $precioBase }}" data-whatsapp="{{ $wa }}" data-plan="{{ $nombreBase }}">
                <div class="cotiza-opciones">
                    <h3>Configura tu experiencia</h3>
                    <p class="cotiza-ayuda">El total cambia automáticamente según tus elecciones.</p>

                    <div class="cotiza-cantidades">
                        <div class="cotiza-campo">
                            <label for="cotiza-invitados">Cantidad de invitados</label>
                            <input id="cotiza-invitados" type="number" min="100" max="1000"
                                step="{{ max(1, (int) ($opcionInvitados->unidad ?? 50)) }}" value="100"
                                data-precio="{{ (float) ($opcionInvitados->precio_valor ?? 0) }}"
                                data-unidad="{{ max(1, (int) ($opcionInvitados->unidad ?? 50)) }}">
                            <small>El plan base incluye 100 personas.</small>
                        </div>
                        <div class="cotiza-campo">
                            <label for="cotiza-fotos">Galería privada con QR · cantidad de fotos</label>
                            @php $unidadFotos = max(1, (int) ($opcionFotos->unidad ?? 500)); @endphp
                            <select id="cotiza-fotos"
                                data-precio="{{ (float) ($opcionFotos->precio_valor ?? 0) }}"
                                data-precio-adicional="{{ (float) ($opcionFotos->precio_adicional ?? 0) }}"
                                data-unidad="{{ $unidadFotos }}">
                                <option value="0">Sin galería de invitados</option>
                                <option value="{{ $unidadFotos }}">Hasta {{ number_format($unidadFotos, 0, ',', '.') }} fotos</option>
                                <option value="{{ $unidadFotos * 2 }}">Hasta {{ number_format($unidadFotos * 2, 0, ',', '.') }} fotos</option>
                                <option value="{{ $unidadFotos * 4 }}">Hasta {{ number_format($unidadFotos * 4, 0, ',', '.') }} fotos</option>
                                <option value="{{ $unidadFotos * 6 }}">Hasta {{ number_format($unidadFotos * 6, 0, ',', '.') }} fotos</option>
                                <option value="{{ $unidadFotos * 10 }}">Hasta {{ number_format($unidadFotos * 10, 0, ',', '.') }} fotos</option>
                            </select>
                            <small>{{ $opcionFotos->descripcion ?? 'Galería privada con carga por QR y descarga consolidada.' }}</small>
                        </div>
                    </div>

                    @if ($opcionesSeleccion->isNotEmpty())
                        <h3>Servicios disponibles</h3>
                        <p class="cotiza-ayuda">Estas opciones solo aparecen dentro de tu cotización.</p>
                        <div class="cotiza-lista">
                            @foreach ($opcionesSeleccion as $servicio)
                                <label class="cotiza-servicio">
                                    <input type="checkbox" class="cotiza-check" value="{{ $servicio->nombre }}"
                                        data-precio="{{ (float) $servicio->precio_valor }}"
                                        data-requiere-fotos="{{ $servicio->requiere_fotos ? '1' : '0' }}">
                                    <span>
                                        {{ $servicio->nombre }}
                                        <small>{{ $servicio->descripcion }}</small>
                                        <em>{{ $servicio->precio }}</em>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>

                <aside class="cotiza-total" aria-live="polite">
                    <h3>Tu cotización estimada</h3>
                    <div class="desde">Valor final</div>
                    <div class="valor" id="cotiza-valor">$ {{ number_format($precioBase, 0, ',', '.') }} COP</div>
                    <ul class="cotiza-resumen" id="cotiza-resumen"></ul>
                    <a class="btn btn-oro" id="cotiza-whatsapp" href="{{ $waLink }}" @if($wa !== '') target="_blank" rel="noopener" @endif>Solicitar esta cotización</a>
                    <p class="cotiza-nota">Este valor es una estimación. Confirmaremos alcance, disponibilidad y condiciones antes de iniciar.</p>
                </aside>
            </div>
        </div>
    </section>

    <!-- TESTIMONIO -->
    <section class="testi">
        <div class="wrap reveal">
            <div class="stars">★★★★★</div>
            <blockquote id="ev-testi-quote">{{ $ini['testiQuote'] }}</blockquote>
            <div class="who" id="ev-testi-who">{{ $ini['testiWho'] }}</div>
        </div>
    </section>

    <!-- CTA -->
    <section id="contacto" class="cta">
        <div class="wrap reveal">
            <h2 id="ev-cta-head">{{ $ini['ctaHead'] }}</h2>
            <p>Cuéntanos la fecha y el estilo de tu evento. Te preparamos una propuesta a tu medida, sin compromiso.</p>
            <div class="cta-actions">
                <a class="btn btn-wa" href="{{ $waLink }}" @if($wa !== '') target="_blank" rel="noopener" @endif>
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Zm5.8 14.12c-.24.68-1.42 1.32-1.95 1.36-.5.04-.99.28-3.4-.72-2.87-1.19-4.7-4.15-4.85-4.34-.14-.19-1.16-1.54-1.16-2.94 0-1.4.73-2.09 1-2.38.24-.26.53-.33.71-.33.18 0 .35 0 .5.01.16.007.38-.06.59.45.24.55.79 1.92.86 2.06.07.14.12.3.02.49-.42.83-.87 1-.42.94-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.94 1.94 1.23 2.22 1.37.28.14.44.12.6-.07.16-.19.69-.8.87-1.08.18-.28.36-.23.61-.14.25.09 1.6.75 1.87.89.28.14.46.21.53.33.07.12.07.68-.17 1.36Z"/></svg>
                    Escríbenos por WhatsApp
                </a>
                <a class="btn btn-line" href="mailto:{{ $email }}?subject={{ rawurlencode('Quiero una invitación o web para mi evento') }}">Escribir un correo</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="foot">
        <div class="wrap">
            <div class="logo"><img src="{{ $logo }}" alt="" style="width:30px;height:30px;border-radius:8px;">{{ $marca }}</div>
            <div>{{ $lema }}</div>
            <div style="margin-top:10px;">
                <a href="{{ $waLink }}" @if($wa !== '') target="_blank" rel="noopener" @endif>WhatsApp</a> &nbsp;·&nbsp; <a href="mailto:{{ $email }}">{{ $email }}</a>
            </div>
            <div style="margin-top:14px;opacity:.6;">© {{ date('Y') }} {{ $marca }}. Hecho con amor para celebrar tus momentos.</div>
        </div>
    </footer>

    <script type="application/json" id="eventos-data">{!! $eventosJs->toJson(JSON_UNESCAPED_UNICODE) !!}</script>
    <script>
        // Selector de tipo de evento (matrimonios / 15 años / otros).
        (function () {
            var isla = document.getElementById('eventos-data');
            var hero = document.getElementById('hero');
            if (!isla || !hero) return;
            var data = JSON.parse(isla.textContent);
            var wa = hero.dataset.whatsapp || '';
            var eyebrow = document.getElementById('ev-eyebrow');
            var title = document.getElementById('ev-title');
            var lead = document.getElementById('ev-lead');
            var phName = document.getElementById('ph-name');
            var phSub = document.getElementById('ph-sub');
            var phHero = document.getElementById('ph-hero');
            var heroWa = document.getElementById('hero-wa');
            var servHead = document.getElementById('ev-serv-head');
            var testiQuote = document.getElementById('ev-testi-quote');
            var testiWho = document.getElementById('ev-testi-who');
            var ctaHead = document.getElementById('ev-cta-head');
            var root = document.documentElement;

            function setText(el, txt) { if (el && txt != null) el.textContent = txt; }

            // Datos de planes por evento (opcional).
            var planIsla = document.getElementById('planes-data');
            var planData = planIsla ? JSON.parse(planIsla.textContent) : null;
            var planCards = Array.from(document.querySelectorAll('.plan[data-plan-index]'));

            function actualizarPlanes(clave, ev) {
                if (!planData) return;
                var lista = planData[clave] || planData.matrimonio || [];
                var fallback = planData.matrimonio || [];
                planCards.forEach(function (card) {
                    var idx = Number(card.dataset.planIndex);
                    var ov = lista[idx] || fallback[idx];
                    if (!ov) return;
                    var nombre = card.querySelector('.plan-nombre');
                    var sub = card.querySelector('.plan-sub');
                    var desc = card.querySelector('.plan-desc');
                    var cta = card.querySelector('.plan-cta');
                    if (nombre) nombre.textContent = ov.nombre;
                    if (sub) sub.textContent = ov.subtitulo || '';
                    if (desc) desc.textContent = ov.descripcion || '';
                    if (cta && wa) {
                        var precio = card.dataset.planPrecio || '';
                        cta.href = 'https://wa.me/' + wa + '?text=' + encodeURIComponent('Hola, me interesa el plan ' + ov.nombre + (precio ? ' (' + precio + ')' : '') + ' para ' + (ev.waCorto || 'mi evento') + '.');
                    }
                });
            }

            function activar(clave) {
                var ev = data[clave];
                if (!ev) return;
                // Acento del evento aplicado a TODA la página.
                root.style.setProperty('--ev', ev.acento);
                root.style.setProperty('--ev-2', ev.acento2);
                if (ev.acentoInk) root.style.setProperty('--ev-ink', ev.acentoInk);
                setText(eyebrow, ev.eyebrow);
                setText(title, ev.titulo);
                setText(lead, ev.texto);
                setText(phName, ev.phName);
                setText(phSub, ev.phSub);
                setText(phHero, ev.phHero);
                setText(servHead, ev.servHead);
                setText(testiQuote, ev.testiQuote);
                setText(testiWho, ev.testiWho);
                setText(ctaHead, ev.ctaHead);
                if (wa) {
                    heroWa.href = 'https://wa.me/' + wa + '?text=' + encodeURIComponent('Hola, quiero información sobre ' + ev.wa + '.');
                }
                document.querySelectorAll('.switch [data-ev]').forEach(function (b) {
                    var on = b.dataset.ev === clave;
                    b.classList.toggle('active', on);
                    b.setAttribute('aria-pressed', on ? 'true' : 'false');
                });
                actualizarPlanes(clave, ev);
            }

            document.querySelectorAll('.switch [data-ev]').forEach(function (el) {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    activar(el.dataset.ev);
                });
            });
        })();

        // Cotizador.
        (function () {
            var app = document.getElementById('cotiza-app');
            if (!app) return;

            var base = Number(app.dataset.base || 749000);
            var whatsapp = app.dataset.whatsapp || '';
            var nombrePlan = app.dataset.plan || 'Invitación';
            var invitados = document.getElementById('cotiza-invitados');
            var fotos = document.getElementById('cotiza-fotos');
            var checks = Array.from(document.querySelectorAll('.cotiza-check'));
            var valor = document.getElementById('cotiza-valor');
            var resumen = document.getElementById('cotiza-resumen');
            var boton = document.getElementById('cotiza-whatsapp');
            function formatoCOP(precio) {
                return '$' + Number(precio).toLocaleString('es-CO') + ' COP';
            }

            function itemResumen(nombre, precio) {
                var item = document.createElement('li');
                var etiqueta = document.createElement('span');
                var monto = document.createElement('strong');
                etiqueta.textContent = nombre;
                monto.textContent = formatoCOP(precio);
                item.append(etiqueta, monto);
                resumen.appendChild(item);
            }

            function calcular() {
                var cantidadInvitados = Math.max(100, Number(invitados.value || 100));
                var unidadInvitados = Number(invitados.dataset.unidad || 50);
                var bloquesInvitados = Math.ceil(Math.max(0, cantidadInvitados - 100) / unidadInvitados);
                var costoInvitados = bloquesInvitados * Number(invitados.dataset.precio || 0);

                var cantidadFotos = Math.max(0, Number(fotos.value || 0));
                var unidadFotos = Number(fotos.dataset.unidad || 1000);
                var bloquesFotos = Math.ceil(cantidadFotos / unidadFotos);
                var costoFotos = bloquesFotos > 0
                    ? Number(fotos.dataset.precio || 0) + ((bloquesFotos - 1) * Number(fotos.dataset.precioAdicional || 0))
                    : 0;

                var seleccionados = checks.filter(function (check) { return check.checked; });
                var costoServicios = seleccionados.reduce(function (suma, check) {
                    return suma + Number(check.dataset.precio || 0);
                }, 0);
                var total = base + costoInvitados + costoFotos + costoServicios;

                valor.textContent = formatoCOP(total);
                resumen.innerHTML = '';
                itemResumen('Plan ' + nombrePlan + ' · 100 personas', base);
                if (costoInvitados > 0) itemResumen((cantidadInvitados - 100) + ' invitados adicionales', costoInvitados);
                if (costoFotos > 0) itemResumen('Galería QR · hasta ' + cantidadFotos.toLocaleString('es-CO') + ' fotos', costoFotos);
                seleccionados.forEach(function (check) {
                    itemResumen(check.value, Number(check.dataset.precio || 0));
                });

                if (whatsapp) {
                    var lineas = [
                        'Hola, quiero solicitar esta cotización personalizada:',
                        '- Plan ' + nombrePlan + ' para ' + cantidadInvitados + ' personas',
                        cantidadFotos > 0
                            ? '- Galería QR: hasta ' + cantidadFotos.toLocaleString('es-CO') + ' fotos'
                            : '- Galería QR: no incluida'
                    ];
                    seleccionados.forEach(function (check) { lineas.push('- ' + check.value); });
                    lineas.push('Total estimado: ' + formatoCOP(total));
                    boton.href = 'https://wa.me/' + whatsapp + '?text=' + encodeURIComponent(lineas.join('\n'));
                }
            }

            invitados.addEventListener('input', calcular);
            fotos.addEventListener('input', calcular);
            checks.forEach(function (check) {
                check.addEventListener('change', function () {
                    if (check.checked && check.dataset.requiereFotos === '1' && Number(fotos.value) === 0) {
                        fotos.value = fotos.options[1].value;
                    }
                    calcular();
                });
            });
            fotos.addEventListener('change', function () {
                if (Number(fotos.value) === 0) {
                    checks.filter(function (check) { return check.dataset.requiereFotos === '1'; })
                        .forEach(function (check) { check.checked = false; });
                }
                calcular();
            });
            calcular();
        })();

        // Reveal on scroll.
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
