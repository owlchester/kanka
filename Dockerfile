FROM php:8.4-fpm-bookworm AS builder

RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl zip unzip \
    libzip-dev libpng-dev libjpeg-dev libwebp-dev libfreetype6-dev \
    libmagickwand-dev libicu-dev libonig-dev libxml2-dev libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql mbstring zip gd intl opcache bcmath xml soap exif \
    && pecl install imagick redis \
    && docker-php-ext-enable imagick redis \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g yarn \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --no-interaction --optimize-autoloader --no-scripts
RUN yarn install && yarn add cookieconsent && yarn build && rm -rf node_modules

RUN rm -rf tests .git .github storage/logs/* \
    storage/framework/cache/data/* \
    storage/framework/sessions/* \
    storage/framework/views/*

FROM php:8.4-fpm-bookworm AS runtime

RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev libpng-dev libjpeg-dev libwebp-dev libfreetype6-dev \
    libmagickwand-dev libicu-dev libonig-dev libxml2-dev libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql mbstring zip gd intl opcache bcmath xml soap exif \
    && pecl install imagick redis \
    && docker-php-ext-enable imagick redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY deploy/php/opcache.ini /usr/local/etc/php/conf.d/99-kanka.ini
COPY --from=builder /var/www/html /var/www/html

WORKDIR /var/www/html
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]


# Rename public so the shared volume can be mounted at /public
RUN mv /var/www/html/public /var/www/html/public_baked \
    && mkdir /var/www/html/public

COPY deploy/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
