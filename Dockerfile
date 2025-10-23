# Dockerfile para Prodmais
FROM php:8.2-apache

# Instalar extensões PHP necessárias
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        git \
        zip \
        unzip \
        libzip-dev \
        libxml2-dev \
        libcurl4-openssl-dev \
        libsqlite3-dev \
        libonig-dev \
        pkg-config \
        zlib1g-dev \
        build-essential \
        autoconf \
        make \
        gcc \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install -j"$(nproc)" \
        zip \
        xml \
        curl \
        pdo_sqlite \
        mbstring \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite do Apache
RUN a2enmod rewrite

# Configurar DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar arquivos da aplicação
WORKDIR /var/www/html
COPY . .

# Instalar dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/data

# Executar script de instalação
RUN php bin/install.php

# Expor porta 80
EXPOSE 80

# Comando padrão
CMD ["apache2-foreground"]
