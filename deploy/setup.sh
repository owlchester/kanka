#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."

GREEN="\033[1;32m"; BLUE="\033[1;34m"; RED="\033[1;31m"; RESET="\033[0m"
ok()   { echo -e "${GREEN}✓ $*${RESET}"; }
info() { echo -e "${BLUE}→ $*${RESET}"; }
die()  { echo -e "${RED}✗ $*${RESET}"; exit 1; }

[ ! -f .env ] && die ".env manquant — lancer gen-passwords.sh d'abord"
source .env
[ -z "${APP_URL:-}"    ] && die "APP_URL vide dans .env"
[ -z "${DB_PASSWORD:-}"] && die "DB_PASSWORD vide — lancer gen-passwords.sh"
[ -z "${KANKA_VERSION:-}"] && die "KANKA_VERSION vide dans .env"

info "Génération de APP_KEY..."
grep -q "^APP_KEY=$" .env && {
    KEY=$(docker run --rm php:8.4-cli php -r \
        "echo 'base64:'.base64_encode(random_bytes(32));")
    sed -i "s|^APP_KEY=$|APP_KEY=${KEY}|" .env
    ok "APP_KEY généré"
} || ok "APP_KEY déjà présent"

info "Build de l'image kanka-app:${KANKA_VERSION}..."
docker compose build app
ok "Image buildée"

info "Démarrage de db et redis..."
docker compose up -d db redis
info "Attente MariaDB..."
until docker compose exec db healthcheck.sh --connect --innodb_initialized \
    >/dev/null 2>&1; do sleep 2; done
ok "MariaDB prêt"

info "Démarrage de tous les services..."
docker compose up -d
sleep 5

info "Migrations..."
docker compose exec app php artisan migrate --force
info "Installation Kanka..."
docker compose exec app php artisan kanka:install
info "Lien storage..."
docker compose exec app php artisan storage:link
info "Setup MeiliSearch..."
docker compose exec app php artisan setup:meilisearch
info "Optimisation..."
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache

ok "Installation terminée !"
echo -e "\nKanka disponible sur : ${GREEN}${APP_URL}:${APP_PORT:-8080}${RESET}"
echo "Créez votre compte — le premier est automatiquement admin."
