FROM php:7.2-apache

RUN apt-get update \
    && apt-get install -y git zip authbind vim libpng-dev\
    && docker-php-ext-install -j$(nproc) pdo_mysql bcmath gd\
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN a2enmod rewrite

COPY .docker/web/000-default.conf /etc/apache2/sites-enabled/000-default.conf
COPY .docker/web/run.sh /usr/local/bin/run.sh

RUN groupadd -g 999 deploy \
    && useradd -r -m -u 999 -g deploy -G www-data deploy \
    && touch /etc/authbind/byport/80 \
    && touch /etc/authbind/byport/443 \
    && chmod 777 /etc/authbind/byport/80 \
    && chmod 777 /etc/authbind/byport/443 \ 
    && chmod -R 770 /var/log/apache2 \
    && chgrp -R www-data /var/log/apache2

USER deploy
WORKDIR /var/www/html

CMD ["/usr/local/bin/run.sh"]
