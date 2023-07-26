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

<div class="bg-[--color-background] h-full w-full flex flex-col items-center justify-start">
        {#await sleep(100) then}
            <div transition:fade={{duration: 2500, easing: quadInOut}} class="-mb-20">
                <Logo class="w-96 h-96" />
            </div>
    
            <ul>
                <li in:fly={{duration: 600, delay: 1500, x: -1500}}>
                    <button on:click={() => goto("/dev")}> 
                        /dev: Enter engineer portal 
                    </button>
                </li>
                <li in:fly={{duration: 600, delay: 1800, x: -1500}}>
                    <button> 
                        /teach: Enter teacher portal 
                    </button>
                </li>
                <li in:fly={{duration: 600, delay: 2100, x: -1500}}>
                    <button> 
                        /translate: Enter translator portal 
                    </button>
                </li>
            </ul>
            
        {/await}
</div>

<div class="fixed bottom-5 right-5">
    <ThemeSwitcher />
</div>

<style>
    li button {
        @apply text-[--color-text] text-2xl font-bold mt-10 font-mono border-b-2 border-default;
    }

    li button:hover {
        @apply border-[--color-text];
    }
</style>