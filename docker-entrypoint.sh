#!/bin/sh
set -eu

DATA_DIR="${DATA_DIR:-/data}"
DB_FILE="${DB_FILE:-$DATA_DIR/hoaks_bengkulu.sqlite}"
UPLOAD_DIR="${UPLOAD_DIR:-$DATA_DIR/uploads}"

mkdir -p "$DATA_DIR"
mkdir -p "$(dirname "$DB_FILE")"
mkdir -p "$UPLOAD_DIR"

export DB_FILE
export UPLOAD_DIR

# The app creates the schema and demo accounts automatically.
# If a database already exists on a persistent volume, keep it.
exec php -S "0.0.0.0:${PORT:-8080}" -t /app
