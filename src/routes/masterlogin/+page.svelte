<script lang="ts">
    import type { PageData } from '../login/$types';

    export let data: PageData;

    function googleLogin() {
        data.supabase.auth.signInWithOAuth({
            provider: 'google',
        });
    }

    console.log(data.session?.user);

</script>

<div class="w-1/2 mx-auto pt-10 ">
    <h1>Admin Login</h1>
    <form class="flex flex-col gap-2">
        <input type="email" placeholder="email"/>
        <input type="password" placeholder="password"/>
        <button type="submit" class="bg-lime-300 rounded-md py-3">Login</button>
    </form>
    <div class="mt-5">
        <button class="bg-orange-400 p-4 rounded-md w-full" on:click={googleLogin}>
            Login with Google
        </button>
    </div>
</div>