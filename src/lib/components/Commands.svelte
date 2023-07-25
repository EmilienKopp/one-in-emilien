<script>
    import { fade, slide } from 'svelte/transition';
    import { onMount } from 'svelte';
    import { cubicInOut } from 'svelte/easing';
    import GlowHoverButton from './GlowHoverButton.svelte';
    import { scrolled } from '$lib/stores';
    import { goto } from '$app/navigation';

    export let show = false;
    let scrolling = false;
    let width = 'w-[47%]';

    onMount( () => {

        document.addEventListener('keyup', (e) => {
            if( document.activeElement === document.getElementById('chatInput') ) return;
            if(e.key == 'h') {
                show = !show;
            }
        });
    })

</script>

<div class="w-1/2 flex flex-col md:flex-row md:justify-end gap-8">
    <GlowHoverButton on:click={ () => goto('/#services')}>
        Work
    </GlowHoverButton>
    <GlowHoverButton on:click={() => show = !show}>
        Play
    </GlowHoverButton>
</div>

<div class="hidden sm:block">
{#if show}
    <div id="controls" class="fixed bottom-0 w-fit {$scrolled ? '' : 'pr-80'} right-0 text-xs p-2 opacity-70 bg-white rounded-tl"
         role="button" tabindex="0"
         transition:slide={{duration: 500, easing: cubicInOut}}
         on:click={ (e) => { show = e.target.tagName == 'INPUT'}}
         on:keyup={ (e) => { show = e.key == 'enter' } }>
        <div id="commands-title" class="flex flex-row items-center gap-2 font-bold">
            Commands 
            <input type="text" placeholder="Type a command here" class="block lg:hidden"/>
        </div>
        <ul class="commands-list">
            <li>Hold Shift: Type something...</li>
            <li>Shift + Enter: Validate</li>
            <li class="hidden md:block"><strong>S</strong>: Toggle <strong>S</strong>unglasses</li>
            <li><strong>P or J</strong>: Display a <strong>J</strong>oke</li>
            <li><strong>R</strong>: Change background to <strong>R</strong>andom color</li>
            <li><strong>G</strong>: Change background to random color <strong>G</strong>radient</li>
            <li><strong>B</strong>: Set <strong>B</strong>ackground to <strong>B</strong>lack</li>
            <li><strong>H</strong>: <strong>H</strong>ide controls</li>
            <li><strong>D</strong>: Toggle <strong>D</strong>ark mode</li>
        </ul>
    </div>    
{/if}
</div>



<style>
#controls {
    font-weight: 600;
    color:black;
    transition: padding 0.5s ease-in-out;
}
</style>