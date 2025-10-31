<script lang="ts">
	import {
		SidebarGroup,
		SidebarGroupContent,
		SidebarMenu,
		SidebarMenuButton,
		SidebarMenuItem,
	} from '$components/ui/sidebar';
	import { toUrl } from '$lib/utils';
	import { type NavItem } from '@/types';

	interface Props {
		items: NavItem[];
		class?: string;
	}

	let { items, class: className }: Props = $props();
</script>

<SidebarGroup class={`group-data-[collapsible=icon]:p-0 ${className || ''}`}>
	<SidebarGroupContent>
		<SidebarMenu>
			{#each items as item (item.title)}
				{@const Icon = item.icon}
				<SidebarMenuItem>
					<SidebarMenuButton
						class="text-neutral-600 hover:text-neutral-800 dark:text-neutral-300 dark:hover:text-neutral-100"
						asChild
					>
						<a href={toUrl(item.href)} target="_blank" rel="noopener noreferrer">
							<Icon />
							<span>{item.title}</span>
						</a>
					</SidebarMenuButton>
				</SidebarMenuItem>
			{/each}
		</SidebarMenu>
	</SidebarGroupContent>
</SidebarGroup>
