import * as schema from "./schema";

import { PUBLIC_SUPABASE_URL } from "$env/static/public";
import { drizzle } from "drizzle-orm/postgres-js";
import postgres from "postgres";

export class DB {
    private static _instance: DB;

    public static getInstance(): any {
        if (!DB._instance) {
            DB._instance = new DB();
        }
        return DB._instance;
    }

    private constructor() {
        const client = postgres(PUBLIC_SUPABASE_URL);
        DB._instance = drizzle(client); 
    }
}