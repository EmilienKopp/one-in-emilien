<script>
    let loading = false;
    let mailtoLink;

    async function handleClick() {
        if (loading) return;
        loading = true;

        const response = await fetch('/api/email', {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' },
        });
        const data = await response.json();
        loading = false;

        mailtoLink.href = `mailto:${data.email}`;
        mailtoLink.click();
    }
</script>

<a
    bind:this={mailtoLink}
    href="#"
    class="hidden"
    aria-hidden="true"
    tabindex="-1"
></a>

<a
    on:click={handleClick}
    disabled={loading}
    class="flex items-center justify-center gap-3 border-2 border-current px-6 py-4"
    href="TheCakeIsNotHere"
>
    {#if loading}
        <span
            class="inline-block h-4 w-32 animate-pulse rounded bg-current opacity-30"
        ></span>
    {:else}
        <slot />
    {/if}
</a>
