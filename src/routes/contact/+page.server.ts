import type { RequestEvent } from './$types';
import { fail } from '@sveltejs/kit';
import { superValidate } from 'sveltekit-superforms/server';
import { z } from 'zod';

const schema = z.object({
    customer_name: z.string().min(3).max(50),
    company_name: z.string().min(3).max(50).optional(),
    email: z.string().email(),
    inquiry: z.string().min(3).max(500),
    message: z.string().optional(),
});

export async function load () {
    const form = await superValidate(schema);

    return {
        form
    }
}

export const actions = {
    default: async ( {request}: RequestEvent ) => {
        const form = await superValidate(request,schema);
        console.log('POST', form);

        if(!form.valid) {
            return fail(400, { form });
        }

        return {
            form
        }
    }
}