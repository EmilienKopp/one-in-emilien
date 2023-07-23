import { EMAIL } from "$env/static/private";
import { json } from "@sveltejs/kit";

export async function GET({ params, request }: any) {
    const data = {
        email: EMAIL
    }
    console.log(JSON.stringify(data));
    return json(data);
}