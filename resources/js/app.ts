import '../css/app.css';

import { createInertiaApp } from '@inertiajs/svelte';
import { mount } from 'svelte';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';


createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => {
        const pages = import.meta.glob('./pages/**/*.svelte', { eager: true });
        const page = pages[`./pages/${name}.svelte`] as any;

        return { default: page.default};
    },
    setup({ el, App, props }) {
        if (!el) return;
        mount(App, { target: el, props });
    },
    progress: {
        color: '#4B5563',
    },
});
