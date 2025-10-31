<script lang="ts">
	import Heading from '@/components/Heading.svelte';
	import { Button } from '$components/ui/button';
	import { Separator } from '$components/ui/separator';
	import { toUrl, urlIsActive } from '$lib/utils';
	import { edit as editAppearance } from '@/routes/appearance';
	import { edit as editProfile } from '@/routes/profile';
	import { show } from '@/routes/two-factor';
	import { edit as editPassword } from '@/routes/user-password';
	import type { NavItem } from '@/types';
	import { Link } from '@inertiajs/svelte';
	import type { Snippet } from 'svelte';
	import type { Component } from 'svelte';

	interface Props {
		children?: Snippet;
	}

	let { children }: Props = $props();

	const sidebarNavItems: NavItem[] = [
		{
			title: 'Profile',
			href: editProfile(),
		},
		{
			title: 'Password',
			href: editPassword(),
		},
		{
			title: 'Two-Factor Auth',
			href: show(),
		},
		{
			title: 'Appearance',
			href: editAppearance(),
		},
	];

	const currentPath =
		typeof window !== 'undefined' ? window.location.pathname : '';
</script>

<div class="px-4 py-6">
	<Heading title="Settings" description="Manage your profile and account settings" />

	<div class="flex flex-col lg:flex-row lg:space-x-12">
		<aside class="w-full max-w-xl lg:w-48">
			<nav class="flex flex-col space-y-1 space-x-0">
				{#each sidebarNavItems as item (toUrl(item.href))}
					<Button
						variant="ghost"
						class={[
							'w-full justify-start',
							urlIsActive(toUrl(item.href), currentPath) ? 'bg-muted' : '',
						].join(' ')}
						href={item.href}
					>
						{#if item.icon}
							{@const Icon = item.icon}
							<Icon class="h-4 w-4" />
						{/if}
						{item.title}
					</Button>
				{/each}
			</nav>
		</aside>

		<Separator class="my-6 lg:hidden" />

		<div class="flex-1 md:max-w-2xl">
			<section class="max-w-xl space-y-12">
				{@render children?.()}
			</section>
		</div>
	</div>
</div>
