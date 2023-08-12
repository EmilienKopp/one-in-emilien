<script lang="ts">
    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher();

    export let type: "button" | "a" = "a";
    export let title: string;
    export let href: string | undefined =  type == "a" ? "#" : undefined;
    export let width: string | undefined = undefined;
    export let rounded: boolean = false;
    export let external: boolean = false;
    export let submit: boolean = false;
    export let color: "red" | "blue" | "orange" | "yellow" | "green" | "default" = "default";
    export let text: "xs" | "sm" | "md" | "lg" | "xl" | "2xl" = "sm";

    let colorUtility: string = color == "default" ? "bg-[--color-background-offset]" : `bg-${color}-100`;
    
    let target: string | undefined = external ? "_blank" : undefined;

</script>


<svelte:element 
        this={submit ? "button" : type} 
        class={ rounded
            ? `${colorUtility} ${width} text-${text} justify-center font-mono shadow-btn-round text-light-blue-light hover:text-light-blue-dark border-2 inline-flex items-center last-of-type:mr-0 p-2.5 border-transparent bg-light-secondary shadow-button-flat-nopressed hover:border-2 hover:shadow-button-flat-pressed focus:opacity-100 focus:outline-none active:border-2 active:shadow-button-flat-pressed font-medium rounded-full text-center `
            : `${colorUtility} ${width} text-${text} justify-center font-mono text-light-blue-light hover:text-light-blue-dark bg-light-secondary shadow-btn hover:border-2 hover:shadow-btn-pressed focus:opacity-100 focus:outline-none active:border-2 active:shadow-button-flat-pressed font-medium rounded-md text-sm p-2.5 text-center inline-flex items-center last-of-type:mr-0 border-2 border-transparent `
        }
        on:click={() => dispatch("click")}
        tabindex="0"
        role={type == "a" ? "button" : undefined}
        {title}
        {href}
        type={ submit ? "submit" : type}
        {target}
        {...$$restProps}
        >

    <slot/>

    <span class="sr-only">{title}</span>
</svelte:element>

<!-- <button type="button" class="text-light-blue-light hover:text-light-blue-dark dark:text-gray-400 bg-light-secondary shadow-btn hover:border-2 hover:shadow-btn-pressed focus:opacity-100 focus:outline-none active:border-2 active:shadow-button-flat-pressed font-medium rounded-md text-sm p-2.5 text-center inline-flex items-center mr-4 last-of-type:mr-0 border-2 border-transparent dark:bg-button-curved-default-dark dark:shadow-button-curved-default-dark dark:hover:bg-button-curved-pressed-dark dark:hover:shadow-button-curved-pressed-dark dark:focus:bg-button-curved-pressed-dark dark:focus:shadow-button-curved-pressed-dark dark:border-0">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
    <circle cx="12" cy="12" r="4"></circle>
    <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"></path>
    </svg>
    <span class="sr-only"> Theme color switcher</span>
</button>
<span class="mr-4"></span>
<a href="https://github.com/paablolc/" target="_blank" title="Link to pabloLC GitHub" class=" shadow-btn-round text-light-blue-light hover:text-light-blue-dark dark:text-gray-400 border-2 inline-flex items-center mr-4 last-of-type:mr-0 p-2.5 border-transparent bg-light-secondary shadow-button-flat-nopressed hover:border-2 hover:shadow-button-flat-pressed focus:opacity-100 focus:outline-none active:border-2 active:shadow-button-flat-pressed font-medium rounded-full text-sm text-center dark:bg-button-curved-default-dark dark:shadow-button-curved-default-dark dark:hover:bg-button-curved-pressed-dark dark:hover:shadow-button-curved-pressed-dark dark:active:bg-button-curved-pressed-dark dark:active:shadow-button-curved-pressed-dark dark:focus:bg-button-curved-pressed-dark dark:focus:shadow-button-curved-pressed-dark dark:border-0">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
    <path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5">
    </path>
    </svg>
</a> -->

<style>

</style>