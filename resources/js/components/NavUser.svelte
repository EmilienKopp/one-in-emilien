<script lang="ts">
	import UserInfo from '@/components/UserInfo.svelte';
	import {
		DropdownMenu,
		DropdownMenuContent,
		DropdownMenuTrigger,
	} from '$components/ui/dropdown-menu';
	import {
		SidebarMenu,
		SidebarMenuButton,
		SidebarMenuItem,
		useSidebar,
	} from '$components/ui/sidebar';
	import { page } from '@inertiajs/svelte';
	import { ChevronsUpDown } from 'lucide-svelte';
	import type { User } from '@/types';
	import UserMenuContent from './UserMenuContent.svelte';

	const user = $derived($page.props.auth.user as User);
	const { isMobile, state } = useSidebar();
</script>

<SidebarMenu>
	<SidebarMenuItem>
		<DropdownMenu>
			<DropdownMenuTrigger asChild let:builder>
				<SidebarMenuButton
					builders={[builder]}
					size="lg"
					class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
					data-test="sidebar-menu-button"
				>
					<UserInfo {user} />
					<ChevronsUpDown class="ml-auto size-4" />
				</SidebarMenuButton>
			</DropdownMenuTrigger>
			<DropdownMenuContent
				class="w-(--bits-dropdown-menu-trigger-width) min-w-56 rounded-lg"
				side={isMobile() ? 'bottom' : state() === 'collapsed' ? 'left' : 'bottom'}
				align="end"
				sideOffset={4}
			>
				<UserMenuContent {user} />
			</DropdownMenuContent>
		</DropdownMenu>
	</SidebarMenuItem>
</SidebarMenu>
