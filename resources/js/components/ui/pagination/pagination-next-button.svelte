<script lang="ts">
  import { Pagination as PaginationPrimitive } from "bits-ui";
  import { ChevronRight as ChevronRightIcon } from "lucide-svelte";
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
  }: PaginationPrimitive.NextButtonProps & { href?: string } = $props();
</script>

{#snippet Fallback()}
  <span>Next</span>
  <ChevronRightIcon class="size-4" />
{/snippet}

{#snippet button()}
	{console.log("next button", href, disabled)}
  <PaginationPrimitive.NextButton
    bind:ref
    aria-label="Go to next page"
    class={cn(
      buttonVariants({
        size: "default",
        variant: "ghost",
        class: "gap-1 px-2.5 sm:pr-2.5",
      }),
      className,
    )}
		disabled={disabled}
    children={children || Fallback}
    {...restProps} 
	/>
{/snippet}

{#if href}
  <a {href} use:inertia>
    {@render button()}
  </a>
{:else}
  {@render button()}
{/if}
