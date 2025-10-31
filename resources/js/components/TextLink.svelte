<script lang="ts">
    import { cn } from '$lib/utils';
    import type { Method } from '@inertiajs/core';
    import { Link } from '@inertiajs/svelte';
    import type { Snippet } from 'svelte';
		import { Button } from '$components/ui/button';

    interface Props {
        href: string;
        tabindex?: number;
        method?: Method;
        as?: string;
        children?: Snippet;
				class?: string;
    };

    let {
        href,
        tabindex,
        method,
        as: asElement,
        children,
        class: className
    }: Props = $props();
    const classes = $derived(
        cn(
            'text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current!',
            'dark:decoration-neutral-500',
            className,
        ),
    );
</script>

{#if asElement === 'button'}
    <Button {href} {tabindex} class={classes}>
        {@render children?.()}
    </Button>
{:else}
    <Link {href} {tabindex} {method} class={classes}>
        {@render children?.()}
    </Link>
{/if}
