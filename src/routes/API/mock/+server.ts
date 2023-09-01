

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
    
    console.log('POST', request.headers.get('origin'));
    const sender = request.headers.get('origin')

    let response;
    if(body.message) {
        if(!body.message.includes('!')) {
            return new Response(
                JSON.stringify({ message: '💣 Your message should include an exclamation mark! ' }), 
                { headers: headersWithCORS, statusText: 'Bad Request', status: 400 });
        }
        
        response = new Response(
            JSON.stringify({ message: 'Hello from the API 😎' }), 
            { headers: headersWithCORS, status: 200 });
        
        const url: URL = new URL(request.url);
        const {data, error} = await locals.supabase.from('public_posting').insert([{content: body.message, sender}]);

    } else {
        response = new Response(
            JSON.stringify({ message: 'Error' }), 
            { headers: headersWithCORS, statusText: 'Bad Request: "message" parameter was expected.', status: 400 });
    }

    //Sleep for .5s
    await new Promise(resolve => setTimeout(resolve, 500));

    return response;
}