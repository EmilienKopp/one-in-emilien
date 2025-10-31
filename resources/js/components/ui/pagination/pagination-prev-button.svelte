<script lang="ts">
  import { Pagination as PaginationPrimitive } from "bits-ui";
  import { ChevronLeft as ChevronLeftIcon } from "lucide-svelte";
  import { buttonVariants } from "$components/ui/button/index.js";
  import { cn } from "$lib/utils.js";
  import { inertia } from "@inertiajs/svelte";

  let {
    ref = $bindable(null),
    class: className,
    children,
    href,
		disabled,
    ...restProps
  }: PaginationPrimitive.PrevButtonProps & { href?: string } = $props();
</script>

{#snippet Fallback()}
  <ChevronLeftIcon class="size-4" />
  <span>Previous</span>
{/snippet}

{#if href}
  <a {href} use:inertia>
    {@render button()}
  </a>
{:else}
  {@render button()}
{/if}

{#snippet button()}
	{console.log("prev button",href,disabled)}
  <PaginationPrimitive.PrevButton
    bind:ref
    aria-label="Go to previous page"
    class={cn(
      buttonVariants({
        size: "default",
        variant: "ghost",
        class: "gap-1 px-2.5 sm:pl-2.5",
      }),
      className,
    )}
		disabled={disabled}
    children={children || Fallback}
    {...restProps} />
{/snippet}
