<script lang="ts">
    import { fly, fade } from 'svelte/transition';
    import { quintIn, cubicInOut } from 'svelte/easing';
    import { onMount } from 'svelte';
    import * as Dialog from './dialog.js';
    import { stores } from '$lib/stores.svelte';

    let cheatcodes = ['SUDO'];
    let silentInput = $state('');
    let prompt = $state('');
    let counter = $state(6);
    let loading = $state(true);
    let hugeImage: SVGImageElement | undefined = $state();

    const toggleSunglasses = () => {
        stores.sunglassesOn = !stores.sunglassesOn;
        console.log('Sunglasses toggled: ' + stores.sunglassesOn);
    };
    const toggleChatting = () => (stores.chatting = !stores.chatting);

    function trigger() {
        counter = 6;
        timeout();
    }

    function timeout(): any {
        if (--counter > 0) return setTimeout(timeout, 1000);
        stores.typingBlockContent = '';
    }

    onMount(() => {
        const main = document.querySelector('main');

        setTimeout(() => {
            loading = false;
        }, 1000);

        document.addEventListener('keyup', async (e) => {
            if (
                document.activeElement ===
                    document.getElementById('chatInput') ||
                document.activeElement?.tagName == 'TEXTAREA' ||
                (document.activeElement?.tagName == 'INPUT' &&
                    document.activeElement.id != 'command-text-input')
            )
                return;
            if (e.shiftKey) {
                if (e.key == 'Backspace') {
                    e.preventDefault();
                    silentInput = silentInput.slice(0, -1);
                } else if (e.key == 'Enter') {
                    e.preventDefault();
                    prompt = silentInput;
                    silentInput = '';
                    console.log('ENTERED PROMPT: ' + prompt);
                    if (cheatcodes.includes(prompt)) {
                        console.log('CHEATCODE ENTERED:', prompt);
                    }
                    trigger();
                } else {
                    silentInput += e.key;
                }
            }
            let header = document.querySelector('header');
            switch (e.key) {
                case 's':
                    toggleSunglasses();
                    break;
                case 'r':
                    if (main)
                        main.style.background = `rgb(${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)})`;
                    if (header) header.style.background = 'transparent';
                    break;
                case 'g': //Change background to random color gradient
                    const gradient = `linear-gradient(90deg, rgb(${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)}), rgb(${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)}))`;
                    if (main) main.style.background = gradient;
                    if (header) header.style.background = 'transparent';
                    // document.getElementById('typing').color = '#0000';
                    break;
                case 'c':
                    silentInput = '';
                    console.log('Input Cleared');
                    break;
                case 'j':
                    console.log('Calling dad joke api');
                    stores.typingBlockContent = await Dialog.getDadJoke();
                    break;
                case 'p':
                    console.log('Calling programmer joke api');
                    stores.typingBlockContent =
                        await Dialog.getProgrammerJoke();
                    break;
                case 't':
                    if (main) main.style.background = '';
                    stores.theme = stores.theme == 'dark' ? 'light' : 'dark';
                    stores.toggleSunglasses(stores.theme);
                    document.documentElement.dataset.theme = stores.theme;
                    document.documentElement.classList.remove('dark', 'light');
                    document.documentElement.classList.add(stores.theme);
                    localStorage?.setItem('one-in-emilien-theme', stores.theme);
                    break;
            }
        });
    });
</script>

{#if !stores.scrolled}
    <svg
        id="image"
        class="fixed top-0 right-0 z-20 hidden md:block"
        transition:fly={{ duration: 800, x: 2000, easing: cubicInOut }}
        data-name="Layer 1"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        viewBox="0 -300 1498 2246"
    >
        <defs>
            <style>
                .cls-1 {
                    fill: #fff;
                    opacity: 0;
                }
            </style>
        </defs>

        {#if !loading}
            <!-- <image width="1498" height="2246" transform="scale(1.16)" 
                xlink:href="images/emilien_nobg.png" transition:fade={{duration: 600}}/> -->

            <image
                id="portrait"
                width="1498"
                height="2246"
                transform="scale(1.16)"
                bind:this={hugeImage}
                transition:fly={{
                    duration: 800,
                    x: 2000,
                    easing: cubicInOut,
                    opacity: 0,
                }}
                onload={() => {
                    console.log('img loaded ' + Date.now());
                }}
                xlink:href="images/emilien_nobg.png"
                class="opacity-{loading ? '0' : '100'} transition duration-1000"
            />
        {/if}

        {#if stores.sunglassesOn}
            <image
                id="sunglasses"
                transition:fly={{ duration: 800, y: -1000, easing: quintIn }}
                width="995"
                height="543"
                transform="translate(440.46 318.81) scale(.47)"
                xlink:href="images/sunglasses.png"
            />
        {/if}
        <rect
            id="eyes"
            onclick={toggleSunglasses}
            class="cls-1"
            x="504.46"
            y="367.38"
            width="312.5"
            height="128.25"
        />
        <rect
            id="mouth"
            onclick={toggleChatting}
            class="cls-1"
            x="550"
            y="595"
            width="312.5"
            height="128.25"
        />
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
