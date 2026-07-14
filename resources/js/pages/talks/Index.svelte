<script lang="ts">
    import { fly } from 'svelte/transition';
    import { Link } from '@inertiajs/svelte';
    import Logo from '@/components/shared/Logo.svelte';
    import ThemeToggle from '@/components/ui/theme-toggle/ThemeToggle.svelte';

    interface Talk {
        slug: string;
        title: string;
        description: string;
    }

    let { talks }: { talks: Talk[] } = $props();

    function sleep(ms: number) {
        return new Promise((resolve) => setTimeout(resolve, ms));
    }
</script>

<svelte:head>
    <title>Talks</title>
</svelte:head>

<div
    class="lg:pt-auto flex h-full min-h-screen w-full flex-col items-center justify-center bg-background"
>
    {#await sleep(100) then}
        <div class="lg:-mb-20">
            <Logo class="w-56 lg:h-96 lg:w-96" />
        </div>

        <ul class="w-fit text-left">
            {#each talks as talk, i}
                <li
                    in:fly|global={{
                        duration: 600,
                        delay: 500 + i * 200,
                        x: -1500,
                    }}
                >
                    <a
                        href={`/talks/${talk.slug}`}
                        class="mt-10 block w-fit font-mono text-sm font-bold text-foreground lg:text-2xl"
                    >
                        /{talk.slug}: {talk.description}
                    </a>
                </li>
            {/each}
            <li
                transition:fly={{
                    duration: 600,
                    delay: 500 + talks.length * 200,
                    x: -1500,
                }}
            >
                <Link
                    href="/"
                    class="mt-10 block w-fit font-mono text-sm font-bold text-muted-foreground lg:text-2xl"
                >
                    ../: Back
                </Link>
            </li>
        </ul>
    {/await}
</div>

<div class="fixed right-5 bottom-5">
    <ThemeToggle />
</div>

<style>
    li a::after {
        display: block;
        content: '';
        width: 0;
        border-bottom: 1px solid hsl(var(--foreground));
        transition: width 0.4s ease-in-out;
    }

    li a:hover {
        scale: 1.05;
        color: hsl(var(--foreground));
    }

    li a:hover::after {
        width: 100%;
        transition: width 0.4s ease-in-out;
    }
</style>
