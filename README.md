# One-In-Emilien

A portfolio application built with Laravel 12, Inertia.js v2, and Svelte 5. Features an admin panel, AI chat integration, and automated deployment via webhooks.

## Tech Stack

**Backend:**
- PHP 8.4
- Laravel 12
- Laravel Sail (Docker)
- Laravel Fortify (Authentication)
- PostgreSQL 17
- Redis

**Frontend:**
- Svelte 5
- Inertia.js v2
- Tailwind CSS v4
- Vite 7

**AI Integration:**
- Anthropic Claude API

## Requirements

- Docker & Docker Compose
- Node.js 20+
- Composer (for initial setup)

## Getting Started

### 1. Clone and Install Dependencies

```bash
git clone <repository-url>
cd one-in-emilien

# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2. Environment Setup

```bash
# Copy example environment file
cp .env.example .env

# Generate application key
./vendor/bin/sail artisan key:generate
```

Edit `.env` and configure:
- `ANTHROPIC_API_KEY` - For AI chat functionality

### 3. Start Development Server

```bash
# Start local development (default)
./startup.sh

# Or explicitly:
./startup.sh local
```

This starts:
- Laravel app at http://localhost
- PostgreSQL at localhost:5432
- Redis at localhost:6379
- Mailpit dashboard at http://localhost:8025
- Vite dev server with HMR at localhost:5173

### 4. Run Migrations

```bash
./vendor/bin/sail artisan migrate
```

### 5. Stop Containers

```bash
./startup.sh stop
```

## Development Environments

This project supports two Docker configurations:

| Environment | Compose File | URL | Use Case |
|-------------|--------------|-----|----------|
| Local | `compose.local.yaml` | http://localhost | Local machine development |
| VPS | `compose.vps.yaml` | https://dev.one-in-emilien.com | Remote development via Traefik |

### Local Development

Default configuration for development on your local machine:

```bash
./startup.sh local
```

- No external dependencies (Traefik, SSL)
- Standard ports (80, 5173, 5432, 6379)
- Simple localhost access

### VPS Development

For development on a VPS with Traefik reverse proxy:

```bash
./startup.sh vps
```

Requires:
- Traefik with `traefik_network` external network
- DNS configured for `dev.one-in-emilien.com`
- See `docs/REMOTE_ENVIRONMENT_SETUP.md` for full setup

## Project Structure

```
one-in-emilien/
├── app/
│   ├── Http/Controllers/    # Request handlers
│   ├── Models/              # Eloquent models
│   └── Actions/             # Fortify actions
├── resources/
│   └── js/
│       ├── Pages/           # Inertia page components
│       ├── Components/      # Reusable Svelte components
│       └── Layouts/         # Page layouts
├── routes/
│   ├── web.php              # Web routes
│   ├── api.php              # API routes
│   └── settings.php         # Settings routes
├── tests/
│   ├── Feature/             # Feature tests
│   └── Unit/                # Unit tests
├── compose.local.yaml       # Local Docker config
├── compose.vps.yaml         # VPS Docker config (Traefik)
├── Envoy.blade.php          # Deployment tasks
└── startup.sh               # Development startup script
```

## Common Commands

```bash
# Sail commands (run inside Docker)
./vendor/bin/sail artisan <command>
./vendor/bin/sail npm <command>
./vendor/bin/sail composer <command>
./vendor/bin/sail test

# Run tests
./vendor/bin/sail artisan test

# Run specific test
./vendor/bin/sail artisan test --filter=TestName

# Code formatting
./vendor/bin/pint

# Build for production
./vendor/bin/sail npm run build
```

## Deployment

The project uses Laravel Envoy for deployment. On the VPS, production runs at `/var/www/portfolio`.

### Manual Deployment

```bash
php artisan deploy
```

### Webhook Deployment

POST to `/api/webhook/deploy` with `X-Webhook-Token` header. See `docs/WEBHOOK_DEPLOYMENT.md` for details.

## Documentation

- [MIGRATION_PLAN.md](MIGRATION_PLAN.md) - SvelteKit to Laravel migration status
- [VITE_CONFIGURATION.md](VITE_CONFIGURATION.md) - Vite HMR configuration
- [docs/REMOTE_ENVIRONMENT_SETUP.md](docs/REMOTE_ENVIRONMENT_SETUP.md) - VPS development setup
- [docs/WEBHOOK_DEPLOYMENT.md](docs/WEBHOOK_DEPLOYMENT.md) - Webhook deployment guide

## License

Proprietary
