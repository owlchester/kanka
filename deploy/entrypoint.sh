#!/bin/sh
set -e

# Au premier démarrage, copier les fichiers public vers le volume partagé
if [ ! -f /var/www/html/public/index.php ]; then
    echo "Initialisation du répertoire public..."
    cp -a /var/www/html/public_baked/. /var/www/html/public/
    chown -R www-data:www-data /var/www/html/public
fi

exec "$@"
