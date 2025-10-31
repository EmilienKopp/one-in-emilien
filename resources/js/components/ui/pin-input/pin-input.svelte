<script lang="ts">
	import { PinInput as PinInputPrimitive } from "bits-ui";
	import { cn } from "$lib/utils.js";

	let {
		ref = $bindable(null),
		class: className,
		...restProps
	}: PinInputPrimitive.RootProps = $props();
</script>

<PinInputPrimitive.Root
	bind:ref
	class={cn("flex gap-2", className)}
	{...restProps}
>
	{@render children?.()}
</PinInputPrimitive.Root>
