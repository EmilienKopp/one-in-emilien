<script lang="ts">
	import UserInfo from '@/components/UserInfo.svelte';
	import {
		DropdownMenuGroup,
		DropdownMenuItem,
		DropdownMenuLabel,
		DropdownMenuSeparator,
	} from '$components/ui/dropdown-menu';
	import { logout } from '@/routes';
	import { edit } from '@/routes/profile';
	import type { User } from '@/types';
	import { Link, router } from '@inertiajs/svelte';
	import { LogOut, Settings } from 'lucide-svelte';

	interface Props {
		user: User;
	}

	let { user }: Props = $props();

	const handleLogout = () => {
		router.flushAll();
	};
</script>

<DropdownMenuLabel class="p-0 font-normal">
	<div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
		<UserInfo {user} showEmail={true} />
	</div>
</DropdownMenuLabel>
<DropdownMenuSeparator />
<DropdownMenuGroup>
	<DropdownMenuItem asChild>
		<Link class="block w-full" href={edit()} prefetch as="button">
			<Settings class="mr-2 h-4 w-4" />
			Settings
		</Link>
	</DropdownMenuItem>
</DropdownMenuGroup>
<DropdownMenuSeparator />
<DropdownMenuItem asChild>
	<Link
		class="block w-full"
		href={logout()}
		onclick={handleLogout}
		as="button"
		data-test="logout-button"
	>
		<LogOut class="mr-2 h-4 w-4" />
		Log out
	</Link>
</DropdownMenuItem>
