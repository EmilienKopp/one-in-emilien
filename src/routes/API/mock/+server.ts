

export async function OPTIONS ({ params, request }: any) {
    const headersWithCORS = {
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
        'Access-Control-Allow-Headers': 'Content-Type',
    }
    return new Response(null, { headers: headersWithCORS });
}

export async function POST ({ params, request, locals }: any) {
    const body = await request.json();
    const headersWithCORS = {
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
        'Access-Control-Allow-Headers': 'Content-Type',
    }
    console.log('POST', body);

    let response;
    if(body.message) {
        response = new Response(
            JSON.stringify({ message: 'Hello from the API' }), 
            { headers: headersWithCORS, status: 200 });
        
        const url: URL = new URL(request.url);
        const {data, error} = await locals.supabase.from('public_posting').insert([{content: body.message, sender: url.origin}]);

    } else {
        response = new Response(
            JSON.stringify({ message: 'Error' }), 
            { headers: headersWithCORS, statusText: 'Bad Request: "message" parameter was expected.', status: 400 });
    }


    return response;
}