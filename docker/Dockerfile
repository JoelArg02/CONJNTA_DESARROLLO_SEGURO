FROM php:8.2-fpm

# ---------- dependencias del sistema ----------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libpq-dev \
    default-mysql-client \
    gnupg \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql bcmath

# ---------- Node.js + npm (v18 LTS) ----------
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# ---------- Composer ----------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ---------- OPcache (acelera PHP) ----------
RUN docker-php-ext-install opcache \
    && { \
       echo 'opcache.enable=1'; \
       echo 'opcache.validate_timestamps=0'; \
       echo 'opcache.memory_consumption=128'; \
       echo 'opcache.interned_strings_buffer=16'; \
       echo 'opcache.max_accelerated_files=10000'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www

# puerto php-fpm interno
EXPOSE 9000
