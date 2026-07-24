# Invita · Ventas Eventos Web

Página comercial (landing) para **ofrecer y vender invitaciones digitales y páginas web para
eventos** —matrimonios, fiestas de 15 años, bautizos, grados, cumpleaños y más—, con un panel de
administración para gestionar precios, ventas y servidores.

Proyecto Laravel 12 independiente, pensado para desplegarse en un **subdominio** propio.

## Qué incluye

- **Landing pública** en `/` — diseño moderno con un **selector de tipo de evento** en la parte
  superior (Matrimonios · 15 años · Otros eventos) que cambia la portada (textos, mockup y acento
  de color) de forma dinámica. Incluye los servicios (ubicación, invitación, estado de
  invitaciones, recuerdos, fotos compartidas en vivo, ingreso con QR, mesas), personalización a
  medida y la promesa de dominio + hosting por 1 año con el nombre del evento.
- **Producto de entrada: Tarjeta de Invitación con panel por $349.000 COP** — solo la tarjeta de
  invitación con dominio propio y un panel de control exclusivo de esa tarjeta para revisar el
  estado de las confirmaciones. Se muestra en una banda destacada de la landing y como primer plan.
- **6 planes**. Van desde la Tarjeta de Invitación (**$349.000 COP**) y el plan Invitación
  (**$749.000 COP** para 100 personas) hasta Premium; los precios de todos los planes se
  administran desde el panel.
- **Cotización personalizada** desde el plan Invitación: permite calcular invitados, cantidad de
  fotos por paquetes y servicios elegidos, y preparar el resumen para enviarlo por WhatsApp.
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

- Tarjeta de Invitación: $349.000 COP.
- Invitación: $749.000 COP.
- Gestión de Invitados: $1.149.000 COP.
- Organización y Mesas: $1.599.000 COP.
- Experiencia y Recuerdos: $2.299.000 COP.
- Premium: $3.499.000 COP.

La **Tarjeta de Invitación** ($349.000) es el producto de entrada: incluye la tarjeta digital, el
dominio propio con el nombre del evento y un panel de control exclusivo de esa tarjeta para revisar
el estado de las confirmaciones. No incluye gestión avanzada de invitados ni módulo de mesas.

El plan Invitación incluye todo lo de la Tarjeta más perfil de administración, actualización del
estado de las invitaciones, música en la tarjeta, ubicación de ceremonia y recepción, código de
vestimenta, opciones de regalo y capacidad para 100 personas. Este detalle solo se muestra dentro
del panel.

Todo el catálogo se ofrece para matrimonios, fiestas de 15 años y otros eventos; el selector
superior de la landing adapta la portada a cada tipo de evento.

## Alcance del cotizador personalizado

Las opciones públicas describen entregables y límites concretos:

- Invitados adicionales a $70.000 COP por cada bloque de 50.
- Galería privada con QR: $250.000 COP hasta 500 fotos y $60.000 COP por cada bloque adicional de
  500; incluye carga desde el navegador sin instalar aplicaciones y descarga consolidada.
- Presentación de fotos en tiempo real por $70.000 COP como módulo separado. Se entrega un enlace
  en pantalla completa para abrirlo desde un computador conectado a un televisor o videobeam.
  El servicio no incluye equipos, operador ni la conexión a internet del lugar.
- Moderación remota de fotos durante máximo cuatro horas.
- Videos de invitados limitados a 100 clips de máximo 30 segundos.
- Módulo de mesas limitado a 20 mesas.
- Check-in con QR desde celular, libro de mensajes digital y recordatorios preparados para
  WhatsApp.
- Soporte remoto o presencial con duración y cobertura indicadas.

El cotizador no promete envíos masivos automáticos de WhatsApp ni incluye cobros de API de
terceros. Los servicios que dependen de fotos activan el paquete mínimo de galería.
