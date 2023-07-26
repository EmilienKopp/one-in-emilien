<script lang="ts">
    import {fly,fade} from 'svelte/transition';
    import {quintIn, cubicInOut} from 'svelte/easing';
    import { onMount } from 'svelte';    
    import * as Dialog from './dialog.js';
    import { typingBlockContent } from '$lib/stores';
    import { chatting, scrolled, theme } from '$lib/stores';

    let silentInput = '';
    let cheatcodes = ['SUDO'];
    let triggered = false;
    let speaking = false;
    let sunglasses = false;
    let prompt = '';
    let scrollY: number;
    let counter = 6;
    let loading = true;

    const toggleSunglasses = () => sunglasses = !sunglasses;
    const toggleChatting = () => $chatting = !$chatting;

    function trigger() {
        speaking = true;
        counter = 6;
        timeout();
    }

    function timeout(): any {
        if (--counter > 0) return setTimeout(timeout, 1000);
        $typingBlockContent = "";
    }

    onMount( () => {
        console.log('OnMount');
        const main = document.querySelector('main');

        let eyes = document.getElementById('eyes');
        eyes?.addEventListener('click', toggleSunglasses);

        setTimeout(() => {
            loading = false;
        }, 1500);

        document.addEventListener('keyup', async (e) => {
            if(document.activeElement === document.getElementById('chatInput')) return;
            if(e.shiftKey) {
                if(e.key == 'Backspace') {
                    e.preventDefault();
                    silentInput = silentInput.slice(0,-1)
                } else if (e.key == 'Enter') {
                    e.preventDefault();
                    prompt = silentInput;
                    silentInput = '';
                    console.log('ENTERED PROMPT: ' + prompt);
                    if(cheatcodes.includes(prompt)) {
                        console.log('CHEATCODE ENTERED:', prompt);
                        triggered = true;
                    }
                    trigger();
                } else {
                    silentInput += e.key;
                }
            }

            switch (e.key) {
                case 's':
                    toggleSunglasses();
                    break;
                case 'r':
                    if(main) main.style.background = `rgb(${Math.floor(Math.random()*255)},${Math.floor(Math.random()*255)},${Math.floor(Math.random()*255)})`;
                    break;
                case 'g': //Change background to random color gradient
                    if(main) main.style.background = `linear-gradient(90deg, rgb(${Math.floor(Math.random()*255)},${Math.floor(Math.random()*255)},${Math.floor(Math.random()*255)}), rgb(${Math.floor(Math.random()*255)},${Math.floor(Math.random()*255)},${Math.floor(Math.random()*255)}))`;
                    // document.getElementById('typing').color = '#0000';
                    break;
                case 'c':
                    silentInput = '';
                    console.log('Input Cleared');
                    break;
                case 'j':
                    console.log('Calling dad joke api');
                    $typingBlockContent = await Dialog.getDadJoke();
                    break;
                case 'p':
                    console.log('Calling programmer joke api');
                    $typingBlockContent = await Dialog.getProgrammerJoke();
                    break;
                case 't':
                    if(main) main.style.background = '';
                    $theme = ($theme == "dark") ? "light" : "dark";
                    document.documentElement.dataset.theme = $theme;
                    localStorage?.setItem("one-in-emilien-theme", $theme)
                    break;
            }
        });
    });

</script>
<svelte:window bind:scrollY={scrollY} />


{#if !$scrolled}

    <svg  id="image" class="hidden md:block fixed right-0 top-0 z-20" transition:fade={{duration: 1200, easing: cubicInOut}} 
    data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 -300 1498 2246">
        <defs>
            <style>
            .cls-1 {
                fill: #fff;
                opacity: 0;
            }
            </style>
        </defs>
        {#if !loading}
        <image width="1498" height="2246" transform="scale(1.16)" 
                xlink:href="images/emilien_nobg.png" transition:fade={{duration: 600}}/>
        {/if}
        {#if sunglasses}
        <image id="sunglasses" transition:fly={{duration:800, y: -1000, easing: quintIn}} width="995" height="543" transform="translate(440.46 318.81) scale(.47)" xlink:href="images/sunglasses.png"/>
        {/if}
        <rect id="eyes" on:click={ toggleSunglasses } class="cls-1" x="504.46" y="367.38" width="312.5" height="128.25"/>
        <rect id="mouth" on:click={ toggleChatting } class="cls-1" x="550" y="595" width="312.5" height="128.25"/>
        <!-- <rect x="0" y="2600" width="1500" height="100" fill="#000000" /> -->
    </svg>

    
{/if}

<style>
    * {
        box-sizing: border-box;
    }

    svg {
        --container-height: 100vh;
        --container-width: 30vw;
        position: absolute;
        top: -3.9rem;
        right: 0;
        height: var(--container-height);
        width: var(--container-width);
        background-size: cover;
    }

    #eyes {
        cursor: pointer;
    }

    #mouth {
        cursor: pointer;
    }

</style>