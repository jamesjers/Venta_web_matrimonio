<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso · Administración</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/logo-matrimonio.svg') }}">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; padding: 24px;
            background:
                radial-gradient(circle at 16% 22%, rgba(22,161,155,.32), transparent 45%),
                radial-gradient(circle at 84% 80%, rgba(37,99,175,.42), transparent 45%),
                linear-gradient(150deg, #060f22 0%, #0a1c39 55%, #0a2a42 100%);
        }
        .card {
            width: 100%; max-width: 400px; background: #fff; border-radius: 22px; padding: 34px 30px;
            box-shadow: 0 28px 60px rgba(4,12,30,.5); color: #16233c;
        }
        .top { display: flex; align-items: center; gap: 12px; margin-bottom: 22px; }
        .top img { width: 46px; height: 46px; border-radius: 12px; }
        .top .t { font-weight: 800; color: #0a1c39; font-size: 1.15rem; line-height: 1.1; }
        .top .s { font-size: .8rem; color: #667a93; }
        label { display: block; font-weight: 600; color: #0a1c39; margin-bottom: 6px; font-size: .9rem; }
        input { width: 100%; border: 1px solid #d7e1ec; border-radius: 10px; padding: 12px 13px; font-size: .96rem; font-family: inherit; margin-bottom: 16px; }
        input:focus { outline: 2px solid rgba(14,90,92,.2); border-color: #0e5a5c; }
        .btn { width: 100%; border: none; border-radius: 12px; padding: 14px; font-weight: 800; font-size: 1rem; cursor: pointer;
            background: linear-gradient(120deg, #16a19b, #0e5a5c); color: #fff; font-family: inherit; }
        .btn:hover { filter: brightness(1.05); }
        .err { background: #fdecec; color: #8d2b2b; border: 1px solid #f2c4c4; border-radius: 10px; padding: 10px 13px; margin-bottom: 16px; font-size: .9rem; }
        .remember { display: flex; align-items: center; gap: 8px; margin-bottom: 18px; font-size: .9rem; color: #667a93; }
        .remember input { width: auto; margin: 0; }
        .back { display: block; text-align: center; margin-top: 16px; color: #667a93; text-decoration: none; font-size: .86rem; }
    </style>
</head>
<body>
    <div class="card">
        <div class="top">
            <img src="{{ asset('assets/logo-matrimonio.svg') }}" alt="">
            <div>
                <div class="t">Administración</div>
                <div class="s">Panel de ventas del negocio</div>
            </div>
        </div>

        @if ($errors->any())
            <div class="err">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf
            <label for="email">Correo</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required>

            <label class="remember"><input type="checkbox" name="remember" value="1"> Recordarme en este equipo</label>

            <button class="btn" type="submit">Ingresar</button>
        </form>

        <a class="back" href="{{ route('servicio') }}">← Volver a la página</a>
    </div>
</body>
</html>
