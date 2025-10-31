<script lang="ts">
	import {
		SidebarGroup,
		SidebarGroupLabel,
		SidebarMenu,
		SidebarMenuButton,
		SidebarMenuItem,
	} from '$components/ui/sidebar';
	import { urlIsActive } from '$lib/utils';
	import { type NavItem } from '@/types';
	import { Link, page } from '@inertiajs/svelte';

	interface Props {
		items: NavItem[];
	}

	let { items }: Props = $props();
</script>

<SidebarGroup class="px-2 py-0">
	<SidebarGroupLabel>Platform</SidebarGroupLabel>
	<SidebarMenu>
		{#each items as item (item.title)}
			{@const Icon = item.icon}
			<SidebarMenuItem>
				<SidebarMenuButton asChild isActive={urlIsActive(item.href, $page.url)} tooltip={item.title}>
					<Link href={item.href}>
						<Icon />
						<span>{item.title}</span>
					</Link>
				</SidebarMenuButton>
			</SidebarMenuItem>
		{/each}
	</SidebarMenu>
</SidebarGroup>
