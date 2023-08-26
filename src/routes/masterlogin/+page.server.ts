import { PUBLIC_SUPABASE_ANON_KEY, PUBLIC_SUPABASE_URL } from "$env/static/public";
import type { PageLoadEvent, PageServerLoad } from "./$types";

import { EMAIL } from "$env/static/private";
import type { RequestEvent } from '../$types';
import { fail, redirect, type ServerLoadEvent } from '@sveltejs/kit';
import { AuthApiError } from "@supabase/supabase-js";

export const load: PageServerLoad = async ({ cookies, locals: {supabase, getSession} }) => {
    const session = await getSession();
};

export const actions = {
    adminLogin: async ({request,locals}: RequestEvent) => {

        const formData = await request.formData();

        const email = formData.get('email') as string;
        const password = formData.get('password') as string;

        console.log(email,password);

        if(!email || !password) return fail(400,{message: "Email and password are required"});

        if(email !== EMAIL) return fail(401,{message: "This email is not authorized to access this page."});

        const { data, error } = await locals.supabase.auth.signInWithPassword({
            email,
            password,
        });

        if (error && error instanceof AuthApiError) {
            return fail(401,{message: error.message});
        }

        throw redirect(301, '/admin');
    },
    logout: async ({request,locals}: RequestEvent) => {

        const { error } = await locals.supabase.auth.signOut();
        
        if (error) {
            throw error;
        }
        
    }
};
