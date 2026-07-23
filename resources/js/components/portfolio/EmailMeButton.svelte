<script>
    import { useHttp } from '@inertiajs/svelte';

    const http = useHttp();

    let loading = $state(false);
    let mailtoLink = $state(null);
    let promise = $state(null);

    let { children } = $props();

    async function handleClick(e) {
        promise = fetchEmail(e);
        promise.catch((error) => {
            console.error('Error fetching email:', error);
            loading = false;
        });
    }

    async function fetchEmail(e) {
        e.preventDefault();
        if (loading) return;
        loading = true;
        const data = await http.get('/api/email');
        loading = false;

        mailtoLink.href = `mailto:${data.email}`;
        mailtoLink.click();
    }
</script>

<a
    bind:this={mailtoLink}
    href="TheCakeIsALie"
    class="hidden"
    aria-hidden="true"
    tabindex="-1"
></a>

<a
    onclick={handleClick}
    disabled={loading}
    class="flex items-center justify-center gap-3 border-2 border-current px-6 py-4"
    href="TheCakeIsNotHere"
>
    {#if promise}
        {#await promise}
            <span
                class="inline-block h-4 w-32 animate-pulse rounded bg-current opacity-30"
            ></span>
        {:then}
            {@render children()}
        {/await}
    {:else}
        {@render children()}
    {/if}
</a>
