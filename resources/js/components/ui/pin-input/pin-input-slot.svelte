<script lang="ts">
	import { PinInput as PinInputPrimitive } from "bits-ui";
	import { cn } from "$lib/utils.js";

	let {
		ref = $bindable(null),
		class: className,
		...restProps
	}: PinInputPrimitive.InputProps = $props();
</script>

<PinInputPrimitive.Input
	bind:ref
	class={cn(
		"border-input bg-background placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-ring/50 shadow-xs flex h-10 w-10 items-center justify-center rounded-md border text-center text-sm outline-none transition-shadow focus-visible:ring-[3px] disabled:cursor-not-allowed disabled:opacity-50",
		className
	)}
	{...restProps}
/>
