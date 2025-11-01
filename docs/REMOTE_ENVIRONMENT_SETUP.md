# Vite HMR Setup Checklist

To make sure Vite's Hot Module Replacement (HMR) works correctly in the remote 
development environment, follow this checklist to configure all necessary components.

**important:** You can choose any port you like for Vite (e.g., `5174`), but it must be consistent across all configurations.
We chose `5174` here because the default `5173` is reserved for **PRODUCTION** use.

## Main Traefik Compose (`/root/docker-compose.yml`)

```yaml
vite-dev-proxy:
  image: alpine
  container_name: vite-dev-proxy
  command: tail -f /dev/null
  labels:
    - traefik.enable=true
    - traefik.http.routers.vite-dev.rule=Host(`vite.one-in-emilien.com`)
    - traefik.http.routers.vite-dev.tls=true
    - traefik.http.routers.vite-dev.entrypoints=websecure
    - traefik.http.routers.vite-dev.tls.certresolver=mytlschallenge
    - traefik.http.services.vite-dev.loadbalancer.server.url=http://host.docker.internal:5173
  networks:
    - traefik_network
```

**Key:** Port must be 5174

## DNS Records

- `vite.one-in-emilien.com` → A record → `72.61.112.179`
- `dev.one-in-emilien.com` → A record → `72.61.112.179`

## Project Dev Compose (`/root/ec2k/code/one-in-emilien/compose.yaml`)

```yaml
laravel.test:
  ports:
    - '${APP_PORT:-8001}:80'
    - '5174:5173'  # Must match VITE_PORT
  # ... rest of config
```

**Key:** Expose 5174:5173 (or whatever port you choose)

## Project .env

```bash
VITE_PORT=5174
APP_PORT=8001
```

**Key:** VITE_PORT must match everywhere

## Project vite.config.js

```js
server: {
    host: '0.0.0.0',
    port: 5174,  // Must match VITE_PORT
    hmr: {
        host: 'vite.one-in-emilien.com',
        protocol: 'wss',
        clientPort: 443,
    },
},
```

**Key:** Port 5174 and HMR host vite.one-in-emilien.com

## Golden Rule

All instances of the Vite port must be identical:

- Main proxy: `5174`
- Dev compose: `5174`
- .env: `5174`
- vite.config.js: `5174`