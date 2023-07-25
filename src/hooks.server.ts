import {
    PUBLIC_SUPABASE_ANON_KEY,
    PUBLIC_SUPABASE_URL
} from '$env/static/public';

import type { Handle } from '@sveltejs/kit';
import type { Session } from '@supabase/supabase-js';
import { createSupabaseServerClient } from '@supabase/auth-helpers-sveltekit';
import { redirect } from '@sveltejs/kit';

export const handle: Handle = async ({ event, resolve }) => {

    event.locals.supabase = createSupabaseServerClient({
        supabaseUrl: PUBLIC_SUPABASE_URL,
        supabaseKey: PUBLIC_SUPABASE_ANON_KEY,
        event
    });

    event.locals.getSession = async () => {
        const {
            data: { session },
        } = await event.locals.supabase.auth.getSession();
        return session;
    }

    if(event.url.pathname.startsWith('/private')) {
        const session = await event.locals.getSession();
        if(!session) {
            throw redirect(303, '/login');
        }
    }

    const response = await resolve(event, {
        /**
         * There´s an issue with `filterSerializedResponseHeaders` not working when using `sequence`
         *
         * https://github.com/sveltejs/kit/issues/8061
         */
        filterSerializedResponseHeaders(name) {
            return name === 'content-range';
        }
    });

    return response;
};