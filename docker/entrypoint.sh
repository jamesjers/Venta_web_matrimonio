#!/usr/bin/env bash
set -euo pipefail

POSTGRES_VERSION="${POSTGRES_VERSION:-16}"
POSTGRES_DB="${POSTGRES_DB:-ventas}"
POSTGRES_USER="${POSTGRES_USER:-ventas}"
POSTGRES_PASSWORD="${POSTGRES_PASSWORD:-ventas123}"
PROJECT_PATH="/var/www/html"
PG_CONF="/etc/postgresql/${POSTGRES_VERSION}/main/postgresql.conf"
PG_HBA="/etc/postgresql/${POSTGRES_VERSION}/main/pg_hba.conf"

mkdir -p "${PROJECT_PATH}"
mkdir -p "${PROJECT_PATH}/storage" "${PROJECT_PATH}/storage/framework" "${PROJECT_PATH}/storage/framework/views" "${PROJECT_PATH}/storage/framework/cache" "${PROJECT_PATH}/storage/framework/sessions" "${PROJECT_PATH}/storage/framework/testing" "${PROJECT_PATH}/storage/logs" "${PROJECT_PATH}/bootstrap/cache"
chown -R www-data:www-data /var/www/html

mkdir -p /var/run/postgresql
chown -R postgres:postgres /var/run/postgresql /var/lib/postgresql

if ! grep -q "^listen_addresses = '\*'" "${PG_CONF}"; then
  sed -i "s/^#\?listen_addresses =.*/listen_addresses = '*'/" "${PG_CONF}"
fi

if ! grep -q "^host all all 0.0.0.0/0 md5" "${PG_HBA}"; then
  echo "host all all 0.0.0.0/0 md5" >> "${PG_HBA}"
fi

pg_ctlcluster "${POSTGRES_VERSION}" main start

if ! su - postgres -c "psql -tAc \"SELECT 1 FROM pg_roles WHERE rolname='${POSTGRES_USER}'\"" | grep -q 1; then
  su - postgres -c "psql -c \"CREATE USER \\\"${POSTGRES_USER}\\\" WITH PASSWORD '${POSTGRES_PASSWORD}';\""
else
  su - postgres -c "psql -c \"ALTER USER \\\"${POSTGRES_USER}\\\" WITH PASSWORD '${POSTGRES_PASSWORD}';\""
fi

if ! su - postgres -c "psql -tAc \"SELECT 1 FROM pg_database WHERE datname='${POSTGRES_DB}'\"" | grep -q 1; then
  su - postgres -c "createdb \"${POSTGRES_DB}\" -O \"${POSTGRES_USER}\""
fi

su - postgres -c "psql -c \"GRANT ALL PRIVILEGES ON DATABASE \\\"${POSTGRES_DB}\\\" TO \\\"${POSTGRES_USER}\\\";\""

cd "${PROJECT_PATH}"

# Dependencias PHP (se instalan en el volumen del contenedor la primera vez).
if [ -f "${PROJECT_PATH}/composer.json" ] && [ ! -f "${PROJECT_PATH}/vendor/autoload.php" ]; then
  echo "Instalando dependencias de Composer..."
  composer install --no-interaction --prefer-dist --no-progress
fi

# Configuracion inicial de la aplicacion (idempotente).
if [ ! -f "${PROJECT_PATH}/.env" ]; then
  echo "Creando .env desde .env.example..."
  cp "${PROJECT_PATH}/.env.example" "${PROJECT_PATH}/.env"
fi

if ! grep -q "^APP_KEY=base64:" "${PROJECT_PATH}/.env"; then
  php artisan key:generate --force
fi

# Migraciones y usuario administrador (idempotente).
php artisan migrate --force
php artisan db:seed --force || true

chown -R www-data:www-data "${PROJECT_PATH}/storage" "${PROJECT_PATH}/bootstrap/cache"
chmod -R ug+rwX "${PROJECT_PATH}/storage" "${PROJECT_PATH}/bootstrap/cache"

pg_ctlcluster "${POSTGRES_VERSION}" main restart

exec apachectl -D FOREGROUND
