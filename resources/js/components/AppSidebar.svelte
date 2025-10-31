<script lang="ts">
	import NavFooter from '@/components/NavFooter.svelte';
	import NavMain from '@/components/NavMain.svelte';
	import NavUser from '@/components/NavUser.svelte';
	import {
		Sidebar,
		SidebarContent,
		SidebarFooter,
		SidebarHeader,
		SidebarMenu,
		SidebarMenuButton,
		SidebarMenuItem,
	} from '$components/ui/sidebar';
	import { dashboard } from '@/routes';
	import { type NavItem } from '@/types';
	import { Link } from '@inertiajs/svelte';
	import { BookOpen, Folder, LayoutGrid } from 'lucide-svelte';
	import AppLogo from './AppLogo.svelte';
	import type { Snippet } from 'svelte';

	interface Props {
		children?: Snippet;
	}

	let { children }: Props = $props();

	const mainNavItems: NavItem[] = [
		{
			title: 'Dashboard',
			href: dashboard(),
			icon: LayoutGrid,
		},
	];

	const footerNavItems: NavItem[] = [
		{
			title: 'Github Repo',
			href: 'https://github.com/laravel/vue-starter-kit',
			icon: Folder,
		},
		{
			title: 'Documentation',
			href: 'https://laravel.com/docs/starter-kits#vue',
			icon: BookOpen,
		},
	];
</script>

<Sidebar collapsible="icon" variant="inset">
	<SidebarHeader>
		<SidebarMenu>
			<SidebarMenuItem>
				<SidebarMenuButton size="lg" asChild let:builder>
					<Link href={dashboard()} builders={[builder]}>
						<AppLogo />
					</Link>
				</SidebarMenuButton>
			</SidebarMenuItem>
		</SidebarMenu>
	</SidebarHeader>

	<SidebarContent>
		<NavMain items={mainNavItems} />
	</SidebarContent>

	<SidebarFooter>
		<NavFooter items={footerNavItems} />
		<NavUser />
	</SidebarFooter>
</Sidebar>
{@render children?.()}
