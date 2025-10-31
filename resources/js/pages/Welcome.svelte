<script lang="ts">
    import { fade, fly } from "svelte/transition";
    import { Link } from "@inertiajs/svelte";
    import Logo from "@/components/shared/Logo.svelte";
    import ThemeToggle from "@/components/ui/theme-toggle/ThemeToggle.svelte";
    import { quadInOut } from "svelte/easing";

    function sleep(ms: number) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
</script>

<div class="bg-background h-full w-full flex flex-col items-center justify-center lg:pt-auto min-h-screen">
    {#await sleep(100) then}
        <div transition:fade={{duration: 2000, easing: quadInOut}} class="lg:-mb-20">
            <Logo class="lg:w-96 lg:h-96 w-56" />
        </div>

        <ul class="text-left w-fit">
            <li in:fly={{duration: 600, delay: 1500, x: -1500}}>
                <Link href="/dev" class="lg:text-2xl text-foreground text-sm font-bold mt-10 font-mono block w-fit">
                    /dev: Enter engineer portal
                </Link>
            </li>
            <li in:fly={{duration: 600, delay: 1800, x: -1500}}>
                <span class="lg:text-2xl text-muted-foreground text-sm font-bold mt-10 font-mono block w-fit">
                    /blog: 🚧 Under construction 🚧
                </span>
            </li>
            <!-- <li in:fly={{duration: 600, delay: 1800, x: -1500}}>
                <Link href="/teach" class="lg:text-2xl text-foreground text-sm font-bold mt-10 font-mono block w-fit">
                    /teach: Enter teacher portal
                </Link>
            </li>
            <li in:fly={{duration: 600, delay: 2100, x: -1500}}>
                <Link href="/translate" class="lg:text-2xl text-foreground text-sm font-bold mt-10 font-mono block w-fit">
                    /translate: Enter translator portal
                </Link>
            </li> -->
        </ul>

    {/await}

</div>

<div class="fixed bottom-5 right-5">
    <ThemeToggle />
</div>

<style>
    li a::after {
        display: block;
        content: "";
        width: 0;
        border-bottom: 1px solid hsl(var(--foreground));
        transition: width 0.4s ease-in-out;
    }

    li a:hover {
        @apply scale-105 text-foreground;
    }

    li a:hover::after {
        width: 100%;
        transition: width 0.4s ease-in-out;
    }
</style>
