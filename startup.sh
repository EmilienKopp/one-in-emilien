#!/bin/bash

# Development startup script
# Usage:
#   ./startup.sh           - Start local development (default)
#   ./startup.sh local     - Start local development
#   ./startup.sh vps       - Start VPS development (with Traefik)
#   ./startup.sh stop      - Stop all containers

set -e

ENV="${1:-local}"

case "$ENV" in
    local)
        echo "Starting local development environment..."
        export SAIL_FILES="compose.local.yaml"
        ./vendor/bin/sail up -d
        ./vendor/bin/sail npm run dev
        ;;
    vps)
        echo "Starting VPS development environment..."
        export SAIL_FILES="compose.vps.yaml"
        ./vendor/bin/sail up -d
        ./vendor/bin/sail npm run dev
        ;;
    stop)
        echo "Stopping containers..."
        # Try both compose files
        if [ -f compose.local.yaml ]; then
            SAIL_FILES="compose.local.yaml" ./vendor/bin/sail down 2>/dev/null || true
        fi
        if [ -f compose.vps.yaml ]; then
            SAIL_FILES="compose.vps.yaml" ./vendor/bin/sail down 2>/dev/null || true
        fi
        echo "Containers stopped."
        ;;
    *)
        echo "Usage: ./startup.sh [local|vps|stop]"
        echo ""
        echo "  local  - Local development (http://localhost)"
        echo "  vps    - VPS development (https://dev.one-in-emilien.com)"
        echo "  stop   - Stop all containers"
        exit 1
        ;;
esac
