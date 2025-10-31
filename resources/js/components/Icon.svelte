<script lang="ts">
	import { cn } from '$lib/utils';
	import * as icons from 'lucide-svelte';
	import type { Component } from 'svelte';

	interface Props {
		name: string;
		class?: string;
		size?: number | string;
		color?: string;
		strokeWidth?: number | string;
	}

	let {
		name,
		class: className = '',
		size = 16,
		strokeWidth = 2,
		color,
	}: Props = $props();

	const iconComponent = $derived(() => {
		const iconName = name.charAt(0).toUpperCase() + name.slice(1);
		return (icons as Record<string, Component>)[iconName];
	});

	const computedClass = $derived(cn('h-4 w-4', className));
</script>

<svelte:component
	this={iconComponent()}
	class={computedClass}
	{size}
	strokeWidth={strokeWidth}
	{color}
/>
