#!/bin/sh
# Static export of the PHP MVC site into dist/ (used by Vercel's build step).
#
# The export runs in a throw-away copy of the project with its own SQLite
# database, so your development database, .env and vendor/ are never touched.
# Usage:  sh build.sh        (optional: BUILD_PORT=8088 APP_URL=https://example.com)
set -e

ROOT=$(cd "$(dirname "$0")" && pwd)
cd "$ROOT"

# --- PHP + required extensions ------------------------------------------
if ! command -v php >/dev/null 2>&1; then
  echo "php not found; installing (Amazon Linux build image)..."
  dnf install -y -q php-cli php-pdo php-mbstring >/dev/null 2>&1 || dnf install -y -q php-cli >/dev/null
fi
php -r 'foreach (["pdo_sqlite","mbstring"] as $e) { if (!extension_loaded($e)) { fwrite(STDERR, "Missing PHP extension: $e\n"); exit(1); } }'

# --- Isolated workspace ---------------------------------------------------
WORK=$(mktemp -d)
SERVER_PID=""
cleanup() {
  if [ -n "$SERVER_PID" ]; then kill "$SERVER_PID" 2>/dev/null; wait "$SERVER_PID" 2>/dev/null; fi
  rm -rf "$WORK"
}
trap cleanup EXIT

tar --exclude=./.git --exclude=./dist --exclude=./vendor --exclude=./.env \
    --exclude=./services_coop_bank --exclude=./storage/backups \
    --exclude='./storage/cache/*.json' -cf - . | (cd "$WORK" && tar xf -)
mkdir -p "$WORK/vendor" "$WORK/storage/cache" "$WORK/storage/sessions" "$WORK/storage/logs"
cp scripts/autoload-fallback.php "$WORK/vendor/autoload.php"

# Public URL (used for og:url / og:image only)
SITE_URL="${APP_URL:-}"
if [ -z "$SITE_URL" ] && [ -n "$VERCEL_PROJECT_PRODUCTION_URL" ]; then SITE_URL="https://$VERCEL_PROJECT_PRODUCTION_URL"; fi
if [ -z "$SITE_URL" ] && [ -n "$VERCEL_URL" ]; then SITE_URL="https://$VERCEL_URL"; fi

cat > "$WORK/.env" <<ENV
APP_NAME="Static export"
APP_ENV=production
APP_DEBUG=false
APP_URL=$SITE_URL
CLIENT=kalliaseri-scb
DB_DRIVER=sqlite
DB_DATABASE=$WORK/build.sqlite
ENV

# --- Database: schema + seed data ----------------------------------------
( cd "$WORK" && php cli.php migrate >/dev/null && php cli.php seed kalliaseri-scb >/dev/null )

# --- Start the app on a free port ----------------------------------------
PORT="${BUILD_PORT:-8088}"
while ! php -r '$s = @stream_socket_server("tcp://127.0.0.1:" . $argv[1]); exit($s ? 0 : 1);' "$PORT"; do
  PORT=$((PORT + 1))
done
( cd "$WORK" && exec php -S "127.0.0.1:$PORT" -t public public/index.php >"$WORK/server.log" 2>&1 ) &
SERVER_PID=$!
sleep 2

# --- Crawl -> dist/ ---------------------------------------------------------
rm -rf "$ROOT/dist"
mkdir -p "$ROOT/dist"
php scripts/static-export.php "http://127.0.0.1:$PORT" "$ROOT/dist"

cp -R public/assets "$ROOT/dist/assets"
[ -f "$ROOT/dist/index.html" ] || { echo "Build failed: dist/index.html missing" >&2; exit 1; }
echo "Static export complete: $(find "$ROOT/dist" -name '*.html' | wc -l | tr -d ' ') HTML pages in dist/"
