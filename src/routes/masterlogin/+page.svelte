<script lang="ts">
    import { enhance } from '$app/forms';
    import type { PageData, ActionData } from './$types';

    export let data: PageData;
    export let form: ActionData;

    $: console.log(form);

</script>

<div class="w-1/2 mx-auto pt-10 ">
    <h1>Admin Login</h1>
    <form class="flex flex-col gap-2" method="POST" action="?/adminLogin" use:enhance>
        <input type="email" name="email" placeholder="email" />
        <input type="password" name="password" placeholder="password" />
        <button type="submit" class="bg-lime-300 rounded-md py-3" >Login</button>
        {#if form && form.message}
            <p class="text-red-500">{form.message}</p>
        {/if}
    </form>
</div>