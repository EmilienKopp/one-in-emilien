import { createInertiaApp } from '@inertiajs/svelte';
import createServer from '@inertiajs/svelte/server';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { Component } from 'svelte';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createServer(
    (page) =>
        createInertiaApp({
            page,
            title: (title) => (title ? `${title} - ${appName}` : appName),
            resolve: (name) =>
                resolvePageComponent(
                    `./pages/${name}.svelte`,
                    import.meta.glob<Component>('./pages/**/*.svelte'),
                ),
            setup: ({ App, props }) => {
                return {
                    head: App.render(props).head,
                    body: App.render(props).html,
                };
            },
        }),
    { cluster: true },
);
