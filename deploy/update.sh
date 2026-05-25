#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."
NEW="${1:-}"; [ -z "$NEW" ] && { echo "Usage: ./deploy/update.sh <version>"; exit 1; }
source .env; OLD="${KANKA_VERSION}"

echo "Mise à jour : ${OLD} → ${NEW}"
git fetch origin && git checkout "tags/${NEW}" 2>/dev/null || \
    { echo "Tag ${NEW} introuvable"; exit 1; }
sed -i "s|^KANKA_VERSION=.*|KANKA_VERSION=${NEW}|" .env

docker compose build app
docker compose up -d --no-deps app nginx
docker compose exec app php artisan migrate --force
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache

docker image rm "kanka-app:${OLD}" 2>/dev/null && \
    echo "✓ Ancienne image supprimée" || true
echo "✓ Mise à jour ${NEW} terminée"
