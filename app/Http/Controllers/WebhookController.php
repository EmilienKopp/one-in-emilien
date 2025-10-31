<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

class WebhookController extends Controller
{
    /**
     * Handle deployment webhook
     */
    public function deploy(Request $request)
    {
        // Validate the webhook token
        $token = $request->header('X-Webhook-Token') ?? $request->input('token');
        $expectedToken = config('app.webhook_token');

        if (!$expectedToken) {
            Log::error('Webhook token not configured');
            return response()->json(['error' => 'Webhook not configured'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (!hash_equals($expectedToken, $token ?? '')) {
            Log::warning('Invalid webhook token received', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        try {
            Log::info('Deployment webhook triggered', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'payload' => $request->all(),
            ]);

            $ref = $request->input('ref', 'unknown');

            if(str($ref)->contains('main')) {
                \Log::info('Deployment for ref skipped as it matches the main branch', ['ref' => $ref]);
                return response()->json(['message' => 'Deployment skipped: main branch deployment is disabled'], Response::HTTP_I_AM_A_TEAPOT);
            }

            Log::info('Deployment triggered for ref', ['ref' => $ref]);

            $refCached = Cache::get('last_deployment_ref');
            if ($ref === $refCached) {
                Log::info('Deployment for ref skipped as it matches the last deployed ref', ['ref' => $ref]);
                return response()->json([
                    'message' => 'Deployment skipped: ref already deployed',
                    'ref' => $ref,
                    'timestamp' => now()->toISOString(),
                ], Response::HTTP_NO_CONTENT);
            }

            Cache::forever('last_deployment_ref', $ref);

            // Run the deployment command in the background
            Artisan::call('deploy', ['--force' => true]);

            $output = Artisan::output();

            Log::info('Deployment command executed', ['output' => $output]);

            return response()->json([
                'message' => 'Deployment triggered successfully',
                'output' => $output,
                'timestamp' => now()->toISOString(),
            ]);

        } catch (\Exception $e) {
            Log::error('Deployment webhook failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Deployment failed',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Health check endpoint for the webhook
     */
    public function healthCheck()
    {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toISOString(),
            'service' => 'webhook',
        ]);
    }
}
