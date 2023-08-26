


export async function load ({locals}: any) {

    const db = locals.supabase;

    const availability = async () => {
        const {data, error} = await db.from('availability').select('*');
        return data;
    }

    return {
        availabilities: availability(),
    }
}