FROM ubuntu:24.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
    apache2 \
    postgresql \
    postgresql-contrib \
    php \
    php-cli \
    libapache2-mod-php \
    php-pgsql \
    php-mbstring \
    php-xml \
    php-curl \
    php-zip \
    php-bcmath \
    php-intl \
    composer \
    curl \
    unzip \
    git \
    ca-certificates \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite headers

COPY docker/apache/laravel.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php/99-performance.ini /etc/php/8.3/apache2/conf.d/99-performance.ini
COPY docker/php/99-performance.ini /etc/php/8.3/cli/conf.d/99-performance.ini
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && mkdir -p /var/www/html \
    && chown -R www-data:www-data /var/www/html

EXPOSE 80 5432

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
