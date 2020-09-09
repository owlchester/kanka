#!/bin/sh -e

##
# Display the text for the given step
# $1 the text for the step heading
##
step() {
    printf "$1\n"
}

step "Wait for database up"
wait-for database:3306

# step "composer install"
# cd /var/www/html && composer install

step "Generating Key"
cd /var/www/html && php artisan key:generate

# step "Creating storage link"
# cd /var/www/html && php artisan storage:link

step "Installing voyager"
cd /var/www/html && php artisan voyager:install

# step "Migrating the database"
# cd /var/www/html && php artisan migrate --force

# step "Seeding permissions"
# cd /var/www/html && php artisan db:seed --class=BouncerSeeder

step "Starting Apache"
authbind --deep /usr/local/bin/apache2-foreground
