<script lang="ts">

	import AppearanceTabs from '@/components/AppearanceTabs.svelte';
	import HeadingSmall from '@/components/HeadingSmall.svelte';
	import { type BreadcrumbItem } from '@/types';

	import AppLayout from '@/layouts/AppLayout.svelte';
	import SettingsLayout from '@/layouts/settings/Layout.svelte';
	import { edit } from '@/routes/appearance';

	const breadcrumbItems: BreadcrumbItem[] = [
		{
			title: 'Appearance settings',
			href: edit().url,
		},
	];
</script>

<AppLayout breadcrumbs={breadcrumbItems}>

	<SettingsLayout>
		<div class="space-y-6">
			<HeadingSmall
				title="Appearance settings"
				description="Update your account's appearance settings"
			/>
			<AppearanceTabs />
		</div>
	</SettingsLayout>
</AppLayout>
