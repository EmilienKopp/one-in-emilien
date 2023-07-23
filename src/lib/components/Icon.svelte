<script lang="ts">
    import { onDestroy, onMount } from "svelte";
    import { mdi } from './Icon';
    import { PUBLIC_HOME_URL } from "$env/static/public";
    import { fade } from "svelte/transition";
    
    export let name: string;
    export let pack: string | undefined = undefined;
    export let cssClass: string | undefined = undefined;
    export let size: string | undefined = undefined;
    export let href: string | undefined = undefined;
    export let circled: boolean = false;

    let svgContent: string | undefined = undefined;
    let svg: any = undefined;
    let container: HTMLDivElement | undefined = undefined;
    let iconPath: string | undefined = mdi[name];

    onMount(async () => {
        if(pack) return;

        const parser = new DOMParser();
        try {
            const file = await fetch(`${PUBLIC_HOME_URL}icons/${name}.svg`);
            svgContent = await file.text();
        } catch (error) {
            console.error(name, error);
        }

        if (svgContent) {
            svg =  parser.parseFromString(svgContent, "image/svg+xml").documentElement;
            if(size) {
                svg.setAttribute("height", size);
                svg.setAttribute("width", size);
            } else {
                if(svg.getAttribute("height")) {
                    svg.removeAttribute("height");
                }
                if(svg.getAttribute("width")) {
                    svg.removeAttribute("width");
                }
            }
            svg.setAttribute("class", cssClass);
            container?.appendChild(svg);
        }
    });

    onDestroy(() => {
        svg?.remove();
    });
    
</script>




<a {href} class="{href ? '' : 'pointer-events-none' } {circled ? 'flex h-16 w-16 items-center justify-center rounded-full border-2 border-current p-4' : ''} " 
          target="_blank">
    <slot />
    {#if pack}
        <svg viewBox="0 0 24 24" class={cssClass} in:fade>
            <path d={iconPath} fill="var(--color-text)"/>
        </svg>
    {:else}
        <div bind:this={container} in:fade>
        </div>
    {/if}
</a>