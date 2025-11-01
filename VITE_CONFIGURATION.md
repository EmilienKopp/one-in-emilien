# Vite Development Server Configuration

This project supports two different Vite development server configurations:

## 1. Local Development (Default)

For development on your local machine with Hot Module Replacement (HMR).

### Setup:

```bash
# Copy the local example environment file
cp .env.local.example .env

# Or manually add these variables to your .env:
VITE_DEV_SERVER_MODE=local
VITE_DEV_SERVER_HOST=0.0.0.0
VITE_DEV_SERVER_PORT=5173
VITE_HMR_HOST=localhost
```

### Running:

```bash
# Start the Vite dev server
npm run dev

# Or with Sail
./vendor/bin/sail npm run dev
```

### Access:
- Your app will be available at: `http://localhost` (or your APP_URL)
- HMR will work automatically at `http://localhost:5173`

---

## 2. VPS Development

For development on a VPS with remote HMR access via WSS (WebSocket Secure).

### Setup:

```bash
# Copy the VPS example environment file
cp .env.vps.example .env

# Or manually add these variables to your .env:
VITE_DEV_SERVER_MODE=vps
VITE_DEV_SERVER_HOST=0.0.0.0
VITE_DEV_SERVER_PORT=5174
VITE_HMR_HOST=vite.one-in-emilien.com
VITE_HMR_PROTOCOL=wss
VITE_HMR_CLIENT_PORT=443
```

### Prerequisites:

1. **DNS Setup**: Point `vite.one-in-emilien.com` to your VPS IP
2. **Reverse Proxy**: Configure your web server (Nginx/Traefik) to proxy WSS connections to port 5174

#### Example Nginx Configuration:

```nginx
server {
    listen 443 ssl http2;
    server_name vite.one-in-emilien.com;

    ssl_certificate /path/to/ssl/cert.pem;
    ssl_certificate_key /path/to/ssl/key.pem;

    location / {
        proxy_pass http://localhost:5174;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

#### Example Traefik Configuration (docker-compose.yml):

```yaml
labels:
  - "traefik.enable=true"
  - "traefik.http.routers.vite.rule=Host(`vite.one-in-emilien.com`)"
  - "traefik.http.routers.vite.entrypoints=websecure"
  - "traefik.http.routers.vite.tls.certresolver=letsencrypt"
  - "traefik.http.services.vite.loadbalancer.server.port=5174"
```

### Running:

```bash
# Start the Vite dev server
npm run dev

# Or with Sail
./vendor/bin/sail npm run dev
```

### Access:
- Your app will be available at: `https://one-in-emilien.com`
- HMR will connect via: `wss://vite.one-in-emilien.com:443`

---

## Environment Variables Reference

| Variable | Local | VPS | Description |
|----------|-------|-----|-------------|
| `VITE_DEV_SERVER_MODE` | `local` | `vps` | Determines which HMR configuration to use |
| `VITE_DEV_SERVER_HOST` | `0.0.0.0` | `0.0.0.0` | Host for the dev server to bind to |
| `VITE_DEV_SERVER_PORT` | `5173` | `5174` | Port for the dev server |
| `VITE_HMR_HOST` | `localhost` | `vite.one-in-emilien.com` | Host for HMR connections |
| `VITE_HMR_PROTOCOL` | _(not set)_ | `wss` | Protocol for HMR (ws or wss) |
| `VITE_HMR_CLIENT_PORT` | _(not set)_ | `443` | Port for HMR client connections |

---

## Troubleshooting

### HMR not working locally?

1. Make sure `VITE_DEV_SERVER_MODE=local`
2. Check that `VITE_HMR_HOST=localhost`
3. Verify Vite dev server is running on the correct port
4. Clear browser cache and reload

### HMR not working on VPS?

1. Verify DNS: `vite.one-in-emilien.com` resolves to your VPS
2. Check reverse proxy configuration
3. Ensure SSL certificates are valid
4. Check firewall allows connections on port 443
5. Verify `VITE_DEV_SERVER_MODE=vps`
6. Check browser console for WebSocket errors

### Port conflicts?

Change the port in your `.env`:
```bash
VITE_DEV_SERVER_PORT=5175  # or any available port
```

---

## Production Build

For production, none of these environment variables matter. Simply run:

```bash
npm run build
```

This will create optimized static assets without any dev server configuration.
