# Ventas Bodas Web

Página comercial (landing) para **ofrecer y vender el servicio de páginas web para matrimonios**,
con un panel de administración para gestionar precios, ventas y servidores.

Proyecto Laravel 12 independiente, pensado para desplegarse en un **subdominio** propio.

## Qué incluye

- **Landing pública** en `/` — diseño moderno, con los servicios (ubicación, invitación,
  recordatorios, recuerdos, fotos compartidas en vivo, ingreso con QR, mesas), personalización a
  medida y la promesa de dominio + hosting por 1 año con los nombres de los novios.
- **5 planes**. El plan Invitación inicia en **$799.000 COP** para 100 personas y los precios de
  todos los planes se administran desde el panel.
- **Cotización personalizada** desde el plan Invitación: permite calcular invitados, cantidad de
  fotos y servicios elegidos, y preparar el resumen para enviarlo por WhatsApp.
- Las características detalladas de los planes son información interna: se gestionan en el
  administrador y se consultan al registrar una venta, pero no se muestran en la landing.
- **Panel de administración** en `/admin` (requiere login):
  - Ventas, Servidores, Planes y precios, y Configuración (marca, WhatsApp, correo, textos).

## Puesta en marcha con Docker

```bash
docker compose up -d --build
```

El contenedor levanta PostgreSQL, instala dependencias, crea `.env`, genera la app key,
corre las migraciones y crea el usuario administrador automáticamente.

- Landing: http://localhost:8082
- Panel: http://localhost:8082/admin
- Acceso por defecto: `admin@ventas-bodas.com` / `ventasbodas2026` (cámbialo tras el primer ingreso).

## Puesta en marcha manual (sin Docker)

Requiere PHP 8.2+, Composer y PostgreSQL.

```bash
composer install
cp .env.example .env      # ajusta credenciales de base de datos
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Despliegue en el servidor (subdominio)

1. Crea el repositorio remoto y sube el código:
   ```bash
   git remote add origin <URL-de-tu-repo>
   git push -u origin main
   ```
2. En el servidor, clona el repo y apunta el subdominio (por ejemplo `ventas.tudominio.com`)
   al `DocumentRoot` `public/`.
3. Configura `.env` con la base de datos del servidor y ejecuta
   `composer install --no-dev`, `php artisan key:generate`, `php artisan migrate --seed`.
4. O usa el `Dockerfile` / `docker-compose.yml` incluidos.

## Personalización

Casi todo se edita **sin tocar código** desde `/admin`:

- **Planes y precios** → valor de venta, nombre, características internas y plan destacado.
- **Cotizador** → valor numérico, unidad y forma de cálculo de cada servicio disponible.
- **Configuración** → marca, WhatsApp, correo y textos del hero.
- **Ventas** y **Servidores** → gestión interna del negocio.

## Precios configurados

- Invitación: $799.000 COP.
- Gestión de Invitados: $1.240.000 COP.
- Organización y Mesas: $1.740.000 COP.
- Experiencia y Recuerdos: $2.540.000 COP.
- Premium: $3.840.000 COP.

El plan Invitación incluye perfil de administración, revisión y actualización del estado de las
invitaciones, música en la tarjeta, ubicación de ceremonia y recepción, código de vestimenta,
opciones de regalo y capacidad para 100 personas. Este detalle solo se muestra dentro del panel.
