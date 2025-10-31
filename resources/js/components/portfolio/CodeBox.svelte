<script lang="ts">
    import { onMount } from 'svelte';
    import { stores } from '$lib/stores.svelte';

    let { propContent = '' } = $props();
    let typingBlock: HTMLSpanElement;

    const n = $derived(
        stores.typingBlockContent.length
            ? stores.typingBlockContent.length
            : 478,
    );
</script>

{#key stores.typingBlockContent}
    <div class="pointer-events-none z-[1] opacity-80 select-none">
        <pre
            class="{stores.typingBlockContent
                ? 'pt-[10vh] text-xs sm:pt-[52vh] md:w-4/6 lg:mt-2 lg:text-sm xl:text-xl'
                : 'lg:text-md text-xs xl:text-4xl'} block w-full rounded-md px-4 pt-12">
        <code
                class="code-panel language-javascript sm:text-xs md:text-lg lg:text-xl">
            <span
                    id="typing"
                    class="type font-mono"
                    style="--n:478"
                    bind:this={typingBlock}>
                {#if propContent}
                        {propContent}
                    {:else if stores.typingBlockContent == ''}
                        {`import { JavaScript, PHP, Elixir, CSS, SQL } from 'languages';`}<br
                        />
                    {`import { Webflow, Figma, Illustrator, GIMP } from 'design';`}<br
                        />
                    {`import { SvelteKit, Laravel, Phoenix } from 'frameworks';`}<br
                        />
                    {`import { work, code } from 'experience';`}<br
                        />
                    <br
                        />
                    {`export function WorkForYou ( coffee, dollars) {`}<br
                        />
                    &emsp;&emsp;{`while ( coffee && dollars && ! work.isPerfect() ) {`}<br
                        />
                    &emsp;&emsp;&emsp;&emsp;{`GreatValue += code();`}<br
                        />
                    &emsp;&emsp;{`}`}<br
                        />
                    &emsp;&emsp;{`return GreatValue;`}<br
                        />
                    {`}`}<br />
                    {:else}
                        {@html stores.typingBlockContent.replace(
                            /\n/g,
                            '<br/>',
                        )}
                    {/if}
                </span>
            </code>
        </pre>
    </div>
{/key}

<style>
    pre {
        white-space: normal;
        background-color: transparent;
        color: var(--color-text);
        position: fixed;
        top: 10%;
        left: 2%;
        opacity: 0.15;
        z-index: -1;
        transition: opacity 0.6s ease-in-out;
    }
    .code-panel {
        font-family: monospace;
    }

    .type {
        color: #0000;
        background:
            linear-gradient(-90deg, var(--color-text) 5px, transparent 0) 10px 0,
            /* CARET COLOR */ linear-gradient(var(--color-text) 0 0) 0 0; /* TEXT COLOR */
        background-size: calc(var(--n) * 1ch) 200%;
        -webkit-background-clip: padding-box, text;
        background-clip: padding-box, text;
        background-repeat: no-repeat;
        animation:
            b 0.5s infinite steps(1),
            t calc(var(--n) * 0.1s) steps(var(--n)) forwards;
    }

    @keyframes t {
        from {
            background-size: 0 200%;
        }
    }
    @keyframes b {
        50% {
            background-position:
                0 -100%,
                0 0;
        }
    }
</style>
