<script lang="ts">
    interface Props {
        type?: "button" | "a";
        title: string;
        href?: string;
        width?: string;
        rounded?: boolean;
        external?: boolean;
        submit?: boolean;
        color?: "red" | "blue" | "orange" | "yellow" | "green" | "default";
        text?: "xs" | "sm" | "md" | "lg" | "xl" | "2xl";
        onclick?: () => void;
        children?: import('svelte').Snippet;
        [key: string]: any;
    }

    let {
        type = "a",
        title,
        href = type == "a" ? "#" : undefined,
        width = undefined,
        rounded = false,
        external = false,
        submit = false,
        color = "default",
        text = "sm",
        onclick,
        children,
        ...rest
    }: Props = $props();

    let colorUtility: string = color == "default" ? "bg-[--color-background-offset]" : `bg-${color}-100`;
    
    let target: string | undefined = external ? "_blank" : undefined;

</script>

<svelte:element 
        this={submit ? "button" : type} 
        class={ rounded
            ? `${colorUtility} ${width} text-${text} justify-center font-mono shadow-btn-round text-light-blue-light hover:text-light-blue-dark border-2 inline-flex items-center last-of-type:mr-0 p-2.5 border-transparent bg-light-secondary shadow-button-flat-nopressed hover:border-2 hover:shadow-button-flat-pressed focus:opacity-100 focus:outline-none active:border-2 active:shadow-button-flat-pressed font-medium rounded-full text-center `
            : `${colorUtility} ${width} text-${text} justify-center font-mono text-light-blue-light hover:text-light-blue-dark bg-light-secondary shadow-btn hover:border-2 hover:shadow-btn-pressed focus:opacity-100 focus:outline-none active:border-2 active:shadow-button-flat-pressed font-medium rounded-md text-sm p-2.5 text-center inline-flex items-center last-of-type:mr-0 border-2 border-transparent `
        }
        {onclick}
        tabindex="0"
        role={type == "a" ? "button" : undefined}
        {title}
        {href}
        type={ submit ? "submit" : type}
        {target}
        {...rest}
        >

    {@render children?.()}

    <span class="sr-only">{title}</span>
</svelte:element>