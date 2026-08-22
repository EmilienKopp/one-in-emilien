<script lang="ts">
    interface Props {
        type?: 'button' | 'a';
        title: string;
        href?: string;
        width?: string;
        rounded?: boolean;
        external?: boolean;
        submit?: boolean;
        color?: 'red' | 'blue' | 'orange' | 'yellow' | 'green' | 'default';
        text?: 'xs' | 'sm' | 'md' | 'lg' | 'xl' | '2xl';
        onclick?: () => void;
        children?: import('svelte').Snippet;
        [key: string]: any;
    }

    let {
        type = 'a',
        title,
        href = type == 'a' ? '#' : undefined,
        width = undefined,
        rounded = false,
        external = false,
        submit = false,
        color = 'default',
        text = 'sm',
        onclick,
        children,
        // eslint-disable-next-line svelte/valid-compile
        ...rest
    }: Props = $props();

    let colorUtility: string =
        color == 'default'
            ? 'bg-[--color-background-offset]'
            : `bg-${color}-100`;

    let target: string | undefined = external ? '_blank' : undefined;
</script>

<svelte:element
    this={submit ? 'button' : type}
    class={rounded
        ? `${colorUtility} ${width} text-${text} shadow-btn-round text-light-blue-light hover:text-light-blue-dark bg-light-secondary shadow-button-flat-nopressed hover:shadow-button-flat-pressed active:shadow-button-flat-pressed inline-flex items-center justify-center rounded-full border-2 border-transparent p-2.5 text-center font-mono font-medium last-of-type:mr-0 hover:border-2 focus:opacity-100 focus:outline-none active:border-2 `
        : `${colorUtility} ${width} text-${text} text-light-blue-light hover:text-light-blue-dark bg-light-secondary shadow-btn hover:shadow-btn-pressed active:shadow-button-flat-pressed inline-flex items-center justify-center rounded-md border-2 border-transparent p-2.5 text-center font-mono text-sm font-medium last-of-type:mr-0 hover:border-2 focus:opacity-100 focus:outline-none active:border-2 `}
    {onclick}
    tabindex="0"
    role={type == 'a' ? 'button' : undefined}
    {title}
    {href}
    type={submit ? 'submit' : type}
    {target}
    {...rest}
>
    {@render children?.()}

    <span class="sr-only">{title}</span>
</svelte:element>
