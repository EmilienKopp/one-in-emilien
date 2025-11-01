import { svelte, vitePreprocess } from '@sveltejs/vite-plugin-svelte';

import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import tailwindcss from '@tailwindcss/vite';
import { wayfinder } from '@laravel/vite-plugin-wayfinder';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');

    // Determine if we're in VPS mode
    const isVPS = env.VITE_DEV_SERVER_MODE === 'vps';

    // Configure HMR based on environment
    const hmrConfig = isVPS
        ? {
            host: env.VITE_HMR_HOST || 'vite.one-in-emilien.com',
            protocol: (env.VITE_HMR_PROTOCOL || 'wss') as 'ws' | 'wss',
            clientPort: parseInt(env.VITE_HMR_CLIENT_PORT || '443'),
        }
        : {
            host: env.VITE_HMR_HOST || 'localhost',
        };

    return {
        plugins: [
            laravel({
                input: ['resources/js/app.ts'],
                ssr: 'resources/js/ssr.ts',
                refresh: true,
            }),
            tailwindcss(),
            ...(process.env.NODE_ENV !== 'production'
                ? [wayfinder({ formVariants: true })]
                : []),
            svelte({
                preprocess: vitePreprocess(),
            }),
        ],
        resolve: {
            alias: {
                $lib: path.resolve('./resources/js/lib'),
                $components: path.resolve('./resources/js/components'),
                $pages: path.resolve('./resources/js/pages'),
                $types: path.resolve('./resources/js/types'),
                $models: path.resolve('./resources/js/models/models.d.ts'),
                $layouts: path.resolve('./resources/js/layouts'),
                $routes: path.resolve('./resources/js/routes'),
                $actions: path.resolve('./resources/js/actions'),
                '@': path.resolve('./resources/js'),
            },
        },
        server: {
            host: env.VITE_DEV_SERVER_HOST || '0.0.0.0',
            port: parseInt(env.VITE_DEV_SERVER_PORT || '5173'),
            hmr: hmrConfig,
        },
    };
});
