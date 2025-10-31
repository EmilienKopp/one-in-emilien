# Deployment Webhook System

This project includes an automated deployment system using Laravel Envoy and a webhook endpoint.

## Components

### 1. Artisan Command
- **Command**: `php artisan deploy`
- **Options**: `--force` (skip confirmation prompt)
- **Function**: Executes the Envoy deployment script

### 2. Webhook Endpoint
- **URL**: `/api/webhook/deploy` (POST)
- **Security**: Token-based authentication
- **Function**: Triggers deployment via webhook calls

### 3. Health Check
- **URL**: `/api/webhook/health` (GET)
- **Function**: Verify webhook service status

## Setup

### 1. Environment Configuration
Add the following to your `.env` file:

```env
# Generate a secure random token
WEBHOOK_TOKEN=your-secure-random-token-here
```

You can generate a secure token with:
```bash
php artisan tinker
>>> str_random(64)
```

### 2. Install Laravel Envoy (if not already installed)
```bash
composer require laravel/envoy
```

## Usage

### Manual Deployment
```bash
# With confirmation prompt
php artisan deploy

# Skip confirmation
php artisan deploy --force
```

### Webhook Deployment
Send a POST request to `/api/webhook/deploy` with the webhook token:

**Headers:**
```
X-Webhook-Token: your-secure-random-token-here
Content-Type: application/json
```

**Or as form data:**
```json
{
    "token": "your-secure-random-token-here"
}
```

### Example cURL request:
```bash
curl -X POST https://your-domain.com/api/webhook/deploy \
  -H "X-Webhook-Token: your-secure-random-token-here" \
  -H "Content-Type: application/json"
```

### GitHub Webhook Integration
1. Go to your GitHub repository settings
2. Navigate to Webhooks
3. Add webhook URL: `https://your-domain.com/api/webhook/deploy`
4. Set content type to `application/json`
5. Add custom header: `X-Webhook-Token: your-secure-random-token-here`
6. Select events: Push, Pull request (merged)

## Security Features

- **Token Authentication**: All webhook requests must include a valid token
- **Request Logging**: All webhook attempts are logged
- **CSRF Exemption**: Webhook endpoints are exempt from CSRF protection
- **Rate Limiting**: API routes include rate limiting by default

## Monitoring

- Check deployment logs in `storage/logs/laravel.log`
- Health check endpoint: `/api/webhook/health`
- All webhook attempts are logged with IP and user agent

## Troubleshooting

### Common Issues

1. **"Envoy is not installed"**
   - Run: `composer require laravel/envoy`

2. **"Webhook token not configured"**
   - Add `WEBHOOK_TOKEN` to your `.env` file
   - Clear config cache: `php artisan config:clear`

3. **"Unauthorized" response**
   - Verify the webhook token matches your `.env` configuration
   - Check request headers or form data

4. **Permission errors during deployment**
   - Ensure proper file permissions on target directories
   - Check that the web server user has necessary permissions

### Debug Mode
To see detailed error output, temporarily set in `.env`:
```env
APP_DEBUG=true
```
Remember to set it back to `false` in production.