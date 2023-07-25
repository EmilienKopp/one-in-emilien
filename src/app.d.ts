import { SupabaseClient, Session } from '@supabase/supabase-js';
import { Database } from './DatabaseDefinitions';
import type { Translate } from '@google-cloud/translate/build/src/v2';
import type { Database } from "$lib/supabase";


declare global {
  namespace App {
    interface Locals {
      supabase: SupabaseClient<Database>;
      getSession(): Promise<Session | AppSession | null>;
      refreshSession(): Promise<Session | AppSession | null>;
      getProfile(): Promise<Profile | Model | null>;
      GT: Translate;
      user: User | CustomUser;
      session: any;
      profile: Profile | null;
    }
    interface PageData {
      session: Session | null;
    }

    interface Session extends Session {
      user: User | CustomUser | null;
    }

    interface CustomUser extends User {
      profile?: Profile;
    }
   
    // interface Error {}
    // interface Platform {}
  }
}