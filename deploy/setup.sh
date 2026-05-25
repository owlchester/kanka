#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."

GREEN="\033[1;32m"; BLUE="\033[1;34m"; RED="\033[1;31m"; RESET="\033[0m"
ok()   { echo -e "${GREEN}✓ $*${RESET}"; }
info() { echo -e "${BLUE}→ $*${RESET}"; }
die()  { echo -e "${RED}✗ $*${RESET}"; exit 1; }

[ ! -f .env ] && die ".env manquant — copier .env.example vers .env et remplir les valeurs"
source .env
[ -z "${APP_URL:-}"        ] && die "APP_URL vide dans .env"
[ -z "${DB_PASSWORD:-}"    ] && die "DB_PASSWORD vide — lancer deploy/gen-passwords.sh"
[ -z "${KANKA_VERSION:-}"  ] && die "KANKA_VERSION vide dans .env"

# Générer APP_KEY si absent
info "Vérification APP_KEY..."
grep -q "^APP_KEY=$" .env && {
    KEY=$(docker run --rm php:8.4-cli php -r \
        "echo 'base64:'.base64_encode(random_bytes(32));")
    sed -i "s|^APP_KEY=$|APP_KEY=${KEY}|" .env
    ok "APP_KEY généré"
} || ok "APP_KEY déjà présent"

# Build de l'image
info "Build de l'image kanka-app:${KANKA_VERSION}..."
docker compose build app
ok "Image buildée"

# Démarrage base de données
info "Démarrage de db, redis et meilisearch..."
docker compose up -d db redis meilisearch
info "Attente MariaDB..."
until docker compose exec db healthcheck.sh --connect --innodb_initialized \
    >/dev/null 2>&1; do sleep 2; done
ok "MariaDB prêt"

# Démarrage de tous les services
info "Démarrage de tous les services..."
docker compose up -d
sleep 5

# Migrations
info "Migrations..."
docker compose exec app php artisan migrate --force
ok "Migrations terminées"

# Seed
info "Seed de la base de données..."
docker compose exec app php artisan db:seed --force
ok "Seed terminé"

# Passport (OAuth)
info "Installation Passport..."
docker compose exec app php artisan passport:install --force
ok "Passport installé"

# Corriger les permissions des clés OAuth (créées en root par passport)
info "Correction des permissions OAuth..."
docker compose exec -u root app chown www-data:www-data \
    storage/oauth-private.key storage/oauth-public.key 2>/dev/null || true
ok "Permissions OAuth corrigées"

# Lien storage
info "Lien storage..."
docker compose exec app php artisan storage:link
ok "Lien storage créé"

# Corriger les icônes entity types (fa-duotone Pro → free FA6)
info "Correction des icônes entity types..."
docker compose exec db mariadb \
    -u "${DB_USERNAME}" -p"${DB_PASSWORD}" "${DB_DATABASE}" -e "
UPDATE entity_types SET icon = 'fa-people-group'        WHERE icon = 'fa-family'                AND campaign_id IS NULL;
UPDATE entity_types SET icon = 'fa-location-dot'        WHERE icon = 'fa-circle-location-arrow' AND campaign_id IS NULL;
UPDATE entity_types SET icon = 'fa-user-group'          WHERE icon = 'fa-screen-users'          AND campaign_id IS NULL;
UPDATE entity_types SET icon = 'fa-wand-magic-sparkles' WHERE icon = 'fa-person-fairy'          AND campaign_id IS NULL;
UPDATE entity_types SET icon = 'fa-book'                WHERE icon = 'fa-books'                 AND campaign_id IS NULL;
UPDATE entity_types SET icon = 'fa-list-ol'             WHERE icon = 'fa-list-timeline'         AND campaign_id IS NULL;
UPDATE entity_types SET icon = 'fa-paw'                 WHERE icon = 'fa-deer'                  AND campaign_id IS NULL;
"
ok "Icônes corrigées"

# MeiliSearch
info "Configuration MeiliSearch..."
docker compose exec app php artisan setup:meilisearch
ok "MeiliSearch configuré"

# Permissions storage (au cas où des fichiers auraient été créés en root)
info "Correction des permissions storage..."
docker compose exec -u root app chown -R www-data:www-data storage/
docker compose exec -u root app chmod -R 775 storage/
ok "Permissions storage corrigées"

# Optimisation
info "Optimisation (cache config, routes, vues)..."
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
ok "Optimisation terminée"

echo
echo -e "${GREEN}✓ Kanka installé avec succès !${RESET}"
echo -e "Accès : ${GREEN}${APP_URL}:${APP_PORT:-8080}${RESET}"
echo "→ Crée ton compte sur cette URL (le premier compte est admin)"
