#!/usr/bin/env bash
set -euo pipefail
[ ! -f .env ] && cp .env.example .env && echo "→ .env créé"
gen() { openssl rand -hex 32; }
fill() {
    local k="$1" v="$2"
    grep -q "^${k}=$" .env && sed -i "s|^${k}=$|${k}=${v}|" .env \
        && echo "✓ ${k}" || echo "  ${k} déjà défini"
}
fill DB_PASSWORD          "$(gen)"
fill DB_ROOT_PASSWORD     "$(gen)"
fill MEILISEARCH_KEY      "$(gen)"
fill THUMBOR_SECURITY_KEY "$(gen)"
echo; echo "Reste à renseigner : KANKA_VERSION, APP_URL, APP_EMAIL"
