import { svelte, vitePreprocess } from '@sveltejs/vite-plugin-svelte';

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import tailwindcss from '@tailwindcss/vite';
import { wayfinder } from '@laravel/vite-plugin-wayfinder';

export default defineConfig({
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
        host: '0.0.0.0',
        port: 5174,
        hmr: {
            host: 'vite.one-in-emilien.com',
            protocol: 'wss',
            clientPort: 443,
        },
    },
});
