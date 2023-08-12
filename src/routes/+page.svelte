<script lang="ts">
    import { fade, fly } from "svelte/transition";
    import { goto } from "$app/navigation";
    import Logo from "$lib/components/Logo.svelte";
    import ThemeSwitcher from "$lib/components/ThemeSwitcher.svelte";
    import { elasticInOut, quadInOut, sineInOut } from "svelte/easing";

    function sleep(ms: number) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

</script>

<div class="bg-[--color-background] h-full w-full flex flex-col items-center justify-start lg:pt-auto ">
        {#await sleep(100) then}
            <div transition:fade={{duration: 2500, easing: quadInOut}} class="lg:-mb-20">
                <Logo class="lg:w-96 lg:h-96 w-56" />
            </div>
    
            <ul class="text-left w-fit">
                <li in:fly={{duration: 600, delay: 1500, x: -1500}}>
                    <a href="/dev" class="lg:text-2xl text-[--color-text] text-sm font-bold mt-10 font-mono block w-fit"> 
                        /dev: Enter engineer portal 
                    </a>
                </li>
                <li in:fly={{duration: 600, delay: 1800, x: -1500}}>
                    <span class="lg:text-2xl text-[--color-text-offset] text-sm font-bold mt-10 font-mono block w-fit"> 
                        /blog: 🚧 Under construction 🚧
                    </span>
                </li>
                <!-- <li in:fly={{duration: 600, delay: 1800, x: -1500}}>
                    <a href="/teach" class="lg:text-2xl text-[--color-text] text-sm font-bold mt-10 font-mono block w-fit"> 
                        /teach: Enter teacher portal 
                    </a>
                </li>
                <li in:fly={{duration: 600, delay: 2100, x: -1500}}>
                    <a href="/translate" class="lg:text-2xl text-[--color-text] text-sm font-bold mt-10 font-mono block w-fit"> 
                        /translate: Enter translator portal 
                    </a>
                </li> -->
            </ul>
            
        {/await}
        
</div>

<div class="fixed bottom-5 right-5">
    <ThemeSwitcher />
</div>

<style>

    li a::after {
        display: block;
        content: "";
        width: 0;
        border-bottom: 1px solid var(--color-text);
        transition: width 0.4s ease-in-out;
    }

    li a:hover {
        @apply scale-105 text-[--color-text];
    }

    li a:hover::after {
        width: 100%;
        transition: width 0.4s ease-in-out;
    }

    

    
</style>