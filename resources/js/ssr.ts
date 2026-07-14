import { createInertiaApp } from '@inertiajs/svelte';
import createServer from '@inertiajs/svelte/server';
import { render } from 'svelte/server';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createServer(
    (page) =>
        createInertiaApp({
            page,
            title: (title) => (title ? `${title} - ${appName}` : appName),
            resolve: (name) => {
                // Talk decks are client-only (reveal.js); excluding them here
                // makes Inertia fall back to client-side rendering for those pages.
                const pages = import.meta.glob(
                    ['./pages/**/*.svelte', '!./pages/talks/deck/**'],
                    { eager: true },
                );
                return pages[`./pages/${name}.svelte`] as any;
            },
            setup: ({ App, props }) => {
                return render(App, { props });
            },
        }),
    { cluster: true },
);
