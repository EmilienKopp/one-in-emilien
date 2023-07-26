<script>
    import { fade, slide } from 'svelte/transition';
    import { onMount } from 'svelte';
    import { cubicInOut } from 'svelte/easing';
    import GlowHoverButton from './GlowHoverButton.svelte';
    import { scrolled } from '$lib/stores';
    import { goto } from '$app/navigation';
    import { commandsVisible, chatting } from '$lib/stores';

    onMount( () => {
        document.addEventListener('keyup', (e) => {
            if( document.activeElement === document.getElementById('chatInput') ) return;
            if(e.key == 'h') {
                $commandsVisible = !$commandsVisible;
            }
        });
    })

</script>

<div class="w-1/2 flex flex-col md:flex-row md:justify-end sm:gap-8 gap-2">
    <GlowHoverButton on:click={ () => goto('/#intro')}>
        Work
    </GlowHoverButton>
    <GlowHoverButton on:click={() => $commandsVisible = !$commandsVisible}>
        Play
    </GlowHoverButton>
</div>


{#if $commandsVisible && !$chatting}
    <div id="controls" 
        class="fixed w-fit {$scrolled ? 'sm:bottom-0 bottom-3 sm:pr-6' : 'top-0 sm:pr-80'} right-0 text-xs scale-75 sm:scale-100 p-2 sm:opacity-80 bg-white rounded-md shadow-md"
         role="button" tabindex="0"
         transition:slide={{duration: 500, easing: cubicInOut}}
         on:click={ (e) => { $commandsVisible = e.target.tagName == 'INPUT'}}
         on:keyup={ (e) => { $commandsVisible = e.key == 'enter' } }>
        <div id="commands-title" class="flex flex-row items-center gap-2 font-bold">
            Commands 
            <input type="text" placeholder="Type a command here" class="block lg:hidden"/>
        </div>
        <ul class="commands-list">
            <li class="hidden md:block">Hold Shift: Type something...</li>
            <li class="hidden md:block">Shift + Enter: Validate... try to find the cheat code!</li>
            <li class="block md:hidden italic">Use the desktop version to try and discover the cheat code</li>
            <li><strong>P or J</strong>: Display a <strong>J</strong>oke instead of background code</li>
            <li><strong>G</strong>: Change background to random color <strong>G</strong>radient</li>
            <li><strong>R</strong>: Change background to <strong>R</strong>andom color</li>
            <li class="hidden md:block"><strong>S</strong>: Toggle <strong>S</strong>unglasses</li>
            <li><strong>T</strong>: <strong>T</strong>oggle Dark/Light mode</li>
            <li><strong>H</strong>: <strong>H</strong>ide controls</li>
            <li class="hidden md:block">... or try clicking on parts of my face</li>
        </ul>
    </div>    
{/if}




<style>
#controls {
    font-weight: 600;
    color:black;
    transition: padding 0.5s ease-in-out;
}
</style>