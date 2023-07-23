<script>
    import {onMount} from 'svelte';
    import { typingBlockContent } from './stores.ts';
    import AnimatedSVGTitle from './AnimatedSVGTitle.svelte';
        
    let foreground = false;
    let typingBlock;
    let n = 478;

    onMount(() => {
        const code = typingBlock.textContent;
    });

    $: n = $typingBlockContent.length ? $typingBlockContent.length : 478;
</script>


   
    {#key $typingBlockContent}
    <div class="opacity-50 z-[1] pointer-events-none select-none">
        <pre class="{$typingBlockContent ? "pt-[52vh] lg:mt-2 md:w-4/6 text-xs lg:text-sm xl:text-xl" : "text-xs lg:text-md xl:text-4xl"} rounded-md px-4 pt-12 block w-full ">
        <code class="code-panel sm:text-xs md:text-lg lg:text-xl language-javascript">
            <span id="typing" class="type" style="--n:478" bind:this={typingBlock}>
                {#if $typingBlockContent == ""}
                    {`import { JavaScript, PHP, C#, CSS, MySQL } from 'languages';`}<br/>
                    {`import { Webflow, Figma, Illustrator, GIMP } from 'design';`}<br/>
                    {`import { SvelteKit, .NET, Laravel } from 'frameworks';`}<br/>
                    <br/>
                    {`export function WorkForYou ( coffee, dollars) {`}<br/>
                    &emsp;&emsp;{`while ( coffee && dollars && ! work.isPerfect() ) {`}<br/>
                    &emsp;&emsp;&emsp;&emsp;{`code();`}<br/>
                    &emsp;&emsp;{`}`}<br/>
                    &emsp;&emsp;{` return GreatValue;`}<br/>
                    {`}`}<br/>
                    {:else}
                    {@html $typingBlockContent.replace(/\n/g, '<br/>')}
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
        transition: opacity .6s ease-in-out;
    }
    .code-panel {
        font-family: monospace;
    }

    .type {
        color: #0000;
        background:
            linear-gradient(-90deg,var(--color-text) 5px, transparent 0) 10px 0, /* CARET COLOR */
            linear-gradient(var(--color-text) 0 0) 0 0; /* TEXT COLOR */
        background-size:calc(var(--n)*1ch) 200%;
        -webkit-background-clip:padding-box,text;
        background-clip:padding-box,text;
        background-repeat:no-repeat;
        animation: 
        b .5s infinite steps(1),   
        t calc(var(--n)*.1s) steps(var(--n)) forwards;
    }

    @keyframes t{
        from {background-size:0 200%}
    }
    @keyframes b{
        50% {background-position:0 -100%,0 0}
    }

</style>