# Ventas Bodas Web

Página comercial (landing) para **ofrecer y vender el servicio de páginas web para matrimonios**,
con un panel de administración para gestionar precios, ventas y servidores.

Proyecto Laravel 12 independiente, pensado para desplegarse en un **subdominio** propio.

## Qué incluye

- **Landing pública** en `/` — diseño moderno, con los servicios (ubicación, invitación,
  recordatorios, recuerdos, fotos compartidas en vivo, ingreso con QR, mesas), personalización a
  medida y la promesa de dominio + hosting por 1 año con los nombres de los novios.
- **2 planes** (Básico y Premium). Desde el plan Básico se ofrece el dominio con los nombres de la
  pareja. Los precios se administran desde el panel.
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

- **Planes y precios** → valor de venta, nombre, características y plan destacado.
- **Configuración** → marca, WhatsApp, correo y textos del hero.
- **Ventas** y **Servidores** → gestión interna del negocio.
