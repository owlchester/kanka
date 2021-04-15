FROM php:7.4-apache

RUN apt-get update \
    && apt-get install -y git zip authbind vim libpng-dev libzip-dev libpq-dev netcat \
    && docker-php-ext-install -j$(nproc) bcmath gd pdo_mysql mysqli pdo_pgsql pgsql zip \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN a2enmod rewrite

COPY .docker/web/wait-for /usr/local/bin/
RUN chmod a+rx /usr/local/bin/wait-for
COPY .docker/web/000-default.conf /etc/apache2/sites-enabled/000-default.conf
COPY .docker/web/run.sh /usr/local/bin/run.sh
COPY .docker/web/variables.env /var/www/html/.env
COPY app                /var/www/html/app/
COPY bootstrap          /var/www/html/bootstrap/
COPY config             /var/www/html/config/
COPY database           /var/www/html/database/
COPY hooks              /var/www/html/hooks/
COPY public             /var/www/html/public/
COPY .htaccess.example  /var/www/html/public/.htaccess
COPY resources          /var/www/html/resources/
COPY routes             /var/www/html/routes/
COPY storage            /var/www/html/storage/
COPY artisan *.json *.lock *.xml *.php *.js /var/www/html/

RUN groupadd -g 999 deploy \
    && useradd -r -m -u 999 -g deploy -G www-data deploy \
    && touch /etc/authbind/byport/80 \
    && touch /etc/authbind/byport/443 \
    && chmod 777 /etc/authbind/byport/80 \
    && chmod 777 /etc/authbind/byport/443 \ 
    && chmod -R 770 /var/log/apache2 \
    && chgrp -R www-data /var/log/apache2 \
    && chown -R deploy:www-data /var/www/html/* /var/www/html/.*

USER deploy
WORKDIR /var/www/html

RUN DB_CONNECTION=sqlite DB_DATABASE=:memory: composer install

CMD ["/usr/local/bin/run.sh"]
