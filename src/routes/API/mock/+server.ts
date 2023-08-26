

export async function POST ({ params, request }: any) {
    return new Response(await request.json());
}