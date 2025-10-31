<script lang="ts">
    import Nav from '@/components/portfolio/Nav.svelte';
    import Chat from '@/components/portfolio/Chat.svelte';
    import { stores } from '$lib/stores.svelte';
    import { fade } from 'svelte/transition';
    import { type Snippet } from 'svelte';

    interface Props {
      children?: Snippet;
    }

    let { children }: Props = $props();

    let scrollY: number = $state(0);

    function scrollToTop() {
        window?.scrollTo({ top: 0, behavior: 'smooth' });
    }

    $effect(() => {
        stores.scrolled = scrollY > 200;
    });

    let isScrolled: boolean = $derived(stores.scrolled);
</script>

<svelte:window bind:scrollY />

{#if isScrolled}
    <Nav position="top" />
{/if}

<Chat />

<main
    class="text-default h-full scroll-mt-24 overflow-x-hidden overflow-y-auto bg-[--color-background]
		text-base transition-colors duration-500 selection:bg-secondary selection:text-white 2xl:pb-28"
>
    {@render children?.()}

    {#if isScrolled}
        <div transition:fade>
            <button
                id="backtotop"
                class="fixed right-8 bottom-8 z-9000 rounded-full bg-blue-500 p-2! text-white hover:bg-blue-600"
                onclick={scrollToTop}
            >
                <span class="sr-only">Back to top</span>
                ↑
            </button>
        </div>
    {/if}
</main>

{#if !isScrolled}
    <Nav position="bottom" />
{/if}
