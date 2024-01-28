import { PUBLIC_SUPABASE_ANON_KEY, PUBLIC_SUPABASE_URL } from "$env/static/public";

import { createClient } from "@supabase/supabase-js";

export async function POST({ params, request }: any) {
    const supabase = createClient(PUBLIC_SUPABASE_URL, PUBLIC_SUPABASE_ANON_KEY);
    console.log("RECEIVER LINE WEBHOOK", params, request);
    const {events} = request.body();
    for(const {message,source: {userId}} of events){
        
        const {error} = await supabase.from("line_inquiries").insert({
            user_line_id: userId,
            message: message.text ? message.text : message.type
        }).select();
        if(error){
            console.error("RECEIVER LINE WEBHOOK", error);
        }
    }
}